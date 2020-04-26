<?php

namespace App\Console\Commands\Watering;


use Illuminate\Console\Command;

class twoOn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watering:two_on';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'watering swift two turn on';

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
        $this->info('two-On');
    }

}
