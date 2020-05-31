<?php


namespace App\Services\AliceActions;

use App\Services\MqttService;

class WateringDialog implements AliceInterface
{
    /**
     * @var;
     */
    public $text;

    public function __construct()
    {
        $this->text = 'Команда не распознана';
    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['шланг', 'шланга', 'вода', 'воды', 'воду'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        if (is_array($message)) {
            foreach ($message as $value) {
                self::verb($value);
            }
        }
        else {
            if(!empty($message)) {
                self::verb($message);
            }
        }

        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        (in_array( $message, ['включить', 'включи', 'включай'] ))    ? self::turnOn() : null;
        (in_array( $message, ['выключить', 'выключи', 'выключай'] )) ? self::turnOff() : null;
    }

    private function turnOn()
    {
        (new MqttService())->post('water/major', '1');
        $this->text = 'Шланг включен';
    }

    private function turnOff()
    {
        (new MqttService())->post('water/major', '0');
        $this->text = 'Шланг выключен';
    }

}
