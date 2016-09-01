<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\SlackInvite;

class SlackInviteRequested
{
    use InteractsWithSockets, SerializesModels;

    public $invited;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SlackInvite $invited)
    {
        $this->invited = $invited;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
