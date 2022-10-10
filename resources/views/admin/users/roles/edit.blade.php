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
                        Edit Role
                    </div>
                    <div class="col-6">
                        <span>
                            <a href="{{url('admin/roles')}}" type="button" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2" style="position: relative; top: 3px"></i> Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="post">
                    @csrf
                    <input type="hidden" name="level" value="{{ old('level', $role->level) }}" />
                    <div class="row">
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                            <input type="text" class="form-control {!! $errors->has('name') ? 'is-invalid' : '' !!}" value="{{ old('name', $role->name) }}" id="name" name="name" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label for="description">Role Description</label>
                            <textarea type="text" class="form-control" rows="3"  id="description" name="description">{{ old('description', $role->description) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3">
                            <label>Permission</label>
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <select name="permissions[]" class="choices form-select multiple-remove" multiple="multiple">
                                        @foreach($permissions as $permission)
                                            <option value="{{$permission->id}}" {{ in_array($permission->id, old('permissions', $selected_permissions)) ? 'selected' : '' }}>{{$permission->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('javascript')
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
@stop
@stop
