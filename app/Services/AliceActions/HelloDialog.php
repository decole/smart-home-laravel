<?php


namespace App\Services\AliceActions;

class HelloDialog implements AliceInterface
{

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['тест', 'привет', 'test'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        return 't';
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
