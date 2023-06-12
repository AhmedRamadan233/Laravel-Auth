<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;
    public $message;
    public $fromemail;
    public $subject;
    public $mailer;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = "you must login";
        $this->subject ="This is a new login";
        $this->fromemail ="ahmedromio233@gmail.com";
        $this->mailer ="smtp";

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!')
                    ->mailer('smtp')
                    ->subject($this->subject)
                    ->greeting('hello'.$notifiable->first_name)
                    ->line($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
