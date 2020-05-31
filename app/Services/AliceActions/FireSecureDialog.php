<?php


namespace App\Services\AliceActions;

use App\Services\MqttService;

class FireSecureDialog implements AliceInterface
{
    public function __construct()
    {

    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['пожарная', 'пожарную', 'пожарной'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        $status = MqttService::getCacheMqtt('home/firesensor/fire_state');
        $status = ($status === '0') ? 'норма' : 'пожар';
        return 'Система пожарной безопасности в статусе - ' . $status;
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
