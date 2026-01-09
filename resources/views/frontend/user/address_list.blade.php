@extends('frontend.includes.dashboard_layout')
@section('css')
@endsection
@section('dash_content')
    <div class="user-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="user-card">
                    <div class="user-card-header">
                        <h4 class="user-card-title">Address List</h4>
                        <div class="user-card-header-right">
                            <a href="javascript:void(0);" class="theme-btn" id="addBtn"><span
                                    class="far fa-plus-circle"></span>Add Address</a>
                        </div>
                    </div>
                    <div class="table-responsive">
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

    {{-- Add Modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Add New Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-form">
                        <form action="javascript:void(0);" id="addAddressForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control"
                                            placeholder="Type address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" placeholder="State">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control" placeholder="country">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PIN/Postal Code</label>
                                        <input type="tel" name="pin" class="form-control" placeholder="Pin code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Google Map Location (Optional)</label>
                                        <input type="text" name="google_map_location" class="form-control"
                                            placeholder="Paste google map location link.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address Type</label>
                                        <select name="type" class="form-select">
                                            <option value="">--select--</option>
                                            <option value="1">Home</option>
                                            <option value="2">Work</option>
                                            <option value="3">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="theme-btn"><span class="far fa-save"></span> Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Edit Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-form">
                        <form action="javascript:void(0);" id="updateAddressForm">
                            @csrf
                            <input type="hidden" name="edit_id" id="edit_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" id="edit_address" class="form-control"
                                            placeholder="Type address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" id="edit_city" class="form-control"
                                            placeholder="City">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" id="edit_state" class="form-control"
                                            placeholder="State">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="country" id="edit_country" class="form-control"
                                            placeholder="country">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PIN/Postal Code</label>
                                        <input type="tel" name="pin" id="edit_pin" class="form-control"
                                            placeholder="Pin code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Google Map Location (Optional)</label>
                                        <input type="text" name="google_map_location" id="edit_google_map_location"
                                            class="form-control" placeholder="Paste google map location link.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address Type</label>
                                        <select name="type" class="form-select" id="edit_type">
                                            <option value="">--select--</option>
                                            <option value="1">Home</option>
                                            <option value="2">Work</option>
                                            <option value="3">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="theme-btn"><span class="far fa-save"></span> Update
                                Address</button>
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

        $('#addAddressForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error highlights
            $('#addAddressForm .is-invalid').removeClass('is-invalid');

            const form = $(this);
            let isValid = true;

            const showError = (selector) => {
                $(selector).addClass('is-invalid');
                isValid = false;
            };

            // Validate required fields
            const address = $('input[name="address"]').val().trim();
            const city = $('input[name="city"]').val().trim();
            const state = $('input[name="state"]').val().trim();
            const country = $('input[name="country"]').val().trim();
            const type = $('select[name="type"]').val().trim();
            const pin = $('input[name="pin"]').val().trim();

            if (!address) showError('input[name="address"]');
            if (!city) showError('input[name="city"]');
            if (!state) showError('input[name="state"]');
            if (!country) showError('input[name="country"]');
            if (!type) showError('select[name="type"]');
            if (!pin) showError('input[name="pin"]');

            if (!isValid) {
                showToast('error', 'Please fill in all required fields.');
                return;
            }

            Swal.fire({
                title: 'Saving Address...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ route('addresses.store') }}", // update to your actual route name
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.close();
                    showToast('success', response.message || 'Address saved successfully!');
                    form[0].reset();
                    fetchAddresses();
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

        // Edit Address
        $(document).on('click', '.edit-address', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_address').val($(this).data('address'));
            $('#edit_city').val($(this).data('city'));
            $('#edit_state').val($(this).data('state'));
            $('#edit_country').val($(this).data('country'));
            $('#edit_pin').val($(this).data('pin'));
            $('#edit_google_map_location').val($(this).data('google_map_location'));
            $('#edit_type').val($(this).data('type'));
            $('#editModal').modal('show');
        });

        // Update Address
        $('#updateAddressForm').on('submit', function(e) {
            e.preventDefault();
            $('#updateAddressForm .is-invalid').removeClass('is-invalid');
            let form = $(this);
            let isValid = true;

            const fields = ['edit_address', 'edit_city', 'edit_state', 'edit_country', 'edit_pin', 'edit_type'];
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

            const addressId = $('#edit_id').val();
            const updateUrl = `/user/addresses/${addressId}/update`;

            Swal.fire({
                title: 'Updating address...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            $.ajax({
                url: updateUrl,
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    Swal.close();
                    showToast('success', response.message || 'Address updated successfully!');
                    $('#updateAddressForm')[0].reset();
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

        $(document).on('click', '.delete-address', function() {
            const addressId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This address will be deleted permanently.",
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
                            id: addressId
                        },
                        success: function(response) {
                            showToast('success', response.message ||
                                'Address deleted successfully!');
                            fetchAddresses(); // Refresh address list
                        },
                        error: function(xhr) {
                            let message = xhr.responseJSON?.message ||
                                'An error occurred while deleting.';
                            showToast('error', message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
