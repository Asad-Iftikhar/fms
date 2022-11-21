@extends('admin.layouts.default')
@section('title', 'Funding Types')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Funding Type :: <b>{{ $fundingType->name }}</b></h4>
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/funding/types')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                            <input type="text" class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!}" value="{{ old('name', $fundingType->name) }}" id="name" name="name" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            {!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
                            <textarea type="text" class="form-control" rows="3"  id="description" name="description">{{ old('description', $fundingType->description) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                <div class="col-md-12 mb-4">
                                    <input type="text" class="form-control {!! $errors->has('amount') ? 'is-invalid' : '' !!}" value="{{ old('amount', $fundingType->amount) }}" id="amount" name="amount" required/>
                                </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop
