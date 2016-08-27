<?php

namespace App;

use Maknz;
use Log;
use DB;
use Carbon\Carbon;
class SlackHelper {

    private $client;

    public function __construct()
    {
        $this->client = new Maknz\Slack\Client(env('SLACK_WEBHOOK'));
    }

    /*
     * Sends a confirmation link to admins via slack
     *
     * @param collection pending
     *
     * @returns response
     */
    public function sendConfirmationToSlack($pending)
    {
        return $this->slackApiCall('chat.postMessage', [
            'channel' => '#organizers',
            'text' => 'From laraveldfw.com',
            'attachments' => json_encode([
                [
                    'fallback' => 'New Slack Invite Request',
                    'color' => '#36a64f',
                    'title' => 'You have a new Slack invite request',
                    'fields' => [
                        [
                            'title' => 'Name',
                            'value' => $pending->get('name'),
                            'short' => true,
                        ],
                        [
                            'title' => 'Email',
                            'value' => $pending->get('email'),
                            'short' => true,
                        ],
                        [
                            'title' => 'Click the link below to confirm',
                            'value' => 'https://laraveldfw.com/confirmSlackInvite/'.$pending->get('token'),
                            'short' => false,
                        ]
                    ],
                    'ts' => $pending->get('created_at')->timestamp
                ]
            ])
        ]);
    }

    /*
     * Sends a confirmation link to admins via email
     *
     * @param string email
     * @param string name
     *
     * @returns bool
     */
    public function sendConfirmationToEmail($pending)
    {

    }

    /*
     * Automatically invite the person
     *
     * @param string email
     * @param string name
     *
     * @returns bool
     */
    public function inviteUserToTeam($email, $name)
    {

    }

    /*
     * Checks to make sure the name and email are unique
     *
     * @param string email
     * @param string name
     *
     * @returns bool
     */
    public function emailAndNameAreUniqueToTeam($email, $name)
    {
        $users = $this->getAllUsers();
        return $users->contains(function ($user) use ($email, $name) {
            return ($user['name'] !== $name && $user['profile']['email'] !== $email);
        });
    }

    private function getAllUsers()
    {
        $response = $this->slackApiCall('users.list');
        return collect($response->members);
    }

    public function slackApiCall($command, $arguments = null)
    {
        $url = 'https://slack.com/api/'.$command.'?token='.env('SLACK_API_TOKEN');
        if ($arguments) {
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

    public function addPendingInvite($email, $name)
    {
        $now = Carbon::now();
        $token = str_random(32);
        DB::insert('insert into slack_pending_invites (created_at, updated_at, slack_name, email, token) values (?,?,?,?,?)', [
            $now->toDateTimeString(), $now->toDateTimeString(), $name, $email, $token
        ]);

        return collect([
            'name' => $name,
            'email' => $email,
            'token' => $token,
            'created_at' => $now
        ]);
    }
}