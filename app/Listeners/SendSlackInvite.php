<?php

namespace App\Listeners;

use App\Events\SlackInviteConfirmed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SendSlackInvite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SlackInviteConfirmed  $event
     * @return void
     */
    public function handle(SlackInviteConfirmed $event)
    {
        $response = $event->invited->inviteToTeam();
        if (!$response['ok']) {
            Log::error('Error trying to send Slack Invite', [$response]);
        }
    }
}
