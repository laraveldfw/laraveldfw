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
    'meetupevent' => 'http://www.meetup.com/laravel-dallas-fort-worth/events/200296712/',
    'locationname' => 'Google Hangouts',
    'locationurl' => 'https://plus.google.com/events/ct3s9qin5mcd7tpfnj6soheigbo',
    'datetime' => 'Thursday, September 4th at 7:00pm',
    'speaker' => 'Andrew Del Prete',
    'speakerurl' => 'https://twitter.com/pathsofdesign',
    'speakerimg' => 'img/andrew-del-prete.jpg',
    'talk' => 'Laravel + Restangular'
  ];

  return View::make('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/OwBODn');
}]);

Route::get('/hangout', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/ct3s9qin5mcd7tpfnj6soheigbo');
}));

Route::get('/live', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/ct3s9qin5mcd7tpfnj6soheigbo');
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