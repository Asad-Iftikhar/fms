@extends('admin.layouts.default')
@section('styles')
@parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
@endsection
@section('title', 'User Roles')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        Create Role
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/roles')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ url('admin/roles/create') }}" method="post">
                    @csrf
                    <input type="hidden" name="level" value="1" />
                    <div class="row">
                        <div class="form-group">
                            <label>Role Name</label>
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                            <input type="text" class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!}" id="basicInput" name="name" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                             <label>Role Description</label>
                             <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                        </div>
                    </div>
                     <div class="row">
                         <div class="form-group mb-3">
                             <label>Permission</label>
                             <div class="col-md-12 mb-4">
                                 <div class="form-group">
                                      <select name="permissions[]" class="choices form-select multiple-remove" multiple="multiple">
                                           @foreach($permissions as $permission)
                                              <option value="{{$permission->id}}">{{$permission->name}}</option>
                                           @endforeach
                                      </select>
                                 </div>
                             </div>
                         </div>
                     </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
         </div>
    </section>
@section('javascript')
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
@stop
@stop
