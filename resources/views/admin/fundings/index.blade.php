@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Funding Types')
@section('content')
    {{-- Users Grid Datatable   --}}
    <div class="card">
        <div class="card-header">Funding Types
            <span>
                  <a href="{{url('admin/funding/types/create')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldShield-Done"></i> Create</a>
            </span>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="fundTypeTable">
                            <thead>
                            <tr>
                                <th class="small-4">Fund Name</th>
                                <th class="small-2">Description</th>
                                <th class="small-2">Amount</th>
                                <th class="small-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($fundingtypes as $fundingtype)
                                <tr>
                                    <td>{!! $fundingtype->name !!}</td>
                                    <td>{!! $fundingtype->description !!}</td>
                                    <td>{!! $fundingtype->amount !!}</td>
{{--                                    <td><span class="hide">{!! \Illuminate\Support\Carbon::createFromFormat( 'Y-m-d H:i:s', $fundingtype->created_at )->toDateString() !!}</span></td>--}}
                                    <td>
                                            <a href="{!! url('admin/funding/types/edit/' . $fundingtype->id) !!}" class="button btn btn-outline-info">Edit</a>
                                            <a href="{!! url('admin/users/roles/' . $fundingtype->id . '/delete') !!}" class="button btn btn-outline-danger">Delete</a>
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
            $('#fundTypeTable').DataTable({
                order : [[ 0, "asc" ]],
                columnDefs : [
                    {
                        'orderable': false,
                        'targets': [ 3 ] },
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
