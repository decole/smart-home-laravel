<?php


namespace App\Services\AliceActions;

use App\Console\Commands\mqtt;
use App\Services\MqttService;

class LampDialog implements AliceInterface
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
        return ['свет', 'лампа', 'лампу'];
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
        (new MqttService())->post('margulis/lamp01', 'on');
        $this->text = 'Лампа включена';
    }

    private function turnOff()
    {
        (new MqttService())->post('margulis/lamp01', 'off');
        $this->text = 'Лампа выключена';
    }

}
