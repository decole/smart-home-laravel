<?php

namespace App\Console\Commands\Watering;


use App\Services\MqttService;
use App\Services\WateringService;
use Illuminate\Console\Command;

class majorOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:major_off';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'watering swift major turn off';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * watering:major_off    watering swift major turn off
     * watering:major_on     watering swift major turn on
     * watering:one_off      watering swift one turn off
     * watering:one_on       watering swift one turn on
     * watering:three_off    watering swift three turn off
     * watering:three_on     watering swift three turn on
     * watering:two_off      watering swift two turn off
     * watering:two_on       watering swift two turn on
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $watering = new WateringService();
        $watering->turnOff('water/major');
        sleep(0.3);
        $watering->turnOff('water/1');
        sleep(0.2);
        $watering->turnOff('water/2');
        sleep(0.2);
        $watering->turnOff('water/3');
        sleep(0.2);
    }

}
