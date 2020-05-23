<?php

namespace App\Services\ValidateDevices;


use App\MqttFireSecure;
use App\MqttSecure;
use App\MqttSensor;
use App\Notifications\SecureNotify;
use App\Services\DataService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Cache;

class SecureValidate implements DeviceInterface
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
     * secures_list - array current topics
     * secures      - models serialized in array
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
     */
    public function createDataset()
    {
        $model = MqttSecure::all();
        $topics = $model->pluck('topic')->toArray();
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
        if (!Cache::has($this->topicModel) || is_null(Cache::get($this->topicModel)) ) {
            self::createDataset();
            sleep(0.5);
        }
        $model = Cache::get($this->topicModel);
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (
                    (integer)$value['alarm_condition'] == (integer)$message->payload &&
                    $value['trigger'] == true &&
                    DeviceService::is_notifying($value)
                ) {
                    MqttSecure::logAlarm($value['topic'], 'зафиксировано движение');
                    if ($value['notifying'] == true) {
                        $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                        DeviceService::SendNotify(new SecureNotify($text, $message));
                    }
                }
                break;
            }
        }
    }

}
