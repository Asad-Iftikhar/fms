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
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Users</h4>
                </div>
                <div class="col-6">
                    <span>
                      <a href="{{ url('admin/users/create') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldAdd-User" style="position: relative; top: 3px"></i> Create</a>
                    </span>
                </div>
            </div>
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
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
    // Ajax Request to populate Datatable
    $(document).ready(function() {
        // DataTable
        $('#userdatatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: "{{ url('admin/users/getUsers') }}",
            columns: [
                {data: 'id'},
                {data: 'username'},
                {data: 'email'},
                {data: 'activeStatus'},
                {data: 'action'}
            ],
            columnDefs: [
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

    // Sweetalert to confirm before Deleting User
    function confirmDelete(delUrl){
        swal({
            title: "Are you sure?",
            text: "Once deleted, You will not be able to recover the user !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = delUrl;
            } else {

            }
        });
    };
    // Sweetalert to confirm before Activate4/Deactivate User
    function confirmActiveDeactive(changeStatusUrl){
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to change the status of this user ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willChange) => {
            if (willChange) {
                window.location.href = changeStatusUrl;
            } else {

            }
        });
    };

</script>
@stop
@stop
