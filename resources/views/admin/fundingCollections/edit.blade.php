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
                        <h4>Edit Funding Collection</h4>
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/funding/collections')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <h4><label for="name">Users :: </label> <b>{{ $fundingCollection->firstName() }}</b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (!empty($selected_fundingtype))
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="description">Collection</label>
                                    <select name="funding_type_id" class="choices form-select" >
                                        @foreach($fundingtypes as $fundingtype)
                                            <option value="{{ $fundingtype->id }}" {{ ($fundingtype->id == $fundingCollection->funding_type_id) ? 'selected' : '' }}>{{$fundingtype->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        @else
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="event">Event</label>
                                <select name="event_id" class="choices form-select" >
                                    @foreach($events as $event)
                                        <option value="{{$event->id}}" {{ ($event->id == $selected_event) ? 'selected' : '' }}>{{$event->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <div class="btn-group" style="z-index: 0;">
                                    <input type="radio" class="btn-check" name="is_received" id="pending" value="0" autocomplete="off" {{ ($fundingCollection->is_received == 0) ? 'checked' : '' }} />
                                    <label class="btn btn-outline-success" for="pending">Pending</label>
                                    <input type="radio" class="btn-check" name="is_received" id="received" value="1" autocomplete="off" {{ ($fundingCollection->is_received == 1) ? 'checked' : '' }} />
                                    <label class="btn btn-outline-success" for="received">Received</label>
                                </div>
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
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
@stop
@stop
