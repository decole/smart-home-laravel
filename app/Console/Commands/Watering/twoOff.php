<?php

namespace App\Console\Commands\Watering;


use App\Services\WateringService;
use Illuminate\Console\Command;

class twoOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:two_off';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'watering swift two turn off';

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
        $this->info('two-Off');
        $watering = new WateringService();
        $watering->turnOff('water/major');
        sleep(0.5);
        $watering->turnOff('water/2');
    }

}
