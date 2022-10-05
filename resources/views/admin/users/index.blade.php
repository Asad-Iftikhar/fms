@extends('admin.layouts.default')
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
@stop
@section('title', 'Users')
@section('content')
{{-- Users Grid Datatable   --}}
    <div class="card">
        <div class="card-header">Users</div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable-table" id="userdatatable">
                            <thead >
                              <tr>
                                  <th>ID</th>
                                  <th>Username</th>
                                  <th>Email</th>
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
    <script src="http://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

    // Simple Datatable
    $(document).ready(function(){
        // DataTable
        $('#userdatatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: "{{ url('admin/users/getuser') }}",
            columns: [
                { data: 'id' },
                { data: 'username' },
                { data: 'email' }
            ]
        });
    });
</script>
@stop
@stop
