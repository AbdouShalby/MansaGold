<?php

namespace App\Notifications;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;
use Illuminate\Notifications\Notification;

class FirebaseNotification extends Notification
{
    private $title;
    private $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return CloudMessage::new()
            ->withNotification([
                'title' => $this->title,
                'body' => $this->body,
            ]);
    }
}
