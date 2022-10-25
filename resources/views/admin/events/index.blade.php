@extends('admin.layouts.default')
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Events Management')
@section('content')
{{-- Events Grid Datatable   --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Events</h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{ url('admin/events/create') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldPaper-Plus" style="position: relative; top: 3px"></i> Create</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="eventDatatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Event Cost</th>
                                    <th>Participants</th>
                                    <th>Payment Mode</th>
                                    <th>Event Status</th>
                                    <th>Event Date</th>
                                    <th>Created by</th>
                                    <th class="dt-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/DataTables-1.12.1/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>

<script type="text/javascript">

    // Simple Datatable
    $(document).ready(function()
    {
        // DataTable
        $('#eventDatatable').DataTable
        ({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: "{{ url('admin/events/getEvents') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'event_cost'},
                {data: 'participants'},
                {data: 'payment_mode'},
                {data: 'statusname'},
                {data: 'event_date'},
                {data: 'created_by'},
                {data: 'action'}
            ],
            columnDefs: [
                {
                    'orderable': false,
                    'targets': [ 8 ]
                },
                {
                    targets: -1,
                    className: 'dt-body-right'
                }
            ]
        });


    });

    function confirmDelete(delUrl){
        swal({
            title: "Are you sure?",
            text: "Once deleted, You will not be able to recover the event !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = delUrl;
            }
        });
    };

</script>
@stop
@stop
