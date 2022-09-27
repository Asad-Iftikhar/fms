@extends('templates.auth')

@section('title', 'Login')
@section('content')
    <!-- Sign in form section -->
    <div class="page-heading my-5 py-5">
        <div class="page-title">
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Sign in</h3>
                    <p class="text-subtitle text-muted">Sign in to proceed</p>
                </div>
            </div>
        </div>
        <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-4 col-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sign in to continue</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class=" col-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input name="email" type="email" class="form-control"
                                                        placeholder="Email" id="first-name-icon">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input name="password" type="password" class="form-control"
                                                        placeholder="Password">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <div class='form-check'>
                                                <div class="checkbox">
                                                    <input type="checkbox" id="checkbox2"
                                                        class='form-check-input' checked>
                                                    <label for="checkbox2">Remember Me</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-primary me-1 mb-1">Signin</button>
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
