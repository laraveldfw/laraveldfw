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
    'locationname' => 'Google Hangouts',
    'locationurl' => 'https://plus.google.com/events/cudpuacki09mdnse9uuv9pm9cs4',
    'datetime' => 'Thursday, October 9th at 7:00pm',
    'speaker' => 'Osvaldo Brignoni',
    'speakerurl' => 'https://twitter.com/obrignoni',
    'speakerimg' => 'img/osvaldo-brignoni.jpg',
    'talk' => 'Lexicon - an expressive template engine with extensible vocabulary'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/Wm4Ygq');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/events/cudpuacki09mdnse9uuv9pm9cs4');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/195798912/');
}));