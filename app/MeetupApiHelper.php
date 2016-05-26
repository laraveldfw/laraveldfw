<?php

namespace App;

use Carbon\Carbon;
use DMS\Service\Meetup\MeetupKeyAuthClient;
use App\Meetup;

class MeetupApiHelper {
    
    public $client;
    public $tags;
    public $meetups;
    public $meetupUrlName;

    private $apiKey;

    public function __construct()
    {
        if(!env('MEETUP_API_KEY')){
            abort(500, "Meetup API key not defined in env");
        }
        elseif(!env('MEETUP_URL_NAME')){
            abort(500, "Meetup Url name not defined in env");
        }
        $this->tags = config('meetup.meta_tags');
        $this->meetupUrlName = env('MEETUP_URL_NAME');
        $this->apiKey = env('MEETUP_API_KEY');
        $this->client = MeetupKeyAuthClient::factory([
            'key' => $this->apiKey,
        ]);
    }

    /**
     * Fetches all meetup events from meetup api and returns collection of results
     *
     * @params none
     * @return meetup collection
     */
    public function fetchAllMeetups ()
    {
        return $this->client->getEvents([
            'group_urlname' => $this->meetupUrlName,
        ]);
    }

    /**
     * Checks for any new or updated meetup info and replicates to the local db
     *
     * @params none
     * @return meetup collection
     */
    public function checkMeetupForUpdates ()
    {
        $meetups = $this->fetchAllMeetups();

        foreach ($meetups as $meetup) {
            $saved = Meetup::where('meetup_id', $meetup['id'])->first();

            // find any meta data in the description once
            $speakerName = $this->getAttributeFromDescription('speaker_name', $meetup['description']);
            $speakerImage = $this->getAttributeFromDescription('speaker_image', $meetup['description']);
            $speakerUrl = $this->getAttributeFromDescription('speaker_url', $meetup['description']);

            if($saved){
                $changed = false;
                if(!$saved->start_time->eq(Carbon::createFromTimestampUTC($meetup['time'] / 1000))){
                    $saved->start_time = Carbon::createFromTimestampUTC($meetup['time'] / 1000);
                    $changed = true;
                }
                if($saved->status !== $meetup['status']){
                    $saved->status = $meetup['status'];
                    $changed = true;
                }
                if($saved->visibility !== $meetup['visibility']){
                    $saved->visibility = $meetup['visibility'];
                    $changed = true;
                }
                if($saved->online !== isset($meetup['venue'])){
                    $saved->online = isset($meetup['venue']);
                    $changed = true;
                }

                if(isset($meetup['venue'])){
                    if($meetup['venue']['id'] !== $saved->venue_id){
                        $saved->location_name = $meetup['venue']['name'];
                        // for whatever reason meetup api does not always give zip info
                        $saved->location_address = $meetup['venue']['address_1']." ".$meetup['venue']['city'].", ".$meetup['venue']['state'].(isset($meetup['venue']['zip']) ? " ".$meetup['venue']['zip'] : "");
                        $saved->location_lat = $meetup['venue']['lat'];
                        $saved->location_lng = $meetup['venue']['lon'];
                        $saved->venue_id = $meetup['venue']['id'];

                        if(isset($meetup['venue']['phone'])){
                            $saved->location_phone = $meetup['venue']['phone'];
                        }
                        $changed = true;
                    }
                }
                else{
                    if($saved->venue_id){
                        $saved->location_name = null;
                        $saved->location_address = null;
                        $saved->location_phone = null;
                        $saved->location_url = null;
                        $saved->location_lat = null;
                        $saved->location_lng = null;
                        $saved->venue_id = null;
                        $changed = true;
                    }
                }

                if($saved->talk !== $meetup['name']){
                    $saved->talk = $meetup['name'];
                    $changed = true;
                }
                if($saved->additional_info !== $this->cleanDescription($meetup['description'])){
                    $saved->additional_info  = $this->cleanDescription($meetup['description']);
                    $changed = true;
                }
                if($saved->speaker !== $speakerName){
                    $saved->speaker = $speakerName;
                    $changed = true;
                }
                if($saved->speaker_img !== $speakerImage){
                    $saved->speaker_img = $speakerImage;
                    $changed = true;
                }
                if($saved->speaker_url !== $speakerUrl){
                    $saved->speaker_url = $speakerUrl;
                    $changed = true;
                }
                if(!$saved->created_at->eq(Carbon::createFromTimestampUTC($meetup['created'] / 1000))){
                    $saved->created_at = Carbon::createFromTimestampUTC($meetup['created'] / 1000);
                    $changed = true;
                }
                if(!$saved->updated_at->eq(Carbon::createFromTimestampUTC($meetup['updated'] / 1000))){
                    $saved->updated_at = Carbon::createFromTimestampUTC($meetup['updated'] / 1000);
                    $changed = true;
                }

                if($changed) $saved->save();
            }
            else{
                Meetup::create([
                    'meetup_id' => $meetup['id'],
                    'start_time' => Carbon::createFromTimestampUTC($meetup['time'] / 1000),
                    'status' => $meetup['status'],
                    'visibility' => $meetup['visibility'],
                    'online' => !isset($meetup['venue']),
                    'location_name' => isset($meetup['venue']) ? $meetup['venue']['name'] : null,
                    'location_address' => isset($meetup['venue']) ? $meetup['venue']['address_1']." ".$meetup['venue']['city'].", ".$meetup['venue']['state'] : null,
                    'location_phone' => null, // Meetup does not store this. Maybe grab from Google Places?
                    'location_url' => null, // same here
                    'location_lat' => isset($meetup['venue']) ? $meetup['venue']['lat'] : null,
                    'location_lng' => isset($meetup['venue']) ? $meetup['venue']['lon'] : null,
                    'talk' => $meetup['name'],
                    'additional_info' => $this->cleanDescription($meetup['description']),
                    'venue_id' => isset($meetup['venue']) ? $meetup['venue']['id'] : null,
                    'speaker' => $speakerName,
                    'speaker_img' => $speakerImage,
                    'speaker_url' => $speakerUrl,
                    'created_at' => Carbon::createFromTimestampUTC($meetup['created'] / 1000),
                    'updated_at' => Carbon::createFromTimestampUTC($meetup['updated'] / 1000),
                ]);
            }
        }


        // delete any meetups in db that may have been deleted on meetup.com
        $meetupIds = Meetup::all()->pluck('meetup_id');
        $apiIds = array_column($meetups->toArray(), 'id');
        $meetupIds->each(function ($id) use ($apiIds) {
            if(!in_array($id, $apiIds)){
                Meetup::where('meetup_id', $id)->delete();
            }
        });

        return $meetups;
    }

    /**
     * Gets additional info about the meeting from the description body (which is html)
     * TODO redo and incorporate the meetup config file -> meta_tags info
     * Current 'tags' that can be used (put them each on their own line at the bottom of the description on meetup.com)
     * @speakername Joe Smith
     * @speakerimage https://www.speaker.com/4.jpg **urls MUST start with 'http' or 'https'
     * @speakercontact https://www.speakersblog.com
     *
     * @params attribute (string|required), description (string|required)
     * @return attribute (string), or null if not present
     */
    private function getAttributeFromDescription ($attribute, $description)
    {
        if(!$description) return null;
        switch($attribute){
            case 'speaker_name':
                $tag = '@speakername';
                $cut = substr($description, stripos($description, $tag));
                $name = substr($cut, strpos($cut, ' ') + 1, strpos($cut, '</p>') - strpos($cut, ' ') - 1);
                return $name;
            case 'speaker_image':
                $tag = '@speakerimage';
                $cut = substr($description, stripos($description, $tag));
                $cut2 = substr($cut, strpos($cut, 'http'));
                $urlend = strpos($cut2, '"') > strpos($cut2, ' ') ? strpos($cut2, ' ') : strpos($cut2, '"');
                $imageurl = substr($cut2, 0, $urlend);

                return filter_var($imageurl, FILTER_VALIDATE_URL) ? $imageurl : null;
            case 'speaker_url':
                $tag = '@speakercontact';
                $cut = substr($description, stripos($description, $tag));
                $cut2 = substr($cut, strpos($cut, 'http'));
                $urlend = strpos($cut2, '"') > strpos($cut2, ' ') ? strpos($cut2, ' ') : strpos($cut2, '"');
                $contacturl = substr($cut2, 0, $urlend);

                return filter_var($contacturl, FILTER_VALIDATE_URL) ? $contacturl : null;
            default:
                return null;
        }
    }

    /**
    * Wipes out all html tags and meta data from meetup.com description for saving to db
    *
    * @params descrtiption (html string)
    * @return formatted description
    */
    private function cleanDescription($description)
    {
        $d = strip_tags($description);

        // find the lowest index of a valid tag and strip away from there to end of string
        $lowestIndex = null;
        for($i = 0; $i < count($this->tags); $i++){
            $pos = stripos($d, $this->tags[$i]['tag']);
            if($pos !== false){
                if($lowestIndex !== null){
                    $lowestIndex = $lowestIndex < $pos ? $lowestIndex : $pos;
                }
                else{
                    $lowestIndex = $pos;
                }
            }
        }
        
        if($lowestIndex !== null){
            $d = substr($d, 0, $lowestIndex);
        }
        
        return $d;
    }
    
}