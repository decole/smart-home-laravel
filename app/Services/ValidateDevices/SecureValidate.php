<?php


namespace App\Services\ValidateDevices;


use App\MqttSecure;
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
        /**
         * @Todo analise logic
         */
        echo $message->topic . ' is secure' . PHP_EOL;
        return true;
    }

}
