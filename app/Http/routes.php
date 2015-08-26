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
    'locationname' => "Lupe&rsquo;s Tex Mex Grill",
    'locationurl' => 'http://lupestxmx.com/#locations',
    'datetime' => 'Wednesday, September 2nd at 7:00pm',
    'speaker' => 'LaravelDFW',
    'speakerurl' => 'http://www.laraveldfw.com',
    'speakerimg' => 'images/laravel-dfw-image.jpg',
    'talk' => 'Getting to Know Your Artisans!'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/YU80aa');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('https://plus.google.com/u/0/events/cb3sasch33du01ml7ven66qtilg');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/224493977/');
}));
