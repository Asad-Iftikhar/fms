@extends('site.layouts.base')
@section('title', 'Collection')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">

        {{--        Tabs For active and finished events--}}
        <div class="tab">
            <button class="tablinks active" onclick="clickHandle(event, 'ReceivedCollection')">Received Collections <span class="badge bg-danger">{{ \App\Models\Fundings\FundingCollectionMessage::getUnreadMessagesCountByUserId(auth()->user()->id, \App\Models\Fundings\FundingCollectionMessage::ReceivedCollectionMessages) }}</span></button>
            <button class="tablinks" onclick="clickHandle(event, 'PendingCollection')">Pending Collections <span class="badge bg-danger">{{ \App\Models\Fundings\FundingCollectionMessage::getUnreadMessagesCountByUserId(auth()->user()->id, \App\Models\Fundings\FundingCollectionMessage::PendingCollectionMessages) }}</span></button>
        </div>

        {{--        Received Collection listing--}}
        <div id="ReceivedCollection" class="tabcontent" style="display: block;">
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
                                                @if(count($receivedCollection) > 0)
                                                    @foreach($receivedCollection as $collection)

                                                        {{--Collection Listing--}}

                                                        <ul class="users-list-wrapper media-list">
                                                            <li class="media mail-read">
                                                                <div class="media-body">
                                                                    <div class="user-details">
                                                                        <div class="mail-items">
                                                                    <span class="list-group-item-text text-truncate">
                                                                        <h4>{{'Collection Name: ' . $collection->getCollectionEventName()}}</h4>

                                                                    </span>
                                                                        </div>
                                                                        <div class="mail-meta-item">
                                                                            <a href=" {{ url('collections/' . $collection->id ) }} ">
                                                                                <span class="badge bg-danger">{{ \App\Models\Fundings\FundingCollectionMessage::getUnreadMessagesCountByUserId(auth()->user()->id, \App\Models\Fundings\FundingCollectionMessage::ReceivedCollectionMessages, $collection->id) }}</span>
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mail-message">
                                                                        <h5 class="list-group-item-text mb-0 truncate">
                                                                            {{'Amount: ' . $collection->amount }}
                                                                            {{'Payment Status: ' .  $collection->getPaymentStatus() }}
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
                                                                        No Received Collections Available
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

        {{--        Pending Collection listing--}}
        <div id="PendingCollection" class="tabcontent">
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
                                                @if(count($previousPendingCollection) > 0)
                                                    @foreach($previousPendingCollection as $collection)

                                                        {{--Collection Listing--}}

                                                        <ul class="users-list-wrapper media-list">
                                                            <li class="media mail-read">
                                                                <div class="media-body">
                                                                    <div class="user-details">
                                                                        <div class="mail-items">
                                                                    <span class="list-group-item-text text-truncate">
                                                                        <h4>{{'Collection Name: ' . $collection->getCollectionEventName()}}</h4>
                                                                    </span>
                                                                        </div>
                                                                        <div class="mail-meta-item">
                                                                            <a href=" {{ url('collections/' . $collection->id ) }} ">
                                                                                <span class="badge bg-danger">{{ \App\Models\Fundings\FundingCollectionMessage::getUnreadMessagesCountByUserId(auth()->user()->id, \App\Models\Fundings\FundingCollectionMessage::PendingCollectionMessages, $collection->id) }}</span>
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mail-message">
                                                                        <h5 class="list-group-item-text mb-0 truncate">
                                                                            {{'Amount: ' . $collection->amount }}
                                                                            {{'Payment Status: ' .  $collection->getPaymentStatus() }}
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
                                                                        No Pending Collections Available
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
