<?php

namespace App;

use Carbon\Carbon;
use DMS\Service\Meetup\MeetupKeyAuthClient;
use Log;
use Validator;

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
        $this->tags = collect(config('meetup.meta_tags'));
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
            $metaInfo = $this->getMetaInfoFromDescription($meetup['description']);

            if($saved){
                $changed = collect([]);
                if(!$saved->start_time->eq(Carbon::createFromTimestampUTC($meetup['time'] / 1000))){
                    $changed->push('start time changed from '.$saved->start_time->toDateTimeString().' to '.(Carbon::createFromTimestampUTC($meetup['time'] / 1000)));
                    $saved->start_time = Carbon::createFromTimestampUTC($meetup['time'] / 1000);
                }
                if($saved->status !== $meetup['status']){
                    $changed->push('status changed from '.$saved->status.' to '.$meetup['status']);
                    $saved->status = $meetup['status'];
                }
                if($saved->visibility !== $meetup['visibility']){
                    $changed->push('visibility changed from '.$saved->visibility.' to '.$meetup['visibility']);
                    $saved->visibility = $meetup['visibility'];
                }

                if($saved->online === isset($meetup['venue'])){
                    $changed->push('online status switched to '.strval($saved->online));
                    $saved->online = !isset($meetup['venue']);
                }

                if(isset($meetup['venue'])){
                    if($meetup['venue']['id'] !== $saved->venue_id){
                        $changed->push('venue id changed from '.$saved->venue_id.' to '.$meetup['venue']['id']);
                        $saved->location_name = $meetup['venue']['name'];
                        // for whatever reason meetup api does not always give zip info
                        $saved->location_address = $meetup['venue']['address_1']." ".$meetup['venue']['city'].", ".$meetup['venue']['state'].(isset($meetup['venue']['zip']) ? " ".$meetup['venue']['zip'] : "");
                        $saved->location_lat = $meetup['venue']['lat'];
                        $saved->location_lng = $meetup['venue']['lon'];
                        $saved->venue_id = $meetup['venue']['id'];

                        if(isset($meetup['venue']['phone'])){
                            $saved->location_phone = $meetup['venue']['phone'];
                        }
                    }
                }
                else{
                    // if meetup location removed from meetup site but listed in db then remove it
                    if($saved->venue_id){
                        $changed->push('Venue id '.$saved->venue_id.' removed from meetup');
                        $saved->location_name = null;
                        $saved->location_address = null;
                        $saved->location_phone = null;
                        $saved->location_url = null;
                        $saved->location_lat = null;
                        $saved->location_lng = null;
                        $saved->venue_id = null;
                    }
                }

                if($saved->talk !== $meetup['name']){
                    $changed->push('Meetup talk changed from '.$saved->talk.' to '.$meetup['name']);
                    $saved->talk = $meetup['name'];
                }
                if($saved->additional_info !== $this->cleanDescription($meetup['description'])){
                    $changed->push('Additional info changed - ORIGINAL: '.$saved->additional_info.' NEW: '.$this->cleanDescription($meetup['description']));
                    $saved->additional_info  = $this->cleanDescription($meetup['description']);
                }

                if($saved->speaker !== $metaInfo->get('speaker')){
                    $changed->push('Speaker name changed from '.$saved->speaker.' to '.$metaInfo->get('speaker'));
                    $saved->speaker = $metaInfo->get('speaker');
                }
                if($saved->speaker_img !== $metaInfo->get('speaker_img')){
                    $changed->push('Speaker imaged changed from '.$saved->speaker_img.' to '.$metaInfo->get('speaker_img'));
                    $saved->speaker_img = $metaInfo->get('speaker_img');
                }
                if($saved->speaker_url !== $metaInfo->get('speaker_url')){
                    $changed->push('Speaker url changed from '.$saved->speaker_url.' to '.$metaInfo->get('speaker_url'));
                    $saved->speaker_url = $metaInfo->get('speaker_url');
                }

                if(!$saved->created_at->eq(Carbon::createFromTimestampUTC($meetup['created'] / 1000))){
                    $changed->push('Meetup creation date changed from '.$saved->created_at->toDateTimeString().' to '.Carbon::createFromTimestampUTC($meetup['created'] / 1000)->toDateTimeString());
                    $saved->created_at = Carbon::createFromTimestampUTC($meetup['created'] / 1000);
                }
                if(!$saved->updated_at->eq(Carbon::createFromTimestampUTC($meetup['updated'] / 1000))){
                    $changed->push('Meetup updated date changed from '.$saved->updated_at->toDateTimeString().' to '.Carbon::createFromTimestampUTC($meetup['updated'] / 1000)->toDateTimeString());
                    $saved->updated_at = Carbon::createFromTimestampUTC($meetup['updated'] / 1000);
                }

                if(!$changed->isEmpty()) {
                    $saved->save();
                    Log::info('Meetup info updated for id '.$saved->id, $changed->merge($meetups->toArray())->toArray());
                }
            }
            else{
                $newmeet = Meetup::create([
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
                    'speaker' => $metaInfo->get('speaker'),
                    'speaker_img' => $metaInfo->get('speaker_img'),
                    'speaker_url' => $metaInfo->get('speaker_url'),
                    'created_at' => Carbon::createFromTimestampUTC($meetup['created'] / 1000),
                    'updated_at' => Carbon::createFromTimestampUTC($meetup['updated'] / 1000),
                ]);

                Log::info('New meetup found and replicated to id '.$newmeet->id);
            }
        }


        // delete any meetups in db that may have been deleted on meetup.com
        $meetupIds = Meetup::all()->pluck('meetup_id');
        $apiIds = array_column($meetups->toArray(), 'id');
        $meetupIds->each(function ($id) use ($apiIds) {
            if(!in_array($id, $apiIds)){
                Meetup::where('meetup_id', $id)->delete();
                Log::info('Meetup id '.$id.' removed from db');
            }
        });

        Log::info('Meetup api check completed on '.Carbon::now()->toDateTimeString());
        $this->meetups = $meetups;
        return $meetups;
    }
    
    /**
    * Gets the meta content from the description using meta tag info in config/meetup
    *
    * @params description (string|required)
    * @return Collection (keyed by table column name)
    */
    private function getMetaInfoFromDescription ($description) 
    {
        $metaInfo = collect([]);
        if(!$description) return $metaInfo;

        $this->tags->each(function ($tag) use ($description, $metaInfo) {

            $tagpos = stripos($description, $tag['tag']);
            if($tagpos !== false) {
                if(stripos($tag['validate'], 'url') !== false){
                    $cut = substr($description, $tagpos);
                    $cut2 = substr($cut, strpos($cut, 'http'));
                    $urlend = strpos($cut2, '"') > strpos($cut2, ' ') ? strpos($cut2, ' ') : strpos($cut2, '"');
                    $value = substr($cut2, 0, $urlend);
                }
                else {
                    // just grabbing whatever string is after the tag until another tag or EOL
                    $cut = substr($description, $tagpos);
                    $value = substr($cut, strpos($cut, ' ') + 1, strpos($cut, '</p>') - strpos($cut, ' ') - 1);
                }

                $validator = Validator::make(['value' => $value], ['value' => $tag['validate']]);

                if($validator->passes()){
                    $metaInfo->put($tag['column'], $value);
                }
            }
        });

        return $metaInfo;
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