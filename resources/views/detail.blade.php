@extends('site.layouts.base')
@section('title', 'Collection Info')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/widgets/chat.css") }}">
@stop
@section('content')
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Collection Name :: <b>{{ $pending->getCollectionTypeName() }}</b></h4>
                                </div>
                                <div class="col-6">
                            <span>
                                <a href="{{ url('/') }}" type="button" class="btn btn-primary" style="float: right"><i
                                        class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5>Total Amount of Event :</h5>
                                        </td>
                                        <td>
                                            <span class="badge bg-success" style="font-size: large">{{ $pending->amount . ' ' .'Rs' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Status :</h5></td>
                                        <td><span class="badge bg-success" style="font-size: large">{{ $pending->getPaymentStatus() }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <section class="section">
                        <div class="card">
                            <div class="card-body pt-4 bg-grey" id="scroll" style="height: 300px; overflow: auto;">
                                <div class="chat-content">
                                    @foreach ($pending->chatMessages as $message)
                                        {!! $message->getMessageHtml() !!}
                                    @endforeach
                                </div>
                            </div>
                            <form id="chatForm" enctype="multipart/form-data">
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
                                                   value="{{ $pending->id }}">
                                            <input type="hidden" name="user_id" id="user_id"
                                                   value="{{ $pending->user_id }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

@section('javascript')
    @parent
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

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
                    url: "{{ url("collection/".$pending->id."/sendMessage") }}",
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
            let pusher = new Pusher('55c4f792919f9dc8b0fb', {
                cluster: 'ap2',
                forceTLS: true
            });

            let channel = pusher.subscribe('my-channel');
            channel.bind('my-event-{{ $pending->id }}', function (data) {
                $('.chat-content').append(data.content);
                $("#scroll").animate({
                    scrollTop: $('#scroll').get(0).scrollHeight
                }, 1);
            });
        });
    </script>
@stop
@stop
