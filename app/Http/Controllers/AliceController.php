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
        $this->text = null;// убрать после внедрения сервиса Алисы
        $this->ttl = null;// убрать после внедрения сервиса Алисы
    }

    public function index(Request $request)
    {
        $request_json = $request->json()->get('session');
        $this->message_id = $request_json["message_id"];
        $this->session_id = $request_json["session_id"];
        $this->skill_id = $request_json["skill_id"];
        $this->user_id = $request_json["user_id"];
        $this->new = $request_json["new"];

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        $request_json = $request->json()->get('session');
        $this->message_id = $request_json["message_id"];
        $this->session_id = $request_json["session_id"];
        $this->skill_id = $request_json["skill_id"];
        $this->user_id = $request_json["user_id"];
        $this->new = $request_json["new"];

        $this->process($request->json()->get('request')['nlu']['tokens']);

        $arrayToEncode = [
            'response' =>
                [
                    'text'        => $this->dialog->text,
                    'tts'         => $this->dialog->text,
                    'end_session' => $this->end_session,
                ],
            'session' =>
                [
                    'session_id'  => $this->session_id,
                    'message_id'  => $this->message_id,
                    'user_id'     => $this->user_id,
                ],
            'version' => '1.0',
        ];

        return response()->json($arrayToEncode);
    }

    private function process($request_json)
    {
        $this->dialog = new AliceService();
        $this->dialog->route($request_json);
    }

}
