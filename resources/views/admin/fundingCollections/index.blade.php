@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
@stop
@section('title', 'Funding Types')
@section('content')
    {{-- Funding Collection Grid Datatable   --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Funds Collection</h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{url('admin/funding/collections/create')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldShield-Done"></i> Create</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="fundcollectionTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Fund Type</th>
                                <th>Amount</th>
                                <th>Event</th>
                                <th>Status</th>
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
    <script type="text/javascript">

        // Simple Datatable
        $(document).ready(function()
        {
            console.log("here");
            // DataTable
            $('#fundcollectionTable').DataTable({
                processing: true,
                serverSide: true,
                order : [[ 0, "asc" ]],
                ajax: "{{ url('admin/funding/collection/getcollections') }}",
                columns: [
                    {data: 'id'},
                    {data: 'collectionUserName'},
                    {data: 'collectionTypeName'},
                    {data: 'amount'},
                    {data: 'event_id'},
                    {data: 'is_received'},
                    {data: 'action'}
                ],
                columnDefs : [
                    {
                        'orderable': false,
                        'targets': [ 4 ]
                    },
                    {
                        targets: -1,
                        className: 'dt-body-right'
                    }
                ]
            });
        });
    </script>
@stop
@stop
