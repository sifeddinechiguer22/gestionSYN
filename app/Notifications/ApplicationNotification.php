<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ApplicationNotification extends Notification
{
    public function __construct(
        private readonly string $title,
        private readonly string $message,
        private readonly string $type = 'info',
        private readonly ?string $url = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
