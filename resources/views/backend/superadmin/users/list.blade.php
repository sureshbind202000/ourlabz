@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">All Patients</h5>
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
                        </div>
                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-200">
                                <tr>
                                    <th class="text-900">S.No.</th>
                                    <th class="text-900" data-sort="userid">Patient ID</th>
                                    <th class="text-900" data-sort="name">Name</th>
                                    <th class="text-900" data-sort="phone">Phone</th>
                                    <th class="text-900" data-sort="phone">Email</th>
                                    <th class="text-900" data-sort="date">Date</th>
                                    <th class="text-900">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td>1</td>
                                    <td class="userid">000</td>
                                    <td class="name">user</td>
                                    <td class="phone">xxx xxx xxx</td>
                                    <td class="email">user@example.com</td>
                                    <td class="date">dd/mm/yy</td>
                                    <td>
                                        <div><a class="btn btn-link p-0" href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View"><span
                                                    class="text-500 fas fa-eye"></span></a>
                                            <button class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit"><span
                                                    class="text-500 fas fa-edit"></span></button><button
                                                class="btn btn-link p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete"><span
                                                    class="text-500 fas fa-trash-alt"></span></button>
                                        </div>
                                    </td>
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
                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add Patient</h4>
                        <p class="fs-10 mb-0 text-white">Fill the form to create new patient.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="storeUser" enctype="multipart/form-data">
                            @csrf
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
                                    {{-- <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab5"
                                            data-bs-toggle="tab" data-wizard-step="5"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Booking Preferences</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab6"
                                            data-bs-toggle="tab" data-wizard-step="6"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Insurance & Payment</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab7"
                                            data-bs-toggle="tab" data-wizard-step="7"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Uploads & Documents</span></a>
                                    </li> --}}
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
                                                <label class="form-label" for="name">Full Name</label>
                                                <input class="form-control" id="name" name="name" type="text"
                                                    placeholder="Enter name" />
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
                                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                                <input class="form-control" id="date_of_birth" name="date_of_birth"
                                                    type="date" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="age">Age</label>
                                                <input class="form-control" id="age" name="age" type="number"
                                                    placeholder="Auto-calculated based on DOB" readonly />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="blood_group">Blood Group</label>
                                                <select name="blood_group" id="blood_group" class="form-select">
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
                                                <input class="form-control" id="profile" name="profile"
                                                    type="file" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"
                                        data-wizard-form="2">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="phone">Phone</label>
                                                <input class="form-control" id="phone" name="phone" type="number"
                                                    placeholder="Enter phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="alternate_phone">Alternate Phone</label>
                                                <input class="form-control" id="alternate_phone" name="alternate_phone"
                                                    type="number" placeholder="Enter alternate phone number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="email">Email (Optional)</label>
                                                <input class="form-control" id="email" name="email" type="text"
                                                    placeholder="Enter email" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="emergency_contact_name">Emergency Contact
                                                    Name</label>
                                                <input class="form-control" id="emergency_contact_name"
                                                    name="emergency_contact_name" type="text"
                                                    placeholder="Enter emergency contact name" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="emergency_contact_phone">Emergency Contact
                                                    Phone</label>
                                                <input class="form-control" id="emergency_contact_phone"
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
                                                <label class="form-label" for="address">Street Address</label>
                                                <input class="form-control" id="address" name="address" type="text"
                                                    placeholder="Enter address" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="city">City</label>
                                                <input class="form-control" id="city" name="city" type="text"
                                                    placeholder="Enter city" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="state">State</label>
                                                <input class="form-control" id="state" name="state" type="text"
                                                    placeholder="Enter state" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="country">Country</label>
                                                <input class="form-control" id="country" name="country" type="text"
                                                    placeholder="Enter country" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="pin">Pin/Postal code</label>
                                                <input class="form-control" id="pin" name="pin" type="text"
                                                    placeholder="Enter pin/postal code" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="google_map_location">Google Map Location
                                                    (optional)</label>
                                                <input class="form-control" id="google_map_location"
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
                                                <label class="form-label" for="medical_conditon">Existing Medical
                                                    Conditions </label>
                                                <select name="medical_condition[]" id="medical_conditon"
                                                    class="form-select js-choice" multiple="multiple" size="1"
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
                                                <label class="form-label" for="allergies">Allergies (if any)</label>
                                                <select name="allergies[]" id="allergies" class="form-select js-choice"
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
                                                <label class="form-label" for="current_medications">Current
                                                    Medications</label>
                                                <textarea name="current_medications" id="current_medications" rows="5" class="form-control"
                                                    placeholder="Enter current medications"></textarea>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="family_doctor_name_contact">Family Doctor
                                                    Name & Contact (Optional) </label>
                                                <input class="form-control" id="family_doctor_name_contact"
                                                    name="family_doctor_name_contact" type="text"
                                                    placeholder="Enter family doctor name & contact" />
                                            </div>

                                        </div>

                                    </div>
                                    {{-- <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                        data-wizard-form="5">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="preferred_test_type">Preferred Test Type
                                                </label>
                                                <select name="preferred_test_type[]" id="preferred_test_type"
                                                    class="form-select js-choice" multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($labs as $lab)
                                                        @foreach ($lab->lab_tests as $labtest)
                                                            <option value="{{ $labtest->package_id }}">
                                                                {{ $labtest->test_name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="preferred_lab_clinic">Preferred
                                                    Lab/Clinic</label>
                                                <select name="preferred_lab_clinic[]" id="preferred_lab_clinic"
                                                    class="form-select js-choice" multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($labs as $lab)
                                                        <option value="{{ $lab->lab_id }}">{{ $lab->lab_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="preferred_date_time">Preferred Appointment
                                                    Date & Time</label>
                                                <input class="form-control" id="preferred_date_time"
                                                    name="preferred_date_time" type="datetime-local" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="sample_collecton_mode">Sample Collection
                                                    Mode</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="home_collection" type="radio"
                                                        name="sample_collecton_mode" value="Home Collection" />
                                                    <label class="form-check-label" for="home_collection">Home
                                                        Collection</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="visit_lab" type="radio"
                                                        name="sample_collecton_mode" value="Visit Lab" />
                                                    <label class="form-check-label" for="visit_lab">Visit Lab</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6"
                                        data-wizard-form="6">
                                        <div class="row">

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="insurance_provider">Insurance
                                                    Provider</label>
                                                <select name="insurance_provider" id="insurance_provider"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="UnitedHealthcare">UnitedHealthcare</option>
                                                    <option value="Aetna">Aetna</option>
                                                    <option value="Blue Cross Blue Shield">Blue Cross Blue Shield</option>
                                                    <option value="Cigna">Cigna</option>
                                                    <option value="Kaiser Permanente">Kaiser Permanente</option>
                                                    <option value="Humana">Humana</option>
                                                    <option value="MediCare">MediCare</option>
                                                    <option value="MediCal">MediCal</option>
                                                    <option value="Max Bupa Health Insurance">Max Bupa Health Insurance
                                                    </option>
                                                    <option value="Star Health and Allied Insurance">Star Health and Allied
                                                        Insurance</option>
                                                    <option value="Religare Health Insurance">Religare Health Insurance
                                                    </option>
                                                    <option value="HDFC ERGO Health Insurance">HDFC ERGO Health Insurance
                                                    </option>
                                                    <option value="ICICI Lombard">ICICI Lombard</option>
                                                    <option value="Tata AIG Health Insurance">Tata AIG Health Insurance
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="insurance_policy_number">Insurance Policy
                                                    Number</label>
                                                <input class="form-control" id="insurance_policy_number"
                                                    name="insurance_policy_number" type="text"
                                                    placeholder="Enter insurance policy number" />
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="payment_preference">Payment
                                                    Preference</label>
                                                <select name="payment_preference" id="payment_preference"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Online">Online</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Insurance">Insurance</option>
                                                    <option value="UPI">UPI</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="discount_code">Discount Code (if
                                                    any)</label>
                                                <input class="form-control" id="discount_code" name="discount_code"
                                                    type="text" placeholder="Enter discount code" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"
                                        data-wizard-form="7">
                                        <div class="row">
                                            <div class="mb-3 col-6 ">
                                                <div class="input-group">
                                                    <label class="form-label" for="id_proof">ID Proof (optional)</label>
                                                    <label class="form-label ms-auto" for="id_proof_type">ID
                                                        Type</label>
                                                </div>
                                                <div class="input-group">
                                                    <input class="form-control w-75" id="id_proof" name="id_proof"
                                                        type="file" />
                                                    <select name="id_proof_type" id="id_proof_type"
                                                        class="form-select w-25">
                                                        <option value="">Type</option>
                                                        <option value="Aadhar card">Aadhar card</option>
                                                        <option value="PAN Card">PAN Card</option>
                                                        <option value="Ration Card">Ration Card</option>
                                                        <option value="Driving Licence">Driving Licence</option>
                                                        <option value="Voter ID">Voter ID</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="insurance_card">Insurance Card
                                                    Upload</label>
                                                <input class="form-control" id="insurance_card" name="insurance_card"
                                                    type="file" placeholder="Upload insurance card" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="doctor_prescription">Doctor's Prescription
                                                    (if required for test)</label>
                                                <input class="form-control" id="doctor_prescription"
                                                    name="doctor_prescription" type="file"
                                                    placeholder="Upload doctor prescription" />
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5"
                                        data-wizard-form="5">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="username">username</label>
                                                <input class="form-control" id="username" name="username"
                                                    type="text" placeholder="Enter username" />
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
                                            <div class="mb-3 col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="terms_condition" type="checkbox"
                                                        value="" name="terms_condition" />
                                                    <label class="form-check-label" for="terms_condition">Consent to Terms
                                                        & Conditions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="subscribe_notification"
                                                        type="checkbox" value="" name="subscribe"/>
                                                    <label class="form-check-label" for="subscribe_notification">Subscribe
                                                        to Notifications & Updates? </label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 text-center">
                                                <button class="btn btn-primary bg-gradient px-5 " type="button"
                                                    id="submitUserBtn">Submit</button>
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
    <!-- Edit Package Modal Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"
        aria-hidden="true">
        <div class="modal-dialog mt-6 modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="modal-header position-relative modal-shape-header bg-shape">
                    <div class="position-relative z-1">
                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Patient</h4>
                        <p class="fs-10 mb-0 text-white">Update patient details.</p>
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                            data-bs-dismiss="modal" aria-label="Close"></button></div>
                </div>
                <div class="modal-body  px-4 pb-4">
                    <div class="theme-wizard ">
                        <form class="row" id="updateUser" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">

                                    <li class="nav-item"><a class="nav-link active fw-semi-bold"
                                            href="#bootstrap-wizard-tab9" data-bs-toggle="tab" data-wizard-step="9"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-1"></i></span></span>
                                            <span class="d-none d-md-block mt-1 fs-10">Personal Details</span></a></li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab10"
                                            data-bs-toggle="tab" data-wizard-step="10"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-2"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Contact Information</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab11"
                                            data-bs-toggle="tab" data-wizard-step="11"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-3"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Address Details</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab12"
                                            data-bs-toggle="tab" data-wizard-step="12"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-4"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Medical Information</span></a>
                                    </li>
                                    {{-- <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                            data-bs-toggle="tab" data-wizard-step="13"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-5"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Booking Preferences</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab14"
                                            data-bs-toggle="tab" data-wizard-step="14"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-6"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Insurance & Payment</span></a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab15"
                                            data-bs-toggle="tab" data-wizard-step="15"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-7"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Uploads & Documents</span></a>
                                    </li> --}}
                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab13"
                                            data-bs-toggle="tab" data-wizard-step="13"><span
                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i
                                                        class="fa-solid fa-8"></i></span></span><span
                                                class="d-none d-md-block mt-1 fs-10">Login & Account</span></a>
                                    </li>

                                </ul>
                            </div>
                            <div class="py-4">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab9" id="bootstrap-wizard-tab9"
                                        data-wizard-form="9">
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
                                        aria-labelledby="bootstrap-wizard-tab10" id="bootstrap-wizard-tab10"
                                        data-wizard-form="10">
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
                                        aria-labelledby="bootstrap-wizard-tab11" id="bootstrap-wizard-tab11"
                                        data-wizard-form="11">
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
                                        aria-labelledby="bootstrap-wizard-tab12" id="bootstrap-wizard-tab12"
                                        data-wizard-form="12">
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
                                    {{-- <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab13" id="bootstrap-wizard-tab13"
                                        data-wizard-form="13">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_preferred_test_type">Preferred Test
                                                    Type
                                                </label>
                                                <select name="preferred_test_type[]" id="edit_preferred_test_type"
                                                    class="form-select " multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($labs as $lab)
                                                        @foreach ($lab->lab_tests as $labtest)
                                                            <option value="{{ $labtest->package_id }}">
                                                                {{ $labtest->test_name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_preferred_lab_clinic">Preferred
                                                    Lab/Clinic</label>
                                                <select name="preferred_lab_clinic[]" id="edit_preferred_lab_clinic"
                                                    class="form-select " multiple="multiple" size="1"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">--select--</option>
                                                    @foreach ($labs as $lab)
                                                        <option value="{{ $lab->lab_id }}">{{ $lab->lab_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_preferred_date_time">Preferred
                                                    Appointment
                                                    Date & Time</label>
                                                <input class="form-control" id="edit_preferred_date_time"
                                                    name="preferred_date_time" type="datetime-local" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_sample_collecton_mode">Sample
                                                    Collection
                                                    Mode</label>
                                                <br>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_home_collection"
                                                        type="radio" name="sample_collecton_mode"
                                                        value="Home Collection" />
                                                    <label class="form-check-label" for="edit_home_collection">Home
                                                        Collection</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-1">
                                                    <input class="form-check-input" id="edit_visit_lab" type="radio"
                                                        name="sample_collecton_mode" value="Visit Lab" />
                                                    <label class="form-check-label" for="edit_visit_lab">Visit
                                                        Lab</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab14" id="bootstrap-wizard-tab14"
                                        data-wizard-form="14">
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_insurance_provider">Insurance
                                                    Provider</label>
                                                <select name="insurance_provider" id="edit_insurance_provider"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="UnitedHealthcare">UnitedHealthcare</option>
                                                    <option value="Aetna">Aetna</option>
                                                    <option value="Blue Cross Blue Shield">Blue Cross Blue Shield</option>
                                                    <option value="Cigna">Cigna</option>
                                                    <option value="Kaiser Permanente">Kaiser Permanente</option>
                                                    <option value="Humana">Humana</option>
                                                    <option value="MediCare">MediCare</option>
                                                    <option value="MediCal">MediCal</option>
                                                    <option value="Max Bupa Health Insurance">Max Bupa Health Insurance
                                                    </option>
                                                    <option value="Star Health and Allied Insurance">Star Health and
                                                        Allied Insurance</option>
                                                    <option value="Religare Health Insurance">Religare Health Insurance
                                                    </option>
                                                    <option value="HDFC ERGO Health Insurance">HDFC ERGO Health Insurance
                                                    </option>
                                                    <option value="ICICI Lombard">ICICI Lombard</option>
                                                    <option value="Tata AIG Health Insurance">Tata AIG Health Insurance
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_insurance_policy_number">Insurance
                                                    Policy
                                                    Number</label>
                                                <input class="form-control" id="edit_insurance_policy_number"
                                                    name="insurance_policy_number" type="text"
                                                    placeholder="Enter insurance policy number" />
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_payment_preference">Payment
                                                    Preference</label>
                                                <select name="payment_preference" id="edit_payment_preference"
                                                    class="form-select">
                                                    <option value="">--select--</option>
                                                    <option value="Online">Online</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Insurance">Insurance</option>
                                                    <option value="UPI">UPI</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_discount_code">Discount Code (if
                                                    any)</label>
                                                <input class="form-control" id="edit_discount_code"
                                                    name="discount_code" type="text"
                                                    placeholder="Enter discount code" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab15" id="bootstrap-wizard-tab15"
                                        data-wizard-form="15">
                                        <div class="row">
                                            <div class="mb-3 col-6 ">
                                                <div class="input-group">
                                                    <label class="form-label" for="edit_id_proof">ID Proof
                                                        (optional)</label>
                                                    <label class="form-label ms-auto" for="edit_id_proof_type">ID
                                                        Type</label>
                                                </div>
                                                <div class="input-group">
                                                    <input class="form-control w-75" id="edit_id_proof"
                                                        name="id_proof" type="file" />
                                                    <select name="id_proof_type" id="edit_id_proof_type"
                                                        class="form-select w-25">
                                                        <option value="">Type</option>
                                                        <option value="Aadhar card">Aadhar card</option>
                                                        <option value="PAN Card">PAN Card</option>
                                                        <option value="Ration Card">Ration Card</option>
                                                        <option value="Driving Licence">Driving Licence</option>
                                                        <option value="Voter ID">Voter ID</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <br>
                                                <a href="" target="_blank" id="id_proof_preview">View</a>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_insurance_card">Insurance Card
                                                    Upload</label>
                                                <input class="form-control" id="edit_insurance_card"
                                                    name="insurance_card" type="file"
                                                    placeholder="Upload insurance card" />
                                                <br>
                                                <a href="" target="_blank" id="insurance_card_preview">View</a>
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label class="form-label" for="edit_doctor_prescription">Doctor's
                                                    Prescription
                                                    (if required for test)</label>
                                                <input class="form-control" id="edit_doctor_prescription"
                                                    name="doctor_prescription" type="file"
                                                    placeholder="Upload doctor prescription" />
                                                <br>
                                                <a href="" target="_blank"
                                                    id="doctor_prescription_preview">View</a>
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"
                                        aria-labelledby="bootstrap-wizard-tab16" id="bootstrap-wizard-tab13"
                                        data-wizard-form="13">
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
                                                        type="checkbox" value="" name="terms_condition"/>
                                                    <label class="form-check-label" for="edit_terms_condition">Consent
                                                        to Terms & Conditions</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="edit_subscribe"
                                                        type="checkbox" value="" name="subscribe"/>
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
    <!-- Edit Package Modal End -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Add Form Calculate age
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

            // Fetch
            fetchUsers();

            function fetchUsers() {
                $('.loading').show();
                $.ajax({
                    url: "{{ route('user.list') }}",
                    type: "GET",
                    success: function(data) {
                        $('.loading').hide();
                        let rows = "";
                        $.each(data, function(index, user) {
                            let profileImage = (user.profile === 'dummy') ?
                                "{{ asset('backend/assets/img/team/avatar.png') }}" :
                                "{{ asset('/') }}" + user.profile;
                            rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="userid">${user.user_id}</td>
                        <td class="name">
                        <img class="rounded-circle shadow-sm me-1" src="${profileImage}" alt="User Avatar" style="height:26px;width:26px;"/>
                         ${user.name}
                        </td>
                        <td class="phone">${user.phone}</td>
                        <td class="email">${user.email}</td>
                        <td class="date">${formatDate(user.created_at)}</td>
                        <td>
                            <div>
                                 <a class="btn btn-link p-0 " href="{{ url('/') }}/patient/${user.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${user.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                <button class="btn btn-link p-0 edit-btn ms-2" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" data-id="${user.id}"><span
                                                    class="text-primary fas fa-edit"></span></button>
                                                    <button
                                                class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" data-id="${user.id}"><span
                                                    class="text-danger fas fa-trash-alt"></span></button>
                                                    </div>
                            
                        </td>
                    </tr>`;
                        });
                        $("tbody.list").html(rows);
                        new List('tableExample3', {
                            valueNames: ['testid', 'name', 'date'],
                            page: 10,
                            pagination: true
                        });
                    }
                });
            }

            // Store
            $(document).ready(function() {
                var validator = $("#storeUser").validate({
                    ignore: [],
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        phone: {
                            required: true
                        },
                        username: {
                            required: true
                        },
                        password: {
                            required: true
                        },
                        gender: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Name is required",
                            minlength: "Name must be at least 3 characters"
                        },
                        phone: "Phone number is required",
                        username: "Username is required",
                        password: "Password is required",
                        gender: "Gender is required",
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

                $('#submitUserBtn').on('click', function(e) {
                    e.preventDefault();

                    if ($("#storeUser").valid()) {
                        $('.loading').show();
                        var form = $("#storeUser")[0];
                        var formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('user.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('.loading').hide();
                                Swal.fire("Success!", response.success, "success");
                                fetchUsers();
                                $('#addModal').modal('hide');
                                window.location.reload();
                            },
                            error: function(xhr) {
                                $('.loading').hide();
                                console.log(xhr);
                                let errorMessage = "An error occurred!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire("Error!", errorMessage, "error");
                            }
                        });
                    }
                });
            });


            // Edit
            // Open Edit Modal & Load Data
            $(document).on('click', '.edit-btn', function() {
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
                            $('#PreviewProfile').attr('src','/backend/assets/img/team/avatar.png');
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

                        // // Booking Preferences
                        // if (user.booking_preference) {
                        //     initOrResetChoices('#edit_preferred_test_type',
                        //         'edit_preferred_test_type', user.booking_preference
                        //         .preferred_test_type);
                        //     initOrResetChoices('#edit_preferred_lab_clinic',
                        //         'edit_preferred_lab_clinic', user.booking_preference
                        //         .preferred_lab_clinic);
                        //     $('#edit_preferred_date_time').val(user.booking_preference
                        //         .preferred_date_time || '');

                        //     if (user.booking_preference.sample_collecton_mode ==
                        //         'Home Collection') {
                        //         $('#edit_home_collection').prop('checked', true);
                        //     }
                        //     if (user.booking_preference.sample_collecton_mode == 'Visit Lab') {
                        //         $('#edit_visit_lab').prop('checked', true);
                        //     }
                        // } else {
                        //     $('#edit_preferred_test_type, #edit_preferred_lab_clinic, #edit_preferred_date_time, #edit_sample_collecton_mode')
                        //         .val('');
                        // }

                        // // Insurance and Payment
                        // if (user.insurance_payment) {
                        //     $('#edit_insurance_provider').val(user.insurance_payment
                        //         .insurance_provider || '');
                        //     $('#edit_insurance_policy_number').val(user.insurance_payment
                        //         .insurance_policy_number || '');
                        //     $('#edit_payment_preference').val(user.insurance_payment
                        //         .payment_preference || '');
                        //     $('#edit_discount_code').val(user.insurance_payment.discount_code ||
                        //         '');
                        // } else {
                        //     $('#edit_insurance_provider, #edit_insurance_policy_number, #edit_payment_preference, #edit_discount_code')
                        //         .val('');
                        // }

                        // // Documents (Preview)
                        // if (user.documents) {
                        //     $('#edit_id_proof_type').val(user.documents.id_proof_type || '');
                        //     if (user.documents.id_proof) {
                        //         $('#id_proof_preview').attr('href', '/' + user.documents
                        //             .id_proof).show();
                        //     }
                        //     if (user.documents.insurance_card) {
                        //         $('#insurance_card_preview').attr('href', '/' + user.documents
                        //             .insurance_card).show();
                        //     }
                        //     if (user.documents.doctor_prescription) {
                        //         $('#doctor_prescription_preview').attr('href', '/' + user
                        //             .documents.doctor_prescription).show();
                        //     }
                        // }

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
                        fetchUsers();
                        $('.loading').hide();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire("Error!", "Something went wrong.", "error");
                        $('.loading').hide();
                    }
                });
            });

            // Delete 
            $(document).on('click', '.delete-btn', function() {
                let packageId = $(this).data('id');

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
                            url: `/user/${packageId}`,
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
                                    fetchUsers();
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

        });
    </script>
@endsection
