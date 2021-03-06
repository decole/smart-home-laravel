<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;

/**
 * Class MqttvSensor
 * эмультор сенсора
 * @package App\Console\Commands
 */
class mqtt_vsensor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:vsensor';
    protected $mqtt;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->mqtt = new MqttService();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->mqtt->post('out_topic', 'virtual-sensor');
        $this->mqtt->post('virtual/sensor/temperature', rand(0, 30));
    }
}
