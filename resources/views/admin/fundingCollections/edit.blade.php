@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
    <link rel="stylesheet" href="{{ asset("assets/css/widgets/chat.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/custom-file-input.css") }}">

@endsection
@section('title', 'Funding Collection')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Funding Collection</h4>
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/funding/collections')}}" type="button" class="btn btn-primary"
                               style="float: right"><i class="iconly-boldArrow---Left-2"
                                                       style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <form method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">User</label>
                                <select class="choices form-select" disabled>
                                    <option>{{ $fundingCollection->user->username }}</option>
                                </select>
                            </div>

                            @if (!empty( $fundingCollection->funding_type_id) )
                                <div class="form-group mb-3">
                                    <label for="description" for="funding_type_id">Collection</label>
                                    <select name="funding_type_id" class="form-select" id="funding_type_id">
                                        @foreach( $fundingTypes as $fundingtype )
                                            <option data-amount="{{ $fundingtype->amount }}"
                                                    value="{{ old('funding_type_id', $fundingtype->id) }}" {{ ($fundingtype->id == $fundingCollection->funding_type_id) ? 'selected' : '' }}>{{ $fundingtype->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group mb-3">
                                    <label for="event">Event</label>
                                    <select name="event_id" class="choices form-select" disabled>
                                        @foreach( $events as $event )
                                            <option
                                                value="{{ old('event_id',$event->id) }}" {{ ($event->id == $fundingCollection->event_id ) ? 'selected' : '' }}>{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <lable>Amount</lable>
                                @if(!empty( $fundingCollection->funding_type_id ))
                                    {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                    <input type="text" name='amount' class="form-control" id="amount"
                                           value="{{ old('amount', $fundingCollection->amount) }}"/>
                                @else
                                    {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                    <input type="text"
                                           class="form-control {!! $errors->has('amount') ? 'is-invalid' : '' !!}"
                                           id="amount" name="amount"
                                           value="{{ old('amount', $fundingCollection->amount) }}"/>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="btn-group" style="z-index: 0;">
                                    <input type="radio" class="btn-check" name="is_received" id="pending" value="0"
                                           autocomplete="off" {{ ($fundingCollection->is_received == 0) ? 'checked' : '' }} />
                                    <label class="btn btn-outline-success" for="pending">Pending</label>
                                    <input type="radio" class="btn-check" name="is_received" id="received" value="1"
                                           autocomplete="off" {{ ($fundingCollection->is_received == 1) ? 'checked' : '' }} />
                                    <label class="btn btn-outline-success" for="received">Received</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6">
                        <label>Discussion Area</label>
                        <section class="section" style="border-style: groove">
                            <div class="card">
                                <div class="card-body pt-4 bg-grey pb-0" id="scroll" style="height: 300px; overflow: auto;">
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
                                                       class="btn btn-send custom-file-input" style="width: 45%">
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
            </div>
        </div>
    </section>
@section('javascript')
    @parent
    <script src="{!! asset('assets/js/pusher.min.js') !!}"></script>

    <script>
        $(document).ready(function () {
            $("#funding_type_id").change(function () {
                let amount = $('#funding_type_id option[value="' + $(this).val() + '"]').data('amount');
                $("#amount").val(amount);
            });
        });
    </script>

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
                    url: "{{ url("admin/funding/collections/".$fundingCollection->id."/sendMessage") }}",
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
            let pusher = new Pusher( '{{ env("PUSHER_APP_KEY") }}' , {
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                forceTLS: true
            });

            let channel = pusher.subscribe('my-channel');
            channel.bind('my-event-admin', function (data) {
                $.ajax({
                    method: 'get',
                    url: "{{ url("admin/funding/collections/" . $fundingCollection->id . "/markMessagesAsSeen") }}",
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
