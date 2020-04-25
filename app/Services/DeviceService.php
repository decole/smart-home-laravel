<?php


namespace App\Services;


use App\MqttFireSecure;
use App\MqttRelay;
use App\MqttSecure;
use App\MqttSensor;
use App\Services\ValidateDevices\FireSecureValidate;
use App\Services\ValidateDevices\RelayValidate;
use App\Services\ValidateDevices\SecureValidate;
use App\Services\ValidateDevices\SensorValidate;
use Illuminate\Support\Facades\Cache;

class DeviceService
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
    protected $secure_model = 'secures';

    /**
     * @var FireSecureValidate
     */
    private $fireSecure;
    protected $fireSecure_list = 'fire_secures_list';
    protected $fireSecure_model = 'fire_secures';


    public function __construct()
    {
        $this->sensor     = new SensorValidate($this->sensor_list, $this->sensor_model);
        $this->relay      = new RelayValidate($this->relay_list, $this->relay_model);
        $this->secure     = new SecureValidate($this->secure_list, $this->secure_model);
        $this->fireSecure = new FireSecureValidate($this->fireSecure_list, $this->fireSecure_model);

        self::refresh();
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

    public function refresh()
    {
        Cache::forget($this->sensor_list);
        Cache::forget($this->sensor_model);

        Cache::forget($this->relay_list);
        Cache::forget($this->relay_model);

        Cache::forget($this->secure_list);
        Cache::forget($this->secure_model);

        Cache::forget($this->fireSecure_list);
        Cache::forget($this->fireSecure_model);
    }

}
