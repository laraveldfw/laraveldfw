<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SlackHelper;
use Carbon\Carbon;
use DB;
class SlackController extends Controller
{

    public $slackHelper;

    public function __construct()
    {
        $this->slackHelper = new SlackHelper();
    }

    public function requestInvite(Requests\SlackInviteRequest $request)
    {
        if (config('slack.invite_request.auto_invite')) {
            $this->slackHelper->inviteUserToTeam($request->email, $request->name);
        }
        else {
            $pendingUser = $this->slackHelper->addPendingInvite($request->email, $request->name);
            $confirmVia = config('slack.invite_request.manual_confirm_via');
            if ($confirmVia === 'slack' || $confirmVia === 'all') {
                $this->slackHelper->sendConfirmationToSlack($pendingUser);
            }
            if ($confirmVia === 'email' || $confirmVia === 'all') {
                $this->slackHelper->sendConfirmationToEmail($pendingUser);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function confirmInvite($token)
    {
        $pending = $this->slackHelper->getPendingUserFromToken($token);
        if (!$pending) {
            abort(400, 'Confirmation does not exist');
        }
        $expire = config('slack.invite_request.invite_expire_minutes');
        if ($expire) {
            $expireTime = Carbon::parse($pending->created_at)->addMinutes($expire);
            if (Carbon::now()->gt($expireTime)) {
                if (config('slack.invite_request.delete_expired_confirmations')) {
                    $this->slackHelper->deletePendingInvite($pending->id);
                }
                abort(410, 'The confirmation has expired');
            }
        }
        $this->slackHelper->inviteUserToTeam($pending->email, $pending->name);
        return view('inviteConfirmed', ['name' => $pending->name, 'email' => $pending->email]);
    }

    //TODO remove when done testing
    public function test()
    {

        dd($this->slackHelper->emailIsUniqueToTeam('different@email.com'));
        //dd($this->slackHelper->slackApiCall('users.list'));
    }
}
