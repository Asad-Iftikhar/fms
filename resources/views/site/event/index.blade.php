@extends('site.layouts.base')
@section('title', 'Events')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">

        {{--        Tabs For active and finished events--}}
        <div class="tab">
            <button class="tablinks active" onclick="clickHandle(event, 'ActiveEvents')">Active Events</button>
            <button class="tablinks" onclick="clickHandle(event, 'FinishedEvents')">Finished Events</button>
        </div>

        {{--        Active Event listing--}}
        <div id="ActiveEvents" class="tabcontent" style="display: block;">
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
                                                @if( count($activeEvents) > 0 )
                                                    @foreach( $activeEvents as $collection )
                                                        <ul class="users-list-wrapper media-list">
                                                            <li class="media mail-read">
                                                                <div class="media-body">
                                                                    <div class="user-details">
                                                                        <div class="mail-items">
                                                                                <span
                                                                                    class="list-group-item-text text-truncate">
                                                                                    <h4> {{ 'Event Name: ' . $collection->name }} </h4>
                                                                                </span>
                                                                        </div>
                                                                        <div class="mail-meta-item">
                                                                            <a href=" {{ url('events/' . $collection->id . '/' . $collection->name ) }} ">
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mail-message">
                                                                        <h5 class="list-group-item-text mb-0 truncate">
                                                                            {{ 'Event Cost: ' . $collection->event_cost }}
                                                                            {{ 'Event Status: ' . $collection->status }}
                                                                        </h5>
                                                                        <div class="mail-meta-item">
                                                                        <span class="float-right">
                                                                            <span
                                                                                class="bullet bullet-danger bullet-sm">{!! \Illuminate\Support\Carbon::createFromFormat( 'Y-m-d H:i:s', $collection->created_at )->toDateString() !!}</span>
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

        {{--        Finished Event Listing--}}

        <div id="FinishedEvents" class="tabcontent">
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
                                                @if( count($finishedEvents)>0 )
                                                    @foreach( $finishedEvents as $collection )
                                                        <ul class="users-list-wrapper media-list">
                                                            <li class="media mail-read">
                                                                <div class="media-body">
                                                                    <div class="user-details">
                                                                        <div class="mail-items">
                                                                            <span
                                                                                class="list-group-item-text text-truncate"
                                                                                style="color: red">
                                                                                <h4> {{ 'Event Name: ' . $collection->name }} </h4>
                                                                            </span>
                                                                        </div>
                                                                        <div class="mail-meta-item">
                                                                            <a href=" {{ url('events/' . $collection->id . '/' . $collection->name ) }} ">
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mail-message">
                                                                        <h5 class="list-group-item-text mb-0 truncate">
                                                                            {{ 'Event Cost: ' . $collection->event_cost }}
                                                                            {{ 'Event Status: ' . $collection->status }}
                                                                        </h5>
                                                                        <div class="mail-meta-item">
                                                                        <span class="float-right">
                                                                            <span
                                                                                class="bullet bullet-danger bullet-sm">{!! \Illuminate\Support\Carbon::createFromFormat( 'Y-m-d H:i:s', $collection->created_at )->toDateString() !!}</span>
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
                                                                        style="color:red;">
                                                                        No Finished Events Available
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
    </div>
@section('javascript')
    @parent
    <script>
    function clickHandle(evt, eventName) {
    let i, tabcontent, tablinks;

    // This is to clear the previous clicked content.
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    }

    // Set the tab to be "active".
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Display the clicked tab and set it to active.
    document.getElementById(eventName).style.display = "block";
    evt.currentTarget.className += " active";
    }
    </script>
@stop
@stop
