<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use SlackBot;
class SlackBotController extends Controller
{
    public $bot;

    public function __construct()
    {
        
    }

    public function slackPost(\Illuminate\Http\Request $request)
    {
        $payload = $request->json();

        if ($payload->get('type') === 'url_verification') {
            return $payload->get('challenge');
        }

        $slackBot = app(SlackBot::class);
        $slackBot->initialize(env('SLACK_TOKEN'));

        $slackBot->hears('hello', function (SlackBot $bot) {
            $bot->respond('hi');
        });
    }
}
