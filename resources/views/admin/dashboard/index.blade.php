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
                                    <div class="card chart-container">
                                        <canvas id="chart"></canvas>
                                    </div>
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
    @section('javascript')
        @parent
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
        <script>
            const ctx = document.getElementById("chart").getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["rice", "yam", "tomato", "potato",
                        "beans", "maize", "oil"],
                    datasets: [{
                        label: 'Monthly Collection',
                        backgroundColor: 'rgba(161, 198, 247, 1)',
                        borderColor: 'rgb(47, 128, 237)',
                        data: [300, 400, 200, 500, 800, 900, 200],
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                },
            });
        </script>
    @stop
@stop
