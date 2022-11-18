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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body apexcharts-canvas">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Collections Percentage</h4>
                        <div class="card apexcharts-canvas">
                            <canvas id="piechart" style="width: 100%"></canvas>
                        </div>
                    </div>
                    <div class="card-content pb-4">
                        <h4>Active Events</h4>
                        <div class="upcommingevent m-4" style="align-items: center;">
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
    @section('javascript')
        @parent
        <script src="{!! asset('assets/vendors/apexcharts/locales/Chart.js') !!}"></script>
        <script>
            const graphChart = document.getElementById("chart").getContext('2d');
            $.ajax({
                method: 'GET',
                url: '{{ url('admin/get-post-chart-data') }}',
                data: {
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'JSON',
            }).done(function (response){
                const myChart = new Chart(graphChart, {
                    type: 'bar',
                    data: {
                        labels: response.month,
                        datasets: [{
                            label: 'Monthly Collection',
                            backgroundColor: 'rgb(93, 218, 180)',
                            borderColor: 'rgb(47, 128, 237)',
                            data: response.collectionCount,
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: response.max,
                                }
                            }]
                        }
                    },
                });
            });
        </script>
        <script>
            const ctx1 = document.getElementById("piechart").getContext('2d');
            $.ajax({
                method: 'GET',
                url: '{{ url('admin/get-post-pie-chart-data') }}',
                data: {
                    _token: '{!! csrf_token() !!}'
                },
                dataType: 'JSON',

            }).done(function (response) {
                const myChart = new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        labels: ["Pendings", "Received"],
                        datasets: [{
                            label: 'Collections',
                            data: [response.pendings, response.received],
                            backgroundColor: ["#57CAEB", "#5DDAB4"]
                        }]
                    },
                });
            });
        </script>
    @stop
@stop
