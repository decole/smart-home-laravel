<?php

namespace App\Services\ValidateDevices;


use App\MqttFireSecure;
use App\Notifications\FireSecureNotify;
use App\Services\DataService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Cache;

class FireSecureValidate implements DeviceInterface
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
     * fire_secures_list - array current topics
     * fire_secures      - models serialized in array
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
        $model = MqttFireSecure::all();
        $topics = $model->pluck('topic')->toArray();
        Cache::put($this->topicModel, $model);
        Cache::put($this->topicList, $topics);

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
                if ($value['alarm_condition'] == $message->payload) {
                    MqttFireSecure::logChangeTrigger($message->topic,'зафиксирован статус - пожар');
                    $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                    DeviceService::SendNotify(new FireSecureNotify($text, $message));
                }
                break;
            }
        }
    }

}
