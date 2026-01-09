@extends('frontend.includes.dashboard_layout')
@section('css')
@endsection
@section('dash_content')
    <div class="user-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-card">
                    <div class="card overflow-hidden">
                        <div class="card-header bg-transparent">
                            <div class="row flex-between-center">
                                <div class="col-sm-auto">
                                    <h5 class="mb-1 mb-md-0 user-card-title border-0">All Notifications</h5>
                                </div>
                                <div class="col-sm-auto fs-10 ms-auto">
                                    <a href="javascript:void(0)" id="markAllRead">Mark all as read</a>
                                    <a href="javascript:void(0)" id="deleteAll" class="ms-2 ms-sm-3">Delete All</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body fs-10 p-0">
                            <div id="notification-list">
                                <!-- Notifications will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            loadNotifications();

            function loadNotifications() {
                $.ajax({
                    url: "{{ route('notifications.list') }}",
                    type: "GET",
                    success: function(data) {
                        let html = '';

                        if (data.length > 0) {
                            // Sort: Unread notifications first, then sort by `created_at` (newest first)
                            data.sort((a, b) => {
                                if (!a.read_at && b.read_at) return -1; // Unread first
                                if (a.read_at && !b.read_at) return 1; // Read last
                                return new Date(b.created_at) - new Date(a
                                    .created_at); // Sort by newest
                            });

                            // 🔹 Get total and unread counts
                            let totalCount = data.length;
                            let unreadCount = data.filter(n => !n.read_at).length;

                            // Update title with count
                            $(".user-card-title").html(
                                `All Notifications (${unreadCount}/${totalCount})`);

                            data.forEach(notification => {
                                let readClass = notification.read_at ?
                                    "notification-read" : "shadow-sm";
                                let newClass = notification.read_at ? "" :
                                    "blink-dot";
                                let iconClass = notification.read_at ?
                                    "uploads/notify/open_noti.png" :
                                    "uploads/notify/new_noti.png";
                                let humanTime = moment(notification.created_at).fromNow();

                                html += `
                                    <div class="notification rounded-0 border-x-0 ${readClass} d-flex p-2 mb-2" style="font-size: 12px;">
                                        <div class="avatar avatar-xl m-2">
                                            <img class="rounded-circle" src="{{ asset('${iconClass}') }}" alt="Message Icon" style="height:35px;" />
                                        </div>
                                        <a href="${notification.data.url}" class="flex-grow-1 text-decoration-none text-dark">
                                            <p class="mb-1">
                                                ${notification.data.message}
                                            </p>
                                            <small class="notification-time">
                                                <span class="me-2" role="img" aria-label="Emoji">📢</span> ${humanTime}
                                            </small>
                                            <span class="${newClass}" style="position:relative;margin-bottom: -3px;margin-left: 3px;"></span>
                                        </a>
                                        <div style="min-width: 70px;">
                                            <button class="btn btn-sm btn-primary mark-read border-0" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="Read" data-id="${notification.id}">
                                                <span class="fas fa-check"></span>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-notification border-0" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="Delete" data-id="${notification.id}">
                                                <span class="fas fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html = `<p class="text-center text-muted p-3">No notifications found</p>`;
                        }

                        $('#notification-list').html(html);
                    }
                });
            }



            // Mark selected notifications as read
            $(document).on('click', '.mark-read', function() {
                let id = $(this).data('id');
                updateNotifications([id], "{{ route('notifications.markRead') }}");
            });

            // Delete selected notifications
            $(document).on('click', '.delete-notification', function() {
                let id = $(this).data('id');
                updateNotifications([id], "{{ route('notifications.delete') }}");
            });

            // Mark all as read
            $('#markAllRead').click(function() {
                $.post("{{ route('notifications.markAllRead') }}", {
                    _token: "{{ csrf_token() }}"
                }, function() {
                    loadNotifications();
                    Swal.fire("Success!", "All notifications marked as read.", "success");
                });
            });

            // Delete all notifications
            $('#deleteAll').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete all notifications permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete all!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('notifications.deleteAll') }}", {
                            _token: "{{ csrf_token() }}"
                        }, function() {
                            loadNotifications();
                            Swal.fire("Deleted!", "All notifications have been deleted.",
                                "success");
                        });
                    }
                });
            });


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
        });
    </script>
@endsection
