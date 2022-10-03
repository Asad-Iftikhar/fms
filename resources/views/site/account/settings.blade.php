@extends('site.layouts.base')

@section('title', 'Dashboard')
@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Lorem Ipsum endir as geaa dsfir</h3>
                    <p class="text-subtitle text-muted">your ipsum lorem test aff iaffd </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">FMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Account Settings</h4>
                </div>
                <div class="card-body">
                    <ul class="nav">
                        <li class="nav-item active">
                            <a class="nav-link {{ Request::segment(2)=='profile-settings'?'active':''}}" href="{{ url('account/profile-settings') }}">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2)=='change-avatar'?'active':''}}" href="{{ url('account/change-avatar') }}">Change Avatar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::segment(2)=='change-password'?'active':''}}" href="{{ url('account/change-password') }}">Change Password</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="">
                @if(Request::segment(2)=='profile-settings')
                    @include('site.account.profile.profile_settings')
                @elseif(Request::segment(2)=='change-avatar')
                    @include('site.account.profile.change_avatar')
                @elseif(Request::segment(2)=='change-password')
                    @include('site.account.profile.change_password')
                @endif
            </div>
        </section>
    </div>


@stop
