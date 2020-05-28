<?php


namespace App\Services;

use App\Services\AliceActions\HelloDialog;
use Illuminate\Routing\Controller as BaseController;

class AliceService extends BaseController
{
    private $hello_dialog;

    public function __construct()
    {
        $this->hello_dialog = new HelloDialog();
    }

    /**
     * @param $message
     * @return void
     */
    public function route($message)
    {
        $talks_hello = ['тест', 'привет'];
        if (in_array($message, $talks_hello)) {
            $this->hello_dialog->process($message);
        }
    }

}
