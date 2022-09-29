@extends('site.layouts.base')
@section('title','Login')
@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="//index.html">
                        <img src="{{ asset("/assets/images/logo/nxblogo.svg") }}" alt="Logo">
                    </a>
                </div>
                <h1 style="color:#111112" class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                <form action="{!! url('account/login') !!}" method="post">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}" />

                    <div class="form-group position-relative has-icon-left mb-4">
                        <label for="username">
                            <input type="text" class="form-control form-control-xl" name="username" id="username" value="{{{ old('username') }}}" placeholder="Username/E-Mail">
                            {!! $errors->first('username', '<small class="error">:message</small>') !!}
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="password" class="form-control form-control-xl" name="password" id="password" value="{{{ old('password') }}}"  placeholder="Password"/>
                            {!! $errors->first('password', '<small class="error">:message</small>') !!}
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" data-customforms="disabled" name="remember-me" value="1" type="checkbox" id="remember-me" >
                        <label class="form-check-label text-gray-600" for="remember-me">
                            Keep me logged in
                        </label>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p><a style="color:#111112" class="font-bold" href="{!! url('account/forgot-password') !!}">Forgot password?</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
@stop
