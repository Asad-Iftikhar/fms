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
                    <h4>Create Event</h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{ url('admin/events') }}" class="btn btn-primary" style="float: right"><i
                                class="iconly-boldArrow---Left-2"></i> Back</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="form form-vertical" method="post" action="{{ url('admin/events/create') }}">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name-input">Name<small class="text-danger">*</small></label>
                                {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value="{{ old('name') }}"
                                       class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Name" name="name"
                                       id="name-input">
                            </div>
                            <div class="form-group">
                                <label for="event-date-input">Event Date</label>
                                {!! $errors->first('event_date', '<small class="text-danger">:message</small>') !!}
                                <input type="date" value="{{ old('event_date') }}"
                                       class="form-control {!! $errors->has('event_date') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Date" name="event_date" id="event-date-input">
                            </div>
                            <div class="form-group">
                                <h6>Event Status</h6>
                                <div class="btn-group">
                                    <input type="radio" value="draft" class="btn-check event-status" name="status"
                                           id="warning-outlined-status" {{ old('status')=="draft" ? 'checked' : '' }}
                                           autocomplete="off" checked>
                                    <label class="btn btn-outline-warning" for="warning-outlined-status">Draft</label>
                                    <input type="radio" value="active" class="btn-check event-status" name="status"
                                           id="success-outlined-status" {{ old('status')=="active" ? 'checked' : '' }}
                                           autocomplete="off">
                                    <label class="btn btn-outline-success" for="success-outlined-status">
                                        Active</label>
                                    <input type="radio" value="finished" class="btn-check event-status" name="status"
                                           id="danger-outlined-status" {{ old('status')=="finished" ? 'checked' : '' }}
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
                                          class="form-control {!! $errors->has('description') ? 'is-invalid' : '' !!} "
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
                                        <option value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 vr">
                            <div class="form-group">
                                <label for="event-cost-input">Event Cost</label>
                                {!! $errors->first('event_cost', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('event_cost') }}"
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
                            <input type="radio" value="1" class="btn-check payment_mode_radio" name="payment_mode"
                                   id="success-outlined" {{ old('payment_mode')=="1" ? 'checked' : '' }}
                                   autocomplete="off" checked>
                            <label class="btn btn-outline-success" for="success-outlined">Existing Collections</label>
                            <input type="radio" value="2" class="btn-check payment_mode_radio" name="payment_mode"
                                   id="danger-outlined" {{ old('payment_mode')=="2" ? 'checked' : '' }}
                                   autocomplete="off">
                            <label class="btn btn-outline-success" for="danger-outlined">Existing & New
                                Collections</label>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cash-by-funds-input">Cash By Office Funds</label>
                                {!! $errors->first('cash_by_funds', '<small class="text-danger">:message</small>') !!}
                                <input type="number" readonly value="{{ old('cash_by_funds') }}"
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
                    <div class="col-md-8" id="participant_fieldset">
                        <div class="row collections-row" style="display: none">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="UserSelection0">Select multiple users for collection</label>
                                    <select id="UserSelection0" name="collection_users[0][]" class="choices form-select multiple-remove"
                                            multiple="multiple">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount-input">Amount</label>
                                    {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                    <input type="number" data-id="UserSelection0" value="{{ old('amount[0]') }}"
                                           class="form-control quantity-inputs {!! $errors->has('amount') ? 'is-invalid' : '' !!} "
                                           placeholder="Amount" name="amount[0]" id="amount-input">
                                </div>
                            </div>
                            <div class="col-md-2 justify-content-end d-flex">
                                <div class="form-group py-4">
                                    <button id="" class="btn-remove btn btn-danger"><i class="bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row collections-row" style="display: none">
                        <div class="col-md-12">
                            <button id="" class="btn-add btn btn-success"><i class="bi-plus-circle"></i> Add Row</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mt-4 me-1 mb-1">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>

<script>

    $( document ).ready(function() {
        if($('.payment_mode_radio:checked').val() == 1) {
            console.log('hide');
            $('#cash-by-collections-div').hide();
            $('.collections-row').hide();
        }else {
            console.log('show');
            $('#cash-by-collections-div').show();
            $('.collections-row').show();
        }
    });

    var users = {!! $users !!};
    var selectedUser = [];
    $('.payment_mode_radio').change(function () {
        if (this.value == 2) {
            $('#cash-by-collections-div').show();
            $('.collections-row').show();
        } else if (this.value == 1) {
            $('#cash-by-collections-div').hide();
            $('.collections-row').hide();
        }
    });
    let Counter = 1;
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
        }).on('change', filterMultiSelect).on('change', );
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
        /*let selectedValues = values.map(function (Option, Sec) {
           return $(Sec).val();
        });
        console.log(selectedValues);*/
        // alert('array ready');

        $('.choices').find('.choices__item--choice').show();
        if(selectedUser){
            // alert('if ready');
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
            console.log(totalCollections);
            $('#cash-by-collections-input').val(totalCollections);
            $('#cash-by-funds-input').val(Math.min(totalFunds,(totalCost-totalCollections)));
        }

    }
</script>
@endsection
