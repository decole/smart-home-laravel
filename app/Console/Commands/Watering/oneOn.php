<?php

namespace App\Console\Commands\Watering;


use App\Services\WateringService;
use Illuminate\Console\Command;

class oneOn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:one_on';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'watering swift one turn on';

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
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $watering = new WateringService();
        $watering->turnOn('water/1');
        sleep(0.5);
        $watering->turnOn('water/major');
        sleep(0.3);
        $watering->turnOff('water/2');
        sleep(0.3);
        $watering->turnOff('water/3');
    }

}
