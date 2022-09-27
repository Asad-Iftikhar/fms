@extends('templates.auth')

@section('title', 'Login')
@section('content')
    <!-- Sign in form section -->
    <div class="page-heading my-5 py-5">
        <div class="page-title">
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Change Password</h3>
                    <p class="text-subtitle text-muted">Please fill the following details to proceed</p>
                </div>
            </div>
        </div>
        <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-4 col-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Enter Password</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input name="password" type="password" class="form-control"
                                                           placeholder="Current Password">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input name="new_password" type="password" class="form-control"
                                                           placeholder="New Password">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input name="cpassword" type="password" class="form-control"
                                                           placeholder="Confirm Password">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-primary me-1 mb-1">Change Password
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@stop
