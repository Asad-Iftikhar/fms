@extends('admin.layouts.default')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/DataTables-1.12.1/datatables.min.css") }}"/>
@stop
@section('title', 'Funding Types')
@section('content')
    {{-- Funding Grid Datatable   --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>All Notifications</h4>
                </div>
                <div class="col-6 text-end">
                    <span>
                        @if( \App\Models\Notifications\Notification::countAdminUnreadNotifications() > 0)
                            <button class="btn btn-dark mark-all-admin-read">Mark All As Read</button>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body all-notifications">
            @if( $all_notifications->count() > 0 )
                @foreach( $all_notifications as $notification )
                    <a data-id="{{ $notification->id }}" class="text-muted notification-link" data-href="{!! url($notification->redirect_url) !!}">
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
        @if( $all_notifications->count() > 0 )
            <div class="p-4">
                <button class='load-more btn btn-block btn-xl btn-light-primary font-bold mt-3'>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Load More
                </button>
            </div>
        @endif
    </div>

@endsection

@section('javascript')
    @parent
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        let skip = 6;
        // Ajax request to get more notifications
        $('.load-more').on('click', getMoreAdminNotifications);
        function getMoreAdminNotifications() {
            let clickedBtn = $(this);
            clickedBtn.attr("disabled", true);
            let btnIcon = clickedBtn.find("span");
            btnIcon.removeClass("d-none");
            clickedBtn.attr("disabled", true);
            $.ajax({
                type:'POST',
                url: "{{ url('admin/get-more-admin-notifications') }}",
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
        $('.mark-all-admin-read').on('click', markAllAdminNotificationsRead);
        function markAllAdminNotificationsRead() {
            let clickedBtn = $(this);
            clickedBtn.attr("disabled", true);
            let btnIcon = clickedBtn.find("span");
            btnIcon.removeClass("d-none");
            clickedBtn.attr("disabled", true);
            $.ajax({
                type:'POST',
                url: "{{ url('admin/mark-all-admin-notifications-read') }}",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success:function(res) {
                    clickedBtn.attr("disabled", false);
                    btnIcon.addClass("d-none");
                    if ( res.status ) {
                        $('.recent-message').removeClass('bg-light');
                        $('.admin-unread-notification-badge').html('0');
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
