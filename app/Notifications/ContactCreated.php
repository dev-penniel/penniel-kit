<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct( public string $contactName )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New contact added',
            'message' => "{$this->contactName} was added to your contacts.",
            'icon' => 'user-plus',
            'url' => route('contacts'),
        ];
    }
}
