<?php


namespace App\Services\AliceActions;

class HelloDialog implements AliceInterface
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
     */
    public function process($message)
    {
        // TODO: Implement process() method.
    }

}
