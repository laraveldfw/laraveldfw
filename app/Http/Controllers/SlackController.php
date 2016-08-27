<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SlackHelper;
use Carbon\Carbon;
class SlackController extends Controller
{

    public $slackHelper;

    public function __construct()
    {
        $this->slackHelper = new SlackHelper();
    }

    public function requestInvite(Requests\SlackInviteRequest $request)
    {

    }

    public function confirmInvite($token)
    {

    }

    //TODO remove when done testing
    public function test()
    {
        dd($this->slackHelper->sendConfirmationToSlack(collect([
            'name' => 'Joe Test',
            'email' => 'test@test.com',
            'created_at' => Carbon::now()
        ])));
    }
}
