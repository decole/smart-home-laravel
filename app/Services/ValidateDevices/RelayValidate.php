<?php

namespace App\Services\ValidateDevices;


use App\MqttRelay;
use App\Notifications\RelayNotify;
use App\Services\DataService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Cache;

class RelayValidate implements DeviceInterface
{

    /**
     * @var string
     */
    public $topicList;
    /**
     * @var string
     */
    public $topicModel;

    public function __construct($topicList, $topicsModel)
    {
        $this->topicList = $topicList;
        $this->topicModel = $topicsModel;
    }

    /**
     * @inheritDoc
     *
     * relays_list - array current topics
     * relays      - models serialized in array
     */
    public function getTopics()
    {
        if (Cache::has($this->topicList)) {
            return $value = Cache::get($this->topicList);
        }

        return self::createDataset();
    }

    /**
     * @inheritDoc
     *
     * кэшируется модели реле и топики - топики это смесь проверочных топиков и топиков для комманд
     *
     * @return array
     */
    public function createDataset()
    {
        $model = MqttRelay::all();
        $topics = array_merge($model->pluck('topic')->toArray(), $model->pluck('check_topic')->toArray());
        Cache::rememberForever($this->topicModel, function () use ($model) {
            return $model;
        });
        Cache::rememberForever($this->topicList, function () use ($topics) {
            return $topics;
        });
        return $topics;
    }

    /**
     * @inheritDoc
     */
    public function deviceValidate($message)
    {
        if (!Cache::has($this->topicModel)) {
            self::createDataset();
        }
        $model = Cache::get($this->topicModel);
        foreach ($model as $value) {
            if ($value['check_topic'] == $message->topic) {
                if (DeviceService::is_active($value) == false) {
                    break;
                }
                if (
                    ((string)$message->payload != (string)$value['check_command_on']) &&
                    ((string)$message->payload != (string)$value['check_command_off'])
                ) {
                    self::createDataset();
                    if (DeviceService::is_notifying($value)) {
                        $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                        DeviceService::SendNotify(new RelayNotify($text, $message));
                    }
                }
                break;
            }
        }
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (DeviceService::is_active($value) == false) {
                    $notify = 'на деактивированный топик ' . $message->topic . ' пришла комманда {value}';
                    DeviceService::SendNotify(new RelayNotify($notify, $message));
                    break;
                }
                $payload = $message->payload;
                if ($value['command_on'] == $payload || $value['command_off'] == $payload) {
                    /** @var MqttRelay $relay */
                    $relay = MqttRelay::where('topic', $message->topic)->first();
                    $relay->last_command = $payload;
                    $relay->save();
                    self::createDataset();
                }
                break;
            }
        }
    }

}