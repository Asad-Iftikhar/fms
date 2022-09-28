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

        // else Load Normal User View
        $User =  Auth::user();
        return view( 'index', compact( 'User' ) );
    }



    public function login(Request $request){


    }
}
