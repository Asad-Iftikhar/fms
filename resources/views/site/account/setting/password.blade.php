
<div class="col-md-6 col-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Change Password</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('account/setting/change-password') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">Current Password</label>
                                    {!! $errors->first('current_password', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="password"  class="form-control {!! $errors->has('confirm_password') ? 'is-invalid' : '' !!}"
                                               placeholder="Enter Current Password" name="current_password"
                                               id="current-password-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">New Password</label>
                                    {!! $errors->first('new_password', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="password"  class="form-control {!! $errors->has('confirm_password') ? 'is-invalid' : '' !!}"
                                               placeholder="Enter New Password" name="new_password"
                                               id="new-password-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group has-icon-left">
                                    <label for="first-name-icon">Confirm Password</label>
                                    {!! $errors->first('confirm_password', '<br><small class="text-danger">:message</small>') !!}
                                    <div class="position-relative">
                                        <input type="password"  class="form-control {!! $errors->has('confirm_password') ? 'is-invalid' : '' !!}"
                                               placeholder="Confirm Password" name="confirm_password"
                                               id="confirm-password-icon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
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
