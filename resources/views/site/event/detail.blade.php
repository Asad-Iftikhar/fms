@extends('site.layouts.base')
@section('title', 'Event Info')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
@stop
@section('content')
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="row p-2">
                    <span>
                        <a href="{{url('events')}}" type="button" class="btn btn-primary"
                           style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back
                        </a>
                    </span>
                </div>
                <div class="row p-3">
                    <div class="col-md-6">
                        <div class="card-header">
                            <h5>Event Name :: <b>{{ $event->name }}</b></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5>Total Amount of Event :</h5>
                                        </td>
                                        <td>
                                            <h5><span class="badge bg-success">{{ $event->event_cost . ' ' .'PKR-/' }}</span></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Event Date :</h5></td>
                                        <td><h5><span class="badge bg-success">{{ $event->event_date }}</span></h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Status :</h5></td>
                                        <td><h5><span class="badge bg-success">{{ $event->status }}</span></h5></td>
                                    </tr>
                                    <tr>
                                        @if(!empty($event->description))
                                        <td><h5>Description :</h5></td>
                                        <td><b><span style="font-size: large">{{ $event->description }}</span></b></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped dataTable-table mb-0 shadow" id="participant_table">
                            <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(($event->getGuests->count() > 0) || ($event->fundingCollections->count() > 0))
                                @foreach($event->getGuests as $guest)
                                    <tr>
                                        <td class="">
                                            <img height="70px" class="text-center mx-auto" src="{{ $guest->user->getUserAvatar() }}">
                                        </td>
                                        <td class="text-bold-500">{{ $guest->user->getFullName() }}</td>
                                        <td>Guest</td>
                                        <td>N/A</td>
                                    </tr>
                                @endforeach
                                @foreach($event->fundingCollections as $collection)
                                    <tr>
                                        <td class="">
                                            <img height="70px" class="text-center mx-auto" src="{{ $collection->user->getUserAvatar() }}">
                                        </td>
                                        <td class="text-bold-500">{{ $collection->user->getFullName() }}</td>
                                        <td class="text-bold-500">Participant</td>
                                        <td class="text-bold-500">{{ $collection->amount }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td align="center" colspan="7">
                                        No Data Found
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @section('javascript')
        @parent
        <script type="text/javascript" src="{{ asset('assets/DataTables-1.12.1/datatables.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#participant_table').DataTable();
            });
        </script>
    @stop
@stop
