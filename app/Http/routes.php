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

Route::get('/', 'HomeController@show');

/*
Route::get('/', function () {
  $data = [
    'online' => false,
    'locationname' => 'Lupe&rsquo;s TexMex Grill',
    'locationaddress' => '2200 Airport Freeway, Suite #505, Bedford, TX 76022',
    'locationphone' => '(817) 545-5004',
    'locationurl' => 'http://www.lupestxmx.com/',
    'locationlatitude' => 32.834653,
    'locationlongitude' => -97.132119,
    'datetime' => 'Thursday, May 5th at 7:00pm',
    'talk' => 'In-person MeetUp!',
    'speaker' => '',
    'speakerimg' => '',
    'speakerurl' => '',
    'additionalinfo' => '',
  ];

  return view('home', compact('data'));
});
*/

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
    $meetup = \DB::table('meetups')
        ->where('status', 'upcoming')
        ->where('visibility', 'public')
        ->orderBy('start_time', 'asc')
        ->select('meetup_id')
        ->first();
  return Redirect::away('http://www.meetup.com/laravel-dallas-fort-worth/events/'.$meetup->meetup_id.'/');
}));

Route::get('/slack', array('as' => 'slack', function()
{
    return Redirect::away('https://laraveldfw.typeform.com/to/UGKpb8');
}));

Route::get('/tell-us-about-you', ['as' => 'tellusaboutyou', function()
{
  return Redirect::away('https://docs.google.com/forms/d/1CVmWQdQEV91b5nPwlE4k2lmIyDKzjrhe0P0CTgjK2YA/viewform');
}]);

// Auth Stuff
Route::get('/logout', function() 
{
  Auth::logout();
  return redirect('/');
});

Route::get('/login', 'LoginController@show');
Route::post('/loginAttempt', 'LoginController@attemptLogin');
Route::post('/authCheck', 'LoginController@checkAuth');
Route::post('/sendResetEmail', 'LoginController@sendResetEmail');

Route::get('/getEnv', function () {
    return response()->json([
        'env' => env('APP_ENV'),
    ]);
});


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/getAllUsers', 'LoginController@getAllUsers');
    
    Route::get('/dashboard', 'DashboardController@show');
    Route::get('/getAllMeetups', 'DashboardController@getAllMeetups');
    Route::post('/saveNewMeetup', 'DashboardController@saveNewMeetup');
    
    
});

// Letsencrypt validation
Route::get('/.well-known/acme-challenge/zMxPLDkUPciZE5_179GgGHwngz2akO2Ezcc1kaUzwQo', function () {
    return "zMxPLDkUPciZE5_179GgGHwngz2akO2Ezcc1kaUzwQo.hSIaQp9ewJB-dUD3bSmxxIvFSBqeC_TRMBwj2i5orfM";
});

Route::get('/.well-known/acme-challenge/JTInKeNjuNI8KKP2Hb8LWZ7AgkA5CbZGPUCfzXJdQZE', function () {
    return "JTInKeNjuNI8KKP2Hb8LWZ7AgkA5CbZGPUCfzXJdQZE.hSIaQp9ewJB-dUD3bSmxxIvFSBqeC_TRMBwj2i5orfM";
});
