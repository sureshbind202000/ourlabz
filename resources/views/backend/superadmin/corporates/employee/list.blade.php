@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">All Employees</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3"
                data-list='{"valueNames":["userid","name","phone","email"],"page":10,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group"><input class="form-control form-control-sm shadow-none search"
                                    type="search" placeholder="Search..." aria-label="search" />
                                <div class="input-group-text bg-transparent"><span
                                        class="fa fa-search fs-10 text-600"></span></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto ms-auto">
                        <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i
                                class="fa-solid fa-plus"></i> Add</button>
                        <button class="btn btn-sm btn-falcon-secondary mb-1" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fa fa-file-import"></i> Import
                        </button>

                    </div>
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900">S.No.</th>
                                <th class="text-900" data-sort="userid">Corporate ID</th>
                                <th class="text-900" data-sort="name">User Name</th>
                                <th class="text-900" data-sort="phone">Phone</th>
                                <th class="text-900" data-sort="email">Email</th>
                                <th class="text-900" data-sort="wallet">Wallet</th>
                                <th class="text-900" data-sort="date">Date</th>
                                <th class="text-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list">

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1"
                        type="button" title="Previous" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button"
                        title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Add Employee Modal Start -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="addModal-modal-label">Add Employee</h4>
                    <p class="fs-10 mb-0 text-white">Fill the form to create new employee.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <form id="register-form">
                    <div class="form-group mb-2">
                        <label for="login-name">Full Name</label>
                        <input type="text" class="form-control" id="login-name" name="name" placeholder="Enter your full name.">
                    </div>
                    <div class="form-group mb-2">
                        <label for="login-email">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email.">
                    </div>
                    <div class="form-group">
                        <label for="login-phone">Phone Number</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-end-0">+91</span>
                            </div>
                            <input type="number" class="form-control" id="login-phone" name="phone" placeholder="xxx xxx xxxx">
                        </div>
                        <!-- Moved outside input-group -->
                        <small class="text-danger error-text" id="phone-error"></small>
                    </div>

                    @php
                    $corpUser = App\Models\User::find(auth()->user()->id);
                    $corp_id = $corpUser->user_id ?? null;
                    $corporate_id = $corpUser->id ?? null;
                    @endphp

                    <input type="hidden" name="corp_id" id="corp_id" value="{{ $corp_id }}">
                    <input type="hidden" name="corporate_id" id="corporate_id" value="{{ $corporate_id }}">

                    <div class="form-group form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="terms-check" name="terms">
                        <label class="form-check-label" for="terms-check">
                            I agree to the <a href="#" target="_blank">Terms & Conditions</a>
                        </label>
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary bg-gradient px-5">
                            <i class="fa fa-sign-in"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Employee Modal End -->
<!-- Edit Employee Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
    aria-hidden="true">
    <div class="modal-dialog mt-6 modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Employee</h4>
                    <p class="fs-10 mb-0 text-white">Update employee details.</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body  px-4 pb-4">
                <div class="theme-wizard">
                    <form class="row" id="updateUser" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">

                                <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                        href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-1"></i></span></span>
                                        <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"
                                        data-bs-toggle="tab" data-wizard-step="2"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-2"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3"
                                        data-bs-toggle="tab" data-wizard-step="3"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-3"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4"
                                        data-bs-toggle="tab" data-wizard-step="4"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-4"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Medical Information</span></a>
                                </li>

                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                        data-bs-toggle="tab" data-wizard-step="5"><span
                                            class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                    class="fa-solid fa-5"></i></span></span><span
                                            class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                </li>

                            </ul>
                        </div>
                        <div class="py-4">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1"
                                    data-wizard-form="1">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_name">Full Name</label>
                                            <input class="form-control" id="edit_name" name="name" type="text"
                                                placeholder="Enter name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="gender">Gender</label>
                                            <br>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_male" type="radio"
                                                    name="gender" value="Male" />
                                                <label class="form-check-label" for="edit_male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_female" type="radio"
                                                    name="gender" value="Female" />
                                                <label class="form-check-label" for="edit_female">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" id="edit_other" type="radio"
                                                    name="gender" value="Female" />
                                                <label class="form-check-label" for="edit_other">Other</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_date_of_birth">Date of Birth</label>
                                            <input class="form-control" id="edit_date_of_birth" name="date_of_birth"
                                                type="date" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_age">Age</label>
                                            <input class="form-control" id="edit_age" name="age" type="number"
                                                placeholder="Auto-calculated based on DOB" readonly />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_blood_group">Blood Group</label>
                                            <select name="blood_group" id="edit_blood_group" class="form-select">
                                                <option value="">--select--</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label">Upload Image (optional)</label>
                                            <input class="form-control" id="edit_profile" name="profile"
                                                type="file" />
                                            <br>
                                            <img src="" alt="" id="PreviewProfile" height="100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                    data-wizard-form="2">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_phone">Phone</label>
                                            <input class="form-control" id="edit_phone" name="phone"
                                                type="number" placeholder="Enter phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_alternate_phone">Alternate
                                                Phone</label>
                                            <input class="form-control" id="edit_alternate_phone"
                                                name="alternate_phone" type="number"
                                                placeholder="Enter alternate phone number" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_email">Email (Optional)</label>
                                            <input class="form-control" id="edit_email" name="email"
                                                type="text" placeholder="Enter email" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_name">Emergency
                                                Contact
                                                Name</label>
                                            <input class="form-control" id="edit_emergency_contact_name"
                                                name="emergency_contact_name" type="text"
                                                placeholder="Enter emergency contact name" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_emergency_contact_phone">Emergency
                                                Contact
                                                Phone</label>
                                            <input class="form-control" id="edit_emergency_contact_phone"
                                                name="emergency_contact_phone" type="number"
                                                placeholder="Enter emergency contact phone number" />
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                    data-wizard-form="3">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_address">Street Address</label>
                                            <input class="form-control" id="edit_address" name="address"
                                                type="text" placeholder="Enter address" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_city">City</label>
                                            <input class="form-control" id="edit_city" name="city" type="text"
                                                placeholder="Enter city" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_state">State</label>
                                            <input class="form-control" id="edit_state" name="state"
                                                type="text" placeholder="Enter state" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_country">Country</label>
                                            <input class="form-control" id="edit_country" name="country"
                                                type="text" placeholder="Enter country" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_pin">Pin/Postal code</label>
                                            <input class="form-control" id="edit_pin" name="pin" type="text"
                                                placeholder="Enter pin/postal code" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_google_map_location">Google Map
                                                Location
                                                (optional)</label>
                                            <input class="form-control" id="edit_google_map_location"
                                                name="google_map_location" type="text"
                                                placeholder="Enter google map location" />
                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4"
                                    data-wizard-form="4">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_medical_condition">Existing Medical
                                                Conditions </label>
                                            <select name="medical_condition[]" id="edit_medical_condition"
                                                class="form-select" multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="Diabetes">Diabetes</option>
                                                <option value="Hypertension">Hypertension</option>
                                                <option value="Asthma">Asthma</option>
                                                <option value="Heart Disease">Heart Disease</option>
                                                <option value="Thyroid Disorder">Thyroid Disorder</option>
                                                <option value="Arthritis">Arthritis</option>
                                                <option value="Epilepsy">Epilepsy</option>
                                                <option value="Chronic Kidney Disease">Chronic Kidney Disease</option>
                                                <option value="Liver Disease">Liver Disease</option>
                                                <option value="Cancer">Cancer</option>
                                                <option value="Tuberculosis">Tuberculosis</option>
                                                <option value="Anemia">Anemia</option>
                                                <option value="Migraines">Migraines</option>
                                                <option value="HIV/AIDS">HIV/AIDS</option>

                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_allergies">Allergies (if any)</label>
                                            <select name="allergies[]" id="edit_allergies" class="form-select"
                                                multiple="multiple" size="1"
                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="">--select--</option>
                                                <option value="Peanuts">Peanuts</option>
                                                <option value="Tree Nuts">Tree Nuts</option>
                                                <option value="Shellfish">Shellfish</option>
                                                <option value="Milk">Milk</option>
                                                <option value="Eggs">Eggs</option>
                                                <option value="Wheat">Wheat</option>
                                                <option value="Soy">Soy</option>
                                                <option value="Pollen">Pollen</option>
                                                <option value="Dust Mites">Dust Mites</option>
                                                <option value="Pet Dander">Pet Dander</option>
                                                <option value="Insect Stings">Insect Stings</option>
                                                <option value="Latex">Latex</option>
                                                <option value="Mold">Mold</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_current_medications">Current
                                                Medications</label>
                                            <textarea name="current_medications" id="edit_current_medications" rows="5" class="form-control"
                                                placeholder="Enter current medications"></textarea>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_family_doctor_name_contact">Family
                                                Doctor
                                                Name & Contact (Optional) </label>
                                            <input class="form-control" id="edit_family_doctor_name_contact"
                                                name="family_doctor_name_contact" type="text"
                                                placeholder="Enter family doctor name & contact" />
                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                    data-wizard-form="5">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_username">username</label>
                                            <input class="form-control" id="edit_username" name="username"
                                                type="text" placeholder="Enter username" />
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label class="form-label" for="edit_password">Password</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control w-75" type="password" name="password"
                                                    id="edit_password" placeholder="Type or generate password." />
                                                <button type="button"
                                                    class="btn btn-success edit-generate-password"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Click to generate random password.">
                                                    <i class="fa-solid fa-key"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" id="edit_terms_condition"
                                                    type="checkbox" value="" name="terms_condition" />
                                                <label class="form-check-label" for="edit_terms_condition">Consent
                                                    to Terms & Conditions</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="edit_subscribe"
                                                    type="checkbox" value="" name="subscribe" />
                                                <label class="form-check-label"
                                                    for="edit_subscribe">Subscribe to Notifications &
                                                    Updates? </label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-12 text-center">
                                            <button class="btn btn-primary bg-gradient px-5 "
                                                type="submit">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="display: block !important;">
                            <div class="px-sm-3 px-md-5">
                                <ul class="pager wizard list-inline mb-0">
                                    <li class="previous"><button class="btn btn-falcon-primary px-5 px-sm-6"
                                            type="button" style="display: block !important;"><span
                                                class="fas fa-chevron-left me-2"
                                                data-fa-transform="shrink-3"></span>Prev</button></li>
                                    <li class="next"><button class="btn btn-primary px-5 px-sm-6"
                                            type="button">Next<span class="fas fa-chevron-right ms-2"
                                                data-fa-transform="shrink-3"> </span></button></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Employee Modal End -->
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="importForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Upload CSV or Excel File</label>
                        <input type="file" class="form-control" name="file" id="importFile" accept=".csv, .xlsx, .xls" required>
                        <div class="form-text">Download sample file <a href="{{ asset('/backend/assets/sample_employees_import.xlsx') }}">here</a>.</div>
                    </div>

                    <div class="mb-3">
                        <label for="walletAmount" class="form-label">Wallet Amount for Each Employee</label>
                        <input type="number" class="form-control" name="wallet_amount" id="walletAmount" placeholder="Enter amount (e.g. 100)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        fetchEmployees();
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
        $('#edit_date_of_birth').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();

            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            $('#edit_age').val(age >= 0 ? age : '');
        });

        function generatePassword() {
            let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let password = "";
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }

        // Event to generate a password when the button is clicked
        $(".generate-password").on("click", function() {
            var newPassword = generatePassword();
            $("#password").val(newPassword);
            $("#password").attr("type", "text").focus();
        });

        // Toggle password visibility when input is focused
        $("#password").on("focus", function() {
            $(this).attr("type", "text");
        });

        // Revert back to password type when focus is lost
        $("#password").on("blur", function() {
            $(this).attr("type", "password");
        });

        $(".edit-generate-password").on("click", function() {
            var newPassword = generatePassword();
            $("#edit_password").val(newPassword);
            $("#edit_password").attr("type", "text").focus();
        });

        // Toggle password visibility when input is focused
        $("#edit_password").on("focus", function() {
            $(this).attr("type", "text");
        });

        // Revert back to password type when focus is lost
        $("#edit_password").on("blur", function() {
            $(this).attr("type", "password");
        });


        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        $('#addModalBtn').on('click', function() {
            $('#addModal').modal('show');
        });

        function fetchEmployees() {
            $.ajax({
                url: "{{ route('corporate.get.employeeList') }}",
                type: "GET",
                success: function(response) {
                    const tbody = $('.list');
                    tbody.empty();

                    if (response.success && response.data.length > 0) {
                        response.data.forEach((employee, index) => {
                            let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${employee.user_id ?? 'N/A'}</td>
                            <td>${employee.name ?? '-'}</td>
                            <td>${employee.phone ?? '-'}</td>
                            <td>${employee.email ?? '-'}</td>
                            <td>${employee.wallet ? new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(employee.wallet) : '-'}</td>
                            <td>${employee.created_at ? formatDate(employee.created_at) : '-'}</td>
                            <td>
                             <a class="btn btn-link p-0 " href="{{ url('/') }}/employee/${employee.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${employee.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                                           <button class="btn btn-link p-0 editbtn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${employee.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 deletebtn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${employee.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                             
                            </td>
                        </tr>
                    `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append('<tr><td colspan="7" class="text-center">No employees found.</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('#register-form').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages
            $('.error-text').text('');

            const name = $('#login-name').val();
            const phone = $('#login-phone').val();
            const email = $('#login-email').val();
            const corp_id = $('#corp_id').val();
            const corporate_id = $('#corporate_id').val();
            const terms = $('#terms-check').is(':checked');

            if (!terms) {
                $('#terms-error').text('Please accept the terms and conditions.');
                return;
            }

            $.ajax({
                url: "{{ route('corporate.employee.store') }}",
                type: 'POST',
                data: {
                    name: name,
                    phone: phone,
                    corp_id: corp_id,
                    corporate_id: corporate_id,
                    // terms_condition: terms ? 1 : 0,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#register-form')[0].reset();
                    $('#addModal').modal('hide');
                    fetchEmployees(); // refresh the list
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.phone) {
                            $('#phone-error').text(errors.phone[0]);
                        }
                        if (errors.name) {
                            $('#name-error').text(errors.name[0]);
                        }
                        if (errors.terms_condition) {
                            $('#terms-error').text(errors.terms_condition[0]);
                        }
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                }
            });
        });
        $(document).on('click', '.editbtn', function() {
            $('.loading').show();
            let userId = $(this).data('id');

            $.ajax({
                url: '/user/' + userId + '/edit',
                type: 'GET',
                success: function(response) {
                    let user = response.user;

                    // Basic user info
                    $('#edit_id').val(user.id);
                    $('#edit_name').val(user.name);
                    $('#edit_username').val(user.username);
                    $('#edit_phone').val(user.phone);
                    $('#edit_email').val(user.email);
                    $('#edit_date_of_birth').val(user.date_of_birth || '');
                    $('#edit_age').val(user.age || '');
                    $('#edit_blood_group').val(user.blood_group || '');
                    $('#edit_terms_condition').prop('checked', user.terms_condition == 1);
                    $('#edit_subscribe').prop('checked', user.subscribe == 1);
                    if (user.profile == 'dummy') {
                        $('#PreviewProfile').attr('src', '/backend/assets/img/team/avatar.png');
                    } else {
                        $('#PreviewProfile').attr('src', user.profile);
                    }

                    // Gender
                    $('input[name="gender"]').prop('checked', false);
                    if (user.gender == 'Male') {
                        $('#edit_male').prop('checked', true);
                    }
                    if (user.gender == 'Female') {
                        $('#edit_female').prop('checked', true);
                    }
                    if (user.gender == 'Other') {
                        $('#edit_other').prop('checked', true);
                    }
                    // User Details
                    if (user.user_details) {
                        let details = user.user_details;
                        $('#edit_address').val(details.address || '');
                        $('#edit_city').val(details.city || '');
                        $('#edit_state').val(details.state || '');
                        $('#edit_country').val(details.country || '');
                        $('#edit_pin').val(details.pin || '');
                        $('#edit_google_map_location').val(details.google_map_location ||
                            '');
                        $('#edit_alternate_phone').val(details.alternate_phone || '');
                        $('#edit_emergency_contact_name').val(details
                            .emergency_contact_name || '');
                        $('#edit_emergency_contact_phone').val(details
                            .emergency_contact_phone || '');
                    } else {
                        $('#edit_address, #edit_city, #edit_state, #edit_country, #edit_pin, #edit_google_map_location, #edit_alternate_phone, #edit_emergency_contact_name, #edit_emergency_contact_phone')
                            .val('');
                    }

                    // Medical Information
                    if (user.medical_information) {
                        initOrResetChoices('#edit_medical_condition',
                            'editMedicalCondition', user.medical_information
                            .medical_condition);
                        initOrResetChoices('#edit_allergies', 'editAllergies', user
                            .medical_information.allergies);
                        $('#edit_current_medications').val(user.medical_information
                            .current_medications || '');
                        $('#edit_family_doctor_name_contact').val(user.medical_information
                            .family_doctor_name_contact || '');
                    } else {
                        $('#edit_medical_condition, #edit_allergies, #edit_current_medications, #edit_family_doctor_name_contact')
                            .val('');
                    }

                    $('#editModal').modal('show');
                    $('.loading').hide();
                },
                error: function() {
                    $('.loading').hide();
                    alert('Something went wrong while fetching user data.');
                }
            });
        });
        // Update User AJAX
        $('#updateUser').submit(function(e) {
            e.preventDefault();
            $('.loading').show();

            var userId = $('#edit_id').val();
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                url: '/user/' + userId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#editModal').modal('hide');
                    Swal.fire("Success!", response.success, "success");
                    fetchEmployees();
                    $('.loading').hide();
                    window.location.reload();
                },
                error: function(xhr, error, status) {
                    console.log(xhr, error, status);
                    Swal.fire("Error!", "Something went wrong.", "error");
                    $('.loading').hide();
                }
            });
        });

        // Delete 
        $(document).on('click', '.deletebtn', function() {
            let empId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the user and all related data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.loading').show();

                    $.ajax({
                        url: `/user/${empId}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('.loading').hide();

                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The user and related data have been deleted.",
                                    "success");
                                fetchEmployees();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }
                        },
                        error: function(xhr) {
                            $('.loading').hide();
                            Swal.fire("Error!", "Failed to delete user.",
                                "error");
                        }
                    });
                }
            });
        });
        $('#importForm').on('submit', function(e) {
            e.preventDefault();
             Swal.fire({
                title: 'Please wait, We are cheking your wallet...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let formData = new FormData(this);

            $.ajax({
                url: '/corporate/import-employees',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.success) {
                        $('#importModal').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        fetchEmployees();
                    }
                },
                error: function(xhr, status, error) {
                    // console.log("Error : ", xhr, status, error);

                    // Try to extract a meaningful error message
                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            const parsed = JSON.parse(xhr.responseText);
                            if (parsed.message) {
                                errorMessage = parsed.message;
                            }
                        } catch (e) {
                            errorMessage = xhr.responseText;
                        }
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });


    });
</script>
@endsection