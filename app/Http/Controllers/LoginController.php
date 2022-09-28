<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            //login successfully
            return redirect( 'admin/dashboard' )->with( 'success', 'Login Successful, Welcome' );
//            return redirect()->route('admin/dashboard');
        }else{
//            dd($request->all());
            return back()->with('error', 'Your Credentials are incorrect');
        }
//        return $request->all();
    }
    function logout()
    {
        Auth::logout();
        return redirect( 'login' )->with( 'success', 'Logged out Successfully' );
    }
}
