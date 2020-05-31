<?php


namespace App\Services\AliceActions;

use App\Services\WeatherService;

class WeatherDialog implements AliceInterface
{
    /**
     * @var;
     */
    public $text;

    public function __construct()
    {
        $this->text = 'У природы нет плохой погоды';
    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['погода', 'погоды', 'погоду'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        self::verb($message);
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        $weather    = (new WeatherService())->getAcuweather();
        $temp       = $weather['temperature'];
        $spec       = $weather['spec'];
        $this->text = 'Температура: ' . $temp . ' градусов, ' . $spec;
    }

}
