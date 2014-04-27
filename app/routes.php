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
  return View::make('home')->with('hidemap', false)->with('locationurl', "https://www.google.com/maps/place/Grimaldi's/@32.9428451,-97.1184565,13z/data=!4m5!1m2!2m1!1sgrimaldi's+pizza!3m1!1s0x0:0xb2f23091741c5a94");
});

Route::get('/ask', array('as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/mq5pmL');
}));

Route::get('/hangout', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/c9bd0hitdd3m5evnhsom09g4460');
}));

Route::get('/live', array('as' => 'hangout', function()
{
  return Redirect::away('https://plus.google.com/events/c9bd0hitdd3m5evnhsom09g4460');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/176967102/');
}));