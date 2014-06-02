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
    'meetupevent' => 'http://www.meetup.com/laravel-dallas-fort-worth/events/181020812/',
    'locationname' => 'Google Hangouts',
    'locationurl' => 'https://plus.google.com/events/c5ntekdiv2fd133r2smt40prqck',
    'datetime' => 'Thursday, June 5th at 7:00pm',
    'speaker' => 'Osvaldo Brignoni',
    'speakerurl' => 'https://twitter.com/obrignoni',
    'speakerimg' => 'img/osvaldo-brignoni.jpg',
    'talk' => 'Building Streams'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/mq5pmL');
}]);

Route::get('/hangout', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/c5ntekdiv2fd133r2smt40prqck');
}));

Route::get('/live', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/c5ntekdiv2fd133r2smt40prqck');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/181020812/');
}));