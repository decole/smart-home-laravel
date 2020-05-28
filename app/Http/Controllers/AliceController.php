<?php


namespace App\Http\Controllers;

use App\Services\AliceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\Promise\all;

class AliceController extends Controller
{
    private $validUser;
    private $isAdmin;
    private $user_id;
    private $end_session;
    private $text;
    private $ttl;
    private $message_id;
    private $session_id;
    private $skill_id;
    private $new;
    private $dialog;

    public function __construct(Request $request)
    {
        $this->message_id = null;
        $this->session_id = null;
        $this->skill_id = null;
        $this->user_id = null;
        $this->new = null;

        $this->end_session = true;
        $this->validUser  = false;
        $this->isAdmin = false;
        $this->text = '';
        $this->ttl = '';

        //$this->dialog = new AliceService();
    }

    public function index(Request $request)
    {
        $request_json = $request->json()->get('session');
        $this->message_id = $request_json["message_id"];
        $this->session_id = $request_json["session_id"];
        $this->skill_id = $request_json["skill_id"];
        $this->user_id = $request_json["user_id"];
        $this->new = $request_json["new"];

        //$this->process($request_json);

        $this->text = 'test';
        $this->ttl = 'test';

        $arrayToEncode = [
            'response' =>
                [
                    'text' => $this->text,
                    'tts' => $this->ttl,
                    'end_session' => $this->end_session,
                ],
            'session' =>
                [
                    'session_id'    => $this->session_id,
                    'message_id'    => $this->message_id,
                    'user_id'       => $this->user_id,
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
