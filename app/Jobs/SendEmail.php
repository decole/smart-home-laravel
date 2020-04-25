<?php

namespace App\Jobs;

use App\Mail\UserSendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $address;

    public $timeout = 30;
    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->message = $data;
        $this->address = env('EMAIL_NOTIFY');
    }

    /**
     * Execute the job.
     *
     * @return MailMessage
     */
    public function handle()
    {
        if (!empty($this->message)) {
            Mail::to($this->address)
                ->send(new UserSendEmail($this->message));
        }
        sleep(3);
    }
}
