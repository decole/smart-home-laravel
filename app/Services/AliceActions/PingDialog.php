<?php


namespace App\Services\AliceActions;

class PingDialog implements AliceInterface
{

    public function __construct()
    {

    }

    /**
     * @inheritDoc
     * лист слов тригеров
     */
    public function listVerb()
    {
        return ['ping'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        return 'pong';
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
