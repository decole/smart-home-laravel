<?php

namespace App\Notifications;

use App\Jobs\SendEmail;
use App\Jobs\SendTelegramNotify;
use App\Mail\UserSendEmail;
use App\User;
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

    public $data;
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
        return ['database']; //'database', 'mail',
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage | void
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Уведомление c uberserver.ru')
            ->greeting('test')
            ->line($this->data)
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
        SendEmail::dispatch($this->data);
        return [
            'type' => 'site_notify',
            'message' => $this->data,
        ];
    }
}
