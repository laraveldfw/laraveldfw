<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Meetup;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('dashboard');
    }

    public function getAllMeetups()
    {
        return response()->json([
            'success' => true,
            'meetups' => Meetup::all()->toArray(),
        ]);
    }

    public function saveNewMeetup(Requests\SaveNewMeetupRequest $request)
    {
        $meetup = Meetup::create([
            'start_time' => $request->start_time,
            'online' => $request->online,
            'location_name' => $request->has('location_name') ? $request->location_name : null,
            'location_address' => $request->has('location_address') ? $request->location_address : null,
            'location_phone' => $request->has('location_phone') ? $request->location_phone : null,
            'location_url' => $request->has('location_url') ? $request->location_url : null,
            'location_lat' => $request->has('location_lat') ? $request->location_lat : null,
            'location_lng' => $request->has('location_lng') ? $request->location_lng : null,
            'talk' => $request->talk,
            'speaker' => $request->has('speaker') ? $request->speaker : null,
            'speaker_img' => $request->has('speaker_img') ? $request->speaker_img : null,
            'speaker_url' => $request->has('speaker_url') ? $request->speaker_url : null,
            'additional_info' => $request->has('additional_info') ? $request->additional_info : null,
        ]);

        return response()->json([
            'success' => true,
            'meetup' => $meetup->toArray(),
        ]);
    }

}
