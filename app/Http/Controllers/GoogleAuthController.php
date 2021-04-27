<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /*
    | Controller for login via Socialite/Google
    */

    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('google')->user();
        $theUser = User::firstOrCreate( ['email' => $user->getEmail() ] );
        Auth::login($theUser);
        return new UserResource( Auth::user() );
        //return redirect( '/api/user/me' );
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect( route( 'react' ) );
    }
}
