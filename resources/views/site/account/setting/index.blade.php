@extends('site.layouts.base')
@section('title', 'Settings')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Settings</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">FMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('account/setting/profile') }}">Account Setting</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                @include('site.account.setting.sidebar')
                            </div>
                            @if (\Request::is('account/setting/profile'))
                                @include('site.account.setting.profile')
                            @elseif (\Request::is('account/setting/avatar'))
                                @include('site.account.setting.avatar')
                            @elseif(\Request::is('account/setting/change-password'))
                                @include('site.account.setting.password')
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
