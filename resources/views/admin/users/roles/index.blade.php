@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Users')
@section('content')
    {{-- Users Grid Datatable   --}}
    <div class="card">
        <div class="card-header">Users Roles
            <span>
                  <a href="{{url('admin/roles/create')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldShield-Done" style="position: relative; top: 3px"></i> Create</a>
            </span>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="RoleTable">
                            <thead>
                            <tr>
                                <th class="small-4">Role Name</th>
                                <th class="small-2">Users</th>
                                <th class="small-2">Permissions</th>
                                <th class="small-2">Created At</th>
                                <th class="small-2 text-center"><i class="fa fa-bolt"></i></th>
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
                                            <a href="{!! url('admin/users/roles/' . $role->id . '/edit') !!}" class="button btn btn-outline-info">Edit</a>
                                            <a href="{!! url('admin/users/roles/' . $role->id . '/delete') !!}" class="button btn btn-outline-danger">Delete</a>
                                        @else
                                            -
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

    <script type="text/javascript">

        // Simple Datatable
        $(document).ready(function()
        {
            // DataTable
            $('#RoleTable').DataTable({
                "order": [[ 0, "asc" ]],
                "columnDefs": [
                    { 'orderable': false, 'targets': [ 4 ] }
                ]
            });
        });
    </script>
@stop
@stop
