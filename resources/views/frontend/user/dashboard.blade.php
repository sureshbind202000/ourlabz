@extends('frontend.includes.dashboard_layout')
@section('css')
@endsection
@section('dash_content')
    <div class="user-wrapper">
        <div class="user-card">
            <div class="user-card-header">
                <h4 class="user-card-title">Summary </h4>
                <div class="user-card-header-right">
                    <a href="{{ route('live.tracking') }}" class="text-decoration-none border-glow-btn" data-tooltip="tooltip" title="You have {{ $freeConsultationCount ?? 0}} active live tracking, Click to view.">
                        <span class="badge rounded-pill px-2 py-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span>Live Tracking : </span>
                            <span class="fw-bold fs-6 text-primary bg-white rounded-circle d-flex justify-content-center align-items-center" style="height: 20px;width: 20px;">{{ $freeConsultationCount ?? 0}}</span>
                        </span>
                    </a>
                    <a href="{{ route('user.all.consultation') }}" class="text-decoration-none border-glow-btn" data-tooltip="tooltip" title="You have {{ $freeConsultationCount ?? 0}} Free Consultations, Click to book now.">
                        <span class="badge rounded-pill px-2 py-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-stethoscope"></i>
                            <span>Free Consultations : </span>
                            <span class="fw-bold fs-6 text-primary bg-white rounded-circle d-flex justify-content-center align-items-center" style="height: 20px;width: 20px;">{{ $freeConsultationCount ?? 0}}</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-widget color-3">
                        <div class="dashboard-widget-info">
                            <h1>{{ $bookingCount }}</h1>
                            <span>My Bookings</span>
                        </div>
                        <div class="dashboard-widget-icon">
                            <i class="fal fa-list"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-widget color-3">
                        <div class="dashboard-widget-info">
                            <h1>{{ $orderCount }}</h1>
                            <span>My Orders</span>
                        </div>
                        <div class="dashboard-widget-icon">
                            <i class="fal fa-box-open"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-widget color-2">
                        <div class="dashboard-widget-info">
                            <h1>₹{{ number_format($walletBalance, 2) }}</h1>
                            <span>My Wallet</span>
                        </div>
                        <a href="#">
                            <div class="dashboard-widget-icon">
                                <i class="fal fa-wallet"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="user-card">
            <div class="user-card-header">
                <h4 class="user-card-title user-card-title-text">Latest Notifications</h4>
                <div class="user-card-header-right">
                    <a href="{{ route('user_notification') }}"
                        class="btn btn-sm btn-link text-primary text-decoration-none">View All</a>
                </div>
            </div>
            <div class="table-responsive" id="dashboard-notification"
                style="overflow-y: auto;max-height: 415px;scrollbar-width: thin;">

            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            loadHeaderNotifications();

            function loadHeaderNotifications() {
                $.ajax({
                    url: "{{ route('notifications.list') }}",
                    type: "GET",
                    success: function(data) {
                        let html = '';
                        data = data.slice(0, 5);
                        if (data.length > 0) {
                            // Sort: Unread first, newest first
                            data.sort((a, b) => {
                                if (!a.read_at && b.read_at) return -1;
                                if (a.read_at && !b.read_at) return 1;
                                return new Date(b.created_at) - new Date(a.created_at);
                            });

                            // 🔹 Get total and unread counts
                            let totalCount = data.length;
                            let unreadCount = data.filter(n => !n.read_at).length;

                            // Update title with count
                            $(".user-card-title-text").html(
                                `Latest Notifications (${unreadCount}/${totalCount})`);

                            data.forEach(notification => {
                                let readClass = notification.read_at ? "notification-read" :
                                    "notification-unread mark-read shadow-sm";
                                let newClass = notification.read_at ? "" :
                                    "blink-dot";
                                let iconClass = notification.read_at ?
                                    "uploads/notify/open_noti.png" :
                                    "uploads/notify/new_noti.png";
                                let humanTime = moment(notification.created_at).fromNow();

                                html += `
                        <div class="list-group-item mb-2" style="font-size: 12px;">
                            <a class="notification notification-flush ${readClass} d-flex py-2 rounded-2" data-id="${notification.id}" href="${notification.data.url}">
                                <div class="notification-avatar align-items-center ">
                                    <div class="avatar avatar-2xl m-2">
                                        <img class="rounded-circle" src="{{ asset('${iconClass}') }}" alt="Messsage Icon"  style="height: 35px;"/>
                                    </div>
                                </div>
                                <div class="notification-body">
                                    <p class="mb-1">${notification.data.message}</p>
                                    <span class="notification-time">
                                        <span class="me-2" role="img" aria-label="Emoji">📢</span> ${humanTime}
                                    </span>
                                    <span class="${newClass}" style="position:relative;margin-bottom: -3px;margin-left: 3px;"></span>
                                </div>
                            </a>
                        </div>
                    `;
                            });
                        } else {
                            html = `<p class="text-center text-muted p-3">No notifications found</p>`;
                        }

                        $('#dashboard-notification').html(html);
                    }
                });
            }

            // global Notifications
            function updateNotifications(ids, url) {
                $.post(url, {
                    _token: "{{ csrf_token() }}",
                    ids: ids
                }, function() {
                    loadNotifications();
                    Swal.fire({
                        title: "Success!",
                        text: "Notification updated successfully.",
                        icon: "success",
                        timer: 2000, // Auto close after 2 seconds
                        showConfirmButton: false
                    });
                });
            }

            // Mark selected notifications as read
            $(document).on('click', '.mark-read', function() {
                let id = $(this).data('id');
                updateNotifications([id], "{{ route('notifications.markRead') }}");
            });

        });
    </script>
@endsection
