@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
@endsection
@section('title', 'Funding Collection')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h4>Create Collection</h4>
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
                <form action="{{ url('admin/funding/collections/create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="users">Users</label>
                                {!! $errors->first('users', '<small class="text-danger">:message</small>') !!}
                                <select name="users[]" multiple id="users" class="multiple-remove form-select"
                                        multiselect-search="true" multiselect-select-all="true"
                                        multiselect-max-items="100" multiselect-hide-x="false" style="width: 100%;">
                                    @foreach( $availableUsers as $user )
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="funding_type_id">Collection Type</label>
                                {!! $errors->first('funding_type_id', '<small class="text-danger">:message</small>') !!}
                                <select class="form-select" name="funding_type_id" id="funding_type_id">
                                    <option>Select Funding Type</option>
                                    @foreach( $availableFundingTypes as $availableFundingType)
                                        <option
                                            value="{{ $availableFundingType->id }}">{{ $availableFundingType->name.' ('.$availableFundingType->amount.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <div class="btn-group">
                                    <input type="radio" class="btn-check" name="is_received" id="pending" value="0"
                                           autocomplete="off" checked/>
                                    <label class="btn btn-outline-success" for="pending">Pending</label>
                                    <input type="radio" class="btn-check" name="is_received" id="received" value="1"
                                           autocomplete="off"/>
                                    <label class="btn btn-outline-success" for="received">Received</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-6 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Create</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
    <script src="{!! asset('assets/js/multiselect-dropdown.js') !!}"></script>
@stop
@stop
