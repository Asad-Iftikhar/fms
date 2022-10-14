@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Users')
@section('content')
    {{-- Roles Grid Datatable   --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Users Roles</h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{url('admin/roles/create')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldShield-Done"></i> Create</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="RoleTable">
                            <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Users</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th class="dt-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td><span data-tip title="{!! $role->description !!}">{{{ $role->name }}}</span></td>
                                    <td>{!! $role->users->count() !!}</td>
                                    <td>@if ($role->name == 'super_admin') {!! 'ALL' !!} @else {!! $role->permissions_count !!} @endif</td>
                                    <td><span class="hide">{!! \Illuminate\Support\Carbon::createFromFormat( 'Y-m-d H:i:s', $role->created_at )->toDateString() !!}</span></td>
                                    <td>
                                        @if ($role->name != 'super_admin')
                                            <a href="{!! url('admin/roles/edit/' . $role->id) !!}" class="button btn btn-outline-info">Edit</a>
                                            <button onClick="confirmDelete('{{ url( 'admin/roles/delete' ).'/'. $role->id }}')" class="button btn btn-outline-danger">Delete</button>
                                        @else
                                            -- N/A --
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
            $('#RoleTable').DataTable({
                order : [[ 0, "asc" ]],
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
        function confirmDelete(delUrl){
            swal({
                title: "Are you sure?",
                text: "Once deleted, You will not be able to recover the role !",
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
