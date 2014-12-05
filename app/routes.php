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
    'locationurl' => 'https://plus.google.com/events/c3ijiqs9siq3gjfegpc7g8fdk74',
    'datetime' => 'Thursday, January 8th at 7:00pm',
    'speaker' => 'Taylor Otwell',
    'speakerurl' => 'https://twitter.com/taylorotwell',
    'speakerimg' => 'img/taylor-otwell.jpg',
    'talk' => 'Live Q&A with Taylor Otwell'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/FyR6aK');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/events/c3ijiqs9siq3gjfegpc7g8fdk74');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/219083199/');
}));