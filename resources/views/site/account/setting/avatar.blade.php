@section('styles')
@parent
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@stop
<div class="col-md-6 col-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Change Avatar</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" enctype="multipart/form-data" method="post" action="{{ url('account/setting/avatar') }}">
                    @csrf
                    <div class="form-body">
                        <div class="getuserArow">

                            <div class="col-12 col-md-12">
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
                                            <img height="200px" class="text-center mx-auto" src="{{ $user->getUserAvatar() }}">
                                            <!-- File uploader with image preview -->
                                            <input type="file" name="image" class="image-preview-upload">
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

@section('javascript')
    @parent
{{--       <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
       <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

       <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

       <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
       <script type="text/javascript">
           FilePond.registerPlugin(
               // preview the image file type...
               FilePondPluginImagePreview,
           );
           // Filepond: Image Preview
           FilePond.create( document.querySelector('.image-preview-upload'), {
               allowImagePreview: true,
               allowImageFilter: false,
               allowImageExifOrientation: false,
               allowImageCrop: false,
               acceptedFileTypes: ['image/png','image/jpg','image/jpeg','image/svg'],
               fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                   // Do custom type detection here and return with promise
                   resolve(type);
               })
           });
       </script>--}}
@stop
