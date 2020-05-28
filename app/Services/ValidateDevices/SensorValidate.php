<?php

namespace App\Services\ValidateDevices;


use App\MqttSensor;
use App\Notifications\SensorNotify;
use App\Services\DataService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Cache;

class SensorValidate implements DeviceInterface
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
     * sensor_list - array current topics
     * sensors     - models serialized in array
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
     * @return array
     */
    public function createDataset()
    {
        $model = MqttSensor::all();
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
        if (!Cache::has($this->topicModel) || is_null(Cache::get($this->topicModel))) {
            self::createDataset();
            sleep(0.5);
        }
        // diagnostic and check
        $model = Cache::get($this->topicModel);
        if (empty($model)) {
            \Log::debug('$model is empty');
            \Log::debug($message);
            self::createDataset();
            self::process($model, $message);
        } else {
            self::process($model, $message);
        }
    }

    private function process($model, $message)
    {
        foreach ($model as $value) {
            if ($value['topic'] == $message->topic) {
                if (
                    ($value['from_condition'] && (integer)$message->payload < (integer)$value['from_condition']) ||
                    ($value['to_condition'] && (integer)$message->payload > (integer)$value['to_condition'])
                ) {
                    $text = DataService::getTextNotify($value['message_warn'], (string)$message->payload);
                    DeviceService::SendNotify(new SensorNotify($text, $message));
                }
                break;
            }
        }
    }

}
