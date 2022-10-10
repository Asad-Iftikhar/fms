@extends('admin.layouts.default')

@section('title', 'Users')
@section('styles')
    @parent
    <link rel="stylesheet" href="{!! asset("assets/vendors/choices.js/choices.min.css") !!}">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">Create User
            <span>
                <a href="{{ url('admin/users') }}" class="btn btn-primary" style="float: right"><i class="iconly-boldArrow---Left-2"></i> Back</a>
            </span>
        </div>
        <div class="card-body">
            <form class="form form-vertical" method="post" action="{{ url('admin/users/create') }}">
                @csrf
                <div class="form-body">
                    <div class="row">
                        {{--<div class="col-md-3"></div>
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Avatar Preview</h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="card-text text-info">
                                            Maximum size of file should be 3 MB <br>
                                            Allowed Types are png, jpg, jpeg and svg only <br>
                                        </p>
                                        <!-- File uploader with image preview -->
                                        <input type="file" name="image" class="image-preview-upload">
                                        {!! $errors->first('image', '<br><small class="text-danger">:message</small>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Employee ID</label>
                                {!! $errors->first('employee_id', '<small class="text-danger">:message</small>') !!}
                                <input type="number" value="" class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!} "
                                       placeholder="Employee Id" name="employee_id"
                                       id="employee-id-icon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Username</label>
                                {!! $errors->first('username', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value=""
                                       class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!} "
                                       placeholder="Username" name="username"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">First Name</label>
                                {!! $errors->first('first_name', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value=""
                                       class="form-control {!! $errors->has('first_name') ? 'is-invalid' : '' !!} "
                                       placeholder="First Name" name="first_name"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Last Name</label>
                                {!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value=""
                                       class="form-control {!! $errors->has('last_name') ? 'is-invalid' : '' !!} "
                                       placeholder="Last Name" name="last_name"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Email</label>
                                {!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value=""
                                       class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!} "
                                       placeholder="Email Address" name="email"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Phone Number</label>
                                {!! $errors->first('phone', '<small class="text-danger">:message</small>') !!}
                                <input type="text" value=""
                                       class="form-control {!! $errors->has('phone') ? 'is-invalid' : '' !!} "
                                       placeholder="Phone Number" name="phone"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Password</label>
                                {!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
                                <input type="password" value=""
                                       class="form-control {!! $errors->has('password') ? 'is-invalid' : '' !!} "
                                       placeholder="Password" name="password"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Confirm Password</label>
                                {!! $errors->first('confirm_password', '<small class="text-danger">:message</small>') !!}
                                <input type="password" value=""
                                       class="form-control {!! $errors->has('confirm_password') ? 'is-invalid' : '' !!} "
                                       placeholder="Confirm Password" name="confirm_password"
                                       id="basicInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Date of Birth</label>
                                {!! $errors->first('dob', '<small class="text-danger">:message</small>') !!}
                                <input type="date" class="form-control {!! $errors->has('dob') ? 'is-invalid' : '' !!} "
                                       placeholder="Date of Birth" name="dob" id="dob-id-icon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Joining Date</label>
                                {!! $errors->first('joining_date', '<small class="text-danger">:message</small>') !!}
                                <input type="date" class="form-control {!! $errors->has('joining_date') ? 'is-invalid' : '' !!} "
                                       placeholder="Joining Date" name="joining_date" id="dob-id-icon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="basicInput">Gender</label>
                            {!! $errors->first('gender', '<br><small class="text-danger">:message</small>') !!}
                            <div class='form-check'>
                                <div class="checkbox mt-2">
                                    <input type="radio" value="male" checked name="gender" id="gender-male"
                                           class='form-check-input' >
                                    <label for="remember-me-v">Male</label>
                                </div>
                                <div class="checkbox mt-2">
                                    <input type="radio" value="female" name="gender" id="gender-female"
                                           class='form-check-input '>
                                    <label for="remember-me-v">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <h6>Roles</h6>
                            <p>Select multiple roles for this user</p>
                            <div class="form-group">
                                <select name="roles[]" class="choices form-select multiple-remove"
                                        multiple="multiple">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('javascript')
    @parent
    <script src="{!! asset('assets/vendors/choices.js/choices.min.js') !!}"></script>
@endsection
