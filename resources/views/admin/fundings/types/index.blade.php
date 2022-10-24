@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Funding Types')
@section('content')
    {{-- Funding Grid Datatable   --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>Funding Types</h4>
                </div>
                <div class="col-6">
                    <span>
                        <a href="{{url('admin/funding/types/create')}}" type="button" class="btn btn-primary" style="float: right"><i class="bi bi-cash-stack" style="position: relative; top: 3px"></i> Create</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="fundTypeTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th class="dt-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($fundingTypes as $fundingType)
                                <tr>
                                    <td>{!! $fundingType->name !!}</td>
                                    <td>{!! $fundingType->description !!}</td>
                                    <td>{!! $fundingType->amount !!}</td>
                                    <td>
                                            <a href="{!! url( 'admin/funding/types/edit/' . $fundingType->id ) !!}" class="button btn btn-outline-info">Edit</a>
                                            <button onClick="confirmDelete('{{ url( 'admin/funding/types/delete' ).'/'. $fundingType->id }}')" class="button btn btn-outline-danger">Delete</button>
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
    <script>
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
    </script>
@stop
@stop
