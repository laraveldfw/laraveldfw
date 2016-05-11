<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DMS\Service\Meetup\MeetupKeyAuthClient;
use Carbon\Carbon;
class Meetup extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'online' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
    ];
    
    
}
