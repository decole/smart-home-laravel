<?php

namespace App\Services;


use App\MqttRelay;
use App\MqttSensor;
use App\Schedule;
use Illuminate\Routing\Controller as BaseController;
use Longman\TelegramBot\Exception\TelegramException;

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
                $scheduleData['start_time'] = \Carbon\Carbon::parse($value->next_run)->format('d.m.Y H:m');
                $scheduleData['start_time_job_id'] = $value->id;
            }
            if ($value->command == $scheduleData['end']) {
                $scheduleData['end_time'] = \Carbon\Carbon::parse($value->next_run)->format('d.m.Y H:m');
                $scheduleData['end_time_job_id'] = $value->id;
            }
        }

        (empty($scheduleData['start_time'])) ? $scheduleData['start_time'] = null : $scheduleData['start_time'];
        (empty($scheduleData['end_time'])) ? $scheduleData['end_time'] = null : $scheduleData['end_time'];
        (empty($scheduleData['start_time_job_id'])) ? $scheduleData['start_time_job_id'] = null : $scheduleData['start_time_job_id'];
        (empty($scheduleData['end_time_job_id'])) ? $scheduleData['end_time_job_id'] = null : $scheduleData['end_time_job_id'];

        return $scheduleData;
    }

    /**
     * Вывод данных о командах в планировщике заданий
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getStateOnSite()
    {
        foreach ($this->waterTopics as $waterTopic) {
            /** @var MqttRelay $waterTopic */
            $waterTopic->watering_start = self::getSchedule($waterTopic->topic);
        }

        return $this->waterTopics;
    }

    /**
     * @param $topic
     * @return bool
     */
    public function turnOn($topic)
    {
        if(self::validateTopic($topic)) {
            if (self::waterLeakage()) {
                try { (new TelegramService())->sendDecole('Зафиксирована протечка. Не могу включить клапан - ' . $topic); }
                catch (TelegramException $e) { }
                return false;
            }
//            $mqtt = new MqttService();
            (self::getPayloadCommandOn($topic) === null) ? $payload = 1 : $payload = self::getPayloadCommandOn($topic);
//            $mqtt->post($topic, $payload);
            echo $topic . ' - ' . $payload . PHP_EOL;
            return true;
        }
        return false;
    }

    /**
     * @param $topic
     * @return bool
     */
    public function turnOff($topic)
    {
        echo $topic . PHP_EOL;
        if(self::validateTopic($topic)) {
//            $mqtt = new MqttService();
            (self::getPayloadCommandOn($topic) === null) ? $payload = 0 : $payload = self::getPayloadCommandOff($topic);
//            $mqtt->post($topic, $payload);
            echo $topic . ' - ' . $payload . PHP_EOL;
            return true;
        }
        return false;
    }

    /**
     * @param $topic
     * @return bool
     */
    private function validateTopic($topic)
    {
        /** @var MqttSensor $waterTopic */
        foreach ($this->waterTopics as $waterTopic) {
            if ($waterTopic->topic == $topic) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $topic
     * @return mixed|null
     */
    private function getPayloadCommandOn($topic)
    {
        if(self::validateTopic($topic)) {
            return $this->waterTopics->where('topic', '=', $topic)->get('command_on');
        }
        try { (new TelegramService())->sendDecole('Топик автополива не настроен - ' . $topic); }
        catch (TelegramException $e) { }
        return null;
    }

    /**
     * @param $topic
     * @return mixed|null
     */
    private function getPayloadCommandOff($topic)
    {
        if(self::validateTopic($topic)) {
            return $this->waterTopics->where('topic', '=', $topic)->get('command_on');
        }
        try { (new TelegramService())->sendDecole('Топик автополива не настроен - ' . $topic); }
        catch (TelegramException $e) { }
        return null;
    }

    public function waterLeakage()
    {
        return false;
    }

}
