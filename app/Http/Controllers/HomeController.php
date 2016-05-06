<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Meetup;
use DB;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $meetup = Meetup::where('start_time', DB::table('meetups')->max('start_time'))->first();

        return view('home', [
            'data' => $meetup->toArray(),
            'startTime' => $meetup->start_time->format('l, F jS h:iA'),
        ]);
    }

}
