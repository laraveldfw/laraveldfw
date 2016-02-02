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
    'locationname' => 'Google Hangouts',
    'locationaddress' => 'n/a',
    'locationphone' => 'n/a',
    'locationurl' => 'http://www.youtube.com/watch?v=DAwx-MrlYmE',
    'datetime' => 'Thursday, February 4th at 7:00pm',
    'speaker' => 'LaravelDFW Organizers',
    'speakerurl' => 'http://www.laraveldfw.com',
    'speakerimg' => 'images/laravel-dfw-image.jpg',
    'talk' => 'Building APIs with Lumen'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/oGBGRZ');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('http://www.youtube.com/watch?v=DAwx-MrlYmE');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/228334352/');
}));
