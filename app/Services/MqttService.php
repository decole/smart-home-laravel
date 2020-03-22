<?php
namespace App\Services;

use App\MqttHistory;
use App\MqttRelay;
use App\MqttSensor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

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

    }

    public function listen()
    {
        $this->client->subscribe('#', 1);
        $this->client->onMessage([$this, 'process']);
        while(true) {
            $this->client->loop(10);
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

        Cache::forget($string.'_list_models');
        Cache::forget($string.'_list_topics');
        self::setCacheLong($string.'_list_models', $model->toArray());
        self::setCacheLong($string.'_list_topics', $list);
        return $list;
    }

    private static function analiseRelays($message)
    {
        self::deleteCacheMqtt('relays_list_models');
        self::deleteCacheMqtt('relays_list_topics');
        $sensors_list = self::getCacheMqtt('relays_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('relays');
        }

        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('relays_list_models');
            foreach ($model as $value) {
                if ($value['check_topic'] == $message->topic) {
                    if (
                        empty($value['last_command']) ||
                        $value['last_command'] != self::decodeRequestRelay($message->payload)
                    ) {
                        /** @var MqttRelay $relay */
                        $relay = MqttRelay::where('check_topic', $message->topic)->first();
                        $relay->last_command = self::decodeRequestRelay($message->payload);
                        $relay->save();
                        self::createDataset('relays');
                    }

                    if ($value['last_command'] != 'on' || $value['last_command'] != 'off'){
                        $relay = MqttRelay::where('check_topic', $message->topic)->first();
                        $relay->last_command = 'off';
                        $relay->save();
                        self::createDataset('relays');
                    }
                    // @Todo отправить нотификацию о неправильной команде, не on/off
                    return true;
                }
            }
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    $payload = $message->payload;
                    if($value['command_on'] == $payload || $value['command_off'] == $payload) {
                        /** @var MqttRelay $relay */
                        $relay = MqttRelay::where('topic', $message->topic)->first();
                        $relay->last_command = $payload;
                        $relay->save();
                        self::createDataset('relays');
                        return true;
                    }
                    return true;
                }
            }
        }
        return false;
    }

    private static function analiseFireSecures($message)
    {
        // При изменении состояния датчика на сработку, отправить сообщения по каналам нотификаций
        /* Добавить в таблицу колонки, значение норма и значение пожар, чтобы иметь понятия как различать состояния датчиков
        self::deleteCacheMqtt('sensors_list_models');
        self::deleteCacheMqtt('sensors_list_topics');
        $sensors_list = self::getCacheMqtt('sensors_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('sensors');
        }

        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('sensors_list_models');
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    echo 'find relay ' . $value['name'];
                    return true;
                }
            }
        }
        */
        return false;
    }

    private static function analiseSecures($message)
    {
        // При изменении состояния датчика на сработку, отправить сообщения по каналам нотификаций
        /*
        self::deleteCacheMqtt('sensors_list_models');
        self::deleteCacheMqtt('sensors_list_topics');
        $sensors_list = self::getCacheMqtt('sensors_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('sensors');
        }

        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('sensors_list_models');
            foreach ($model as $value) {
                if ($value['topic'] == $message->topic) {
                    echo 'find relay ' . $value['name'];
                    return true;
                }
            }
        }
        */
        return false;
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
        self::deleteCacheMqtt('sensors_list_models');
        self::deleteCacheMqtt('sensors_list_topics');
        $sensors_list = self::getCacheMqtt('sensors_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('sensors');
        }

        if (in_array($message->topic, $sensors_list)) {
            $model = self::getCacheMqtt('sensors_list_models');
            foreach ($model as $value) {
                if($value['topic'] == $message->topic) {
                    //echo 'find '. $value['topic'].PHP_EOL;
//                    if ($value['from_condition'] && $value['rom_condition'] < $message->payload) {
                    //echo 'warning from_condition, ' . $message->payload;
                    // @Todo add to notification
//                    }
//                    if ($value['to_condition'] && $value['to_condition'] > $message->payload) {
                    //echo 'warning to_condition, ' . $message->payload;
                    // @Todo add to notification
//                    }
                    return true;
                }
            }
            //var_dump($model);
        }

        return false;
    }
    
}
