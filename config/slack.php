<?php

// Slack configurations

return [

    'invite_request' => [

        // manual confirm either 'slack' or 'email' or 'all'
        // set to false to bypass manual confirmation
        'manual_confirm_via' => 'slack',

        // channel to send manual slack confirmations to
        'slack_confirm_channel' => 'organizers',

        // email if manually confirming via email
        'manual_confirm_email' => env('SLACK_INVITE_EMAIL', 'support@laraveldfw.com'),

        // in minutes, put false for no expiration
        'invite_expire_minutes' => false,

        // Number of minutes to delete expired
        // make sure this is higher than invite_expire_minutes
        // put false to keep indefinitely
        'invite_delete_minutes' => 60*24*7,
    ]

];