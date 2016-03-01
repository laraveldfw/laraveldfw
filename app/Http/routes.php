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
    'locationname' => 'Jibaritos',
    'locationaddress' => '2855 Central Dr, Bedford, TX 76021',
    'locationphone' => '(817) 684-4077',
    'locationurl' => 'https://www.google.com/maps/place/Jibaritos+Restaurant/@32.8513353,-97.1357193,17z/data=!3m1!4b1!4m2!3m1!1s0x864e7fa1b4ebdd61:0xaa49f8dfaaf52326',
    'datetime' => 'Thursday, March 3rd at 7:00pm',
    'speaker' => 'LaravelDFW Organizers',
    'speakerurl' => 'http://www.laraveldfw.com',
    'speakerimg' => 'images/laravel-dfw-image.jpg',
    'talk' => 'Face-to-face with your fellow Artisans!'
  ];

  return view('home', compact('data'));
});

Route::get('/ask', ['as' => 'ask', function()
{
  return Redirect::away('https://tannerhearne.typeform.com/to/oGBGRZ');
}]);

Route::get('/live', array('as' => 'live', function()
{
  return Redirect::away('http://www.youtube.com/watch?v=br2O_WDXaKk');
}));


Route::get('/rsvp', array('as' => 'rsvp', function()
{
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/228334352/');
}));

Route::get('/slack', array('as' => 'slack', function()
{
    return Redirect::away('https://laraveldfw.typeform.com/to/UGKpb8');
}));
