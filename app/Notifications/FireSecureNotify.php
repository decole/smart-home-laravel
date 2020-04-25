<?php

namespace App\Notifications;

use App\Jobs\SendTelegramNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FireSecureNotify extends Notification implements ShouldQueue
{
    use Queueable;

    private $message;
    private $topic;
    private $payload;

    /**
     * Create a new notification instance.
     *
     * @param $message
     * @param $mqtt
     */
    public function __construct($message, $mqtt)
    {
        $this->message = $message;
        $this->topic   = $mqtt->topic;
        $this->payload = $mqtt->payload;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // 'mail',
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Уведомление c uberserver.ru')
            ->greeting('Система пожарной безопасности')
            ->line($this->message)
            ->line('');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        SendTelegramNotify::dispatch($this->message);
        return [
            'type' => 'fire_secure',
            'topic' => $this->topic,
            'payload' => $this->payload,
            'message' => $this->message,
        ];
    }

}
