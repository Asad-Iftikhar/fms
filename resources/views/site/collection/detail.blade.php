@extends('site.layouts.base')
@section('title', 'Collection Info')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/widgets/chat.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/custom-file-input.css") }}">

@stop
@section('content')
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Collection </h3>
            <p class="text-subtitle text-muted">{{ $fundingCollection->getCollectionTypeName() }}</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <div class="row p-2">
                     <span class="mt-2">
                        <a href="{{ url('collections') }}" type="button" class="btn btn-primary"
                           style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <table class="table">
                            <tr>
                                <td>
                                    <h5>Amount:</h5>
                                </td>
                                <td>
                                    <h5><span class="badge bg-success" style="font-size: large">{{ 'PKR '.$fundingCollection->amount .'/-' }}</span></h5>
                                </td>
                            </tr>
                            <tr>
                                <td><h5>Status :</h5></td>
                                <td>
                                    <h5><span class="badge bg-success" style="font-size: large">{{ $fundingCollection->getPaymentStatus() }}</span></h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <section class="section">
                <div class="card">
                    <div class="card-body pt-4 bg-grey"  id="scroll" style="height: 300px; overflow: auto;">
                        <div class="chat-content">
                            @foreach ($fundingCollection->messages as $message)
                                {!! $message->getMessageHtml() !!}
                            @endforeach
                        </div>
                    </div>
                    <form method="post" id="chatForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-footer">
                            <div class="message-form d-flex flex-direction-column align-items-center">
                                <div class="d-flex flex-grow-1 ml-4">
                                    <input id="chat_message" name="content" type="text" class="form-control"
                                           placeholder="Type your message..">
                                    <input type="file" name="chat_image" id="chat-image"
                                           class="btn custom-file-input" style="width: 45%">
                                    <button id="send" name="send" class="btn btn-success">
                                        Send
                                    </button>
                                    <input type="hidden" name="collection_id" id="collection_id"
                                           value="{{ $fundingCollection->id }}">
                                    <input type="hidden" name="user_id" id="user_id"
                                           value="{{ $fundingCollection->user_id }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@section('javascript')
    @parent
    <script src="{!! asset('assets/js/pusher.min.js') !!}"></script>

    <script>
        $(document).ready(function () {

            /*chat scroll bar code*/
            $("#scroll").animate({
                scrollTop: $('#scroll').get(0).scrollHeight
            }, 1);

            /*chat form submission code*/
            $("#chatForm").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ url("collections/".$fundingCollection->id."/sendMessage") }}",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                }).done(function (data) {
                    if (data.status) {
                        $('.chat-content').append(data.message);
                        $('#chatForm')[0].reset();
                        $("#scroll").animate({
                            scrollTop: $('#scroll').get(0).scrollHeight
                        }, 1);
                    } else {
                        alert('Not able to send');
                    }
                });
            });

            /*pusher*/
            let pusher = new Pusher( '{{env("PUSHER_APP_KEY")}}',{
                cluster: '{{env("PUSHER_APP_CLUSTER")}}',
                forceTLS: true
            });

            let channel = pusher.subscribe('my-channel');
            channel.bind('my-event-{{ $fundingCollection->id }}', function (data) {
                $.ajax({
                    method: 'get',
                    url: "{{ url("collections/" . $fundingCollection->id . "/markMessagesAsSeen") }}",
                    data: {
                        _token: '{!! csrf_token() !!}'
                    },
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                }).done(function (data) {
                    if (data.status) {
                        $('.chat-content').append(data.message);
                        $('#chatForm')[0].reset();
                        $("#scroll").animate({
                            scrollTop: $('#scroll').get(0).scrollHeight
                        }, 1);
                    } else {
                        alert('Not able to send');
                    }
                });
                $('.chat-content').append(data.content);
                $("#scroll").animate({
                    scrollTop: $('#scroll').get(0).scrollHeight
                }, 1);
            });
        });
    </script>
@stop
@stop
