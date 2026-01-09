

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>

<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>

<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

<script src="{{ asset('assets/js/counter-up.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>

<script src="{{ asset('assets/js/countdown.min.js') }}"></script>

<script src="{{ asset('assets/js/wow.min.js') }}"></script>

<script src="{{ asset('assets/js/flex-slider.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/lc-lightbox-lite@1.5.0/js/lc_lightbox.lite.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.2.0/dist/js/splide.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>



<script>

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token

        }

    });



    var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

</script>

@include('frontend.includes.location')

<script>

    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('select.multi-select').forEach(function(selectEl) {

            new Choices(selectEl, {

                removeItemButton: true,

                placeholder: true,

                placeholderValue: 'Select option(s)',

                searchPlaceholderValue: 'Search...',

            });

        });



        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        tooltipTriggerList.forEach(function(tooltipTriggerEl) {

            new bootstrap.Tooltip(tooltipTriggerEl);

        });

    });

</script>



<script>

    lc_lightbox('.lightbox', {

        wrap_class: 'lcl_fade_oc',

        gallery: true,

        thumb_attr: 'data-lcl-thumb',

        skin: 'light',

        radius: 4,

        padding: 0,

        border_w: 0

    });

</script>



<script>

    function showToast(icon, message, duration = 3000) {

        Swal.fire({

            toast: true,

            position: 'bottom-end',

            icon: icon,

            title: message,

            showConfirmButton: false,

            timer: duration,

            timerProgressBar: true,

        });

    }

</script>



<script>

    function updateCartCount() {
        $.get("{{ route('cart.count') }}", function(res) {

            if (res.count !== undefined && res.count > 0) {

                $('#cart-count')

                    .text(res.count)

                    .show();

            } else {

                $('#cart-count').hide();

            }

        });

    }



    // Add to cart

    $(document).on('click', '.add-to-cart', function() {

        let button = $(this);

        let itemId = button.data('id');

        let itemType = button.data('type');

        let pid = $('#packageListContainer').attr('data-pid') ?? '';

        // console.log(pid);


        Swal.fire({

            title: 'Adding to cart...',

            allowOutsideClick: false,

            didOpen: () => Swal.showLoading()

        });



        $.ajax({

            url: "{{ route('cart.add') }}",

            type: 'POST',

            data: {

                _token: '{{ csrf_token() }}',
                item_id: itemId,
                item_type: itemType,
                patients_id: pid,

            },

            success: function(response) {

                Swal.close();

                if (response.status === 'success') {

                    showToast('success', response.message);



                    // replace button with select (including remove option)

                    let html = `

                   <span class="bg-primary-subtle text-primary p-2 px-3 rounded-2">Added</span>`;

                    button.closest('.cart-action').html(html);



                    updateCartCount();

                    updateProductCartCount();

                    updateCombinedCartCount();

                    updateMobileCartSummary();

                }

            }

        });

    });



    // Update quantity OR remove

    $(document).on('change', '.update-qty', function() {

        let select = $(this);

        let itemId = select.data('id');

        let itemType = select.data('type');

        let qty = select.val();



        if (qty === 'remove') {

            // Remove from cart

            Swal.fire({

                title: 'Removing from cart...',

                allowOutsideClick: false,

                didOpen: () => Swal.showLoading()

            });



            $.ajax({

                url: "{{ route('cart.remove') }}",

                type: 'POST',

                data: {

                    _token: '{{ csrf_token() }}',

                    item_id: itemId,

                    item_type: itemType

                },

                success: function(response) {

                    Swal.close();

                    if (response.status === 'success') {

                        showToast('success', response.message);



                        // replace with Add button

                        let html = `<a href="javascript:void(0);"

                                class="btn btn-primary px-4 py-1 border-0 add-to-cart"

                                data-id="${itemId}" data-type="${itemType}">Add</a>`;

                        select.parent().html(html);



                        updateCartCount();

                        updateProductCartCount();

                        updateCombinedCartCount();

                        updateMobileCartSummary();

                    }

                }

            });

        } else {

            // Update qty

            $.ajax({

                url: '{{ route('cart.updateQty') }}',

                type: 'POST',

                data: {

                    _token: '{{ csrf_token() }}',

                    item_id: itemId,

                    item_type: itemType,

                    quantity: qty

                },

                success: function(response) {

                    if (response.status === 'success') {

                        showToast('success', 'Quantity updated');

                        updateCartCount();

                        updateProductCartCount();

                        updateCombinedCartCount();

                        updateMobileCartSummary();

                    }

                }

            });

        }

    });



    $(document).on('click', '.product-add-to-cart', function() {

        Swal.fire({

            title: 'Product adding to cart...',

            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });

        let productId = $(this).data('id');

        let qty = $('.quantity').val();



        $.ajax({

            url: "{{ route('product.cart.add') }}",

            method: 'POST',

            data: {

                _token: '{{ csrf_token() }}',

                item_id: productId,

                quantity: qty

            },

            success: function(res) {

                Swal.close();

                if (res.status === 'success') {

                    showToast('success', res.message || 'Product added to cart!');

                    updateCartCount();

                    updateProductCartCount();

                    updateCombinedCartCount();

                    updateMobileCartSummary();

                } else {

                    showToast('error', 'Failed to add product.');

                }

            },

            error: function() {

                Swal.close();

                showToast('error', 'Something went wrong.');

            }

        });

    });



    function updateProductCartCount() {

        $.get("{{ route('product.cart.count') }}", function(res) {

            if (res.count !== undefined && res.count > 0) {

                $('#product-cart-count')

                    .text(res.count)

                    .show();

            } else {

                $('#product-cart-count').hide();

            }

        });

    }



    function updateCombinedCartCount() {

        $.get("{{ route('cart.combined.count') }}", function(res) {

            if (res && res.totalcartcount !== undefined && res.totalcartcount > 0) {

                $('.cart-total-count')

                    .text(res.totalcartcount)

                    .show();

                     $('.mobile-bottom-cart').show();

            } else {
                $('.mobile-bottom-cart').hide();

                $('.cart-total-count').hide();

            }

        }).fail(function() {

            console.log("Failed to fetch cart count");

        });

    }



    $(document).ready(function() {

        updateCartCount();

        updateProductCartCount();

        updateCombinedCartCount();

    });



    $(document).on('click', '.cart-icon-handler', function() {

        $.get("{{ route('cart.combined.count') }}", function(res) {

            let testCart = res.lab_cart_count || 0;

            let productCart = res.product_cart_count || 0;



            if (testCart > 0 && productCart > 0) {

                // Show modal to select cart

                $('#cartSelectModal').modal('show');

            } else if (testCart > 0) {

                // Redirect to lab test cart

                window.location.href = "{{ route('cart.view') }}";

            } else if (productCart > 0) {

                // Redirect to product cart

                window.location.href = "{{ route('product.cart') }}";

            } else {

                showToast('info', 'Your cart is empty.');

            }

        }).fail(function() {

            showToast('error', 'Failed to fetch cart info.');

        });

    });

    // ========================
    function updateMobileCartSummary() {
        $.ajax({
            url: "{{ route('cart.total') }}",
            method: "GET",
            success: function(res) {
                console.log(res);
                $(".mobile-cart-total-amount").text("₹" + res.total);
                $(".mobile-cart-total-count").text(res.count);
                if(res.count > 0){
                    $(".mobile-cart-total-count").show();
                } else {
                    $(".mobile-cart-total-count").hide();
                }
            }
        });
    }
    updateMobileCartSummary();

   function loadMobileCart() {
    $.get("{{ route('mobile.cart.fetch') }}", function(res){

        let html = "";
        res.items.forEach(item => {
            html += `
            <div class="d-flex justify-content-between align-items-center card-box mb-2">
                <div class="d-flex align-items-center gap-2 ">
                    <img src="${item.img}" width="32">
                    <div>
                        <p class="fw-bold mb-0">${item.name}</p>
                        <p class="text-muted mb-0">₹${item.price}</p>
                    </div>
                </div>
                <button class="btn btn-outline-danger btn-sm remove-mobile-cart" data-id="${item.id}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>`;
        });

        $("#mobileCartItems").html(html);
        $(".bottom-bar .fw-semibold").text("₹" + res.total);
        $(".bottom-bar .text-muted").text(res.count + " Items");

        // Update top bar mini cart as well
        $(".mobile-cart-total-amount").text("₹" + res.total);
        $(".mobile-cart-total-count").text(res.count).show();

    });
}

$('#viewCartCanvas').on('show.bs.offcanvas', function () {
    loadMobileCart();
});

$(document).on("click", ".remove-mobile-cart", function () {
    let id = $(this).data("id");

    $.ajax({
        url: "{{ route('mobile.cart.remove') }}",
        type: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            loadMobileCart();
             updateMobileCartSummary();
             updateCartCount();
             updateProductCartCount();
            updateCombinedCartCount();

        }
    });
});

</script>

{{-- End Product Cart --}}

<!-- OTP Script -->

<script>

    var otp_inputs = document.querySelectorAll(".otp__digit");

    var mykey = "0123456789".split("");

    otp_inputs.forEach((_) => {

        _.addEventListener("keyup", handle_next_input);

    });



    function handle_next_input(event) {

        let current = event.target;

        let index = parseInt(current.classList[1].split("__")[2]);

        current.value = event.key;



        if (event.keyCode == 8 && index > 1) {

            current.previousElementSibling.focus();

        }

        if (index < 6 && mykey.indexOf("" + event.key + "") != -1) {

            var next = current.nextElementSibling;

            next.focus();

        }

        var _finalKey = "";

        for (let {

                value

            }

            of otp_inputs) {

            _finalKey += value;

        }

        if (_finalKey.length == 6) {

            document.querySelector("#_otp").classList.replace("_notok", "_ok");

            document.querySelector("#_otp").innerText = _finalKey;

        } else {

            document.querySelector("#_otp").classList.replace("_ok", "_notok");

            document.querySelector("#_otp").innerText = _finalKey;

        }

    }

</script>

<script>

    function validatePhone() {

        var phone = document.getElementById('login-phone').value.trim();

        var name = document.getElementById('login-name').value.trim();

        var termsChecked = document.getElementById('terms-check').checked;



        // Regex patterns

        var phoneRegex = /^[6-9]\d{9}$/; // Indian mobile number

        var nameRegex = /^[A-Za-z\s]{3,}$/; // Only letters & space, min 3 chars





        if (!name || !nameRegex.test(name)) {

            showToast('error', 'Please enter a valid full name (only letters, min 3 characters).');

            return;

        }



        if (!phone || !phoneRegex.test(phone)) {

            showToast('error', 'Please enter a valid 10-digit phone number.');

            return;

        }



        if (!termsChecked) {

            showToast('warning', 'Please agree to the Terms & Conditions.');

            return;

        }



        var fullPhone = '+91' + phone;



        Swal.fire({

            title: "Sending OTP...",

            text: "Please wait while we send the OTP to phone.",

            allowOutsideClick: false,

            didOpen: () => Swal.showLoading()

        });



        // Send OTP request

        $.ajax({

            url: "{{ route('send.login.otp') }}",

            method: "POST",

            data: {

                name: name,

                phone: phone,

            },

            success: function(response) {

                // $('#dummyOtp').text(response.otp);

                Swal.close();



                var phone = $("#login-phone").val() || "";



                if (phone) {



                    maskPhone(phone);

                    $('#popup-banner').modal('hide');

                    $('#otpModal').modal('show');



                } else {



                    Swal.close();

                    Toast.fire({

                        icon: 'error',

                        title: 'Phone number is missing, cannot proceed with OTP!'

                    });



                }

            },

            error: function(xhr) {

                Swal.close();

                let errorMessage = "Failed to send OTP.";

                if (xhr.responseJSON && xhr.responseJSON.error) {

                    errorMessage = xhr.responseJSON.error;

                }

                Toast.fire({

                    icon: "error",

                    title: errorMessage

                });

            }

        });



    }

    // Mask Phone Number

    function maskPhone(phone, email) {

        // Mask phone (keep last 4 digits)

        var maskedPhone = phone.replace(/\d(?=\d{4})/g, 'x').replace(/(\d{3})(\d{3})(\d{4})/, 'xxx-xxx-$3');

        // Insert into modal

        $(".info").text(`An OTP has been sent to ${maskedPhone}.`);

    }



    $('#verifyOtpBtn').on('click', function() {

        let otp = '';

        $('.otp__digit').each(function() {

            otp += $(this).val();

        });



        var name = $("#login-name").val();

        var phone = $("#login-phone").val();



        if (otp.length !== 6) {

            Toast.fire({

                icon: 'error',

                title: 'Please enter all 6 digits of the OTP'

            });

            return;

        }



        Swal.fire({

            title: 'Verifying OTP...',

            text: 'Please wait...',

            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });



        $.ajax({

            url: "{{ route('verify.login.otp') }}", // Your OTP verification route

            method: "POST",

            data: {

                otp: otp,

                phone: phone,

                name: name,

            },

            success: function(response) {

                if (response.success) {

                    Swal.close();

                    showToast('success', 'Login successfull!');

                    $('.otp__digit').val('');

                    $('#otpModal').modal('hide');

                    if (response.auth_token) {

                        localStorage.setItem("auth_token", response.auth_token);

                    }

                    setTimeout(function() {

                        if (response.redirect) {

                            window.location.reload();

                        }

                    }, 1000);

                }

            },

            error: function(xhr) {

                console.log(xhr);

                Swal.close();

                let errorMessage = "OTP verification failed!";

                if (xhr.responseJSON?.error) {

                    errorMessage = xhr.responseJSON.error;

                }

                showToast('error', errorMessage);

            }

        });

    });

</script>

{{-- Add to Wishlist --}}

<script>

    function updateWishlistCount() {

        $.get("{{ route('wishlist.count') }}", function(res) {

            if (res.count !== undefined && res.count > 0) {

                $('.product-wishlist-count')

                    .text(res.count)

                    .show();

            } else {

                $('.product-wishlist-count').hide();

            }

        });

    }

    $(document).on('click', '.add-to-wishlist', function(e) {

        Swal.fire({

            title: 'Adding product to wishlist...',

            allowOutsideClick: false,

            didOpen: () => {

                Swal.showLoading();

            }

        });

        e.preventDefault();

        let productId = $(this).data('id');

        let el = $(this);



        $.ajax({

            url: "{{ route('wishlist.toggle') }}",

            method: 'POST',

            data: {

                _token: '{{ csrf_token() }}',

                product_id: productId

            },

            beforeSend: function() {

                el.find('i').addClass('fa-spin'); // loader effect

            },

            success: function(res) {

                Swal.close();

                el.find('i').removeClass('fa-spin');

                Swal.fire({

                    icon: res.status === 'added' ? 'success' : 'warning',

                    title: res.message,

                    toast: true,

                    timer: 2000,

                    position: 'top-end',

                    showConfirmButton: false,

                });

                updateWishlistCount();

            },

            error: function(xhr) {

                Swal.close();

                el.find('i').removeClass('fa-spin');

                Swal.fire({

                    icon: 'error',

                    title: 'Something went wrong!',

                    toast: true,

                    timer: 2000,

                    position: 'top-end',

                    showConfirmButton: false,

                });

            }

        });

    });



    updateWishlistCount();



    $(document).ready(function() {

        $(document).on('click','.wishlist-link', function(e) {

            e.preventDefault(); // prevent default navigation



            if (isLoggedIn) {

                window.location.href = "{{ route('wishlist') }}";

            } else {

                $('#popup-banner').modal('show'); // show login modal

            }

        });

    });

</script>



<script>

    $(window).on('load', function() {

        if (!isLoggedIn && !localStorage.getItem('popupShown')) {

            setTimeout(function() {

                $("#popup-banner").modal("show");

                localStorage.setItem('popupShown', 'true');

            }, 3000);

        }

    });



    $(document).on('click', '.user-login-trigger', function() {

        if (!isLoggedIn) {

            $('#popup-banner').modal('show');

        } else {

            // Optional: redirect to profile or dashboard

            window.location.href = "{{ route('user.dashboard') }}";

        }

    });

    var userRole        = "{{ auth()->check() ? auth()->user()->role : '' }}";
    var corporateId     = "{{ auth()->check() ? auth()->user()->corporate_id : '' }}";

     $(document).on('click', '.require-corporate-login', function(e) {
        e.preventDefault();

        let targetUrl = $(this).attr('href');

        // If user not logged in → show login popup
        if (!isLoggedIn) {
            $('#popup-banner').modal('show');
            sessionStorage.setItem('afterLoginRedirect', targetUrl);
            sessionStorage.setItem('loginTriggeredFromCorporate', "1");
            return;
        }

        // If logged in but NOT corporate user
        if (userRole != 1 || !corporateId) {
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'This section requires a corporate user account.',
            });
            return;
        }

        // Corporate user → continue
        window.location.href = targetUrl;
    });


    // ✅ Only handle redirect if login was triggered from corporate click
    let redirectUrl = sessionStorage.getItem('afterLoginRedirect');
    let fromCorporate = sessionStorage.getItem('loginTriggeredFromCorporate');

    if (redirectUrl && fromCorporate) {
        sessionStorage.removeItem('afterLoginRedirect');
        sessionStorage.removeItem('loginTriggeredFromCorporate');

        if (userRole == 1 && corporateId) {
            window.location.href = redirectUrl;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Access Restricted',
                text: 'Login successful, but this section is for corporate users only.',
            });
        }
    }

    $(document).on('click', '.user-trackmyorder-trigger', function() {

        if (!isLoggedIn) {

            $('#popup-banner').modal('show');

        } else {

            // Optional: redirect to profile or dashboard

            window.location.href = "{{route('track_order')}}";

        }

    });

</script>

<script>

    function dataURLtoBlob(dataurl) {

        const arr = dataurl.split(',');

        const mime = arr[0].match(/:(.*?);/)[1];

        const bstr = atob(arr[1]);

        let n = bstr.length;

        const u8arr = new Uint8Array(n);



        while (n--) {

            u8arr[n] = bstr.charCodeAt(n);

        }



        return new Blob([u8arr], {

            type: mime

        });

    }

</script>

@yield('js')

