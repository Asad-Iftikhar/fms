@extends('admin.layouts.default')

@section('title', 'Events')
@section('styles')
    @parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Event :: <b>{{ $event->name }}</b></h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{ url('admin/events') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2"></i> Back</a>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation" style="min-width:50%">
                                <a class="nav-link active" id="v-pills-form-tab" data-bs-toggle="pill"
                                   href="#v-pills-form" role="tab" aria-controls="v-pills-form"
                                   aria-selected="true">Edit Details</a>
                            </li>
                            <li class="nav-item" role="presentation" style="min-width:50%">
                                <a class="nav-link" id="v-pills-participants-tab" data-bs-toggle="pill"
                                   href="#v-pills-participants" role="tab" aria-controls="v-pills-participants"
                                   aria-selected="false">Participants</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-form" role="tabpanel"
                     aria-labelledby="v-pills-form-tab">
                    <form class="form form-vertical" method="post" action="{{ url('admin/events/edit/'.$event->id) }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name-input">Name<small class="text-danger">*</small></label>
                                    {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                                    <input type="text" value="{{ old('name', $event->name) }}"
                                           class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!} "
                                           placeholder="Event Name" name="name"
                                           id="name-input">
                                </div>
                                <div class="form-group">
                                    <label for="event-date-input">Event Date</label>
                                    {!! $errors->first('event_date', '<small class="text-danger">:message</small>') !!}
                                    <input type="date" value="{{ old('event_date', $event->event_date) }}"
                                           class="form-control {!! $errors->has('event_date') ? 'is-invalid' : '' !!} "
                                           placeholder="Event Date" name="event_date" id="event-date-input">
                                </div>
                                <div class="form-group">
                                    <h6>Event Status</h6>
                                    <div class="btn-group">
                                        <input type="radio" value="draft" class="btn-check event-status" name="status"
                                               id="warning-outlined-status" {{ old('status', $event->status)=="draft" ? 'checked' : '' }}
                                               autocomplete="off" checked>
                                        <label class="btn btn-outline-warning" for="warning-outlined-status">Draft</label>
                                        <input type="radio" value="active" class="btn-check event-status" name="status"
                                               id="success-outlined-status" {{ old('status', $event->status)=="active" ? 'checked' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-success" for="success-outlined-status">
                                            Active</label>
                                        <input type="radio" value="finished" class="btn-check event-status" name="status"
                                               id="danger-outlined-status" {{ old('status', $event->status)=="finished" ? 'checked' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-danger" for="danger-outlined-status">
                                            Finished</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc-input">Description</label>
                                    {!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
                                    <textarea rows="5" type="text"
                                              class="form-control {!! $errors->has('description', $event->description) ? 'is-invalid' : '' !!} "
                                              placeholder="Description" name="description"
                                              id="desc-input">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <h6>Employees</h6>
                                <p>Select Guests for this event</p>
                                <div class="form-group">
                                    <select name="guests[]" class="choices form-select multiple-remove"
                                            multiple="multiple">
                                        @foreach($users as $user)
                                            <option {{ (in_array($user->id, old( 'guests', $guestIds)))?'selected':'' }} value="{{$user->id}}">{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 vr">
                                <div class="form-group">
                                    <label for="event-cost-input">Event Cost</label>
                                    {!! $errors->first('event_cost', '<small class="text-danger">:message</small>') !!}
                                    <input type="number" value="{{ old('event_cost', $event->event_cost) }}"
                                           class="form-control {!! $errors->has('event_cost') ? 'is-invalid' : '' !!} "
                                           placeholder="Event Cost" name="event_cost"
                                           id="event-cost-input">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total-funds-input">Total Funds Available</label>
                                    <input readonly type="number" value="{{ $totalFunds }}"
                                           class="form-control"
                                           placeholder="Total Office Funds" name="total_funds"
                                           id="total-funds-input">
                                </div>
                            </div>
                            <div class="col-md-8 vr">
                                <h6>Payment Mode</h6>
                                <div class="btn-group">
                                    <input type="radio" value="1" class="btn-check payment_mode_radio" name="payment_mode"
                                           id="primary-outlined" {{ old('payment_mode', $event->payment_mode)=="1" ? 'checked' : '' }}
                                           autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="primary-outlined">Existing Collections</label>
                                    <input type="radio" value="2" class="btn-check payment_mode_radio" name="payment_mode"
                                           id="success-outlined" {{ old('payment_mode', $event->payment_mode)=="2" ? 'checked' : '' }}
                                           autocomplete="off">
                                    <label class="btn btn-outline-success" for="success-outlined">Existing With New
                                        Collections</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cash-by-funds-input">Cash By Office Funds</label>
                                    {!! $errors->first('cash_by_funds', '<small class="text-danger">:message</small>') !!}
                                    <input type="number" readonly value="{{ old('cash_by_funds', $event->cash_by_funds) }}"
                                           class="form-control {!! $errors->has('cash_by_funds') ? 'is-invalid' : '' !!} "
                                           placeholder="Cash By Office Funds" name="cash_by_funds"
                                           id="cash-by-funds-input">
                                </div>
                            </div>
                            <div class="col-md-2" id="cash-by-collections-div" style="display: none">
                                <div class="form-group">
                                    <label for="cash-by-collections-input">Cash By Collections</label>
                                    {!! $errors->first('cash_by_collections', '<small class="text-danger">:message</small>') !!}
                                    <input type="number" readonly value="{{ old('cash_by_collections') }}"
                                           class="form-control {!! $errors->has('cash_by_collections') ? 'is-invalid' : '' !!} "
                                           placeholder="Cash By Collections" name="cash_by_collections"
                                           id="cash-by-collections-input">
                                </div>
                            </div>
                        </div>
                        <div class="row collections-row" style="display: none">
                            <div class="col-md-12 mt-3">
                                <h6>Collections from users</h6>
                            </div>
                        </div>
                        <?php $count = 1 ?>
                        @if( !empty (old('collection_users')) )
                            <div class="col-md-8" id="participant_fieldset">
                                @foreach(old('collection_users') as $key=>$collection)
                                    <div class="row collections-row" style="display: none">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="UserSelection{{$key}}">Select multiple users for collection</label>
                                                <select id="UserSelection{{$key}}" name="collection_users[{{$key}}][]" class="choices form-select multiple-remove"
                                                        multiple="multiple">
                                                    @foreach($users as $user)
                                                        <option {{ (in_array($user->id, ( $collection )))?'selected':'' }} value="{{$user->id}}">{{$user->username}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="amount-input">Amount</label>
                                                {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                                <input type="number" data-id="UserSelection{{$key}}" value="{{ old('amount')[$key] }}"
                                                       class="form-control quantity-inputs {!! $errors->has('amount') ? 'is-invalid' : '' !!} "
                                                       placeholder="Amount" name="amount[{{$key}}]" id="amount-input">
                                            </div>
                                        </div>
                                        <div class="col-md-2 justify-content-end d-flex">
                                            <div class="form-group py-4">
                                                <button id="" class="btn-remove btn btn-danger"><i class="bi-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $count++ ?>
                                @endforeach
                            </div>
                        @else
                        <div class="col-md-8" id="participant_fieldset">
                            <?php  $count = 0 ?>
                            @foreach($collections as $key=>$collection)
                                <div class="row collections-row" style="display: none">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="UserSelection{{$count}}">Select multiple users for collection</label>
                                            <select id="UserSelection{{$count}}" name="collection_users[{{$count}}][]" class="choices form-select multiple-remove"
                                                    multiple="multiple">
                                                @foreach($users as $user)
                                                    <option {{ (in_array($user->id, ( $collection )))?'selected':'' }} value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount-input{{$count}}">Amount</label>
                                            {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                            <input type="number" data-id="UserSelection{{$count}}" value="{{ old('amount[0]', $key) }}"
                                                   class="form-control quantity-inputs {!! $errors->has('amount') ? 'is-invalid' : '' !!} "
                                                   placeholder="Amount" name="amount[{{$count}}]" id="amount-input{{$count}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 justify-content-end d-flex">
                                        <div class="form-group py-4">
                                            <button id="" class="btn-remove btn btn-danger"><i class="bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php  $count++ ?>
                            @endforeach
                        </div>
                        @endif
                        <div class="row collections-row" style="display: none">
                            <div class="col-md-12">
                                <button id="" class="btn-add btn btn-success"><i class="bi-plus-circle"></i> Add Row</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-4 me-1 mb-1">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="tab-pane fade" id="v-pills-participants" role="tabpanel"
                     aria-labelledby="v-pills-participants-tab">
                    <div class="row my-4">
                        <div class="col-md-6">
                            <h4>Guests and Participants</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            @if($event->event_date >= $currentDate || $event->status != 'finished')
                            <button class="btn btn-primary ajax-all-btn" data-action="{{ url('admin/events/invite-all') }}" data-id="{{ $event->id }}">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <i class="iconly-boldSend"></i> Invite all
                            </button>
                            @endif
                            @if($event->status != 'finished')
                            <button class="btn btn-primary ajax-all-btn" data-action="{{ url('admin/events/remind-all') }}" data-id="{{ $event->id }}">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <i class="iconly-boldSend"></i> Remind all
                            </button>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Last Invited</th>
                                <th>Last Reminded to pay</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(($event->getGuests->count() > 0) || ($event->fundingCollections->count() > 0))
                            @foreach($event->getGuests as $guest)
                                <tr>
                                    <td class="">
                                        <img height="70px" class="text-center mx-auto" src="{{ $guest->user->getUserAvatar() }}">
                                    </td>
                                    <td class="text-bold-500">{{ $guest->user->username }}</td>
                                    <td>Guest</td>
                                    <td>N/A</td>
                                    <td class="last_invited">{{ (empty($guest->last_invited ))? 'Not Invited' : \Carbon\Carbon::createFromTimeStamp(strtotime( $guest->last_invited ))->diffForHumans() }}</td>
                                    <td class="">N/A</td>
                                    <td>
                                        @if($event->event_date >= $currentDate || $event->status != 'finished')
                                            <button class="btn btn-info btn-sm invite-btn ajax-btn" data-action="{{ url('admin/events/invite-guest') }}" data-id="{{ $guest->id }}">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <i class="iconly-boldSend"></i> {{ ($guest->is_invited == 0)?'Invite':'Re Invite' }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($event->fundingCollections as $collection)
                            <tr>
                                <td class="">
                                    <img height="70px" class="text-center mx-auto" src="{{ $collection->user->getUserAvatar() }}">
                                </td>
                                <td class="text-bold-500">{{ $collection->user->username }}</td>
                                <td class="text-bold-500">Participant</td>
                                <td class="text-bold-500">{{ $collection->amount }}</td>
                                <td class="last_invited">{{ ( empty ( $collection->last_invited ) ) ? 'Not Invited' : \Carbon\Carbon::createFromTimeStamp(strtotime( $collection->last_invited ))->diffForHumans() }}</td>
                                <td class="last_reminded">{{ ( empty ( $collection->last_reminded ) ) ? 'Not Reminded' : \Carbon\Carbon::createFromTimeStamp(strtotime( $collection->last_reminded ))->diffForHumans() }}</td>
                                <td>
                                    @if($event->event_date >= $currentDate || $event->status != 'finished')
                                        <button class="btn btn-info btn-sm invite-btn ajax-btn" data-action="{{ url('admin/events/invite-participant') }}" data-id="{{ $collection->id }}">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="iconly-boldSend"></i> {{ ($collection->is_invited == 0)?'Invite':'Re Invite' }}
                                        </button>
                                    @endif
                                    @if($collection->is_received == 0 || $event->status != 'finished')
                                        <button class="btn btn-warning btn-sm remind-btn ajax-btn" data-action="{{ url('admin/events/remind-participant') }}" data-id="{{ $collection->id }}">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="iconly-boldSend"></i> {{ ($collection->is_reminded == 0)?' Send Reminder':' Remind again' }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td align="center" colspan="7">
                                    No Participants Found
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $( document ).ready(function() {
            filterMultiSelect();
            resettingAmounts();
            if($('.payment_mode_radio:checked').val() == 1) {
                $('#cash-by-collections-div').hide();
                $('.collections-row').hide();
            }else {
                $('#cash-by-collections-div').show();
                $('.collections-row').show();
            }
        });

        var users = {!! $users !!};
        var selectedUser = {!! $selectedUsers !!};
        $('.payment_mode_radio').change(function () {
            if (this.value == 2) {
                $('#cash-by-collections-div').show();
                $('.collections-row').show();
            } else if (this.value == 1) {
                $('#cash-by-collections-div').hide();
                $('.collections-row').hide();
            }
        });
        let Counter = {!! $count !!};
        // jquery.repeater
        $(function () {
            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();
                let currentEntry;
                let choiceId = 'UserSelection' + Counter++;
                currentEntry = '<div class="row collections-row"><div class="col-md-6 mb-4"><div class="form-group"><label for="amount-input">Select multiple users for collection</label> <select name="collection_users['+Counter+'][]" id="' + choiceId + '" class="choices form-select multiple-remove" multiple="multiple">' + availableUsers() + '</select></div></div><div class="col-md-4"><div class="form-group"><label>Amount</label><input type="number" value="" class="form-control quantity-inputs" placeholder="Amount" name="amount['+Counter+']" data-id="'+choiceId+'"></div></div><div class="col-md-2 justify-content-end d-flex"><div class="form-group py-4"> <button id="" class="btn-remove btn btn-danger"><i class="bi-trash"></i> </button></div></div></div>';
                $('#participant_fieldset').append(currentEntry);
                let choiceDOM = document.getElementById( choiceId);
                new Choices(choiceDOM,
                    {
                        delimiter: ',',
                        editItems: true,
                        maxItemCount: 50,
                        removeItemButton: true,
                    });
            }).on('click', '.btn-remove', function (e) {
                if ( $('#participant_fieldset>.collections-row').length > 1 ) {
                    $(this).closest('.collections-row').remove();
                    filterMultiSelect();
                    resettingAmounts();
                } else {
                    alert('deleting last row is not allowed');
                }

                return false;
            }).on('change keyup', filterMultiSelect).on('change keyup', resettingAmounts);
        });

        function availableUsers() {
            let values = '';

            $(users).each(function (index, user) {
                if ( $.inArray( parseInt(user.id), selectedUser) == -1) {
                    values += '<option value="' + user.id + '">' + user.username + '</option>';
                }
            });
            return values;
        }
        $('.choices').on('change keyup', filterMultiSelect);

        function filterMultiSelect() {
            selectedUser=[];
            let values = $('.choices option');
            values.each(function (index, option) {
                if ( $.inArray( parseInt($(option).val()), selectedUser ) == -1) {
                    selectedUser.push(parseInt($(option).val()));
                }
            });

            $('.choices').find('.choices__item--choice').show();
            if(selectedUser){
                $(selectedUser).each(function (index,value){
                    setTimeout(function(){
                        $('.choices').find('.choices__item--choice[data-value="'+value+'"]').hide();
                    }, 100)
                })
            }
        }

        $('#participant_fieldset, #event-cost-input, .payment_mode_radio').on('change keyup', resettingAmounts);

        function resettingAmounts(){
            let totalFunds = {!! $totalFunds !!};
            let totalCost = $('#event-cost-input').val();
            if( $('.payment_mode_radio:checked').val() == 1 ){
                $('#cash-by-funds-input').val(Math.min(totalFunds,totalCost));
            } else {
                let totalCollections = 0;
                $('.quantity-inputs').each(function(index, Element) {

                    let selectUserFieldId =  $(Element).data('id');
                    totalCollections += ($(Element).val())*($( '#' + selectUserFieldId + ' option:selected' ).length);

                });
                $('#cash-by-collections-input').val(totalCollections);
                $('#cash-by-funds-input').val(Math.min(totalFunds,(totalCost-totalCollections)));
            }
        }

        // Ajax request to invite and remind participants and guests
        $('.ajax-btn').on('click', sendInvite);
        function sendInvite() {
            let clickedBtn = $(this);
            clickedBtn.attr("disabled", true);
            let btnIcon = clickedBtn.find("span");
            btnIcon.removeClass("d-none");
            let id = $(this).data('id');
            let action = $(this).data('action');
            let lastInvitedDiv = $(this).closest('tr').find('.last_invited');
            let lastRemindedDiv = $(this).closest('tr').find('.last_reminded');
            clickedBtn.attr("disabled", true);
            $.ajax({
                type:'POST',
                url: action,
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success:function(res) {
                    setTimeout(function () {
                        clickedBtn.attr("disabled", false);
                        btnIcon.addClass("d-none");
                        if ( res.status ) {
                            if(res.invited_text) {
                                $(lastInvitedDiv).html(res.invited_text);
                            }
                            if(res.reminded_text) {
                                $(lastRemindedDiv).html(res.reminded_text);
                            }
                            if(res.btn_text) {
                                $(clickedBtn).html(res.btn_text);
                            }
                            swal({
                                title: 'Success',
                                text: res.msg,
                                icon: "success",
                            }).then(() => {

                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: res.msg,
                                icon: "error",
                            }).then(() => {

                            });
                        }
                    }, 100);

                }
            });
        }


        $('.ajax-all-btn').on('click', sendInvitesToAll);
        function sendInvitesToAll() {
            let clickedBtn = $(this);
            let btnIcon = clickedBtn.find("span");
            clickedBtn.attr("disabled", true);
            btnIcon.removeClass("d-none");
            let eventId = $(this).data('id');
            let action = $(this).data('action');
            clickedBtn.attr("disabled", true);
            $.ajax({
                type:'POST',
                url: action,
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "event_id": eventId
                },
                success:function(res) {
                    setTimeout(function () {
                        clickedBtn.attr("disabled", false);
                        btnIcon.addClass("d-none");
                        if ( res.status ) {
                            if(res.invited_text) {
                                $('.last_invited').html(res.invited_text);
                            }
                            if(res.reminded_text) {
                                $('.last_reminded').html(res.reminded_text);
                            }
                            if(res.invite_btn_text) {
                                $('.invite-btn').html(res.invite_btn_text);
                            }
                            if(res.remind_btn_text) {
                                $('.remind-btn').html(res.remind_btn_text);
                            }
                            swal({
                                title: 'Success',
                                text: res.msg,
                                icon: "success",
                            }).then(() => {

                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: res.msg,
                                icon: "error",
                            }).then(() => {

                            });
                        }
                    }, 100);

                }
            });
        }
    </script>

@endsection
