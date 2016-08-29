<?php

namespace App\Listeners;

use App\Events\SlackInviteRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ConfirmSlackInvite;

class SendEmailConfirmation
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
        if ($confirmVia === 'email' || $confirmVia === 'all') {
            Mail::to($event->invited->email)
                ->queue(new ConfirmSlackInvite($event->invited));
        }
    }
}
