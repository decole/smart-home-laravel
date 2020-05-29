<?php


namespace App\Services;

use App\Services\AliceActions\HelloDialog;
use App\Services\AliceActions\LampDialog;
use Illuminate\Routing\Controller as BaseController;

class AliceService extends BaseController
{
    public $text;
    /**
     * @var HelloDialog
     */
    private $hello;
    /**
     * @var LampDialog
     */
    private $lamp;

    public function __construct()
    {
        $this->text = null;
        $this->hello = new HelloDialog();
        $this->lamp  = new LampDialog();
    }

    /**
     * @param $message
     * @return void
     */
    public function route($message)
    {
        if (is_array($message)) {
            foreach ($message as $value)
            {
                if(self::sorter($value)) {
                    break;
                }
            }
        }
        else {
            self::sorter($message);
        }
    }

    private function sorter($verb)
    {
        if (in_array( $verb, $this->hello->listVerb() )) { // вынести массив схождений внутри инициируемого класса
            $this->text = $this->hello->process($verb);
            return true;
        }
        return false;
    }

    private function delete_value_in_array($value, $array)
    {
        if ( (($key = array_search($value, $array)) !== false) && (count($array) > 1) ) {
            unset($array[$key]);
        }
        return $array;
    }
}
