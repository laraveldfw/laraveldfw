<?php

namespace App\Listeners;

use App\Events\SlackInviteRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

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
            Mail::queue('emails.confirmSlackInvite', [
                'name' => $event->invited->name,
                'email' => $event->invited->email,
                'token' => $event->invited->token
            ], function ($m) {
                $m->to(env('SUPPORT_EMAIL'));
                $m->subject('You have a new Slack invite request');
            });
        }
    }
}
