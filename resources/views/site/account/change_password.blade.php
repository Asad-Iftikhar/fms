@extends('site.layouts.base')

@section('title','Change Password')
@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="//index.html"><img src="assets/images/logo/nxblogo.svg" alt="Logo"></a>
                </div>
                <h1 style="color:#111112" class="auth-title">Change Password</h1>
                <form action="//index.html">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="text" class="form-control form-control-xl" placeholder="Email">
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="password" class="form-control form-control-xl" placeholder="New Password"/>
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="password" class="form-control form-control-xl" placeholder="Confirm Password"/>
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Change Now</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
    @stop
