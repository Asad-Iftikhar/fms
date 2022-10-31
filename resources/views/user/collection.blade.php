@extends('site.layouts.base')
@section('title', 'Collection')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">
        <h3>Your Payments</h3>
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
                                            @if(count($previousPayments) > 0)
                                                @foreach($previousPayments as $collection)
                                                    <ul class="users-list-wrapper media-list">
                                                        <li class="media mail-read">
                                                            <div class="media-body">
                                                                <div class="user-details">
                                                                    <div class="mail-items">
                                                                    <span class="list-group-item-text text-truncate">
                                                                        <h4>{{$collection->getCollectionTypeName()}}</h4>
                                                                    </span>
                                                                    </div>
                                                                    <div class="mail-meta-item">
                                                                        <a href=" {{ url('account/collection/' . $collection->id ) }} ">
                                                                            View
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="mail-message">
                                                                    <h5 class="list-group-item-text mb-0 truncate">
                                                                        {{ $collection->amount }}
                                                                        {{ $collection->getPaymentMethod() }}
                                                                    </h5>
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
                                            @else
                                                <ul class="users-list-wrapper media-list">
                                                    <li class="media mail-read">
                                                        <div class="media-body">
                                                            <div class="mail-message">
                                                                <h5 class="list-group-item-text mb-0 truncate"
                                                                    style="color: red">
                                                                    No Active Events Available
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endif
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
