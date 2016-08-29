<?php

namespace App\Listeners;

use App\Events\SlackInviteConfirmed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SlackHelper;
use Log;

class NotifyViaSlack
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
        $helper = new SlackHelper();
        $response = $helper->notifySlackOfConfirmation($event->invited);
        if (!$response->ok) {
            Log::error('Error trying to notify Slack admins of confirmation', [$response, $event->invited->id]);
        }
    }
}
