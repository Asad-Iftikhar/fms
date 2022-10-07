@extends('admin.layouts.default')

@section('title', 'Users')
@section('content')
    <div class="card">
        <div class="card-header">Add New User
            <span>
                  <a href="{{ url('admin/users') }}" class="btn btn-primary" style="float: right">Back <span class="bi bi-arrow-return-left" style="position: relative; top: 3px"></span></a>
            </span>
        </div>
        <div class="card-body">
            <form class="form form-vertical" method="post" action="{{ url('account/setting/profile') }}">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-3"></div>
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
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="first-name-icon">Employee ID</label>
                                {!! $errors->first('employee_id', '<small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" value="" class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!} "
                                           placeholder="Employee Id" name="employee_id"
                                           id="employee-id-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-key"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="first-name-icon">Username</label>
                                {!! $errors->first('username', '<small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" value="" class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!} "
                                           placeholder="Username" name="username"
                                           id="first-name-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="first-name-icon">First Name</label>
                                {!! $errors->first('first_name', '<br><small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" value="" class="form-control {!! $errors->has('first_name') ? 'is-invalid' : '' !!} "
                                           placeholder="First Name" name="first_name"
                                           id="first-name-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="first-name-icon">Last Name</label>
                                {!! $errors->first('last_name', '<br><small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" value="" class="form-control {!! $errors->has('last_name') ? 'is-invalid' : '' !!} "
                                           placeholder="Last Name" name="last_name"
                                           id="first-name-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="email-id-icon">Email</label>
                                {!! $errors->first('email', '<br><small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!} "
                                           placeholder="Email" value=""
                                           id="email-id-icon" name="email">
                                    <div class="form-control-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="mobile-id-icon">Phone Number</label>
                                {!! $errors->first('phone', '<br><small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="text" name="phone" class="form-control {!! $errors->has('phone') ? 'is-invalid' : '' !!} "
                                           placeholder="Phone Number" id="mobile-id-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-icon-left">
                                <label for="dob-id-icon">Date of Birth</label>
                                {!! $errors->first('dob', '<br><small class="text-danger">:message</small>') !!}
                                <div class="position-relative">
                                    <input type="date" class="form-control {!! $errors->has('dob') ? 'is-invalid' : '' !!} "
                                           placeholder="Date of Birth" name="dob" id="dob-id-icon">
                                    <div class="form-control-icon">
                                        <i class="bi bi-calendar-date"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="first-name-icon">Gender</label>
                            {!! $errors->first('gender', '<br><small class="text-danger">:message</small>') !!}
                            <div class='form-check'>
                                <div class="checkbox mt-2">
                                    <input type="radio" value="male" name="gender" id="gender-male"
                                           class='form-check-input' {{ ($filled->gender == 'male')?'checked':'' }}>
                                    <label for="remember-me-v">Male</label>
                                </div>
                                <div class="checkbox mt-2">
                                    <input type="radio" value="female" name="gender" id="gender-female"
                                           class='form-check-input ' {{ ($filled->gender == 'female')?'checked':'' }}>
                                    <label for="remember-me-v">Female</label>
                                </div>
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
