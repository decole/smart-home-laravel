<?php


namespace App\Services;

use App\Services\AliceActions\HelloDialog;
use App\Services\AliceActions\LampDialog;
use App\Services\AliceActions\PingDialog;
use App\Services\AliceActions\WeatherDialog;
use App\Weather;
use Illuminate\Routing\Controller as BaseController;

class WeatherService extends BaseController
{
    /**
     * @var string
     */
    private $temp;
    /**
     * @var string
     */
    private $weather_spec;

    public function __construct()
    {

    }

    /**
     * get AcuWeather parsed information at now
     */
    public function getAcuweather()
    {
        $this->temp = 'not extracted';
        $this->weather_spec = 'not extracted';
        $page    = file_get_contents( 'http://apidev.accuweather.com/currentconditions/v1/291309.json?language=ru-ru&apikey=hoArfRosT1215' );
        $decoded = json_decode( $page, true );
        if ( is_array( $decoded ) ) {
            if ( ! empty( $decoded[0]['Temperature']['Metric']['Value'] ) ) {
                $this->temp = $decoded[0]['Temperature']['Metric']['Value'];
                $this->weather_spec = $decoded[0]['WeatherText'];
            }
        }
        else {
            /** @var Weather $model */
            $model = Weather::latest()->first();
            if ($model) {
                $this->temp = $model->temperature . ' из БД';
                $this->weather_spec = $model->spec . ' из БД';
            }
        }

        return [
            'temperature'  => $this->temp,
            'spec' => $this->weather_spec,
        ];
    }

}
