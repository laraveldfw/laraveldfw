<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Meetup;
class NewMeetupSaved extends Event
{
    use SerializesModels;

    public $meetup;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meetup $meetup)
    {
        $this->meetup = $meetup;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
