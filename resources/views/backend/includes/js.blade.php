<!-- <script src="{{ asset('backend/vendors/popper/popper.min.js') }}"></script> -->

<!-- <script src="{{ asset('backend/vendors/bootstrap/bootstrap.min.js') }}"></script> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="{{ asset('backend/vendors/anchorjs/anchor.min.js') }}"></script>

<script src="{{ asset('backend/vendors/is/is.min.js') }}"></script>

<script src="{{ asset('backend/vendors/echarts/echarts.min.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

<script src="{{ asset('backend/vendors/lodash/lodash.min.js') }}"></script>

<script src="{{ asset('backend/vendors/list.js/list.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/theme.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<script src="{{ asset('backend/vendors/glightbox/glightbox.min.js') }}"></script>

<script src="{{ asset('backend/vendors/flatpickr/flatpickr.min.js') }}"></script>

<script src="{{ asset('backend/vendors/dropzone/dropzone-min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@include('frontend.includes.location')
<script>
    $(document).ready(function() {

        const currentUrl = window.location.href;

        // Initialize Toastr options
        // toastr.options = {
        //     "closeButton": true,
        //     "progressBar": true,
        //     "positionClass": "toast-top-right",
        //     "timeOut": "5000",
        //     "extendedTimeOut": "2000",
        //     "newestOnTop": true,
        //     "preventDuplicates": true
        // };

                // Step 1️⃣ — Remove previous active classes
        $("#navbarVerticalNav .nav-link").removeClass("active");

        // Step 2️⃣ — Find and mark the current link as active
        $("#navbarVerticalNav .nav-link").each(function() {
            const linkUrl = $(this).attr("href");
            if (currentUrl === linkUrl || currentUrl.includes(linkUrl)) {
                $(this).addClass("active");

                // If it's inside a dropdown, expand its parent
                const parentCollapse = $(this).closest(".collapse");
                if (parentCollapse.length) {
                    parentCollapse.addClass("show");
                    parentCollapse.prev(".nav-link").addClass("active"); // highlight parent menu too
                }
            }
        });

        // Step 3️⃣ — Handle click manually to update active immediately
        $("#navbarVerticalNav .nav-link").on("click", function() {
            $("#navbarVerticalNav .nav-link").removeClass("active");
            $(this).addClass("active");

            // Save clicked menu in localStorage
            localStorage.setItem("activeMenu", $(this).attr("href"));
        });

        // Step 4️⃣ — Keep active even after reload
        const activeMenu = localStorage.getItem("activeMenu");
        if (activeMenu) {
            $("#navbarVerticalNav .nav-link").each(function() {
                if ($(this).attr("href") === activeMenu) {
                    $(this).addClass("active");

                    // Also expand parent dropdown (if any)
                    const parentCollapse = $(this).closest(".collapse");
                    if (parentCollapse.length) {
                        parentCollapse.addClass("show");
                        parentCollapse.prev(".nav-link").addClass("active");
                    }
                }
            });
        }
    });
</script>



@if (session('auth_token'))

<script>
    localStorage.setItem("auth_token", "{{ session('auth_token') }}");
</script>

@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Init tooltip for all existing + future elements

        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        tooltipTriggerList.map(function(tooltipTriggerEl) {

            return new bootstrap.Tooltip(tooltipTriggerEl);

        });



        // Observer for dynamically added tooltips

        const observer = new MutationObserver(() => {

            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {

                if (!bootstrap.Tooltip.getInstance(el)) {

                    new bootstrap.Tooltip(el);

                }

            });

        });



        observer.observe(document.body, {

            childList: true,

            subtree: true

        });

    });





    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token

        }

    });
</script>

@php

$restrict_access = 0;

$lab_status = null;



$user = auth()->user();



if ($user->role == 2 && $user->lab_user_role == 1) {

$lab = \App\Models\Lab::where('lab_id', $user->lab_id)->first();



if ($lab && in_array($lab->status, [0, 2])) {

$restrict_access = 1;

$lab_status = $lab->status;

}

}

@endphp

<script>
    $(document).ready(function() {

        var restrictAccess = @json($restrict_access);

        var labStatus = @json($lab_status ?? null);

        var currentRoute = "{{ Route::currentRouteName() }}";



        // ❌ Don't show modal on lab.profile route

        if (currentRoute !== 'lab.profile' && restrictAccess === 1) {

            let message = "Your access has been restricted.";



            if (labStatus === 0) {

                message = "Your lab is currently inactive. Please contact the administrator.";

            } else if (labStatus === 2) {

                message = "Your lab has been suspended. Please reach out to support.";

            }



            $('#lockScreenMessage').text(message);

            $('#lock-screenstaticBackdrop').modal('show');

        }



        @if(auth()->check() && auth()->user()->status == 0)

        @php

        $user = auth()-> user();

        $profileUrl = '#';



        if ($user -> role == 3) {

            $profileUrl = route('doctor.profile', ['doctorid' => $user-> user_id]);

        }
        elseif($user -> role == 4) {

            $profileUrl = route('corporate.profile', ['corporateid' => $user -> user_id]);

        }
        elseif($user -> role == 5) {

            $profileUrl = route('vendor.profile', ['vendorid' => $user -> user_id]);

        }



        @endphp



        // Only show modal if not on the profile route

        var profileRoutes = [

            'doctor.profile',

            'corporate.profile',

            'vendor.profile'

        ];



        if (!profileRoutes.includes(currentRoute)) {

            Swal.fire({

                icon: 'error',

                title: 'Account Disabled',

                text: 'Your account has been disabled. Please contact support.',

                allowOutsideClick: false,

                allowEscapeKey: false,

                showConfirmButton: true,

                showCancelButton: true,

                confirmButtonText: 'Update Profile',

                cancelButtonText: 'Logout',

                customClass: {

                    confirmButton: 'btn btn-sm btn-primary me-2 mb-4',

                    cancelButton: 'btn btn-sm btn-secondary mb-4'

                },

                buttonsStyling: false

            }).then((result) => {

                if (result.isConfirmed) {

                    // Redirect to the correct profile page based on role

                    window.location.href = "{{ $profileUrl }}";

                } else if (result.dismiss === Swal.DismissReason.cancel) {

                    // Logout user

                    document.getElementById('logout-form').submit();

                }

                // Dim the page after action

                document.body.style.pointerEvents = "none";

                document.body.style.opacity = "0.3";

            });

        }

        @endif









        @if(!session('welcome_shown') && auth()-> check() && auth() -> user() -> status == 1)

        Swal.fire({

            icon: 'success',

            title: 'Welcome!',

            text: 'Welcome back, {{ auth()->user()->name }}!',

            confirmButtonText: 'Continue'

        }).then(() => {

            // When user clicks Continue, set session via AJAX

            fetch("{{ route('set.welcome.shown') }}", {

                method: "POST",

                headers: {

                    "X-CSRF-TOKEN": "{{ csrf_token() }}",

                    "Content-Type": "application/json"

                },

                body: JSON.stringify({})

            });

        });

        @endif

    });
</script>

{{-- Multi Select --}}

<script>
    function initOrResetChoices(id, key, selectedValues = []) {
        const $element = document.querySelector(id);
        if (!$element) return;

        // Parse JSON string if needed
        if (typeof selectedValues === 'string') {
            try {
                selectedValues = JSON.parse(selectedValues);
            } catch (e) {
                selectedValues = [];
                console.warn(e);
            }
        }
        if (!Array.isArray(selectedValues)) selectedValues = [];

        // Destroy existing Choices instance
        if (choicesInstances[key]) {
            choicesInstances[key].destroy();
            delete choicesInstances[key];
        }

        // Clear existing options
        $element.innerHTML = '';

        // Add options without selecting them
        selectedValues.forEach(val => {
            const option = document.createElement('option');
            option.value = val;
            option.text = val;
            $element.appendChild(option);
        });

        // Initialize Choices
        choicesInstances[key] = new Choices($element, {
            removeItemButton: true,
            placeholder: true,
            allowHTML: true,
            shouldSort: false,
        });

        // Let Choices select the values safely
        selectedValues.forEach(val => {
            choicesInstances[key].setChoiceByValue(val);
        });
    }
</script>


{{-- Single Select --}}

<script>
    var choicesInstances = {};



    function initSingleChoice(id, key, selectedValue = '') {

        const $element = document.querySelector(id);

        if (!$element) return;



        // Destroy existing instance

        if (choicesInstances[key]) {

            choicesInstances[key].destroy();

            delete choicesInstances[key];

        }



        // Save and reset options

        const originalOptions = Array.from($element.options);

        $element.innerHTML = '';



        originalOptions.forEach(opt => {

            const option = document.createElement('option');

            option.value = opt.value;

            option.text = opt.text;



            if (opt.value !== '' && opt.value == selectedValue) {

                option.selected = true;

            }



            $element.appendChild(option);

        });



        // Initialize Choices for single select

        choicesInstances[key] = new Choices($element, {

            removeItemButton: false,

            placeholder: true,

            allowHTML: true,

            shouldSort: false,

            maxItemCount: 1,

        });

    }
</script>

<script>
    $(document).ready(function() {

        function loadWalletBalance() {

            $.get('/corporate/wallet', function(res) {

                if (res.success) {

                    $('.walletBalance').html(new Intl.NumberFormat('en-IN', {

                        style: 'currency',

                        currency: 'INR'

                    }).format(res.wallet));

                }

            });

        }

        loadWalletBalance();

    });
</script>



<script>
    function startBarcodeScanner() {

        $("#scan-result").html("");

        $("#barcode-scanner").show();

        Quagga.init({

            inputStream: {

                name: "Live",

                type: "LiveStream",

                target: document.querySelector('#barcode-scanner'),

                constraints: {

                    facingMode: "environment",

                    width: {

                        ideal: 1920

                    }, // high resolution

                    height: {

                        ideal: 1080

                    }

                }

            },

            decoder: {

                readers: ["code_128_reader"]

            },

            locator: {

                patchSize: "medium", // try "large" if still failing

                halfSample: false

            },

            locate: truef

        }, function(err) {

            if (err) {

                console.error(err);

                return;

            }

            console.log("QuaggaJS initialized.");

            Quagga.start();

        });

        Quagga.onDetected(function(data) {

            let code = data.codeResult.code;

            if (/^BK\d+\|TID[\d,]+$/.test(code)) {

                Quagga.stop();

                $("#barcode-scanner").hide();

                fetchBookingDetails(code);

            } else {

                console.warn("Invalid or partial code detected:", code);

            }

        });

    }



    function stopBarcodeScanner() {

        Quagga.stop();

        $("#barcode-scanner").hide();

    }



    function fetchBookingDetails(code) {

        $.ajax({

            url: "{{ route('barcode.scan') }}",

            type: "POST",

            data: {

                code: code,

                _token: "{{ csrf_token() }}"

            },

            success: function(res) {

                console.log(res);

                if (res.status) {

                    let html = `

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">Booking #${res.booking.id}</h5>

                    </div>

                    <div class="card-body">

                        <p><strong>User:</strong> ${res.booking.user_name}</p>

                        <p><strong>Date:</strong> ${res.booking.created_at}</p>



                        <h6 class="mt-3 mb-2">Tests:</h6>

                        <ul class="list-group list-group-flush">

                            ${res.tests.map(t => `

                                <li class="list-group-item">

                    <div class="fw-bold">${t.name}</div>

                    <small class="text-muted">Specimen: ${t.sample_type_specimen}</small>

                         </li>

                            `).join('')}

                        </ul>

                    </div>

                </div>

                `;

                    $("#scan-result").html(html);

                } else {

                    $("#scan-result").html(`

                    <div class="alert alert-danger mb-0">

                        ${res.message}

                    </div>

                `);

                }

            },

            error: function() {

                $("#scan-result").html(`

                <div class="alert alert-danger mb-0">

                    Error scanning barcode.

                </div>

            `);

            }

        });

    }
</script>



<script>
    $(document).ready(function() {

        loadHeaderNotifications();



        // function loadHeaderNotifications() {

        //     $.ajax({

        //         url: "{{ route('notifications.list') }}",

        //         type: "GET",

        //         success: function(data) {

        //             let html = '';



        //             if (data.length > 0) {

        //                 // Sort: Unread first, newest first

        //                 data.sort((a, b) => {

        //                     if (!a.read_at && b.read_at) return -1;

        //                     if (a.read_at && !b.read_at) return 1;

        //                     return new Date(b.created_at) - new Date(a.created_at);

        //                 });



        //                 data.forEach(notification => {

        //                     let readClass = notification.read_at ? "notification-unread" :

        //                         "notification-read mark-read";

        //                     let iconClass = notification.read_at ?

        //                         "uploads/notify/open_noti.png" :

        //                         "uploads/notify/new_noti.png";

        //                     let humanTime = moment(notification.created_at).fromNow();



        //                     html += `

        //                 <div class="list-group-item">

        //                     <a class="notification notification-flush ${readClass}" data-id="${notification.id}" href="${notification.data.url}">

        //                         <div class="notification-avatar">

        //                             <div class="avatar avatar-2xl me-3">

        //                                 <img class="rounded-circle" src="{{ asset('${iconClass}') }}" alt="" />

        //                             </div>

        //                         </div>

        //                         <div class="notification-body">

        //                             <p class="mb-1">${notification.data.message}</p>

        //                             <span class="notification-time">

        //                                 <span class="me-2" role="img" aria-label="Emoji">📢</span> ${humanTime}

        //                             </span>

        //                         </div>

        //                     </a>

        //                 </div>

        //             `;

        //                 });

        //             } else {

        //                 html = `<p class="text-center text-muted p-3">No notifications found</p>`;

        //             }



        //             $('.list-group.list-group-flush.fw-normal.fs-10').html(html);

        //         }

        //     });

        // }



        // Optional: har 10 sec me check
        setInterval(loadHeaderNotifications, 10000);


        let lastNotificationId = 0;
        let firstLoad = true;
        let shownNotificationIds = new Set(); // ✅ Track jo already dikha chuke

        // Har 10 sec me check
        setInterval(loadHeaderNotifications, 10000);

        function playNotificationSound() {
            let audio = document.getElementById('notifySound');
            if (audio) {
                audio.currentTime = 0;
                audio.play().catch(e => console.log('Sound blocked'));
            }
        }

        function showNotificationToastr(notification) {
            // Toastr configuration - persistent until manually closed
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": function() {
                    window.location.href = notification.data.url;
                },
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "0",                // ✅ Persistent
                "extendedTimeOut": "0",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.info(
                notification.data.message,
                '🔔 New Notification',
                {
                    timeOut: 0,
                    extendedTimeOut: 0
                }
            );
        }

        function loadHeaderNotifications() {
            $.ajax({
                url: "{{ route('notifications.list') }}",
                type: "GET",
                success: function(data) {
                    let html = '';

                    if (data.length > 0) {
                        // SORT (newest first)
                        data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                        // 🔐 FIRST LOAD → current notifications ko track karo, NO TOASTR
                        if (firstLoad) {
                            data.forEach(n => {
                                shownNotificationIds.add(n.id); // ✅ Existing sab ko add karo
                            });
                            if (data.length > 0) {
                                lastNotificationId = data[0].id;
                            }
                            firstLoad = false;
                        } else {
                            // ✅ Only TRULY NEW notifications (jo pehle kabhi nahi dikhe)
                            let newNotifications = data.filter(n =>
                                !shownNotificationIds.has(n.id) // ✅ Jo pehli baar aa raha hai
                            );

                            if (newNotifications.length > 0) {
                                newNotifications
                                    .sort((a, b) => a.id - b.id) // oldest first popup
                                    .forEach(n => {
                                        showNotificationToastr(n);  // ✅ Sirf naye notifications
                                        playNotificationSound();
                                        shownNotificationIds.add(n.id); // ✅ Track karo
                                    });

                                // Update last ID
                                lastNotificationId = Math.max(...newNotifications.map(n => n.id));
                            }
                        }

                        // UI render (same as before)
                        data.forEach(notification => {
                            let readClass = notification.read_at
                                ? "notification-unread"
                                : "notification-read mark-read";

                            let iconClass = notification.read_at
                                ? "uploads/notify/open_noti.png"
                                : "uploads/notify/new_noti.png";

                            let humanTime = moment(notification.created_at).fromNow();

                            html += `
                            <div class="list-group-item">
                                <a class="notification notification-flush ${readClass}"
                                href="${notification.data.url}">
                                    <div class="notification-body">
                                        <p class="mb-1">${notification.data.message}</p>
                                        <span class="notification-time">📢 ${humanTime}</span>
                                    </div>
                                </a>
                            </div>`;
                        });

                    } else {
                        html = `<p class="text-center text-muted p-3">No notifications found</p>`;
                    }

                    $('.list-group.list-group-flush.fw-normal.fs-10').html(html);
                }
            });
        }

        // global Notifications

        function updateNotifications(ids, url) {

            $.post(url, {

                _token: "{{ csrf_token() }}",

                ids: ids

            }, function() {

                loadHeaderNotifications();

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



@yield('js')
