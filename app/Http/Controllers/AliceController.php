<?php


namespace App\Http\Controllers;

//use App\Alice;
//use App\AliceSecure;
//use App\Helpers\MqttHelper;
//use App\Helpers\TelegramHelper;
//use App\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AliceController extends Controller
{
    private $validUser;
    private $isAdmin;
    private $user_id;
    private $end_session;
    private $text;
    private $ttl;

    public function __construct()
    {
        $this->validUser  = false;
        $this->isAdmin = false;
        $this->user_id = false;
        $this->end_session = false;
        $this->text = 'test';
        $this->ttl = 'test';
    }

    public function index()
    {
        $apiRequestArray = json_decode(trim(file_get_contents('php://input')), true);
//        Log::info($apiRequestArray);
        //$this->process($apiRequestArray);

        $apiRequestArray['session']['session_id'] = '6dffcae1-8be0-41da-98d1-499776524e20';
        $apiRequestArray['session']['session_id'] = '8ecdeb35-0c30-4353-902f-9d63a4ae68c6';
        $apiRequestArray['session']['session_id'] = '13D65C01F8B51512AF66DAC3DCAE2F893A9D3E8B0851A6BF9C44EB512D48F065';
        $arrayToEncode = [
            'response' =>
                [
                    'text' => 'lol',//$this->text,
                    'tts' => $this->ttl,
                    'end_session' => false,
                ],
            'session' =>
                [
                    'session_id'    => $apiRequestArray['session']['session_id'],
                    'message_id'    => $apiRequestArray['session']['message_id'],
                    'user_id'       => $apiRequestArray['session']['user_id'],
                ],
            'version' => '1.0',
        ];

        return response()->json($arrayToEncode);

    }

    /**
     * обработчик присылаемых команд
     *
     * @param $apiRequestArray
     * @return mixed
     */
    private function process($apiRequestArray)
    {
//        if($apiRequestArray['request']['original_utterance'] == 'ping') {
//            return $this->ping('');
//        }
//        $tokens = $apiRequestArray['request']['nlu']['tokens'];
//        $commands = [
//            'привет'  => 'hello',
//            'pong'    => 'ping',
//        ];
//
//        foreach ($commands as $key=>$value) {
//            if(in_array($key, $tokens)) {
//
//                return $this->$value($tokens);
//            }
//        }
        return $this->hello($apiRequestArray);

    }

    /**
     * Приветствие
     *
     * @param $text
     * @return string
     */
    private function hello($tokens)
    {
        $this->text = 'Привет, я уберсервер, я обслуживаю этот дом. Благодаря мне он становится умным.Мне можно сказать:
        Привет, статус сенсоров, статус полива, общий статус, запусти планировщик, стоп или авария для аварийного
        выключения автополива. Включи шланг.';
        $this->ttl = '123123';
    }

    /**
     * Яндекс раз в пол минуты пингует навык, сцуко. Для уменьшения нагрузки на серв сделал специальную заглушку
     *
     * @param $text
     * @return string
     */
    private function ping($tokens)
    {
        $this->text = 'qqwwwwwwwwwwwwwww шланг.';
        $this->ttl = 'qqwwwwwwwwwwwwwww';
    }

    /**
     * Удаляет значение из массива
     *
     * @param $value
     * @param $array
     * @return mixed
     */
    private function delete_value_in_array($value, $array)
    {
        if ( (($key = array_search($value, $array)) !== false) && (count($array) > 1) ) {
            unset($array[$key]);
        }

        return $array;

    }

}
