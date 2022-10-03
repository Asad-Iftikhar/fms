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
                    @include('site.account.setting.sidebar')
                </div>
            </div>
            <div class="">
                @if (\Request::is('account/setting/profile'))
                    @include('site.account.setting.profile_settings')
                @elseif (\Request::is('account/setting/avatar'))
                    @include('site.account.setting.change_avatar')
                @elseif(\Request::is('account/setting/change-password'))
                    @include('site.account.setting.change_password')
                @endif
            </div>
        </section>
    </div>


@stop
