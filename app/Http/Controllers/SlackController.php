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
class SlackController extends Controller
{

    public $slackHelper;

    public function __construct()
    {
        $this->slackHelper = new SlackHelper();
    }

    public function requestInvite(Requests\SlackInviteRequest $request)
    {
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
        }
        else {
            event(new SlackInviteRequested($invited));
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function confirmInvite($token)
    {
        $invited = SlackInvite::where('token', $token)->first();
        if ($invited) {
            $invited->confirmed_at = Carbon::now();
            $invited->save();
            event(new SlackInviteConfirmed($invited));
            return view('inviteConfirmed', ['name' => $invited->name, 'email' => $invited->email]);
        }
        else {
            abort(400, 'Invite Not Found');
        }

    }

    //TODO remove when done testing
    public function test()
    {

        dd($this->slackHelper->emailIsUniqueToTeam('different@email.com'));
        //dd($this->slackHelper->slackApiCall('users.list'));
    }
}
