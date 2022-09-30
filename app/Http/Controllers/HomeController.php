<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function myDemoMail()
    {
        $myEmail = 'tigerhoney123@gmail.com';

        $details = [
            'title' => 'Mail Demo from ItSolutionStuff.com',
            'url' =>''
        ];

        Mail::to($myEmail)->send(new MyDemoMail($details));

        dd("Mail Send Successfully");
    }

}
