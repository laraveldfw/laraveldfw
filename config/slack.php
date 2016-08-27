<?php

// Slack configurations

return [

    'invite_request' => [

        // whether or not to just automatically email the invite to the requester
        // all other options will be ignored
        'auto_invite' => false,

        // manual confirm either 'slack' or 'email'
        'manual_confirm_via' => 'slack',

        // email if manually confirming via email
        'manual_confirm_email' => env('SLACK_INVITE_EMAIL', 'support@laraveldfw.com'),

        // in minutes, put false for no expiration
        'invite_expire_minutes' => false,

        'delete_expired_confirmations' => false,
    ]

];