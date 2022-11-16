@extends('site.layouts.base')
@section('title', 'Event Info')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/css/pages/email.css") }}">
@stop
@section('content')
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h4>Event Name :: <b>{{ $event->name }}</b></h4>
                                </div>
                                <div class="col-6">
                            <span>
                                <a href="{{url('events')}}" type="button" class="btn btn-primary"
                                   style="float: right"><i class="iconly-boldArrow---Left-2"
                                                           style="position: relative; top: 3px"></i> Back</a>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5>Total Amount of Event :</h5>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $event->event_cost . ' ' .'Rs' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h5>Event Date :</h5></td>
                                        <td><span class="badge bg-success">{{ $event->event_date }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Status :</h5></td>
                                        <td><span class="badge bg-success">{{ $event->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Description :</h5></td>
                                        <td><b><span style="font-size: large">{{ $event->description }}</span></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
