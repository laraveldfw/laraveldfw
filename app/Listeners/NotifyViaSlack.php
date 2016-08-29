<?php

namespace App\Listeners;

use App\Events\SlackInviteConfirmed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SlackHelper;

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
        //
    }
}
