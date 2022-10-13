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
                            <a href="{{url('admin/funding/collections')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ url('admin/funding/collections/create') }}" method="post">
                    @csrf
                    <div class="row">
                            <div class="form-group">
                                <label for="users">Users</label>
                                <select name="users[]" multiple id="users" class="multiple-remove form-control" multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" multiselect-hide-x = "false">
                                    @foreach($availableUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Collection Type</label>
                            {!! $errors->first('type', '<small class="text-danger">:message</small>') !!}
                            <select class="form-select" name="funding_type">
                                <option>Select Funding Type</option>
                                @foreach($availableFundingTypes as $availableFundingType)
                                    <option value="{{ $availableFundingType->id }}">{{ $availableFundingType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label>Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <div class="btn-group">
                                <input type="radio" class="btn-check" name="is_active" id="pending" value="0" autocomplete="off" checked />
                                <label class="btn btn-secondary" for="pending">Pending</label>
                                <input type="radio" class="btn-check" name="is_active" id="received" value="1" autocomplete="off" />
                                <label class="btn btn-secondary" for="received">Received</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
    <script src="{!! asset('assets/js/multiselect-dropdown.js') !!}" ></script>
    <script>
    fetch("/options").then(d=>d.json()).then(d=>{
        sel1.innerHTML =
            d.map(t=>'<option value="'+t.value+'">'+t.text+'</option>');

        sel1.loadOptions();
    })
    </script>
@stop
@stop
