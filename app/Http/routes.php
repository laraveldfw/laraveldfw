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
    'hidemap' => true,
    'locationname' => "Google Hangouts",
    //Correct link for the August 6th broadcast
    'locationurl' => 'https://plus.google.com/u/0/events/cb3sasch33du01ml7ven66qtilg',
    'datetime' => 'Thursday, August 6th at 7:00pm',
    'speaker' => 'Daniel Puente',
    'speakerurl' => 'https://twitter.com/danielpuent3',
    'speakerimg' => 'images/daniel-puente.jpg',
    'talk' => 'Introducing Laravel 5'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/YU80aa');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/events/cski7bqm7qev95nb50n2d0ug5to');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/224087879/');
}));
