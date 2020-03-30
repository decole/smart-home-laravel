<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\MqttService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class MqttApi extends Controller
{
    /**
     * Список колонок и карточек проекта
     *
     * @return array
     */
    public function index()
    {
        return [
            'version' => 1,
        ];
    }

    /**
     * Отдать данные топика
     *
     * @param Request $request
     * @return array
     */
    public function get(Request $request)
    {
        $topic = $request->input('topic');
        return [
            'payload' => MqttService::getCacheMqtt($topic),
//            'payload' => 'on',
        ];
    }

    /**
     * Отправить команду топику
     *
     * @param Request $request
     * @return mixed
     */
    public function post(Request $request)
    {
        $topic = $request->input('topic');
        $payload = $request->input('payload');
        $mqtt = new MqttService();
        return [
            'payload' => $mqtt->post($topic, $payload),
        ];
    }

}
