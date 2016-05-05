<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
