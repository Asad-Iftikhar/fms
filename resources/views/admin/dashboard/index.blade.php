@extends('admin.layouts.default')
@section('title', 'Dashboard')
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
                                        <div class="stats-icon green">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Collections</h6>
                                        <h6 class="font-extrabold mb-0"> {{ $totalCollection .' '.'Rs' }} </h6>
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
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Available Collections</h6>
                                        <h6 class="font-extrabold mb-0"> {{ $totalFunds .' '.'Rs' }} </h6>
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
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldDownload"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Pending Collections</h6>
                                        <h6 class="font-extrabold mb-0"> {{ $totalPendings .' '.'Rs' }} </h6>
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
                                        <div class="stats-icon red">
                                            <i class="iconly-boldUser"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Employees</h6>
                                        <h6 class="font-extrabold mb-0"> {{ $activeUsersCount }} </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">
                                Overall Collection Percentage
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-success table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 50%">Pending Collection</th>
                                            <th>Received Collection</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold ms-3 mb-0">{{ $pendingCollectionPercentage }}</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class="font-bold ms-3 mb-0">{{ $receivedCollectionPercentage }}</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
{{--                                {{ $fundingCollectionsMonthly }}--}}
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
            <div class="row">
                <div class="col-12">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </section>
    </div>
    @section('javascript')
        @parent
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light1", // "light1", "light2", "dark1", "dark2"
                    title:{
                        text: "Monthly Collection Stats"
                    },
                    axisY: {
                        includeZero: true
                    },
                    data: [{
                        type: "column", //change type to bar, line, area, pie, etc
                        //indexLabel: "{y}", //Shows y value on all Data Points
                        indexLabelFontColor: "#5A5757",
                        indexLabelFontSize: 16,
                        indexLabelPlacement: "outside",
                        dataPoints: [
                            { y: 25, label: "JAN" },
                            { y: 50, label: "FEB" },
                            { y: 12, label: "MAR" },
                            { y: 69, label: "APR" },
                            { y: 50, label: "MAY" },
                            { y: 46, label: "JUN" },
                            { y: 80, label: "JUL" },
                            { y: 90, label: "AUG" },
                            { y: 30, label: "SEPT" },
                            { y: 35, label: "OCT" },
                            { y: 95, label: "NOV" },
                            { y: 25, label: "DEC" }
                        ]
                    }]
                });
                chart.render();
            }
        </script>
    @stop
@stop
