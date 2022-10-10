<div class="col-md-12 col-12 mx-auto">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" enctype="multipart/form-data" method="post" action="{{ url('account/setting/avatar') }}">
                    @csrf
                    <div class="form-body">
                        <div class="getuserArow">

                            <div class="col-12 col-md-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <p class="card-text text-info">
                                                Maximum size of file should be 3 MB <br>
                                                Allowed Types are png, jpg, jpeg and svg only <br>
                                            </p>
                                            <img height="200px" class="text-center mx-auto" src="{{ $user->getUserAvatar() }}">
                                            <!-- File uploader with image preview -->
                                            <input type="file" name="image" class="image-preview-upload">
                                            {!! $errors->first('image', '<br><small class="text-danger">:message</small>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-1 mb-1">Change Avatar</button>
                                @if ( $user->avatar )
                                    <a href="{{ url( 'account/setting/remove-avatar' ) }}" class="btn btn-danger me-1 mb-1">Remove Avatar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

