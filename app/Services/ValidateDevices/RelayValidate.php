<?php


namespace App\Services\ValidateDevices;


use App\MqttRelay;
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
        /**
         * @Todo analise logic
         */
        echo $message->topic . ' is relay' . PHP_EOL;
        return true;
    }

}
