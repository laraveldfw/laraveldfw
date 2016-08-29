<?php

namespace App;

use Log;
use DB;
use Carbon\Carbon;
use App\SlackInvite;

class SlackHelper {

    public function __construct()
    {

    }

    /*
     * Sends a confirmation link to admins via slack
     *
     * @param SlackInvite $invited
     *
     * @returns response
     */
    public function sendConfirmationToSlack(SlackInvite $invited)
    {
        return $this->slackApiCall('chat.postMessage', [
            'channel' => '#'.config('slack.invite_request.slack_confirm_channel'),
            'text' => 'From laraveldfw.com',
            'attachments' => [
                [
                    'fallback' => 'New Slack Invite Request',
                    'color' => '#36a64f',
                    'title' => 'You have a new Slack invite request',
                    'fields' => [
                        [
                            'title' => 'Name',
                            'value' => $invited->name,
                            'short' => true,
                        ],
                        [
                            'title' => 'Email',
                            'value' => $invited->email,
                            'short' => true,
                        ],
                        [
                            'title' => 'Click the link below to confirm',
                            'value' => $invited->generateConfirmationURL(),
                            'short' => false,
                        ]
                    ],
                    'ts' => $invited->created_at->timestamp
                ],
            ],
        ]);
    }

    /*
     * Notifies that the slack invite was sent and confirmed
     */


    /*
     * Checks to make sure email is unique to the team
     *
     * @param string email
     * @param string name
     *
     * @returns bool
     */
    public function emailIsUniqueToTeam($email)
    {
        $users = $this->getAllUsers();
        return !($users->contains(function ($user) use ($email) {
            return $user->profile->email !== $email;
        }));
    }

    private function getAllUsers()
    {
        $response = $this->slackApiCall('users.list');
        return collect($response->members);
    }

    public function slackApiCall($command, $arguments = null)
    {
        $url = 'https://slack.com/api/'.$command.'?token='.env('SLACK_TOKEN');
        if (gettype($arguments) === 'array' && count($arguments) > 0) {
            foreach ($arguments as $key => &$value) {
                if (gettype($value) === 'array') {
                    $value = json_encode($value);
                }
            }
            $url .= '&'.http_build_query($arguments);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $response = json_decode($output);

        if ($response->ok) {
            return $response;
        }
        else {
            Log::error('Slack error received', [$command, $arguments]);
            //abort(400);
            dd($response, $url, $arguments);
        }
    }
}