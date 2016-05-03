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
    'datetime' => 'Thursday, April 7th at 7:00pm',
    'speaker' => 'Nathan Barrett',
    'speakerurl' => 'https://www.linkedin.com/in/nathan-barrett-06b91512',
    'speakerimg' => 'images/nathan-barrett.jpg',
    'talk' => 'Custom forms with Laravel and Angular 1.x',
    'additionalinfo' => 'Taylor Otwell will also be joining this month in-person! And we&rsquo;ll be right next door to the Lone Star PHP conference!'
    'locationname' => 'Lupe&rsquo;s TexMex Grill',
    'locationaddress' => '2200 Airport Freeway, Suite #505, Bedford, TX 76022',
    'locationphone' => '(817) 545-5004',
    'locationurl' => 'http://www.lupestxmx.com/',
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://www.twitter.com/laraveldfw');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('http://www.youtube.com/watch?v=yQiqYWIFE-w');
}));

Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/229426053/');
}));

Route::get('/slack', array('as' => 'slack', function()
{
    return Redirect::away('https://laraveldfw.typeform.com/to/UGKpb8');
}));

Route::get('/tell-us-about-you', ['as' => 'tellusaboutyou', function()
{
  return Redirect::away('https://docs.google.com/forms/d/1CVmWQdQEV91b5nPwlE4k2lmIyDKzjrhe0P0CTgjK2YA/viewform');
}]);
