<?php

return [

    'meta_tags' => [
        [
            'tag' => '@speakername',
            'column' => 'speaker',
            'validate' => 'string|max:255'
        ],
        [
            'tag' => '@speakerimage',
            'column' => 'speaker_img',
            'validate' => 'url'
        ],
        [
            'tag' => '@speakercontact',
            'column' => 'speaker_url',
            'validate' => 'url'
        ],
    ],

    'members_cache_timeout' => (4*60),

];