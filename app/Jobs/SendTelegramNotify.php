<?php

namespace App\Jobs;

use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $address;

    public $timeout = 3;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->message = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function handle()
    {
        // @Todo как сделаю страницу настроек, сделать выборку пользователей для нотификаций телеграма и отправить им
        //       сообщение по очереди
        $model = new TelegramService();
        $model->sendDecole($this->message);
    }
}
