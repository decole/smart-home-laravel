<?php

namespace App\Console\Commands;

//use App\Helpers\TelegramHelper;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class telegram_send_decole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:send {message : сообщение}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'telegram:send < message > to Decole';

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
        $telegram = new TelegramService();
        $message = $this->argument('message');
        $this->info($message);
        $telegram->sendDecole($message);
    }
}
