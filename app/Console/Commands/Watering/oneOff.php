<?php

namespace App\Console\Commands\Watering;


use Illuminate\Console\Command;

class oneOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:one_off';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'watering swift one turn off';

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
        $this->info('one-Off');
    }

}
