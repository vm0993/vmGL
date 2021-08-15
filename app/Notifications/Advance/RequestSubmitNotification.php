<?php

namespace App\Notifications\Advance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestSubmitNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $submitRequest, $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($submitRequest)
    {
        $this->submitRequest = $submitRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('One of your request has been submited to your approval!')
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->submitRequest['request_id'],
            'user_name' => $this->submitRequest['user_name'],
            'code' => $this->submitRequest['code'],
            'body' => $this->submitRequest['body'],
        ];
    }
}
