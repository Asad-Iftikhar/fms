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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name-input">Name<small class="text-danger">*</small></label>
                                {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value="{{ old('name') }}"
                                       class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Name" name="name"
                                       id="name-input">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="desc-input">Description</label>
                                {!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
                                <textarea rows="5" type="text"
                                          class="form-control {!! $errors->has('description') ? 'is-invalid' : '' !!} "
                                          placeholder="Description" name="description"
                                          id="desc-input">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="event-date-input">Event Date</label>
                                {!! $errors->first('event_date', '<small class="text-danger">:message</small>') !!}
                                <input type="date" value="{{ old('event_date') }}"
                                       class="form-control {!! $errors->has('event_date') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Date" name="event_date" id="event-date-input">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="event-cost-input">Event Cost</label>
                                {!! $errors->first('event_cost', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('event_cost') }}"
                                       class="form-control {!! $errors->has('event_cost') ? 'is-invalid' : '' !!} "
                                       placeholder="Event Cost" name="event_cost"
                                       id="event-cost-input">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cash-by-funds-input">Cash By Office Funds</label>
                                {!! $errors->first('cash_by_funds', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('cash_by_funds') }}"
                                       class="form-control {!! $errors->has('cash_by_funds') ? 'is-invalid' : '' !!} "
                                       placeholder="Cash By Office Funds" name="cash_by_funds"
                                       id="cash-by-funds-input">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cash-by-collections-input">Cash By User Collections</label>
                                {!! $errors->first('cash_by_collections', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('cash_by_collections') }}"
                                       class="form-control {!! $errors->has('cash_by_collections') ? 'is-invalid' : '' !!} "
                                       placeholder="Cash By Collections" name="cash_by_collections"
                                       id="cash-by-collections-input">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="basicInput">Employee ID</label>
                                {!! $errors->first('employee_id', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="{{ old('employee_id') }}" class="form-control {!! $errors->has('employee_id') ? 'is-invalid' : '' !!} "
                                       placeholder="Employee Id" name="employee_id"
                                       id="employee-id-icon">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="basicInput">Phone Number</label>
                                {!! $errors->first('phone', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value="{{ old('phone') }}"
                                       class="form-control {!! $errors->has('phone') ? 'is-invalid' : '' !!} "
                                       placeholder="Phone Number" name="phone"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="basicInput">Joining Date</label>
                                {!! $errors->first('joining_date', '<small class="text-danger">:message</small>') !!}
                                <input type="date" value="{{ old('joining_date') }}"
                                       class="form-control {!! $errors->has('joining_date') ? 'is-invalid' : '' !!} "
                                       placeholder="Joining Date" name="joining_date" id="dob-id-icon">
                            </div>
                        </div>
                        <div class="col-md-8 mb-4">
                            <h6>Collections from users</h6>
                            <p>Select multiple users for collection</p>
                            <div class="form-group">
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
@endsection
