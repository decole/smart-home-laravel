<?php
namespace App\Services;

use App\Mail\UserSendEmail;
use App\MqttFireSecure;
use App\MqttHistory;
use App\MqttRelay;
use App\MqttSecure;
use App\MqttSensor;
use App\Services\DataService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmail;

final class MqttService
{
    private $host;
    private $port;
    private $client;
    private $isConnect = false;

    // https://mosquitto-php.readthedocs.io/en/latest/client.html#Mosquitto\Client::onConnect
    public function __construct()
    {
        $this->host = env('MQTT_SERVER_IP');
        $this->port = env('MQTT_SERVER_PORT');
        $this->client = new \Mosquitto\Client();
        $this->client->connect($this->host, $this->port, 5);

        $this->client->onConnect(function ($rc){
            if($rc === 0){
                $this->isConnect = true;
            }
            else {
                $this->isConnect = false;
            }

        });
        $this->client->onDisconnect(function (){
            $this->isConnect = false;
        });
        register_shutdown_function([$this, 'disconnect']);

        self::createDataset('sensors');
        self::createDataset('relays');
        self::createDataset('secure');
        self::createDataset('fire_secure');
    }

    public function listen()
    {
        $this->client->subscribe('#', 1);
        $this->client->onMessage([$this, 'process']);
        while(true) {
            $this->client->loop(5);
        }

    }

    /**
     * Disconnect mqtt connection in lib
     */
    public function disconnect()
    {
        if($this->isConnect){
            $this->client->disconnect();
        }

    }

    /**
     * main process compute mqtt messages
     *
     * @param $message
     * @return bool|void
     */
    public function process($message){
        self::setCacheMqtt($message->topic, $message->payload);

        if ($message->topic == 'greenhouse/temperature') {
            self::saveDB($message);
            return true;
        }
        if (self::analiseSensors($message)) {
            return true;
        }
        if (self::analiseSecures($message)) {
            return true;
        }

        if (self::analiseFireSecures($message)) {
            return true;
        }
        if (self::analiseRelays($message)) {
            return true;
        }
    }

    /**
     * Sending data to topic on mqtt protocol
     * @param $topic $data
     * @return mixed
     */
    public function post($topic, $data)
    {
        $this->client->publish($topic, $data, 1, 0);

        return $data;

    }

    /**
     * Get cache on memcache
     *
     * @param $key
     * @return mixed|string
     */
    public static function getCacheMqtt($key)
    {
        return Cache::get($key);

    }

    /**
     * Set cache to memcache
     *
     * @param $key
     * @param $value
     */
    public static function setCacheMqtt($key, $value)
    {
        $expiresAt = Carbon::now()->addMinutes(1);
        Cache::put($key, $value, $expiresAt);

    }

    public static function setCacheLong($key, $value)
    {
        $expiresAt = Carbon::now()->addHour(24);
        Cache::put($key, $value, $expiresAt);

    }

    /**
     * Delete cache value to memcache
     *
     * @param $key
     */
    public static function deleteCacheMqtt($key)
    {
        Cache::forget($key);

    }

    /**
     * Соханение в БД таблице истории сообщений
     *
     * @param $message
     */
    private function saveDB($message)
    {
        /** @var MqttHistory $model */
        $model = new MqttHistory();
        $model->topic = $message->topic;
        $model->payload = $message->payload;
        $model->save();
    }

    public static function decodeRequestRelay($payload)
    {
        if ($payload == 0) {
            return 'off';
        }
        if ($payload == 1) {
            return 'on';
        }
        return null;
    }

    /**
     * Фабрика создания кэшированных датасетов для всех типов топиков
     *
     * @param string $string
     * @return array|bool
     */
    private static function createDataset(string $string)
    {
        if (empty($string)) {
            return false;
        }
        if ($string == 'sensors') {
            $model = MqttSensor::all();
            $list = $model->pluck('topic')->toArray();
        }
        if ($string == 'relays') {
            $model = MqttRelay::all();
            $list = array_merge($model->pluck('topic')->toArray(),$model->pluck('check_topic')->toArray());
        }
        if ($string == 'fire_secure') {
            $model = MqttFireSecure::all();
            $list = $model->pluck('topic')->toArray();
        }
        if ($string == 'secure') {
            $model = MqttSecure::all();
            $list = $model->pluck('topic')->toArray();
        }
        Cache::forget($string.'_list_models');
        Cache::forget($string.'_list_topics');
        self::setCacheLong($string.'_list_models', $model->toArray());
        self::setCacheLong($string.'_list_topics', $list);
        return $list;
    }

    /**
     * sensors_list_topics - кэшированный список топиков
     * sensors_list_models - кэшированный массив объектов моделей топиков
     *
     * @param $message
     * @return bool
     */
    private static function analiseSensors($message)
    {
        $sensors_list = self::getCacheMqtt('sensors_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('sensors');
        }
        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('sensors_list_models');
            foreach ($model as $value) {
                if($value['topic'] == $message->topic) {
                    if (
                        ( $value['from_condition'] && (integer) $message->payload < (integer) $value['from_condition'] ) ||
                        ( $value['to_condition']   && (integer) $message->payload > (integer) $value['to_condition']   )
                    ) {
                        self::sendNotify($value['message_warn'], $message->payload);
                    }
                    return true;
                }
            }
            return true;
        }

        return false;

    }

    private static function analiseRelays($message)
    {
        $sensors_list = self::getCacheMqtt('relays_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('relays');
        }
        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('relays_list_models');
            foreach ($model as $value) {
                if ($value['check_topic'] == $message->topic) {
                    if ($value['active'] == false) {
                        return true;
                    }
                    if (
                        $value['last_command'] != self::decodeRequestRelay($message->payload)
                    ) {
                        /** @var MqttRelay $relay */
                        $relay = MqttRelay::where('check_topic', $message->topic)->first();
                        $relay->last_command = self::decodeRequestRelay($message->payload);
                        $relay->save();
                        self::createDataset('relays');
                        if (self::is_active($value)) {
                            self::sendNotify($value['message_warn'], $relay->last_command);
                        }
                    }
                    return true;
                }
            }
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    if ($value['active'] == false) {
                        return true;
                    }
                    $payload = $message->payload;
                    if($value['command_on'] == $payload || $value['command_off'] == $payload) {
                        /** @var MqttRelay $relay */
                        $relay = MqttRelay::where('topic', $message->topic)->first();
                        $relay->last_command = $payload;
                        $relay->save();
                        self::createDataset('relays');
                        return true;
                    }
                }
            }

            return true;

        }

        return false;

    }

    private static function analiseFireSecures($message)
    {
        $sensors_list = self::getCacheMqtt('fire_secure_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('fire_secure');
        }
        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('fire_secure_list_models');
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    if($value['alarm_condition'] == $message->payload) {
                        // @Todo telegram notify
                        self::sendNotify($value['message_warn'], $message->payload);
                    }
                    return true;
                }
            }
        }

        return false;

    }

    private static function analiseSecures($message)
    {
        $sensors_list = self::getCacheMqtt('secure_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('secure');
        }
        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('secure_list_models');
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    if(
                        (integer) $value['alarm_condition'] == (integer) $message->payload &&
                        $value['trigger'] == true &&
                        self::is_active($value)
                    ) {
                        if ($value['notifying'] == true) {
                            self::sendNotify($value['message_warn'], $message->payload);
                        }
                    }


                }
            }
            return true;
        }

        return false;

    }

    /**
     * Отправка на почту сообщений с сайта
     * @param $string
     * @param $payload
     */
    private static function sendNotify($string, $payload)
    {
        $text = DataService::getTextNotify($string,$payload);
        echo $text . PHP_EOL;
        /*
        SendEmail::dispatch($text);
        */
    }

    private static function is_active($value)
    {
        if ($value['active'] == false) {
            return false;
        }
        return true;
    }

}
