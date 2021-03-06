<?php


namespace App\Services\AliceActions;

class StatusDialog implements AliceInterface
{
    /**
     * @var;
     */
    public $text;

    public function __construct()
    {
        $this->text = 'Команда не распознана';
    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['статус', 'статуса', 'статусу'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        return 'Общий статус - пока неизвестен. Не разработан алгоритм диагностики.';
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
