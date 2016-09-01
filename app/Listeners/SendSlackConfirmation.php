<?php

namespace App\Listeners;

use App\Events\SlackInviteRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SlackHelper;
class SendSlackConfirmation
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
     * @param  SlackInviteRequested  $event
     * @return void
     */
    public function handle(SlackInviteRequested $event)
    {
        $confirmVia = config('slack.invite_request.manual_confirm_via');
        if ($confirmVia === 'slack' || $confirmVia === 'all') {
            $helper = new SlackHelper();
            $helper->sendConfirmationToSlack($event->invited);
        }
    }
}
