@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Referring Labs</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <div id="tableExample3"
                    data-list='{"valueNames":["labid", "labname", "labtype","date","phone","status"],"page":10,"pagination":true}'>
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
                        @if (has_permission('refering', 'create'))
                        <div class="col-auto ms-auto">
                            <button class="btn btn-sm btn-falcon-primary me-1 mb-1" type="button" id="addModalBtn"><i
                                    class="fa-solid fa-plus"></i> Add</button>
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="labid">Lab ID</th>
                                    <th class="text-900" data-sort="labname">Name</th>
                                    <th class="text-900" data-sort="phone">Phone</th>
                                    <th class="text-900" data-sort="labtype">Facilities</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    <th class="text-900" data-sort="status">Status</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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

    <!-- Add Package Modal Start -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Refering Lab</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create refering lab.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="storeReferingLab" enctype="multipart/form-data">
                            @csrf
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Lab Details</span></a></li>
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
                                                class="d-none d-md-block mt-1 fs-10">Login & Admin Details</span></a>
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
                                                <label class="form-label" for="lab_name">Lab Name</label>
                                                <input class="form-control" id="lab_name" name="lab_name"
                                                    type="text" placeholder="Enter lab name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="lab_registration_no">Lab Registration No.
                                                    (Optional)</label>
                                                <input class="form-control" id="lab_registration_no"
                                                    name="lab_registration_no" type="text"
                                                    placeholder="Enter lab registration no." />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label for="lab_type">Lab Facilities</label>
                                                <select class="form-select js-choice" id="lab_type" multiple="multiple"
                                                    size="1" name="lab_type[]"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="" disabled>-- Select --</option>
                                                    @foreach ($facilities as $facility)
                                                        <option value="{{ $facility->facility }}">{{ $facility->facility }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label">Year Of Establishment</label>
                                                <input type="date" class="form-control" id="year_of_establishment"
                                                    name="year_of_establishment" />
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label class="form-label">Accreditation Details (Optional)</label>
                                                <input class="form-control" id="accreditation_details"
                                                    name="accreditation_details" type="file" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="primary_contact_name">Primary Contact
                                                    Name</label>
                                                <input class="form-control" id="primary_contact_name"
                                                    name="primary_contact_name" type="text"
                                                    placeholder="Enter primary contact name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="phone">Phone</label>
                                                <input class="form-control" id="phone" name="phone" type="number"
                                                    placeholder="Enter phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="text"
                                                    placeholder="Enter email" />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="website_url">Website URL (Optional)</label>
                                                <input class="form-control" id="website_url" name="website_url"
                                                    type="text" placeholder="Enter or paste website url" />
                                            </div>


                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3"
                                        data-wizard-form="3">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="name">Admin Name</label>
                                                <input class="form-control" id="name" name="name" type="text"
                                                    placeholder="Enter admin name" />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="username">Username</label>
                                                <input class="form-control" id="username" name="lab_username"
                                                    type="text" placeholder="Enter username" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="gender">Gender</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="male" type="radio"
                                                        name="gender" value="Male" />
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="female" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="other" type="radio"
                                                        name="gender" value="Female" />
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control w-75" type="password" name="password"
                                                        id="password" placeholder="Type or generate password." />
                                                    <button type="button" class="btn btn-success generate-password"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Click to generate random password.">
                                                        <i class="fa-solid fa-key"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 text-center">
                                                <button class="btn btn-primary bg-gradient px-5 " type="button"
                                                    id="submitBtn">Submit</button>
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
                                        <li class="next"><button class="btn btn-falcon-primary px-5 px-sm-6"
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
    <!-- Add Package Modal End -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {

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

            // Fetch
            fetchLabs();

            function fetchLabs() {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Loading referring labs...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "{{ route('refering_lab.list') }}",
                    type: "GET",
                    success: function(data) {
                        Swal.close();
                        let rows = "";
                        $.each(data, function(index, lab) {
                            let lab_logo = (lab.lab_logo === 'NULL') ?
                                "{{ asset('backend/assets/img/team/avatar.png') }}" :
                                "{{ asset('/') }}" + lab.lab_logo;
                            let lab_status = (lab.status == 0) ? 'Pending' : (lab.status == 1) ?
                                'Approved' : 'Declined';
                            let lab_status_badge = (lab.status == 0) ? 'bg-warning' : (lab
                                .status == 1) ? 'bg-success' : 'bg-danger';
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="labid">${lab.lab_id}</td>
                        <td class="labname">
                        <img class="rounded-circle shadow-sm me-1" src="${lab_logo}" alt="Lab Logo" style="height:26px;width:26px;"/>
                         ${lab.lab_name}
                        </td>
                        <td class="phone">${lab.phone}</td>
                        <td class="labtype">
                             ${JSON.parse(lab.lab_type || '[]').map(type => `<span class="badge btn-falcon-primary bg-gradient me-1">${type}</span>`).join('')}
                         </td>

                        <td class="date">${formatDate(lab.created_at)}</td>
                        <td class="status"><a href="javascript:void(0);" data-id="${lab.id}" class="badge ${lab_status_badge} change_lab_status">${lab_status}</a></td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['labid', 'labname', 'labtype', 'date', 'phone'],
                            page: 10,
                            pagination: true
                        });
                    },
                    error: function() {
                        Swal.close();
                        $("tbody.list").html('');
                    }
                });
            }

            // Store
            $(document).ready(function() {
                var validator = $("#storeReferingLab").validate({
                    ignore: [],
                    rules: {
                        lab_name: {
                            required: true,
                            minlength: 3
                        },
                        'lab_type[]': {
                            required: true
                        },
                        year_of_establishment: {
                            required: true,
                        },
                        primary_contact_name: {
                            required: true,
                            minlength: 3
                        },
                        phone: {
                            required: true,
                            digits: true,
                            minlength: 10,
                            maxlength: 15
                        },
                        email: {
                            required: true,
                        },
                        name: {
                            required: true,
                        },
                        username: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                    },
                    messages: {
                        lab_name: {
                            required: "lab name is required",
                            minlength: "lab name must be at least 3 characters"
                        },
                        'lab_type[]': {
                            required: "lab type is required"
                        },
                        year_of_establishment: {
                            required: "year of establishment is required"
                        },
                        primary_contact_name: {
                            required: "Primary contact name is required"
                        },
                        phone: {
                            required: "Phone number is required",
                            digits: "Only numbers are allowed",
                            minlength: "Phone number must be at least 10 digits",
                            maxlength: "Phone number cannot exceed 15 digits"
                        },
                        email: {
                            required: "Email field is required",
                        },
                        name: {
                            required: "Admin name is required",
                        },
                        username: {
                            required: "Username is required",
                        },
                        password: {
                            required: "Password is required",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.addClass("text-danger");
                        if (element.is(":radio") || element.is(":checkbox")) {
                            error.appendTo(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#submitBtn").click(function(e) {
                    e.preventDefault();

                    if ($("#storeReferingLab").valid()) {
                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Saving referring lab...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        var form = $('#storeReferingLab')[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('refering_lab.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close()
                                Swal.fire("Success!", response.success, "success");
                                form.reset();
                                fetchLabs();
                                $('#addModal').modal('hide');
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                Swal.close()
                                let errorMessage = "An error occurred!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire("Error!", errorMessage, "error");
                            }
                        });
                    } else {
                        // Collect jQuery Validate errors
                        let validator = $("#storeReferingLab").validate();
                        let errorList = validator.errorList;

                        if (errorList.length > 0) {
                            let errorHtml = "<ol class='text-start'>";
                            errorList.forEach(function(error) {
                                errorHtml += "<li class='text-danger'>" + error.message +
                                    "</li>";
                            });
                            errorHtml += "</ol>";

                            Swal.fire({
                                icon: "error",
                                title: "Please fix the following errors:",
                                html: errorHtml
                            });
                        }
                    }
                });
            });


        });
    </script>
@endsection
