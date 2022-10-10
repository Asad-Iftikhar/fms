@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
@endsection
@section('title', 'User Roles')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        Create Funding Type
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/funding/types')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ url('admin/funding/types/create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label>Fund Type Name</label>
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                            <input type="text" class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!}" id="basicInput" name="name" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label>Fund Type Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label>Amount</label>
                            <div class="col-md-12 mb-4">
                                <input type="text" class="form-control {!! $errors->has('amount') ? 'is-invalid' : '' !!}" id="basicInput" name="amount" required/>
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
@stop
@stop
