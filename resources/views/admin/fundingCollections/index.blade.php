@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
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
                                <th class="small-4">Name</th>
{{--                                <th class="small-2">Description</th>--}}
                                <th class="small-2">Amount</th>
                                <th class="small-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach ($fundingCollections as $fundingCollection)--}}
{{--                                <tr>--}}
{{--                                    <td>{!! $fundingCollection->user->username!!}</td>--}}
{{--                                    <td>{!! $fundingType->description !!}</td>--}}
{{--                                    <td>{!! $fundingCollection->amount !!}</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="{!! url( 'admin/funding/collections/' . $fundingCollection->id ) !!}" class="button btn btn-outline-info">Edit</a>--}}
{{--                                        <a href="{!! url( 'admin/funding/collections/' . $fundingCollection->id ) !!}" class="button btn btn-outline-danger">Delete</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
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
            $('#fundcollectionTable').DataTable({
                processing: true,
                serverSide: true,
                order : [[ 0, "asc" ]],
                ajax: "{{ url('admin/funding/getcollections') }}",
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'amount'},
                    {data: 'action'}
                ],
                columnDefs : [
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
