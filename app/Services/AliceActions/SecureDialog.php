<?php


namespace App\Services\AliceActions;

use App\MqttSecure;
use App\Services\DeviceService;

class SecureDialog implements AliceInterface
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
        return ['охрана', 'охранная', 'охранную', 'охрану', 'безопасности', 'безопасность'];
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
        self::changeStateTrigger('home/security/margulis/1', true);
        self::changeStateTrigger('home/security/margulis/2', true);
        $this->text = 'Система безопасности включена';
    }

    private function turnOff()
    {
        self::changeStateTrigger('home/security/margulis/1', false);
        self::changeStateTrigger('home/security/margulis/2', false);
        $this->text = 'Система безопасности выключена';
    }

    private function changeStateTrigger($topic, bool $state)
    {

        $model = MqttSecure::where('topic', $topic)->first();
        $model->trigger = $state;
        if ( $model->save() ) {
            (new DeviceService)->refresh();
            $model::logChangeTrigger($model->topic, $model->trigger);
        }
    }

}
