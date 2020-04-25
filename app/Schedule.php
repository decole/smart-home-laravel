<?php

namespace App;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Schedule
 *
 * @property int $id
 * @property string $command
 * @property string|null $interval
 * @property string|null $last_run
 * @property string|null $next_run
 * @property string $created
 * @property string $updated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereLastRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereNextRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereUpdated($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    protected $table = 'schedules';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'command',
        'interval',
        'last_run',
        'next_run',
        'created',
    ];

    /**
     * @param Request $request
     */
    public static function storeSchedule(Request $request)
    {
        $schedule = new self();
        $schedule->command  = $request->get('command');
        $schedule->interval = $request->get('interval');
        $schedule->last_run = $request->get('last_run');
        $schedule->next_run = $request->get('next_run');
        $schedule->save();
    }

    /**
     * @param int $id
     * @param Request $request
     */
    public static function updateSchedule(Request $request, int $id)
    {
        $schedule = self::find($id);
        $schedule->command  = $request->get('command');
        $schedule->interval = $request->get('interval');
        $schedule->last_run = $request->get('last_run');
        $schedule->next_run = $request->get('next_run');
        $schedule->save();
    }

    /**
     * {@inheritdoc}
     */
    public function begin() {
        $this->next_run = null;
        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function end() {
        $lastRunDate = new DateTime('NOW');
        $this->last_run = $lastRunDate->format('Y-m-d H:i:00');
        if($this->interval !== null && $this->interval !== '') {
            $interval = DateInterval::createFromDateString( $this->interval );
            $nextRunDate = $lastRunDate->add( $interval );
            $this->next_run = $nextRunDate->format('Y-m-d H:i:00');
        }
        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function add($command, $interval = null, $nextRun = null) {
        $model = new self;
        $model->command = $command;
        $model->interval = $interval;
        $model->last_run = null;
        $nextRunDate = new DateTime('NOW');
        $model->next_run = $nextRunDate->format('Y-m-d H:i:s');
        return $model->save();
    }

    /**
     * changing time in DB of id
     *
     * @var \App\Schedule $taskModel
     * @param $task
     * @param $date
     */
    private function changeTimer($taskId, $date): void
    {
        self::where(['id' => $taskId])
            ->update(['next_run' => $date]);

    }

    /**
     * changing time of this period time
     * @throws $e
     * @param $minutes
     * @param $timeAt
     * @return string
     */
    private function setTimer($minutes, $timeAt): string
    {
        if(!empty($timeAt)) {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d ') . $timeAt);
            $this->date = $dateTime;
        }
        else {
            if (empty($timeAt)){
                $dateTime = new DateTime();
                if(!empty($this->date)) {
                    $dateTime = $this->date;
                }
            }
        }
        $now = $dateTime->getTimestamp();
        $dateTime->setTimestamp($now + $minutes*60);
        return $dateTime->format("Y-m-d H:i:s");
    }

}
