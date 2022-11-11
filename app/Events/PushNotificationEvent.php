<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $content;
    /**
     * @var
     */
    public $eventName;

    /**
     * PushNotificationEvent constructor.
     * @param String $eventName
     * @param String $content
     */
    public function __construct($eventName, $content)
    {
        $this->content = $content;
        $this->eventName = $eventName;
    }

    /**
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    /**
     * @return eventname
     */
    public function broadcastAs()
    {
        return $this->eventName;
    }
}
