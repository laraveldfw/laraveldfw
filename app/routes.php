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
    'meetupevent' => 'http://www.meetup.com/laravel-dallas-fort-worth/events/192671382/',
    'locationname' => 'Google Hangouts',
    'locationurl' => 'https://plus.google.com/events/clie0k9fcfs5vgtmq8f0mfv8mu8',
    'datetime' => 'Thursday, August 7th at 7:00pm',
    'speaker' => 'John Fischelli',
    'speakerurl' => 'https://twitter.com/johnfischelli',
    'speakerimg' => 'img/john-fischelli.jpg',
    'talk' => 'A practical look at your first Angular / Laravel App'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/QpLJ4s');
}]);

Route::get('/hangout', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/c5ntekdiv2fd133r2smt40prqck');
}));

Route::get('/live', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/clie0k9fcfs5vgtmq8f0mfv8mu8');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/181020812/');
}));

Route::get('/dallas-maker-space', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/dallasmakerspace/events/182120322/');
}));

Route::get('/php-world', array('as' => 'rsvp', function()
{
  return Redirect::away('http://world.phparch.com');
}));