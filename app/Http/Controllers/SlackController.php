<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SlackHelper;
use Carbon\Carbon;
use DB;
use App\SlackInvite;
use App\Events\SlackInviteConfirmed;
use App\Events\SlackInviteRequested;
use Log;

class SlackController extends Controller
{

    public function __construct()
    {

    }

    public function requestInvite(Requests\SlackInviteRequest $request)
    {
        $reinvite = false;
        $existing = SlackInvite::where('email', $request->email)->first();
        if ($existing) {
            $reinvite = true;
            $existing->delete();
        }
        $invited = SlackInvite::create([
            'name' => $request->name,
            'email' => $request->email,
            'token' => str_random(32),
        ]);
        if (config('slack.invite_request.manual_confirm_via') === false) {
            $response = $invited->inviteToTeam();
            if ($response['ok']) {
                $invited->delete();
            }
            else {
                Log::error('Error trying to send Slack invite', [$response, $invited->id]);
            }
        }
        else {
            event(new SlackInviteRequested($invited));
        }

        return response()->json([
            'success' => true,
            'reinvite' => $reinvite,
        ]);
    }

    public function confirmInvite($token)
    {
        $invited = SlackInvite::where('token', $token)->first();
        $expireMin = config('slack.invite_request.invite_expire_minutes');
        if (!$invited) {
            abort(400, 'Invite Not Found');
        }
        elseif ($expireMin && Carbon::now()->gt($invited->created_at->addMinutes($expireMin))) {
            abort(400, 'Invite Expired');
        }
        $invited->confirmed_at = Carbon::now();
        $invited->save();
        event(new SlackInviteConfirmed($invited));
        return view('inviteConfirmed', ['name' => $invited->name, 'email' => $invited->email]);

    }

    //TODO remove when done testing
    public function test()
    {

        dd($this->slackHelper->emailIsUniqueToTeam('different@email.com'));
        //dd($this->slackHelper->slackApiCall('users.list'));
    }
}
