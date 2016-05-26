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
        
        $meetup = Meetup::where('start_time',
            DB::table('meetups')
                ->where('status', 'upcoming')
                ->where('visibility', 'public')
                ->min(DB::raw('CAST(start_time as char)')))
            ->first();

        return view('home', [
            'data' => $meetup->toArray(),
            'startTime' => $meetup->start_time->timezone('America/Chicago')->format('l, F jS g:iA'),
        ]);
    }

}
