@if ($message = session()->get('success'))
<div class="row Topspacer">
    <div class="NotificationAlert alert alert-success alert-dismissible show fade">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
</div>
@endif

@if ($message = session()->get('error'))
<div class="row Topspacer">
    <div class="NotificationAlert alert alert-danger alert-dismissible show fade">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
</div>
@endif

@if ($message = session()->get('warning'))
<div class="row Topspacer">
    <div class="NotificationAlert alert alert-warning alert-dismissible fade show">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
</div>
@endif

@if ($message = session()->get('info'))
<div class="row Topspacer">
    <div class="NotificationAlert alert alert-info alert-dismissible show fade">
        {!! $message !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
</div>
@endif
{{-- Remove Notification after 5 sec --}}
@if ( session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info') )
@section('javascript')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".NotificationAlert ").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 5000);
    });
</script>
@stop
@endif
