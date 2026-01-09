@extends('frontend.includes.dashboard_layout')
@section('css')

@endsection
@section('dash_content')
@php
$authUser = auth()->user();
$authDetail = $authUser->user_details;
$authMedicalInformation = $authUser->medical_information;
@endphp
<div class="user-wrapper ">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button fw-bold text-primary shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Profile Info
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="user-form">
                        <form action="javascript:void(0);" id="profileForm">
                            @csrf
                            <input type="hidden" name="id" value="{{$authUser->id}}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="profile_name">Full Name</label>
                                        <input type="text" name="name" id="profile_name" class="form-control"
                                            placeholder="Enter full name" value="{{$authUser->name}}" autocomplete="true">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="profile_email">Email</label>
                                        <input type="text" name="email" id="profile_email" class="form-control"
                                            value="{{$authUser->email}}" placeholder="Email" autocomplete="true">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="profile_phone">Phone</label>
                                        <input type="tel" name="phone" id="profile_phone" class="form-control"
                                            value="{{$authUser->phone}}" placeholder="Phone" autocomplete="true">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_of_birth">Date of Birth</label>
                                        <input class="form-control" id="date_of_birth" name="date_of_birth" value="{{$authUser->date_of_birth}}" type="date">
                                        <input type="hidden" name="age" id="age">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="gender">Gender</label>
                                        <br>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" id="male" type="radio" name="gender" value="Male" {{$authUser->gender == 'Male' ? 'checked' :  ''}}>
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" id="female" type="radio" name="gender" value="Female" {{$authUser->gender == 'Female' ? 'checked' :  ''}}>
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" id="other" type="radio" name="gender" value="Other" {{$authUser->gender == 'Other' ? 'checked' :  ''}}>
                                            <label class="form-check-label" for="other">Other</label>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood_group" class="form-select">
                                            <option value="">--select--</option>
                                            <option value="A+" {{$authUser->blood_group == 'A+' ? 'selected' :  ''}}>A+</option>
                                            <option value="A-" {{$authUser->blood_group == 'A-' ? 'selected' :  ''}}>A-</option>
                                            <option value="B+" {{$authUser->blood_group == 'B+' ? 'selected' :  ''}}>B+</option>
                                            <option value="B-" {{$authUser->blood_group == 'B-' ? 'selected' :  ''}}>B-</option>
                                            <option value="AB+" {{$authUser->blood_group == 'AB+' ? 'selected' :  ''}}>AB+</option>
                                            <option value="AB-" {{$authUser->blood_group == 'AB-' ? 'selected' :  ''}}>AB-</option>
                                            <option value="O+" {{$authUser->blood_group == 'O+' ? 'selected' :  ''}}>O+</option>
                                            <option value="O-" {{$authUser->blood_group == 'O-' ? 'selected' :  ''}}>O-</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="alternate_phone">Alternate Phone</label>
                                        <input class="form-control" id="alternate_phone" name="alternate_phone" type="number" placeholder="Enter alternate phone number" value="{{$authDetail->alternate_phone ?? ''}}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="profile_emergency_contact_name">Emergency Contact
                                            Name</label>
                                        <input class="form-control" id="profile_emergency_contact_name" name="emergency_contact_name" type="text" placeholder="Enter emergency contact name" value="{{$authDetail->emergency_contact_name ?? ''}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="emergency_contact_phone">Emergency Contact
                                            Phone</label>
                                        <input class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" type="number" placeholder="Enter emergency contact phone number" value="{{$authDetail->emergency_contact_phone ?? ''}}">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="theme-btn btn btn-sm"><span class="far fa-user"></span> Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed shadow-none text-primary fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Primary Address
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="user-form">
                        <form action="javascript:void(0);" id="addressForm">
                            @csrf
                            <input type="hidden" name="id" value="{{$authUser->id}}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="profile_address">Address</label>
                                        <input type="text" name="address" id="profile_address" class="form-control"
                                            placeholder="Enter address" value="{{$authDetail->address ?? ''}}" autocomplete="true">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="profile_city">City</label>
                                        <input type="text" name="city" id="profile_city" class="form-control"
                                            value="{{$authDetail->city ?? ''}}" placeholder="Enter city" autocomplete="true">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="profile_state">State</label>
                                        <input type="text" name="state" id="profile_state" class="form-control"
                                            value="{{$authDetail->state ?? ''}}" placeholder="Enter state" autocomplete="true">
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="profile_country">Country</label>
                                        <input type="text" class="form-control" id="profile_country" name="country" value="{{$authDetail->country ?? ''}}" placeholder="Enter Country">
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="profile_pin">Pin / Postal code</label>
                                        <input class="form-control" id="profile_pin" name="pin" type="text" placeholder="Enter pin/postal code" value="{{$authDetail->pin ?? ''}}">
                                    </div>
                                </div>

                                <div class=" col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="profile_google_map_location">Google Map Location
                                            (optional)</label>
                                        <input class="form-control" id="profile_google_map_location" name="google_map_location" type="text" placeholder="Enter google map location" value="{{$authDetail->google_map_location ?? ''}}">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="theme-btn btn btn-sm"><span class="far fa-user"></span> Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item mb-2">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed shadow-none text-primary fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Medical Information
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="user-form">
                        <form action="javascript:void(0);" id="medicalInformationForm">
                            @csrf
                            <input type="hidden" name="id" value="{{$authUser->id}}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="medical_conditon">Existing Medical
                                            Conditions </label>
                                        @php
                                        $medicalOptions = [
                                        'Diabetes', 'Hypertension', 'Asthma', 'Heart Disease', 'Thyroid Disorder',
                                        'Arthritis', 'Epilepsy', 'Chronic Kidney Disease', 'Liver Disease', 'Cancer',
                                        'Tuberculosis', 'Anemia', 'Migraines', 'HIV/AIDS'
                                        ];
                                        $selectedConditions = json_decode($authMedicalInformation->medical_condition ?? '[]', true);
                                        @endphp

                                        <select name="medical_condition[]" id="medical_conditon"
                                            class="form-select multi-select" multiple="multiple"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">--select--</option>
                                            @foreach ($medicalOptions as $option)
                                            <option value="{{ $option }}" {{ in_array($option, $selectedConditions) ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="allergies">Allergies (if any)</label>
                                        @php
                                        $selectedAllergies = json_decode($authMedicalInformation->allergies ?? '[]', true);
                                        $allergyOptions = [
                                        'Peanuts', 'Tree Nuts', 'Shellfish', 'Milk', 'Eggs', 'Wheat', 'Soy', 'Pollen',
                                        'Dust Mites', 'Pet Dander', 'Insect Stings', 'Latex', 'Mold'
                                        ];
                                        @endphp

                                        <select name="allergies[]" id="allergies"
                                            class="form-select multi-select" multiple="multiple"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">--select--</option>
                                            @foreach ($allergyOptions as $option)
                                            <option value="{{ $option }}" {{ in_array($option, $selectedAllergies) ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="current_medications">Current
                                            Medications</label>
                                        <textarea name="current_medications" id="current_medications" rows="5" class="form-control"
                                            placeholder="Enter current medications">{{$authMedicalInformation->current_medications ?? ''}}</textarea>
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="family_doctor_name_contact">Family Doctor
                                            Name & Contact (Optional) </label>
                                        <input class="form-control" id="family_doctor_name_contact"
                                            name="family_doctor_name_contact" type="text"
                                            placeholder="Enter family doctor name & contact" value="{{$authMedicalInformation->family_doctor_name_contact ?? ''}}" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="theme-btn btn btn-sm"><span class="far fa-user"></span> Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    // Age Calculator
    $('#date_of_birth').on('change', function() {
        var dob = new Date($(this).val());
        var today = new Date();

        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        $('#age').val(age >= 0 ? age : '');
    });

    $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error highlights
        $('#profileForm .is-invalid').removeClass('is-invalid');

        let isValid = true;
        const form = $(this);

        const showError = (selector, message) => {
        $(selector).addClass('is-invalid');
            $(selector).next('.invalid-feedback').text(message);
            isValid = false;
        };

        // Validate required fields
        const name = $('#profile_name').val().trim();
        if (!name) showError('#profile_name','Full Name is required');

        // Email
        const email = $('#profile_email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showError('#profile_email', 'Email is required');
        } else if (!emailRegex.test(email)) {
            showError('#profile_email', 'Enter a valid email address');
        }

         // Phone
        const phone = $('#profile_phone').val().trim();
        if (!phone) {
            showError('#profile_phone', 'Phone number is required');
        } else if (phone.length < 10) {
            showError('#profile_phone', 'Phone number must be at least 10 digits');
        }


        // Date of Birth
        const dob = $('#date_of_birth').val();
        if (!dob) {
            showError('#date_of_birth', 'Date of birth is required');
        } else {
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;

            if (age < 0 || age > 150 || isNaN(age)) {
                showError('#date_of_birth', 'Please enter a valid date of birth');
            } else {
                $('#age').val(age);
            }
        }

        // Gender
        const gender = $('input[name="gender"]:checked').val();
        if (!gender) {
            $('input[name="gender"]').addClass('is-invalid');
            $('#gender-error').text('Please select gender');
            isValid = false;
        }

        // Blood Group
        const bloodGroup = $('#blood_group').val();
        if (!bloodGroup) showError('#blood_group', 'Blood group is required');


        // Alternate Phone
        // const altPhone = $('#alternate_phone').val().trim();
        // if (!altPhone) {
        //     showError('#alternate_phone', 'Alternate phone is required');
        // } else if (altPhone.length < 10) {
        //     showError('#alternate_phone', 'Alternate phone must be at least 10 digits');
        // }

        if (!isValid) return;


        // Proceed with AJAX if valid
        Swal.fire({
            title: 'Saving changes...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('user.profile.update') }}",
            method: "POST",
            data: form.serialize(),
            success: function(response) {
                Swal.close();
                showToast('success', response.message || 'Your profile has been updated successfully!');
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Something went wrong!';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    errorMsg = firstError;
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showToast('error', errorMsg);
            }
        });
    });

    $('#addressForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error highlights
        $('#addressForm .is-invalid').removeClass('is-invalid');

        let isValid = true;
        const form = $(this);

        const showFieldError = (selector) => {
            $(selector).addClass('is-invalid');
            isValid = false;
        };

        // Address
        const address = $('#profile_address').val().trim();
        if (!address) showFieldError('#profile_address');

        // City
        const city = $('#profile_city').val().trim();
        if (!city) showFieldError('#profile_city');

        // State
        const state = $('#profile_state').val().trim();
        if (!state) showFieldError('#profile_state');

        // Country
        const country = $('#profile_country').val().trim();
        if (!country) showFieldError('#profile_country');

        // Pin Code
        const pin = $('#profile_pin').val().trim();
        const pinRegex = /^[0-9]{4,10}$/;
        if (!pin || !pinRegex.test(pin)) showFieldError('#profile_pin');

        // Google Map Location (optional)
        const mapLocation = $('#profile_google_map_location').val().trim();
        if (mapLocation.length > 255) showFieldError('#profile_google_map_location');

        if (!isValid) {
            showToast('error', 'Please correct the highlighted fields before submitting.');
            return;
        }

        // Proceed with AJAX if valid
        Swal.fire({
            title: 'Saving changes...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('user.primaryaddress.update') }}", // Update this route if needed
            method: "POST",
            data: form.serialize(),
            success: function(response) {
                Swal.close();
                showToast('success', response.message || 'Primary address has been updated successfully!');
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Something went wrong!';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    errorMsg = firstError;
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showToast('error', errorMsg);
            }
        });
    });

    $('#medicalInformationForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous error highlights
        $('#medicalInformationForm .is-invalid').removeClass('is-invalid');

        let isValid = true;
        const showFieldError = (selector) => {
            $(selector).addClass('is-invalid');
            isValid = false;
        };

        // Medical Condition (at least one required)
        const medicalCondition = $('#medical_conditon').val();
        if (!medicalCondition || medicalCondition.length === 0) {
            showFieldError('#medical_conditon');
        }

        // Allergies (optional, skip validation unless length > 0)
        const allergies = $('#allergies').val();

        // Current Medications (optional but max 1000 chars)
        const currentMeds = $('#current_medications').val().trim();
        if (currentMeds.length > 1000) showFieldError('#current_medications');

        // Family Doctor Contact (optional but max 255 chars)
        const doctorContact = $('#family_doctor_name_contact').val().trim();
        if (doctorContact.length > 255) showFieldError('#family_doctor_name_contact');

        if (!isValid) {
            showToast('error', 'Please correct the highlighted fields before submitting.');
            return;
        }

        // Show loader and submit
        Swal.fire({
            title: 'Saving changes...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('user.medicalinformation.update') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.close();
                showToast('success', response.message || 'Medical info updated successfully!');
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Something went wrong!';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                    errorMsg = firstError;
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg
                });
                showToast('error', errorMsg);
            }
        });
    });


    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        $('#changePasswordForm .is-invalid').removeClass('is-invalid');
        $('#changePasswordForm .invalid-feedback').remove();

        let oldPassword = $('#old-password').val().trim();
        let newPassword = $('#new-password').val().trim();
        let retypePassword = $('#retype-password').val().trim();
        let isValid = true;

        if (!oldPassword) {
            markInvalid('#old-password', 'Old password is required.');
            isValid = false;
        }

        if (!newPassword || newPassword.length < 6) {
            markInvalid('#new-password', 'New password must be at least 6 characters.');
            isValid = false;
        }

        if (newPassword !== retypePassword) {
            markInvalid('#retype-password', 'Passwords do not match.');
            isValid = false;
        }

        if (!isValid) {
            showToast('error', 'Please fix the highlighted errors before submitting.');
            return;
        }

        Swal.fire({
            title: 'Updating password...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('user.password.change') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.close();
                $('#changePasswordForm')[0].reset();
                showToast('success', response.message || 'Password updated successfully!');
            },
            error: function(xhr) {
                Swal.close();
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        const inputId = key.replace(/_/g, '-'); // match field ids like old_password -> old-password
                        markInvalid(`#${inputId}`, errors[key][0]);
                    });
                    showToast('error', 'Please fix the highlighted errors.');
                } else {
                    let message = xhr.responseJSON?.message || 'Something went wrong.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                    showToast('error', message);
                }
            }
        });

        function markInvalid(selector, message) {
            const input = $(selector);
            input.addClass('is-invalid');
            if (input.next('.invalid-feedback').length === 0) {
                input.after(`<div class="invalid-feedback">${message}</div>`);
            }
        }
    });
</script>
<script>
    // Update Profile Image
    $(document).ready(function() {

        $('#profile-image').on('change', function() {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('profile_image', file);
            formData.append('_token', '{{ csrf_token() }}'); // Include CSRF token manually

            Swal.fire({
                title: 'Uploading...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "{{ route('user.profile.image.upload') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();
                    showToast('success', res.message || 'Profile image updated!');
                    if (res.image_url) {
                        $('#currentProfileImage').attr('src', res.image_url);
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let message = xhr.responseJSON?.message || 'Something went wrong.';
                    showToast('error', message);
                }
            });
        });
    });
</script>

@endsection
