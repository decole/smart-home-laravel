<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;

class mqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:start';
    protected $mqtt;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starting parser on mqtt protocol';

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
        $this->mqtt->listen();
    }

}
