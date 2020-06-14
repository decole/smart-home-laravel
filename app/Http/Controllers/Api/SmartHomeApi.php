<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class SmartHomeApi extends Controller
{
    /**
     * Список колонок и карточек проекта
     *
     * @return array
     */
    public function index()
    {
        Log::info('alice ping');

        return [
            'version' => 1,
        ];
    }

    public function unlink(Request $request)
    {
        Log::info('unlink');
        Log::info(var_export($request, true));

        return ['lol' => 'lol'];
    }

    public function devices(Request $request)
    {
//        Log::info('alice devices');
//        Log::info(var_export($request, true));

        //$bearer =  $request->bearerToken();
        $request_id =  $request->header('X-Request-Id');

        $res = [
            "request_id" => $request_id,
            "payload" => [
                "user_id" => "decole2014",
                "devices" => [
                    [
                        "id" =>  '1',
                        "name" =>  'switcher1',
                        "type" =>  'devices.types.switch',
                        "capabilities" => [
                            [
                                "type" => "devices.capabilities.on_off",
                                "retrievable" => true
                            ]
                        ],

                    ]
                ]
            ]
        ];

        return $res;
    }

    public function devicesQuery(Request $request)
    {
        Log::info('alice devicesQuery');
        Log::info(var_export($request, true));

        $request_id =  $request->header('X-Request-Id');
        $mqttLampState = MqttService::getCacheMqtt('margulis/check/lamp01');

        $res = [
            "request_id" => $request_id,
            "payload" => [
                "user_id" => "decole2014",
                "devices" => [
                    [
                        "id" =>  '1',
                        "name" =>  'switcher1',
                        "type" =>  'devices.types.switch',
                        "capabilities" => [
                            [
                                "type" => "devices.capabilities.on_off",
                                "retrievable" => true,
                                "state" => [
                                    'instance' => 'on',
                                    "value" => ($mqttLampState == 1)? true : false,
                                ],
                            ]
                        ],

                    ]
                ]
            ]
        ];

        return $res;
    }

    public function devicesAction(Request $request)
    {
//        Log::info('alice devicesAction');
//        Log::info(var_export($request, true));
        $fin = $request->getContent();
        $fin = json_decode($fin);
        $state = $fin->payload->devices[0]->capabilities[0]->state->value;

        $mqtt = new MqttService();
        if($state) {
            $mqtt->post('margulis/lamp01', 'on');
        }
        else {
            $mqtt->post('margulis/lamp01', 'off');
        }

        $request_id =  $request->header('X-Request-Id');
        $res = [
            "request_id" => $request_id,
            "payload" => [
                "user_id" => "decole2014",
                "devices" => [
                    [
                        "id" =>  '1',
                        "name" =>  'switcher1',
                        "type" =>  'devices.types.switch',
                        "capabilities" => [
                            [
                                "type" => "devices.capabilities.on_off",
                                "retrievable" => true,
                                "state" => [
                                    'instance' => 'on',
                                    "value" => $state,
                                    "action_result" => [
                                        "status" => "DONE"
                                    ],
                                ],
                            ]
                        ],
                    ]
                ]
            ]
        ];

        return $res;
    }





}
