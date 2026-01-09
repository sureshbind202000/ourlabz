@extends('frontend.includes.dashboard_layout')
@section('css')

@endsection
@section('dash_content')

<div class="user-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="user-card">
                <div class="user-card-header">
                    <h4 class="user-card-title">Payment Methods</h4>
                    <div class="user-card-header-right">
                        <a href="javascript:void(0);" class="theme-btn" id="addBtn"><span class="far fa-plus-circle"></span>Add Payment</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless text-nowrap" id="paymentMethodTable">
                        <thead>
                            <tr>
                                <th>Card Info</th>
                                <th>Card Holder Name</th>
                                <th>Card Number</th>
                                <th>Expire Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="table-list-img w-25">
                                        <img class="rounded-3" src="assets/img/payment/amex.svg" alt="">
                                    </div>
                                </td>
                                <td><span class="table-list-code">Antoni Jonson</span></td>
                                <td>1234***********</td>
                                <td>10/2024</td>
                                <td>
                                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-2" data-tooltip="tooltip" title="Edit"><i class="far fa-pen"></i></a>
                                    <a href="#" class="btn btn-outline-danger btn-sm rounded-2" data-tooltip="tooltip" title="Delete"><i class="far fa-trash-can"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add New Payment Method</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="user-form">
                    <form action="javascript:void(0);" id="addMethodForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name On Card</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="tel" name="card_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Card Expiry</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" name="exp_month" class="form-control" placeholder="MM" maxlength="2" pattern="\d{2}" required style="width: 50%;">
                                        <input type="text" name="exp_year" class="form-control" placeholder="YY" maxlength="2" pattern="\d{2}" required style="width: 50%;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CVC</label>
                                    <input type="tel" name="cvv" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="theme-btn"><span class="far fa-save"></span> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Payment Method</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="user-form">
                    <form action="javascript:void(0);" id="updateMethodForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name On Card</label>
                                    <input type="text" name="name" id="edit_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="tel" name="card_no" id="edit_card_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Card Expiry</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" name="exp_month" id="edit_exp_month" class="form-control" placeholder="MM" maxlength="2" pattern="\d{2}" required style="width: 50%;">
                                        <input type="text" name="exp_year" id="edit_exp_year" class="form-control" placeholder="YY" maxlength="2" pattern="\d{2}" required style="width: 50%;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CVC</label>
                                    <input type="tel" name="cvv" id="edit_cvv" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="theme-btn"><span class="far fa-save"></span> Save</button>
                    </form>
                </div>
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
            $('#addModal').modal('show');
        });
        fetchMethods();
    });

    function fetchMethods() {
        $.ajax({
            url: "{{ route('user.payment_method.show') }}",
            method: "GET",
            success: function(response) {
                const tbody = $('#paymentMethodTable tbody');
                tbody.empty();

                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function(method) {
                        const maskedCard = method.card_no.slice(-4).padStart(method.card_no.length, '*');

                        tbody.append(`
                        <tr>
                            <td>Card</td>
                            <td>${method.name}</td>
                            <td>${maskedCard}</td>
                            <td>${String(method.exp_month).padStart(2, '0')}/${String(method.exp_year).padStart(2, '0')}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm rounded-2 edit-method"
                                   data-id="${method.id}"
                                   data-name="${method.name}"
                                   data-card_no="${method.card_no}"
                                   data-exp_month="${method.exp_month}"
                                   data-exp_year="${method.exp_year}"
                                   data-cvv="${method.cvv}"
                                   title="Edit">
                                   <i class="far fa-pen"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm rounded-2 delete-method"
                                   data-id="${method.id}"
                                   title="Delete">
                                   <i class="far fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    `);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center text-muted">No payment methods found.</td></tr>');
                }
            },
            error: function() {
                showToast('error', 'Failed to load payment methods.');
            }
        });
    }



    $('#addMethodForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error highlights
        $('#addMethodForm .is-invalid').removeClass('is-invalid');

        const form = $(this);
        let isValid = true;

        const showError = (selector) => {
            $(selector).addClass('is-invalid');
            isValid = false;
        };

        // Validate required fields
        const name = $('input[name="name"]').val();
        const card_no = $('input[name="card_no"]').val();
        const exp_month = $('input[name="exp_month"]').val();
        const exp_year = $('input[name="exp_year"]').val();
        const cvv = $('input[name="cvv"]').val();

        if (!name) showError('input[name="name"]');
        if (!card_no) showError('input[name="card_no"]');
        if (!exp_month) showError('input[name="exp_month"]');
        if (!exp_year) showError('input[name="exp_year"]');
        if (!cvv) showError('input[name="cvv"]');

        if (!isValid) {
            showToast('error', 'Please fill in all required fields.');
            return;
        }

        Swal.fire({
            title: 'Saving Method...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('user.payment_method.store') }}",
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                Swal.close();
                showToast('success', response.message || 'Payment method saved successfully!');
                form[0].reset();
                fetchMethods();
                $('#addModal').modal('hide');
            },
            error: function(xhr) {
                Swal.close();
                let message = 'Something went wrong.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    message = firstError;
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                showToast('error', message);
            }
        });
    });

    // Edit Method
    $(document).on('click', '.edit-method', function() {
        $('#edit_name').val($(this).data('name'));
        $('#edit_card_no').val($(this).data('card_no'));
        $('#edit_exp_month').val($(this).data('exp_month'));
        $('#edit_exp_year').val($(this).data('exp_year'));
        $('#edit_cvv').val($(this).data('cvv'));

        $('#editModal').modal('show');
    });

    // Update payment method
    $('#updateMethodForm').on('submit', function(e) {
        e.preventDefault();
        $('#updateMethodForm .is-invalid').removeClass('is-invalid');
        let form = $(this);
        let isValid = true;

        const fields = ['edit_name', 'edit_card_no', 'edit_exp_month', 'edit_exp_year', 'edit_cvv'];
        fields.forEach(field => {
            const value = $(`#${field}`).val().trim();
            if (!value) {
                $(`#${field}`).addClass('is-invalid');
                isValid = false;
            }
        });

        if (!isValid) {
            showToast('error', 'Please fill in all required fields.');
            return;
        }

        const updateUrl = "{{route('user.payment_method.update')}}";

        Swal.fire({
            title: 'Updating payment method...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        $.ajax({
            url: updateUrl,
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                Swal.close();
                showToast('success', response.message || 'Payment method updated successfully!');
                $('#updateMethodForm')[0].reset();
                $('#editModal').modal('hide');
                fetchAddresses();
            },
            error: function(xhr) {
                console.log(xhr);
                Swal.close();
                let message = 'Something went wrong.';
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    message = firstError;
                } else if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                showToast('error', message);
            }
        });
    });

    $(document).on('click', '.delete-method', function() {
        const methodId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This payment method will be deleted permanently.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('user.address.delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: methodId
                    },
                    success: function(response) {
                        showToast('success', response.message || 'Address deleted successfully!');
                        fetchAddresses(); // Refresh address list
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'An error occurred while deleting.';
                        showToast('error', message);
                    }
                });
            }
        });
    });
</script>
@endsection