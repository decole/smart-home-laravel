<?php


namespace App\Services;

use App\Services\AliceActions\DiagnosticDialog;
use App\Services\AliceActions\FireSecureDialog;
use App\Services\AliceActions\HelloDialog;
use App\Services\AliceActions\LampDialog;
use App\Services\AliceActions\PingDialog;
use App\Services\AliceActions\SecureDialog;
use App\Services\AliceActions\StatusDialog;
use App\Services\AliceActions\WateringDialog;
use App\Services\AliceActions\WeatherDialog;
use Illuminate\Routing\Controller as BaseController;

class AliceService extends BaseController
{
    /**
     * @var null
     */
    public $text;
    /**
     * @var
     */
    public $message;
    /**
     * @var
     */
    private $listing;

    public function __construct($request_json)
    {
        $this->text = 'Привет';
        $this->message = $request_json;
        $this->listing = [
            'ping'     => new PingDialog(),
            'hello'    => new HelloDialog(),
            'lamp'     => new LampDialog(),
            'weather'  => new WeatherDialog(),
            'watering' => new WateringDialog(),
            'secure'   => new SecureDialog(),
            'diagnose' => new DiagnosticDialog(),
            'status'   => new StatusDialog(),
            'fire'     => new FireSecureDialog(),
        ];
    }

    /**
     * @return void
     */
    public function route()
    {

        if (is_array($this->message)) {
            foreach ($this->message as $value)
            {
                if(self::sorter($value)) {
                    break;
                }
            }
        }
        else {
            self::sorter($this->message);
        }
    }

    private function sorter($verb)
    {
        foreach ($this->listing as $value) {
            if (in_array( $verb, $value->listVerb() )) {
                $this->text = $value->process($this->message);
                return true;
            }
        }
        return false;
    }

//    static public function delete_value_in_array($value, $array)
//    {
//        if ( (($key = array_search($value, $array)) !== false) && (count($array) > 1) ) {
//            unset($array[$key]);
//        }
//        return $array;
//    }
}
