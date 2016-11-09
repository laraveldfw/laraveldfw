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
    public function show($openSlackModal = false)
    {
        
        $meetup = Meetup::where('status', 'upcoming')
            ->where('visibility', 'public')
            ->orderBy('start_time', 'asc')
            ->first();

        return view('home', [
            'data' => $meetup->toArray(),
            'startTime' => $meetup->start_time->timezone('America/Chicago')->format('l, F jS g:iA'),
            'openSlackModal' => $openSlackModal,
        ]);
    }

    /**
    * Display home page with slack modal pulled up
    *
    * @params none
    * @return \Illuminate\View\Factory
    */
    public function showSlackModal()
    {
        return $this->show(true);
    }

}
