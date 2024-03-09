<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class Message extends Notification
{

    /**
     * Create a new notification instance.
     */
    public $pengirim;
    public $hal;
     public $message;
     public $link;

    public static $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */

     public function __construct($pengirim,$hal,$message,$link)
    {
        $this->pengirim = $pengirim;
        $this->hal= $hal;
        $this->message = $message;
        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return $this->buildMailMessage();
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage()
    {
        return (new MailMessage)
            ->subject(Lang::get($this->hal))
            ->line(new HtmlString('<strong>Pesan dari ' . $this->pengirim . '</strong>'))
            ->line(Lang::get($this->message))
            ->action(Lang::get('Simdes'), $this->link);
            
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    

    /**
     * Set a callback that should be used when creating the email verification URL.
     *
     * @param  \Closure  $callback
     * @return void
     */

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
