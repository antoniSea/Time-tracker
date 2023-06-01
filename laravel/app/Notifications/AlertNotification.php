<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AlertNotification extends Notification implements ShouldBroadcast
{
    public function __construct(
        public readonly string $message
    )
    {
    }

    public function via(): array
    {
        return ['broadcast'];
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    public function broadcastAs()
    {
        return 'AlertNotification';
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->message,
        ]);
    }
}
