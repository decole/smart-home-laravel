<?php

namespace App\Services;

use App\Jobs\SendTelegramNotify;
use App\MqttFireSecure;
use App\MqttHistory;
use App\MqttRelay;
use App\MqttSecure;
use App\MqttSensor;
use App\Notifications\FireSecureNotify;
use App\Notifications\RelayNotify;
use App\Notifications\SecureNotify;
use App\Notifications\SensorNotify;
use App\Services\DataService;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SiteNotify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmail;

final class MqttService
{
    // https://mosquitto-php.readthedocs.io/en/latest/client.html#Mosquitto\Client::onConnect

    private $host;
    private $port;
    private $client;
    private $isConnect = false;
    private $device;

    public function __construct()
    {
        $this->host = env('MQTT_SERVER_IP');
        $this->port = env('MQTT_SERVER_PORT');
        $this->client = new \Mosquitto\Client();
        $this->client->connect($this->host, $this->port, 5);

        $this->client->onConnect(function ($rc) {
            if ($rc === 0) {
                $this->isConnect = true;
            } else {
                $this->isConnect = false;
            }

        });
        $this->client->onDisconnect(function () {
            $this->isConnect = false;
        });
        register_shutdown_function([$this, 'disconnect']);

        $this->device = new DeviceService();
    }

    /**
     * Service initializing
     */
    public function listen()
    {
        $this->client->subscribe('#', 1);
        $this->client->onMessage([$this, 'process']);
        while (true) {
            $this->client->loop(5);
        }
    }

    /**
     * Disconnect mqtt connection in lib
     */
    public function disconnect()
    {
        if ($this->isConnect) {
            $this->client->disconnect();
        }
    }

    /**
     * main process compute mqtt messages
     *
     * @param $message
     * @return bool|void
     */
    public function process($message)
    {
        self::setCacheMqtt($message->topic, $message->payload);

        if ($message->topic == 'greenhouse/temperature') {
            self::saveDB($message);
            return true;
        }

        $this->device->route($message);
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
     * Анализ топиков датчиков
     *
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
            self::sensorValidate($message);
            return true;
        }

        return false;

    }

    /**
     * Анализ топиков реле
     *
     * relays_list_topics - кэшированный список топиков
     * relays_list_models - кэшированный массив объектов моделей топиков
     *
     * @param $message
     * @return bool
     */
    private static function analiseRelays($message)
    {
        $sensors_list = self::getCacheMqtt('relays_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('relays');
        }
        if (in_array($message->topic, $sensors_list)) {
            self::relayValidate($message);
            return true;
        }

        return false;

    }

    /**
     * Анализ пожарных топиков
     *
     * fire_secure_list_topics - кэшированный список топиков
     * fire_secure_list_models - кэшированный массив объектов моделей топиков
     *
     * @param $message
     * @return bool
     */
    private static function analiseFireSecures($message)
    {
        $sensors_list = self::getCacheMqtt('fire_secure_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('fire_secure');
        }
        if (in_array($message->topic, $sensors_list)) {
            self::fireSecureValidate($message);
            return true;
        }

        return false;

    }

    /**
     * Анализ охранных топиков
     *
     * secure_list_topics - кэшированный список топиков
     * secure_list_models - кэшированный массив объектов моделей топиков
     *
     * @param $message
     * @return bool
     */
    private static function analiseSecures($message)
    {
        $sensors_list = self::getCacheMqtt('secure_list_topics');
        if ($sensors_list === null) {
            $sensors_list = self::createDataset('secure');
        }
        if (in_array($message->topic, $sensors_list)) {
            self::secureValidate($message);
            return true;
        }

        return false;

    }

    /**
     * @param $message
     */
    private static function sensorValidate($message)
    {
        $model = self::getCacheMqtt('sensors_list_models');
        /* @Todo если нет кэша сгенерировать его */
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (
                    ($value['from_condition'] && (integer)$message->payload < (integer)$value['from_condition']) ||
                    ($value['to_condition'] && (integer)$message->payload > (integer)$value['to_condition'])
                ) {
                    $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                    self::SendNotify(new SensorNotify($text, $message));
                }
                break;
            }
        }
    }

    /**
     * @param $message
     */
    private static function relayValidate($message)
    {
        $model = self::getCacheMqtt('relays_list_models');
        foreach ($model as $value) {
            if ($value['check_topic'] == $message->topic) {
                if (self::is_active($value) == false) {
                    break;
                }
                if (
                    ((string)$message->payload != (string)$value['check_command_on']) &&
                    ((string)$message->payload != (string)$value['check_command_off'])
                ) {
                    self::createDataset('relays');
                    if (self::is_notifying($value)) {
                        $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                        self::SendNotify(new RelayNotify($text, $message));
                    }
                }
                break;
            }
        }
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (self::is_active($value) == false) {
                    $notify = 'на деактивированный топик ' . $message->topic . ' пришла комманда {value}';
                    self::SendNotify(new RelayNotify($notify, $message));
                    break;
                }
                $payload = $message->payload;
                if ($value['command_on'] == $payload || $value['command_off'] == $payload) {
                    /** @var MqttRelay $relay */
                    $relay = MqttRelay::where('topic', $message->topic)->first();
                    $relay->last_command = $payload;
                    $relay->save();
                    self::createDataset('relays');
                }
                break;
            }
        }
    }

    /**
     * @param $message
     */
    private static function fireSecureValidate($message)
    {
        $model = self::getCacheMqtt('fire_secure_list_models');
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if ($value['alarm_condition'] == $message->payload) {
                    $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                    self::SendNotify(new FireSecureNotify($text, $message));
                }
                break;
            }
        }
    }

    /**
     * @param $message
     */
    private static function secureValidate($message)
    {
        $model = self::getCacheMqtt('secure_list_models');
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (
                    (integer)$value['alarm_condition'] == (integer)$message->payload &&
                    $value['trigger'] == true &&
                    self::is_notifying($value)
                ) {
                    if ($value['notifying'] == true) {
                        $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                        self::SendNotify(new SecureNotify($text, $message));
                    }
                }
                break;
            }
        }
    }

    /**
     * Фабрика создания кэшированных датасетов для всех типов топиков
     *
     * @param string $string
     * @return array|bool
     */
    public static function createDataset(string $string)
    {
        if (empty($string)) {
            return false;
        }
        $model = $list = null;
        if ($string == 'sensors') {
            $model = MqttSensor::all();
            $list = $model->pluck('topic')->toArray();
        }
        if ($string == 'relays') {
            $model = MqttRelay::all();
            $list = array_merge($model->pluck('topic')->toArray(), $model->pluck('check_topic')->toArray());
        }
        if ($string == 'fire_secure') {
            $model = MqttFireSecure::all();
            $list = $model->pluck('topic')->toArray();
        }
        if ($string == 'secure') {
            $model = MqttSecure::all();
            $list = $model->pluck('topic')->toArray();
        }
        if ($model === null) {
            return false;
        }

        self::deleteCacheMqtt($string . '_list_models');
        self::deleteCacheMqtt($string . '_list_topics');
        self::setCacheLong($string . '_list_models', $model->toArray());
        self::setCacheLong($string . '_list_topics', $list);

        return $list;

    }

    /**
     * Проверка возможности отправки нотификации
     *
     * @param $value
     * @return bool
     */
    private static function is_notifying($value)
    {
        return $value['notifying'];
    }

    /**
     * Проверка активности топиков из БД
     *
     * @param $value
     * @return bool
     */
    private static function is_active($value)
    {
        return $value['active'];
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

    /**
     * Отправка уведомлений
     * @param \Illuminate\Notifications\Notification $object
     */
    public static function SendNotify(\Illuminate\Notifications\Notification $object)
    {
        /** @var SensorNotify $note */
        $note = $object;
        $user = User::where('name', 'decole')->first();
        foreach ($user->unreadNotifications as $notification) {
            if ($notification->data['message'] == $note->message) {
                $startTime = Carbon::parse($notification->created_at);
                $finishTime = Carbon::now();
                if ($finishTime->diffInSeconds($startTime) > 20) {
                    Notification::send($user, $object);
                }
                break;
            }
        }
    }
}
