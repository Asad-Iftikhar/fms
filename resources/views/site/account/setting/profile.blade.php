
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
                                    <div class="position-relative">
                                        <input type="text" value="{{ $user->username}}" class="form-control"
                                               placeholder="Input with icon left" name="username"
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
                                    <div class="position-relative">
                                        <input type="text" value="{{$user->first_name}}" class="form-control"
                                               placeholder="Input with icon left" name="first_name"
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
                                    <div class="position-relative">
                                        <input type="text" value="{{ $user->last_name}}" class="form-control"
                                               placeholder="Input with icon left" name="last_name"
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
                                    <div class="position-relative">
                                        <input type="text" class="form-control"
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
                                    <div class="position-relative">
                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone}}"
                                               placeholder="Mobile" id="mobile-id-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="dob-id-icon">Date of Birth</label>
                                    <div class="position-relative">
                                        <input value="{{ $user->dob}}" type="date" class="form-control"
                                               placeholder="Date of Birth" name="dob" id="dob-id-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class='form-check'>
                                    <div class="checkbox mt-2">
                                        <input type="radio" value="male" name="gender" id="gender-male"
                                               class='form-check-input' {{ ($user->gender == 'male')?'checked':'' }}>
                                        <label for="remember-me-v">Male</label>
                                    </div>
                                    <div class="checkbox mt-2">
                                        <input type="radio" value="female" name="gender" id="gender-female"
                                               class='form-check-input' {{ ($user->gender == 'female')?'checked':'' }}>
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
