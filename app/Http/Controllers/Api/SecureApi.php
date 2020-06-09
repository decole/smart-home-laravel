<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\MqttSecure;
use App\Services\DeviceService;
use App\Services\MqttService;
use App\Services\ValidateDevices\SecureValidate;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SecureApi extends Controller
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
    public function state(Request $request)
    {
        $topic = $request->input('topic');
        $trigger = $this->getTrigger($topic);
        return [
            'state' => MqttService::getCacheMqtt($topic),
            'trigger' => $trigger,
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
        $payload = $request->input('trigger');
        $model = MqttSecure::where('topic', $topic)->first();
        if ($model) {
            $payload == 'on' ? $trigger = true : $trigger = false;
            /** @var MqttSecure $model */
            $model->trigger = $trigger;
            if ( $model->save() ) {
                (new DeviceService)->refresh();
                $model::logChangeTrigger($model->topic, $model->trigger);
                return [
                    'success' => 'Команда  передана успешно',
                ];
            }
            else {
                return [
                    'error' => 'Датчик не может сохранить свое новое состояние!',
                ];
            }
        }
        else {
            return [
                'error' => 'Не могу передать команду датчику!',
            ];
        }
    }

    /**
     * @param $topic
     * @return string|null
     */
    public function getTrigger($topic)
    {
        return MqttSecure::where('topic', '=',$topic )->get('trigger')->first()->trigger;
    }

}
