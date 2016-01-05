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
    'online' => false,
    'locationname' => "Lupe&rsquo;s TexMex Grill",
    'locationurl' => 'http://lupestxmx.com/',
    'datetime' => 'Thursday, January 7th at 7:00pm',
    'speaker' => 'LaravelDFW Organizers',
    'speakerurl' => 'http://www.laraveldfw.com',
    'speakerimg' => 'images/laravel-dfw-image.jpg',
    'talk' => 'Getting to know your fellow Artisans!'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/fjgRPg');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('http://www.youtube.com/watch?v=DAwx-MrlYmE');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/227225922/');
}));
