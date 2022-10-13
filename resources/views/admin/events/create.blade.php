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
                        <a href="{{ url('admin/events') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2"></i> Back</a>
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
                        <div class="col-md-6">
                            <h6>Payment Mode</h6>
                            <input type="radio" value="1" class="btn-check payment_mode_radio" name="payment_mode" id="success-outlined"
                                   autocomplete="off" checked>
                            <label class="btn btn-outline-success" for="success-outlined">Existing Collections</label>
                            <input type="radio" value="2" class="btn-check payment_mode_radio" name="payment_mode" id="danger-outlined"
                                   autocomplete="off">
                            <label class="btn btn-outline-success" for="danger-outlined">Existing & New Collections</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total-funds-input">Total Funds Available</label>
                                <input readonly type="number" value="{{ $total_funds }}"
                                       class="form-control"
                                       placeholder="Total Office Funds" name="total_funds"
                                       id="total-funds-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event-cost-input">Event Cost</label>
                                {!! $errors->first('event_cost', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('event_cost') }}"
                                       class="form-control {!! $errors->has('event_cost') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Cost" name="event_cost"
                                       id="event-cost-input">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cash-by-funds-input">Cash By Office Funds</label>
                                {!! $errors->first('cash_by_funds', '<small class="text-danger">:message</small>') !!}
                                <input type="number" readonly value="{{ old('cash_by_funds') }}"
                                       class="form-control {!! $errors->has('cash_by_funds') ? 'is-invalid' : '' !!} "
                                       placeholder="Cash By Office Funds" name="cash_by_funds"
                                       id="cash-by-funds-input">
                            </div>
                        </div>
                        <div class="col-md-3" id="cash-by-collections-div" style="display: none">
                            <div class="form-group">
                                <label for="cash-by-collections-input">Cash By User Collections</label>
                                {!! $errors->first('cash_by_collections', '<small class="text-danger">:message</small>') !!}
                                <input type="number" readonly value="{{ old('cash_by_collections') }}"
                                       class="form-control {!! $errors->has('cash_by_collections') ? 'is-invalid' : '' !!} "
                                       placeholder="Cash By Collections" name="cash_by_collections"
                                       id="cash-by-collections-input">
                            </div>
                        </div>
                        <h6>Collections from users</h6>
                        <div class="col-md-8 mb-4">
                            <div class="form-group">
                                <label for="amount-input">Select multiple users for collection</label>
                                <select name="users[]" class="choices form-select multiple-remove"
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
                                <input type="number" value="{{ old('amount') }}"
                                       class="form-control {!! $errors->has('amount') ? 'is-invalid' : '' !!} "
                                       placeholder="Amount" name="amount" id="amount-input">
                            </div>
                        </div>
                        <div class="col-md-12 text-right d-flex justify-content-end">
                            <div class="form-group">
                                <label for="status-input">Save Event as</label>
                                <select name="users[]" id="status-input" style="max-width: 400px;" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="finished">Finished</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Create</button>
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
        $('.payment_mode_radio').change(function() {
            if (this.value == 2) {
                $('#cash-by-collections-div').show();
            }
            else if (this.value == 1) {
                $('#cash-by-collections-div').hide();
            }
        });
    </script>
@endsection
