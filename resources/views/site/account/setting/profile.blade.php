
<div class="col-md-6 col-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">My Profile</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('account/setting/profile') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">Username</label>
                                    {!! $errors->first('username', '<small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="text" value="{{ $user->username}}" class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!} "
                                               placeholder="Username" name="username"
                                               id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">First Name</label>
                                    {!! $errors->first('first_name', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="text" value="{{$user->first_name}}" class="form-control {!! $errors->has('first_name') ? 'is-invalid' : '' !!} "
                                               placeholder="First Name" name="first_name"
                                               id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">Last Name</label>
                                    {!! $errors->first('last_name', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="text" value="{{ $user->last_name}}" class="form-control {!! $errors->has('last_name') ? 'is-invalid' : '' !!} "
                                               placeholder="Last Name" name="last_name"
                                               id="first-name-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="email-id-icon">Email</label>
                                    {!! $errors->first('email', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="text" class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!} "
                                               placeholder="Email" value="{{ $user->email}}"
                                               id="email-id-icon" name="email">
                                        <div class="form-control-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="mobile-id-icon">Phone Number</label>
                                    {!! $errors->first('phone', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="text" name="phone" class="form-control {!! $errors->has('phone') ? 'is-invalid' : '' !!} "
                                               value="{{ $user->phone}}"
                                               placeholder="Phone Number" id="mobile-id-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="dob-id-icon">Date of Birth</label>
                                    {!! $errors->first('dob', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input value="{{ $user->dob}}" type="date" class="form-control {!! $errors->has('dob') ? 'is-invalid' : '' !!} "
                                               placeholder="Date of Birth" name="dob" id="dob-id-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                {!! $errors->first('gender', '<br><small class="text-danger">:message</small>') !!}
                                <div class='form-check'>
                                    <div class="checkbox mt-2">
                                        <input type="radio" value="male" name="gender" id="gender-male"
                                               class='form-check-input' {{ ($user->gender == 'male')?'checked':'' }}>
                                        <label for="remember-me-v">Male</label>
                                    </div>
                                    <div class="checkbox mt-2">
                                        <input type="radio" value="female" name="gender" id="gender-female"
                                               class='form-check-input ' {{ ($user->gender == 'female')?'checked':'' }}>
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
    </div>
</div>
