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
                            <a href="{{url('admin/funding/collections')}}" type="button" class="btn btn-primary"
                               style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
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
                                <label for="name">User</label>
                                <select class="choices form-select" disabled>
                                    <option>{{ $fundingCollection->firstName() }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (!empty($selected_fundingtype))
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="description" for="funding_type_id">Collection</label>
                                    <select name="funding_type_id" class="form-select" id="funding_type_id">
                                        @foreach($fundingtypes as $fundingtype)
                                            <option data-amount="{{ $fundingtype->amount }}"
                                                    value="{{ $fundingtype->id }}" {{ ($fundingtype->id == $fundingCollection->funding_type_id) ? 'selected' : '' }}>{{$fundingtype->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="event">Event</label>
                                    <select name="event_id" class="choices form-select" disabled>
                                        @foreach($events as $event)
                                            <option
                                                value="{{$event->id}}" {{ ($event->id == $selected_event) ? 'selected' : '' }}>{{$event->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <lable>Amount</lable>
                                @if(!empty($selected_fundingtype))
                                    {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                    <input type="text" class="form-control" id="amount" value="{{ $fundingCollection->amount }}" disabled/>
                                @else
                                    {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                                    <input type="text" class="form-control {!! $errors->has('amount') ? 'is-invalid' : '' !!}" id="amount" name="amount" value="{{ $fundingCollection->amount }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <div class="btn-group" style="z-index: 0;">
                                    <input type="radio" class="btn-check" name="is_received" id="pending" value="0"
                                           autocomplete="off" {{ ($fundingCollection->is_received == 0) ? 'checked' : '' }} />
                                    <label class="btn btn-outline-success" for="pending">Pending</label>
                                    <input type="radio" class="btn-check" name="is_received" id="received" value="1"
                                           autocomplete="off" {{ ($fundingCollection->is_received == 1) ? 'checked' : '' }} />
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

    <script>
        $(document).ready(function () {
            $("#funding_type_id").change(function () {
                console.log('#funding_type_id option[value="' + $(this).val() + '"]');
                let amount = $('#funding_type_id option[value="' + $(this).val() + '"]').data('amount');
                console.log(amount);
                $("#amount").val(amount);
            });
        });
    </script>
@stop
@stop
