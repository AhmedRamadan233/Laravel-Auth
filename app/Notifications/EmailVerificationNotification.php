<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Otp;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;
    public $mailer; // to use one or more email
    private $otp;
    
    public function __construct()
    {
        $this->message = "use code for verification process";
        $this->subject = "Verification needed";
        $this->fromEmail = "ahmedromio233@gmail.com";
        $this->mailer = "smtp";
        $this->otp = new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $otp = $this->otp->generate($notifiable->email,6,60);
        return (new MailMessage)

            ->line('VERIVICaTION')
            // ->action('Notification Action', url('/'))
            // ->line('Thank you for using our application!')
            ->mailer('smtp')
            ->subject($this->subject)
            ->greeting('hello '.$notifiable->first_name)
            ->line($this->message)
            ->line('code: '.$otp->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
