<?php


namespace App\Services\ValidateDevices;


use App\MqttFireSecure;
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
        echo $message->topic . ' is fire_secure' . PHP_EOL;
        return true;
    }

}
