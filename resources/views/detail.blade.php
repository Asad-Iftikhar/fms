@extends('site.layouts.base')
@section('title', 'Collection Info')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4>Collection Name :: <b>{{ $pending->getCollectionTypeName() }}</b></h4>
                        </div>
                        <div class="col-6">
                            <span>
                                <a href="{{ url('/') }}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                <div class="col-md-12 mb-4">
                                    <input type="text" class="form-control" value="{{  $pending->amount }}"
                                           disabled/>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <div class="col-md-12 mb-4">
                                    <input type="text" class="form-control"
                                           value="{{  $pending->getPaymentStatus() }}" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            Discussion Area
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
