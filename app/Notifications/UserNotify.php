<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserNotify
 * Нотификации пользователю по второстипенным данным, не относящися к системным или состоянию датчиков и приборов
 *
 * @package App\Notifications
 */
class UserNotify extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage | void
     */
    public function toMail($notifiable)
    {

        $email = (new MailMessage)
                    ->subject('Уведомление c uberserver.ru')
                    ->greeting('Привет!')
                    ->line($this->data)
                    ->line('');
//        return Mail::to("env('EMAIL_NOTIFY')")
//            ->queue($email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'site_notify',
            'message' => $this->data,
        ];
    }
}
