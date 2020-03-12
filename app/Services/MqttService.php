<?php
namespace App\Services;

use App\MqttHistory;

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
     */
    public function process($message){

        if($message->topic == 'greenhouse/temperature') {
            print_r($message->payload.PHP_EOL);
            /** @var MqttHistory $model */
            $model = new MqttHistory();
            $model->topic = $message->topic;
            $model->payload = $message->payload;
            $model->save();
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

}
