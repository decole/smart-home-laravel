<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class test_cache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:get {topic?}';
    protected $mqtt;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from mqtt topic';

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

        $topic = $this->argument('topic');
        if(!$topic) {
            $topic = $this->ask('Topic?');
        }


        $list = $this->mqtt->getCacheMqtt($topic);
        $this->info($list);

        /*
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $this->info($date);
        */
    }
}
