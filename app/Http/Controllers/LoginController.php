<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            //login successfully
            return redirect()->route('admin/dashboard');
        }else{
            return back()->with('error', 'Your Credentials are incorrect');
        }
//        return $request->all();
    }
}
