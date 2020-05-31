<?php


namespace App\Services\AliceActions;

use App\Schedule;
use DateTime;

class DiagnosticDialog implements AliceInterface
{

    public function __construct()
    {

    }

    /**
     * @inheritDoc
     */
    public function listVerb()
    {
        return ['диагностика', 'диагностики', 'диагностику'];
    }

    /**
     * @inheritDoc
     */
    public function process($message)
    {
        /** @var Schedule $model */
        $model = Schedule::find(12);
        $lastRunDate = new DateTime('NOW');
        $model->next_run = $lastRunDate->format('Y-m-d H:i:00');
        $model->interval = null;
        $model->save();
        return 'Самодиагностика запланирована в менеджере задач. Конечные данные придут в телеграм чат.';
    }

    /**
     * @inheritDoc
     */
    public function verb($message)
    {
        // TODO: Implement verb() method.
    }

}
