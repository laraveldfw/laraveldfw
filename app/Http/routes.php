<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
  $data = [
    'online' => true,
    'locationname' => "YouTube Live Stream",
    'locationurl' => 'http://www.youtube.com/watch?v=DAwx-MrlYmE',
    'datetime' => 'Thursday, October 1st at 7:00pm',
    'speaker' => 'LaravelDFW Organizers',
    'speakerurl' => 'http://www.laraveldfw.com',
    'speakerimg' => 'images/laravel-dfw-image.jpg',
    'talk' => 'How We Upgraded to Laravel 5, Use GitHub, and Auto-deploy with Forge'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/fjgRPg');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('http://www.youtube.com/watch?v=DAwx-MrlYmE');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/224493977/');
}));
