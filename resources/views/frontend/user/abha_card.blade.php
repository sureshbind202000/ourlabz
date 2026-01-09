@extends('frontend.includes.dashboard_layout')

@section('css')

@endsection

@section('dash_content')

<div class="user-wrapper">

    <div class="row">

        <div class="col-lg-12">

            <div class="user-card">

                <div class="user-card-header">

                    <h4 class="user-card-title">ABHA card</h4>

                    <div class="user-card-header-right">

                        <a href="javascript:void(0);" class="theme-btn" id="addBtn"><span

                                class="far fa-plus-circle"></span>Link ABHA</a>

                    </div>

                </div>

                <div class="table-responsive d-none">

                    <table class="table table-borderless text-nowrap" id="addressTable">

                        <thead>

                            <tr>

                                <th>Type</th>

                                <th>Address</th>

                                <th>City</th>

                                <th>State</th>

                                <th>Pin</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <!-- Filled by jQuery -->

                        </tbody>

                    </table>

                </div>



            </div>

        </div>

    </div>

</div>

<!-- Link ABHA Modal -->
<div class="modal fade" id="linkAbhaModal" tabindex="-1" aria-labelledby="linkAbhaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkAbhaModalLabel">Link Your ABHA ID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="abhaResult"></div>

                <form id="linkAbhaForm">
                    @csrf
                    <div class="step1">
                        <label>Enter ABHA Number / Mobile</label>
                        <input type="text" id="abha_identifier" name="abha_identifier" class="form-control" placeholder="ABHA Number or Mobile" required>
                        <button type="submit" class="theme-btn mt-3 w-100">Send OTP</button>
                    </div>

                    <div class="step2 d-none">
                        <input type="hidden" id="txnId" name="txnId">
                        <label>Enter OTP</label>
                        <input type="text" id="abha_otp" name="abha_otp" class="form-control" placeholder="Enter OTP">
                        <button type="button" id="verifyOtpBtn" class="theme-btn mt-3 w-100">Verify OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {

        $(document).on('click', '#addBtn', function(e) {

            e.preventDefault();

            $('#linkAbhaModal').modal('show');

        });

        fetchAddresses();

    });



    function fetchAddresses() {

        $.ajax({

            url: "{{ route('user.addresses.show') }}",

            method: "GET",

            success: function(response) {

                const tbody = $('#addressTable tbody');

                tbody.empty();



                // Add primary address first

                if (response.primary && Object.keys(response.primary).length > 0) {

                    tbody.append(`

                    <tr>

                        <td><span class="badge bg-primary">Primary</span></td>

                        <td>${response.primary.address}</td>

                        <td>${response.primary.city}</td>

                        <td>${response.primary.state}</td>

                        <td>${response.primary.pin}</td>

                        <td>—</td>

                    </tr>

                `);

                }



                // Add other addresses

                response.addresses.forEach(function(addr) {

                    let badgeText = 'Other';

                    let badgeClass = 'bg-secondary';



                    switch (addr.type) {

                        case 1:

                            badgeText = 'Home';

                            badgeClass = 'bg-success';

                            break;

                        case 2:

                            badgeText = 'Work';

                            badgeClass = 'bg-info';

                            break;

                        case 3:

                            badgeText = 'Other';

                            badgeClass = 'bg-secondary';

                            break;

                    }

                    tbody.append(`

                    <tr>

                        <td><span class="badge ${badgeClass}">${badgeText}</span></td>

                        <td>${addr.address}</td>

                        <td>${addr.city}</td>

                        <td>${addr.state}</td>

                        <td>${addr.pin}</td>

                        <td>

                            <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm rounded-2 edit-address" data-id="${addr.id}" data-address="${addr.address}" data-city="${addr.city}" data-state="${addr.state}" data-country="${addr.country}" data-pin="${addr.pin}" data-google_map_location="${addr.google_map_location}" data-type="${addr.type}" title="Edit"><i class="far fa-pen"></i></a>

                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm rounded-2 delete-address" data-id="${addr.id}" title="Delete"><i class="far fa-trash-can"></i></a>

                        </td>

                    </tr>

                `);

                });

            },

            error: function() {

                showToast('error', 'Failed to load address list.');

            }

        });

    }
</script>

<script>
    $(document).ready(function() {

        // STEP 1: Send OTP
        $('#linkAbhaForm').on('submit', function(e) {
            e.preventDefault();

            let abhaIdentifier = $('#abha_identifier').val();

            // Detect if it's a mobile number or ABHA address (like abha@abdm)
            let data = {
                _token: '{{ csrf_token() }}'
            };
            if (/^\d{10}$/.test(abhaIdentifier)) {
                data.mobile = abhaIdentifier; // Mobile-based OTP
            } else {
                data.abha_number = abhaIdentifier; // ABHA-based OTP
            }

            $.ajax({
                url: "{{ route('abha.sendOtp') }}",
                type: "POST",
                data: data,
                beforeSend: function() {
                    $('#abhaResult').html('<div class="text-info">📤 Sending OTP...</div>');
                },
                success: function(response) {
                    if (response.success) {
                        $('#abhaResult').html('<div class="alert alert-success">✅ OTP sent successfully to your registered number.</div>');
                        $('#txnId').val(response.txnId);
                        $('.step1').addClass('d-none');
                        $('.step2').removeClass('d-none');
                    } else {
                        $('#abhaResult').html('<div class="alert alert-danger">❌ Failed to send OTP. Try again.</div>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    let message = '❌ Failed to send OTP. Please check your ABHA or mobile.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        message += `<br><small>${xhr.responseJSON.error.message || ''}</small>`;
                    }
                    $('#abhaResult').html(`<div class="alert alert-danger">${message}</div>`);
                }
            });
        });

        // STEP 2: Verify OTP
        $('#verifyOtpBtn').on('click', function() {
            let otp = $('#abha_otp').val();
            let txnId = $('#txnId').val();

            if (!otp || !txnId) {
                $('#abhaResult').html('<div class="alert alert-warning">⚠️ Please enter OTP.</div>');
                return;
            }

            $.ajax({
                url: "{{ route('abha.verifyOtp') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    otp: otp,
                    txnId: txnId
                },
                beforeSend: function() {
                    $('#abhaResult').html('<div class="text-info">🔍 Verifying OTP...</div>');
                },
                success: function(response) {
                    if (response.success) {
                        $('#abhaResult').html('<div class="alert alert-success">🎉 ABHA linked successfully!</div>');
                        $('.step2').addClass('d-none');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        $('#abhaResult').html('<div class="alert alert-danger">❌ Verification failed. Try again.</div>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    $('#abhaResult').html('<div class="alert alert-danger">❌ Invalid OTP. Please try again.</div>');
                }
            });
        });
    });
</script>



@endsection