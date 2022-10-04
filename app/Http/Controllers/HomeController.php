<?php

namespace App\Http\Controllers;

use App\Mail\resetpassMail;
use Illuminate\Http\Request;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        // If User Not Login load login view
        if (!Auth::check()) {
            return view( 'site.account.login' );
        }

        // Load Normal User Dashboard (New activities e.g polls ) for now we just show user account dashboard as same as account route
        $User =  Auth::user();
        return view( 'dashboard', compact( 'User' ) );
    }



    public function sendMail($token)
    {

        $myEmail = 'tigerhoney123@gmail.com';

        Mail::to($myEmail)->send(new resetpassMail($token));

       dd("email sent");
    }

}
