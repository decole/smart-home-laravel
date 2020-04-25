<?php

namespace App\Services;


use App\MqttHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

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

}
