@extends('site.layouts.auth')

@section('title','Forgot Password')
@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="//index.html"><img src="{{ asset("/assets/images/logo/nxblogo.svg") }}" alt="Logo"></a>
                </div>
                <h3 style="color:#111112">Forgot Password</h3>
                <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
                @if (session('message'))
                    <div class="alert-success" role="alert">
                        {{session('message')}}
                    </div>
                @endif
                <form action="{!! url('account/forgot-password') !!}" method="post" class="md-float-material">
                    <!-- CSRF Token -->
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <label>
                            <input type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email" required autofocus>
                        </label>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    @if ( session()-> has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Remember your account?
                        <a href="{!! url('account/login') !!}" style="color:#111112" class="font-bold">Log in</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
    @stop
