<?php

namespace App\Services;


use App\MqttRelay;
use App\Schedule;
use Illuminate\Routing\Controller as BaseController;

class WateringService extends BaseController
{

    /**
     * @var Schedule[]|\Illuminate\Database\Eloquent\Collection
     */
    private $schedule;
    /**
     * @var \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private $waterTopics;

    public function __construct()
    {
        $this->schedule = Schedule::all();
        $this->waterTopics = MqttRelay::where('type', '=', '8')
            ->where('location', '=', '4')
            ->orderBy('id', 'asc')
            ->get();
    }

    private function getSchedule(string $topic)
    {
        /**
        watering:major_off    watering swift major turn off
        watering:major_on     watering swift major turn on
        watering:one_off      watering swift one turn off
        watering:one_on       watering swift one turn on
        watering:three_off    watering swift three turn off
        watering:three_on     watering swift three turn on
        watering:two_off      watering swift two turn off
        watering:two_on       watering swift two turn on
         */
        $scheduleData = [];
        switch ($topic) {
            case 'water/major':
                $scheduleData['start'] = 'watering:one_on';
                $scheduleData['end']   = 'watering:three_off';
                break;
            case 'water/1':
                $scheduleData['start'] = 'watering:one_on';
                $scheduleData['end']   = 'watering:two_on';
                break;
            case 'water/2':
                $scheduleData['start'] = 'watering:two_on';
                $scheduleData['end']   = 'watering:three_on';
                break;
            case 'water/3':
                $scheduleData['start'] = 'watering:three_on';
                $scheduleData['end']   = 'watering:three_off';
                break;
            default:
                $scheduleData['start'] = 'watering:major_on';
                $scheduleData['end']   = 'watering:three_off';
        }

        /** @var Schedule $value */
        foreach ($this->schedule as $value) {
            if ($value->command == $scheduleData['start']) {
                $scheduleData['start_time'] = $value->next_run;
                $scheduleData['start_time_job_id'] = $value->id;
            }
            if ($value->command == $scheduleData['end']) {
                $scheduleData['end_time'] = $value->next_run;
                $scheduleData['end_time_job_id'] = $value->id;
            }
        }

        // @Todo add ternar operators
        if (empty($scheduleData['start_time'])) { $scheduleData['start_time'] = null; }
        if (empty($scheduleData['end_time']))   { $scheduleData['end_time']   = null; }
        if (empty($scheduleData['start_time_job_id']))   { $scheduleData['start_time_job_id']   = null; }
        if (empty($scheduleData['end_time_job_id']))   { $scheduleData['end_time_job_id']   = null; }

        return $scheduleData;
    }

    public function getStateOnSite()
    {
        foreach ($this->waterTopics as $waterTopic) {
            /** @var MqttRelay $waterTopic */
            $waterTopic->watering_start = self::getSchedule($waterTopic->topic);
        }

        return $this->waterTopics;
    }


}
