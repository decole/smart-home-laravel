<?php

namespace App\Console\Commands;

use App\FailedJob;
use App\Mail\LogEmail;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class failed_jobs_notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:failed_jobs';

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
     * @return void
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function handle()
    {
        $model = FailedJob::all();
        $count = $model->count();
        if ($count > 0) {
            $service = new TelegramService();
            $service->sendDecole('обнаружены невыполненные задачи');
        }

        $path = __DIR__ . '/../../../storage/logs/';
        $fileName = 'laravel-'. date('Y-m-d') .'.log';
        $fileLogNotify = $path . $fileName;

        if(is_file($fileLogNotify)) {
            $this->info('log is set');
            Mail::to('decole@rambler.ru')
                ->send(new LogEmail('log in this date', $fileLogNotify));
        }
    }
}
