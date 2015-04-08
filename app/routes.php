<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
  $data = [
    'hidemap' => true,
    'locationname' => "Google Hangouts",
    'locationurl' => 'https://plus.google.com/events/c3c0e3qo8t6jtj476q8nrntshak',
    'datetime' => 'Thursday, April 9th at 7:00pm',
    'speaker' => 'Stuart Yamartino',
    'speakerurl' => 'https://twitter.com/stuyam',
    'speakerimg' => 'img/stuart-yamartino.jpg',
    'talk' => 'Laravel 5 in Action'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/MR8Nnt');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/events/c3c0e3qo8t6jtj476q8nrntshak');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/220953291/');
}));