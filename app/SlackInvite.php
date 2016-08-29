<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackInvite extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'created_at', 'updated_at', 'confirmed_at'
    ];

    /*
     * Invites the pending invite to the Laravel DFW slack team
     *
     * @returns array $response
     */
    public function inviteToTeam()
    {
        return json_decode(\Darovi\LaravelSlackInvite\Slack::invite($this->email));
    }

    /*
     * Generates the confirmation url that will send the invite
     *
     * @returns string $url
     */
    public function generateConfirmationURL()
    {
        return 'https://laraveldfw.com/confirmSlackInvite/'.$this->token;
    }
}
