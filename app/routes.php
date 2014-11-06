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
    'locationurl' => 'https://plus.google.com/events/cl7lrkuka6jvmmn267n0n2hkdak',
    'datetime' => 'Thursday, November 6th at 7:00pm',
    'speaker' => 'David Hemphill',
    'speakerurl' => 'https://twitter.com/davidhemphill',
    'speakerimg' => 'img/david-hemphill.jpg',
    'talk' => 'Crafting Packages with Workbench'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/ASNFg2');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/events/cl7lrkuka6jvmmn267n0n2hkdak');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/215415582/');
}));