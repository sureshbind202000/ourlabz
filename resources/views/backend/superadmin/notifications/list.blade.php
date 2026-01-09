@extends('backend.includes.layout')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header bg-body-tertiary">
            <div class="row flex-between-center">
                <div class="col-sm-auto">
                    <h5 class="mb-1 mb-md-0">All Notifications</h5>
                </div>
                <div class="col-sm-auto fs-10">
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

                            data.forEach(notification => {
                                let readClass = notification.read_at ?
                                    "bg-300 border-secondary" : "";
                                let iconClass = notification.read_at ?
                                    "uploads/notify/open_noti.png" :
                                    "uploads/notify/new_noti.png";
                                let humanTime = moment(notification.created_at).fromNow();

                                html += `
                                    <div class="border-bottom-0 notification rounded-0 border-x-0 ${readClass}">
                                        <div class="avatar avatar-xl me-3">
                                            <img class="rounded-circle" src="{{ asset('${iconClass}') }}" alt="" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">
                                                <a href="${notification.data.url}" class="text-decoration-none text-dark">${notification.data.message}</a>
                                            </p>
                                            <small class="notification-time">
                                                <span class="me-2" role="img" aria-label="Emoji">📢</span> ${humanTime}
                                            </small>
                                        </div>
                                        <div style="width: 135px;">
                                            <button class="btn btn-sm btn-falcon-primary mark-read bg-gradient" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="Read" data-id="${notification.id}">
                                                <span class="text-success fas fa-check"></span>
                                            </button>
                                            <button class="btn btn-sm btn-falcon-danger delete-notification bg-gradient ms-2" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="Delete" data-id="${notification.id}">
                                                <span class="text-danger fas fa-trash"></span>
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
