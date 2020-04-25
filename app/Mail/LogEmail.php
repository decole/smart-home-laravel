<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogEmail extends Mailable
{
    private $data;
    private $file;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $file)
    {
        $this->data = $data;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'Уведомление системы умного дома')
            ->view('emails.user_notify', ['feedback' => $this->data,])
            ->attach($this->file);
    }
}
