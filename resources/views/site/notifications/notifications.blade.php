@extends('site.layouts.base')

@section('title', 'Notifications')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Notifications</h3>
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Notifications</h4>
                        </div>
                        <div class="card-content pb-4">
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="assets/images/faces/4.jpg">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">Hank Schrader</h5>
                                    <h6 class="text-muted mb-0">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quas omnis
                                        laudantium tempore
                                        exercitationem, expedita aspernatur sed officia asperiores unde tempora maxime odio
                                        reprehenderit
                                        distinctio incidunt! Vel aspernatur dicta consequatur!</h6>
                                </div>
                            </div>
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="assets/images/faces/5.jpg">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">Dean Winchester</h5>
                                    <h6 class="text-muted mb-0">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quas omnis
                                        laudantium tempore
                                        exercitationem, expedita aspernatur sed officia asperiores unde tempora maxime odio
                                        reprehenderit
                                        distinctio incidunt! Vel aspernatur dicta consequatur!</h6>
                                </div>
                            </div>
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="assets/images/faces/1.jpg">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">John Dodol</h5>
                                    <h6 class="text-muted mb-0">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quas omnis
                                        laudantium tempore
                                        exercitationem, expedita aspernatur sed officia asperiores unde tempora maxime odio
                                        reprehenderit
                                        distinctio incidunt! Vel aspernatur dicta consequatur!</h6>
                                </div>
                            </div>
                            <div class="px-4">
                                <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
