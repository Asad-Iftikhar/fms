@extends('site.layouts.base')
@section('title', 'Collection')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">
        <div class="page-heading email-application">
            <section class="section content-area-wrapper">
                <div class="content-right" style="width:100%">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <div class="content-body">
                            <div class="app-content-overlay"></div>
                            <div class="email-app-area">
                                <div class="email-app-list-wrapper">
                                    <div class="email-app-list">
                                        <div class="email-user-list list-group ps ps--active-y">
                                            @foreach($paidCollection as $collection)
                                                <ul class="users-list-wrapper media-list">
                                                    <li class="media mail-read">
                                                        <div class="media-body">
                                                            <div class="user-details">
                                                                <div class="mail-items">
                                                                    <span
                                                                        class="list-group-item-text text-truncate">{{$collection->getCollectionTypeName()}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="mail-message">
                                                                <p class="list-group-item-text mb-0 truncate">
                                                                    {{ $collection->amount }}
                                                                    {{ $collection->getPayment() }}
                                                                </p>
                                                                <div class="mail-meta-item">
                                                        <span class="float-right">
                                                            <span class="bullet bullet-danger bullet-sm"></span>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@stop
