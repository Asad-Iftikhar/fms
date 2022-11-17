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
                            <div class="row">
                                <div class="col-6">
                                    <h4>Recent Notifications</h4>
                                </div>
                                <div class="col-6 text-end">
                                    @if(Auth::user()->countUserUnreadNotifications() > 0)
                                        <button class="btn btn-dark mark-all-read">Mark All As Read</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-content pb-4 all-notifications">
                            @if( $all_notifications->count() > 0 )
                                @foreach( $all_notifications as $notification )
                                    <a data-id="{{ $notification->id }}" class="text-muted notification-link" data-href="{{ $notification->redirect_url }}">
                                        <div class="recent-message d-flex px-4 py-3 my-2 {{ empty($notification->read_at)?'bg-light':'' }}">
                                            <div class="avatar avatar-lg display-5">
                                                {!! $notification->getNotificationIcon() !!}
                                            </div>
                                            <div class="name ms-4">
                                                <h5 class="mb-1">{{ $notification->title }}</h5>
                                                <h6 class="text-muted mb-3">
                                                    {{ $notification->description }}
                                                </h6>
                                                <small class="text-muted mb-0">
                                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime( $notification->created_at ))->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="recent-message d-flex px-4 py-3 my-5">
                                    <div class="name ms-4">
                                        <h5 class="mb-1">No Notification(s) Found</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <button class='load-more btn btn-block btn-xl btn-light-primary font-bold mt-3'>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Load More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    @parent
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>

<script>
    let skip = 6;
    // Ajax request to get more notifications
    $('.load-more').on('click', getMoreNotifications);
    function getMoreNotifications() {
        let clickedBtn = $(this);
        clickedBtn.attr("disabled", true);
        let btnIcon = clickedBtn.find("span");
        btnIcon.removeClass("d-none");
        clickedBtn.attr("disabled", true);
        $.ajax({
            type:'POST',
            url: "{{ url('get-notifications') }}",
            dataType: "json",
            data: {
            "_token": "{{ csrf_token() }}",
            "skip": skip
        },
        success:function(res) {
            clickedBtn.attr("disabled", false);
            btnIcon.addClass("d-none");
            if ( res.status ) {
                skip += 6;
                if(res.notifications) {
                    $.each(res.notifications , function(key, value) {
                        $('.all-notifications').append('<a onclick="markNotificationRead(this)" data-id="'+ value.id +'" class="text-muted notification-link" data-href="'+ value.redirect_url +'"> <div class="recent-message d-flex px-4 py-3 my-2  '+ value.read_class +'">  <div class="avatar avatar-lg display-5">'+ value.icon +'</div><div class="name ms-4"> <h5 class="mb-1">'+ value.title +'</h5><h6 class="text-muted mb-0">'+ value.description +'</h6><small class="text-muted mb-0">'+ value.created_ago +'</small></div></div></a>');
                    })
                }
            } else {
                clickedBtn.attr("disabled", true);
                swal({
                    title: 'Error',
                    text: 'No More Notifications Found',
                    icon: "error",
                }).then(() => {

                });
            }

        }
    });
}

    // Ajax request to mark all notifications as read
    $('.mark-all-read').on('click', markAllNotificationsRead);
    function markAllNotificationsRead() {
        let clickedBtn = $(this);
        clickedBtn.attr("disabled", true);
        let btnIcon = clickedBtn.find("span");
        btnIcon.removeClass("d-none");
        clickedBtn.attr("disabled", true);
        $.ajax({
            type:'POST',
            url: "{{ url('mark-all-notifications-read') }}",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success:function(res) {
                clickedBtn.attr("disabled", false);
                btnIcon.addClass("d-none");
                if ( res.status ) {
                    $('.recent-message').removeClass('bg-light');
                    $('.unread-notification-badge').html('0');
                    swal({
                        title: 'Success',
                        text: res.msg,
                        icon: "success",
                    }).then(() => {

                    });
                } else {
                    clickedBtn.addClass("d-none");
                    swal({
                        title: 'Error',
                        text: res.msg,
                        icon: "error",
                    }).then(() => {

                    });
                }

            }
        });
    }

</script>
@endsection
