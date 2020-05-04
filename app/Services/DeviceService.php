<?php

namespace App\Services;


use App\Notifications\SensorNotify;
use App\Services\ValidateDevices\FireSecureValidate;
use App\Services\ValidateDevices\RelayValidate;
use App\Services\ValidateDevices\SecureValidate;
use App\Services\ValidateDevices\SensorValidate;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

final class DeviceService
{
    /**
     * @var SensorValidate
     */
    private $sensor;
    protected $sensor_list = 'sensor_list';
    protected $sensor_model = 'sensors';

    /**
     * @var RelayValidate
     */
    private $relay;
    protected $relay_list = 'relay_list';
    protected $relay_model = 'relays';

    /**
     * @var SecureValidate
     */
    private $secure;
    protected $secure_list = 'secure_list';
    protected static $secure_model = 'secures';

    /**
     * @var FireSecureValidate
     */
    private $fireSecure;
    protected $fireSecure_list = 'fire_secures_list';
    protected $fireSecure_model = 'fire_secures';


    public function __construct()
    {
        self::refresh();

        $this->sensor     = new SensorValidate($this->sensor_list, $this->sensor_model);
        $this->relay      = new RelayValidate($this->relay_list, $this->relay_model);
        $this->secure     = new SecureValidate($this->secure_list, self::$secure_model);
        $this->fireSecure = new FireSecureValidate($this->fireSecure_list, $this->fireSecure_model);
    }

    /**
     * @param $message
     * @return void
     */
    public function route($message)
    {
        if (in_array($message->topic, $this->sensor->getTopics())) {
            $this->sensor->deviceValidate($message);
        }
        if (in_array($message->topic, $this->relay->getTopics())) {
            $this->relay->deviceValidate($message);
        }
        if (in_array($message->topic, $this->secure->getTopics())) {
            $this->secure->deviceValidate($message);
        }
        if (in_array($message->topic, $this->fireSecure->getTopics())) {
            $this->fireSecure->deviceValidate($message);
        }
    }

    /**
     * Обновления кэша топиков
     *
     * @return void
     */
    public function refresh()
    {
        Cache::forget($this->sensor_list);
        Cache::forget($this->sensor_model);

        Cache::forget($this->relay_list);
        Cache::forget($this->relay_model);

        Cache::forget($this->secure_list);
        Cache::forget(self::$secure_model);

        Cache::forget($this->fireSecure_list);
        Cache::forget($this->fireSecure_model);
    }

    /**
     * Проверка возможности отправки нотификации
     *
     * @param $value
     * @return bool
     */
    public static function is_notifying($value)
    {
        return $value['notifying'];
    }

    /**
     * Проверка активности топиков из БД
     *
     * @param $value
     * @return bool
     */
    public static function is_active($value)
    {
        return $value['active'];
    }

    /**
     * Отправка уведомлений
     *
     * @param \Illuminate\Notifications\Notification $object
     */
    public static function SendNotify(\Illuminate\Notifications\Notification $object)
    {
        /** @var SensorNotify $note */
        $note = $object;
        $user = User::where('name', 'decole')->first();
        $is_double = false;
        foreach ($user->unreadNotifications as $notification) {
            echo var_export($notification->data['message'], true) . ' - ';
            echo var_export($note->message, true) . PHP_EOL;
            if ($notification->data['message'] == $note->message) {
                $startTime = Carbon::parse($notification->created_at);
                $finishTime = Carbon::now();
                if ($finishTime->diffInSeconds($startTime) < 30) {
                    $is_double = true;
                }
                break;
            }
        }
        if (!$is_double) {
            echo 'sending message, not find double notify'.PHP_EOL;
            Notification::send($user, $object);
        }
    }

    public static function getSecureModel()
    {
        $secure_model = self::$secure_model;
        return Cache::get($secure_model);
    }
}
