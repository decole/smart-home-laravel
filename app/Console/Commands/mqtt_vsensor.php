<?php

namespace App\Console\Commands;

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('lol');
    }
}
