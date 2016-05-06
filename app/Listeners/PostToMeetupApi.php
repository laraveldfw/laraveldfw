<?php

namespace App\Listeners;

use App\Events\NewMeetupSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DMS\Service\Meetup\MeetupKeyAuthClient;
class PostToMeetupApi implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewMeetupSaved  $event
     * @return void
     */
    public function handle(NewMeetupSaved $event)
    {

        /*
         Version 1, this doesn't work with all available fields
         but we can modify the dashboard forms going forward to
         fill out any necessary fields needed for Meetup.com

         Also, we should consider swapping out the google places api
        for location and use the meetup api to fill the autocomplete.
        That will allow us to grab the venue id which will show up better
        on the Meetup site than just a marker on the map provided by lat, lng.

        */

        /*
         
        $client = MeetupKeyAuthClient::factory(array('key' => env('MEETUP_API_KEY')));


        $meetup = $client->createEvent([
            'description' => $event->meetup->additional_info,
            'name' => $event->meetup->title,
            'time' => $event->meetup->start_time->timestamp,
            'venue_visibility' => 'members',
            'lat' => $event->meetup->location_lat,
            'lon' => $event->meetup->location_lng,
        ]);

        */

    }
}
