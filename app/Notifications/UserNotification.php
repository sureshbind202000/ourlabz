<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $url;

    public function __construct($message, $url = null)
    {
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Determine channels based on user email.
     */
    public function via($notifiable)
    {
        $channels = ['database']; // Always send database notification

        // Send email only if email exists
        if (!empty($notifiable->email)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Store notification in database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->url ?? '#',
        ];
    }

    /**
     * Email format.
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Notification')
            ->line($this->message);

        if ($this->url) {
            $mail->action('View Details', $this->url);
        }

        return $mail;
    }
}
