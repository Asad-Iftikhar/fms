@extends('admin.layouts.default')
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'User Management')
@section('content')
{{-- Users Grid Datatable   --}}
    <div class="card">
        <div class="card-header">Users
            <span>
                  <a href="{{ url('admin/users/create') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldAdd-User" style="position: relative; top: 3px"></i> Create</a>
            </span>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="userdatatable">
                            <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Username</th>
                                  <th>Email</th>
                                  <th>Actions</th>
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
        // DataTable
        $('#userdatatable').DataTable
        ({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: "{{ url('admin/users/getuser') }}",
            columns: [
                {data: 'id'},
                {data: 'username'},
                {data: 'email'},
                {data: 'action'}
            ],
            columnDefs: [
                {
                    'orderable': false,
                    'targets': [ 3 ]
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
