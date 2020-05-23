<?php

namespace App\Console\Commands;


use App\Services\TelegramService;
use Illuminate\Console\Command;

class diagnostic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnostic:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'self diagnostic';

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
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function handle()
    {
        $tg = new TelegramService();
        /*@Todo спроектировать диагностику:
            - датчики
            - ошибки заданий
        */
        $tg->sendDecole('diagnosit: ok');
    }
}
