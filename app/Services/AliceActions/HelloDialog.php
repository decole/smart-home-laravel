<?php


namespace App\Services\AliceActions;

class HelloDialog implements AliceInterface
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
        return ['hello', 'привет'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        return 'Привет, это частный навык';
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
