@extends('site.layouts.base')
@section('title', 'Home Screen')
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldBuy"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Collections</h6>
                                        <h6 class="font-extrabold mb-0">{{$totalCollection}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldSend"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Available Collections</h6>
                                        <h6 class="font-extrabold mb-0">{{$totalAmount .' '.'Rs'}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldUser"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Pending Collections</h6>
                                        <h6 class="font-extrabold mb-0">{{$pendingPayment .' '.'Rs'}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldUser"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Spended Collections</h6>
                                        <h6 class="font-extrabold mb-0">{{$totalSpendings .' '.'Rs'}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ajax-loading"></div>
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pending Payments</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                        <tr>
                                            <th>Fund Type Name</th>
                                            <th>Amount</th>
                                            <th>Event Name</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($pendingPaymentList) > 0)
                                            @foreach($pendingPaymentList as $collection)
                                                <tr>
                                                    <td>{{ $collection->getCollectionTypeName()}}</td>
                                                    <td>{{ $collection->amount}}</td>
                                                    <td>{{$collection->getEvent()}}</td>
                                                    <td>{{$collection->getDescription()}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" style="text-align: center; color: red">No Pending Available</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Active Events</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="upcommingevent ms-4">
                            @if ($activeEvents->count())
                                @foreach($activeEvents as $activeEvent)
                                    <i class="iconly-boldCalendar text-primary"></i>
                                    {{'Event Name: ' . $activeEvent->name}}
                                    <p>{{'Event Description: '. $activeEvent->description}}</p>
                                    <hr>
                                @endforeach
                            @else
                                <div class="alert alert-secondary">No Events.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
