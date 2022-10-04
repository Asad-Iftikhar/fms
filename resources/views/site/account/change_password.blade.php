@extends('site.layouts.auth')

@section('title','Change Password')
@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="//index.html"><img src="assets/images/logo/nxblogo.svg" alt="Logo"></a>
                </div>
                <h2 style="color:#111112" >Change Password</h2>
                <form action="{!! url('account/reset-password/' . $token ) !!}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            {{ $user->username }}
                        </label>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="password" class="form-control form-control-xl" placeholder="New Password" name='password' required autofocus/>
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="password" name="password_confirmation" class="form-control form-control-xl" placeholder="Confirm Password"/>
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Change Now</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
@stop
