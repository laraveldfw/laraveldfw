<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Mail;
use App\User;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view(Auth::check() ? 'dashboard' : 'login');
    }

    /**
     * Attempts a login.
     *
     * @return \Illuminate\Http\Response
     */
    public function attemptLogin(Requests\LoginAttemptRequest $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        
        return response()->json([
            'success' => Auth::check(),
            'user' => Auth::check() ? Auth::user()->toArray() : null,
        ]);
    }

    /**
     * Checks to see if a user is logged in.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAuth()
    {
        return response()->json([
            'success' => Auth::check(),
            'user' => Auth::check() ? Auth::user()->toArray() : null,
        ]);
    }

    /**
     * Sends a password reset email if exists.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetEmail(Requests\SendResetEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if($user){
            /*
             TODO complete later
            $user->generateResetToken();
            Mail::queue('resetEmail',['token' => $user->token], function ($m) use ($user) {
                $m->to($user->email);
                $m->subject('Reset Password Request');
            });
            */
        }
        
        return response()->json([
            'success' => true,
        ]);
    }

    public function getAllUsers()
    {
        return response()->json([
            'success' => true,
            'users' => User::all()->toArray(),
        ]);
    }


}
