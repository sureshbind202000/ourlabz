@extends('backend.includes.layout')

@section('content')

    <div class="card mb-3">

        <div class="card-header">

            <div class="row flex-between-end">

                <div class="col-auto align-self-center">

                    <h5 class="mb-0" data-anchor="data-anchor">Manage Staff</h5>

                </div>

            </div>

        </div>

        <div class="card-body pt-0">

            <div class="tab-content">



                <div id="tableExample3"

                    data-list='{"valueNames":["userid","name","phone","credentials","role","status","date"],"page":10,"pagination":true}'>

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

                        @if (has_permission('manage', 'create'))

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

                                    <th class="text-900" data-sort="userid">User ID</th>

                                    <th class="text-900" data-sort="name">Name</th>

                                    <th class="text-900" data-sort="phone">Phone</th>

                                    <th class="text-900" data-sort="credentials">Credentials</th>

                                    <th class="text-900" data-sort="role">Role</th>

                                    <th class="text-900" data-sort="status">Status</th>

                                    <th class="text-900" data-sort="date">Date</th>

                                    <th class="text-900">Action</th>

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

    {{-- Add Lab User --}}

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-modal-label"

        aria-hidden="true">

        <div class="modal-dialog mt-6 modal-xl" role="document">

            <div class="modal-content border-0">

                <div class="modal-header position-relative modal-shape-header bg-shape">

                    <div class="position-relative z-1">

                        <h4 class="mb-0 text-white" id="addModal-modal-label">Add User</h4>

                        <p class="fs-10 mb-0 text-white">Fill the form to create new user.</p>

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

                                                        class="fa-solid fa-1"></i></span></span></a></li>

                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2"

                                            data-bs-toggle="tab" data-wizard-step="2"><span

                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i

                                                        class="fa-solid fa-2"></i></span></span></a>

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

                                                <label class="form-label" for="name">Name</label>

                                                <input class="form-control" id="name" name="name" type="text"

                                                    placeholder="Enter name" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="phone">Phone</label>

                                                <input class="form-control" id="phone" name="phone" type="number"

                                                    placeholder="Enter phone number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="email">Email (Optional)</label>

                                                <input class="form-control" id="email" name="email" type="text"

                                                    placeholder="Enter email" />

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

                                                <label class="form-label">Upload Image (Optional)</label>

                                                <input class="form-control" id="profile" name="profile"

                                                    type="file" />

                                            </div>



                                            <div class="mb-3 col-6">

                                                <label class="form-label">Role</label>

                                                <select class="form-select" name="lab_user_role" id="lab_user_role">

                                                    <option value="">-- Select --</option>

                                                    <option value="1">Admin</option>

                                                    <option value="2">Manager</option>

                                                    <option value="3">Technician</option>

                                                    <option value="4">Phlebotomist</option>

                                                    <option value="5">Doctor</option>

                                                </select>

                                            </div>



                                            <div class="mb-3 col-12">

                                                <label class="form-label fw-bold mb-3">Assign Module Permissions</label>



                                                <div class="table-responsive">

                                                    <table

                                                        class="table table-bordered table-hover align-middle text-center">

                                                        <thead class="table-light">

                                                            <tr>

                                                                <th class="text-start">Module</th>

                                                                <th>

                                                                    <input type="checkbox"

                                                                        class="form-check-input check-all-add"

                                                                        data-permission="view"> View

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox"

                                                                        class="form-check-input check-all-add"

                                                                        data-permission="create"> Create

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox"

                                                                        class="form-check-input check-all-add"

                                                                        data-permission="edit"> Edit

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox"

                                                                        class="form-check-input check-all-add"

                                                                        data-permission="delete"> Delete

                                                                </th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            @foreach ($modules as $module)

                                                                <tr>

                                                                    <td class="text-start">

                                                                        <strong>{{ $module->name }}</strong>

                                                                        <input type="hidden"

                                                                            name="modules[{{ $module->id }}][module_id]"

                                                                            value="{{ $module->id }}">

                                                                    </td>



                                                                    @foreach (['view', 'create', 'edit', 'delete'] as $perm)

                                                                        <td>

                                                                            @if ($module->name === 'Booking' && in_array($perm, ['create', 'edit']))

                                                                                -

                                                                            @elseif($module->name === 'Reports' && in_array($perm, ['create', 'edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Refering' && in_array($perm, ['edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'All Reports' && in_array($perm, ['create', 'edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Report Layout' && in_array($perm, ['edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Reviews' && in_array($perm, ['create']))

                                                                                -

                                                                            @elseif($module->name === 'Notifications' && in_array($perm, ['create']))

                                                                                -

                                                                            @else

                                                                                {{-- Normal checkbox --}}

                                                                                <input type="checkbox"

                                                                                    class="form-check-input add-perm-{{ $perm }}"

                                                                                    name="modules[{{ $module->id }}][can_{{ $perm }}]"

                                                                                    value="1"

                                                                                    id="add_{{ $perm }}_{{ $module->id }}">

                                                                            @endif

                                                                        </td>

                                                                    @endforeach

                                                                </tr>

                                                            @endforeach

                                                        </tbody>



                                                    </table>

                                                </div>

                                            </div>







                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"

                                        aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2"

                                        data-wizard-form="2">

                                        <div class="row">

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="address">Address</label>

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

                                                <label class="form-label" for="username">Username</label>

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

                                            <input type="hidden" name="lab_id" id="lab_id"

                                                value="{{ auth()->user()->lab_id }}">

                                            <div class="mb-3 col-12 text-center">

                                                <button class="btn btn-primary bg-gradient px-5 " type="button"

                                                    id="submitLabUserBtn">Submit</button>

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

    {{-- /Add Lab User --}}



    <!-- Edit Lab User Modal Start -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal-modal-label"

        aria-hidden="true">

        <div class="modal-dialog mt-6 modal-xl" role="document">

            <div class="modal-content border-0">

                <div class="modal-header position-relative modal-shape-header bg-shape">

                    <div class="position-relative z-1">

                        <h4 class="mb-0 text-white" id="editModal-modal-label">Edit Lab User</h4>

                        <p class="fs-10 mb-0 text-white">Update lab user details.</p>

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

                                            href="#bootstrap-wizard-tab7" data-bs-toggle="tab" data-wizard-step="1"><span

                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i

                                                        class="fa-solid fa-1"></i></span></span></a></li>

                                    <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab8"

                                            data-bs-toggle="tab" data-wizard-step="2"><span

                                                class="nav-item-circle-parent"><span class="nav-item-circle"><i

                                                        class="fa-solid fa-2"></i></span></span></a>

                                    </li>

                                </ul>

                            </div>

                            <div class="py-4">

                                <div class="tab-content">

                                    <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel"

                                        aria-labelledby="bootstrap-wizard-tab7" id="bootstrap-wizard-tab7"

                                        data-wizard-form="1">

                                        <div class="row">

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_name">Name</label>

                                                <input class="form-control" id="edit_name" name="name" type="text"

                                                    placeholder="Enter name" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_phone">Phone</label>

                                                <input class="form-control" id="edit_phone" name="phone"

                                                    type="number" placeholder="Enter phone number" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_email">Email (Optional)</label>

                                                <input class="form-control" id="edit_email" name="email"

                                                    type="text" placeholder="Enter email" />

                                            </div>



                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_gender">Gender</label><br>



                                                <div class="form-check form-check-inline mt-1">

                                                    <input class="form-check-input" id="edit_gender_male" type="radio"

                                                        name="gender" value="Male">

                                                    <label class="form-check-label" for="edit_gender_male">Male</label>

                                                </div>



                                                <div class="form-check form-check-inline mt-1">

                                                    <input class="form-check-input" id="edit_gender_female"

                                                        type="radio" name="gender" value="Female">

                                                    <label class="form-check-label"

                                                        for="edit_gender_female">Female</label>

                                                </div>



                                                <div class="form-check form-check-inline mt-1">

                                                    <input class="form-check-input" id="edit_gender_other" type="radio"

                                                        name="gender" value="Other">

                                                    <label class="form-check-label" for="edit_gender_other">Other</label>

                                                </div>

                                            </div>



                                            <div class="mb-3 col-6">

                                                <label class="form-label">Upload Image (Optional)</label>

                                                <input class="form-control" id="edit_profile" name="profile"

                                                    type="file" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label">Role</label>

                                                <select class="form-select" name="lab_user_role" id="edit_lab_user_role">

                                                    <option value="">-- Select --</option>

                                                    <option value="1">Admin</option>

                                                    <option value="2">Manager</option>

                                                    <option value="3">Technician</option>

                                                    <option value="4">Phlebotomist</option>

                                                    <option value="5">Doctor</option>

                                                </select>

                                            </div>



                                            <div class="mb-3 col-12">

                                                <label class="form-label fw-bold mb-3">Assign Module Permissions</label>



                                                <div class="table-responsive">

                                                    <table

                                                        class="table table-bordered table-hover align-middle text-center">

                                                        <thead class="table-light">

                                                            <tr>

                                                                <th class="text-start">Module</th>

                                                                <th>

                                                                    <input type="checkbox" id="checkAllView"> View

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox" id="checkAllCreate"> Create

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox" id="checkAllEdit"> Edit

                                                                </th>

                                                                <th>

                                                                    <input type="checkbox" id="checkAllDelete"> Delete

                                                                </th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            @foreach ($modules as $module)

                                                                <tr>

                                                                    <td class="text-start">

                                                                        <strong>{{ $module->name }}</strong>

                                                                        <input type="hidden"

                                                                            name="modules[{{ $module->id }}][module_id]"

                                                                            value="{{ $module->id }}">

                                                                    </td>

                                                                    @foreach (['view', 'create', 'edit', 'delete'] as $perm)

                                                                        <td>

                                                                            @if ($module->name === 'Booking' && in_array($perm, ['create', 'edit']))

                                                                                -

                                                                            @elseif($module->name === 'Reports' && in_array($perm, ['create', 'edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Refering' && in_array($perm, ['edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'All Reports' && in_array($perm, ['create', 'edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Report Layout' && in_array($perm, ['edit', 'delete']))

                                                                                -

                                                                            @elseif($module->name === 'Reviews' && in_array($perm, ['create']))

                                                                                -

                                                                            @elseif($module->name === 'Notifications' && in_array($perm, ['create']))

                                                                                -

                                                                            @else

                                                                                {{-- Normal checkbox --}}

                                                                                <input type="checkbox"

                                                                                    class="form-check-input edit-perm-{{ $perm }}"

                                                                                    name="modules[{{ $module->id }}][can_{{ $perm }}]"

                                                                                    value="1"

                                                                                    id="edit_{{ $perm }}_{{ $module->id }}">

                                                                            @endif

                                                                        </td>

                                                                    @endforeach

                                                                </tr>

                                                            @endforeach

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>



                                        </div>

                                    </div>

                                    <div class="tab-pane px-sm-3 px-md-5" role="tabpanel"

                                        aria-labelledby="bootstrap-wizard-tab8" id="bootstrap-wizard-tab8"

                                        data-wizard-form="2">

                                        <div class="row">

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_address">Address</label>

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

                                                <label class="form-label" for="edit_username">Username</label>

                                                <input class="form-control" id="edit_username" name="username"

                                                    type="text" placeholder="Enter username" />

                                            </div>

                                            <div class="mb-3 col-6">

                                                <label class="form-label" for="edit_password">Password</label>

                                                <div class="input-group mb-3">

                                                    <input class="form-control w-75" type="password" name="password"

                                                        id="edit_password" placeholder="Type or generate password." />

                                                    <button type="button" class="btn btn-success edit-generate-password"

                                                        data-bs-toggle="tooltip" data-bs-placement="top"

                                                        title="Click to generate random password.">

                                                        <i class="fa-solid fa-key"></i>

                                                    </button>

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

    <!-- Edit Lab User Modal End -->

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

            fetchData();



            function fetchData() {

                $('.loading').show();

                $.ajax({

                    url: "{{ route('manage.staff.list') }}",

                    type: "GET",

                    success: function(data) {

                        $('.loading').hide();

                        let rows = "";

                        $.each(data, function(index, staff) {

                            rows += `<tr>

                            <td>${index + 1}</td>

                            <td class="userid">${staff.user_id}</td>

                            <td class="name">${staff.name}</td>

                            <td class="phone">${staff.phone}</td>

                            <td class="credentials">

                                <b>Username : </b> ${staff.username} <br>

                                <b>Password : </b> ${staff.show_password} <br>

                                </td>

                            <td class="role">${convertLabUserRoles(staff.lab_user_role)}</td>

                            <td class="status">

                                <span class="toggle-status badge ${staff.status == 1 ? 'bg-success' : 'bg-secondary'} change-status-btn"

                                      style="cursor:pointer"

                                      data-id="${staff.id}"

                                      data-status="${staff.status}">

                                      ${staff.status == 1 ? 'Active' : 'Disabled'}

                                </span>

                            </td>

                            <td class="date">${formatDate(staff.created_at)}</td>

                             <td>

                                <div>

                                    @if (has_permission('manage', 'view'))

                                     <a class="btn btn-link p-0 " href="{{ url('/') }}/lab/user/profile/${staff.encrypted_id}" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="View" data-id="${staff.id}"><span

                                                        class="text-secondary fas fa-eye"></span></a>

                                                        @endif

                                                        @if (has_permission('manage', 'edit'))

                                                        <button

                                                    class="btn btn-link p-0 ms-2 edit-btn" type="button" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="Edit" data-id="${staff.id}"><span

                                                        class="text-primary fas fa-pen-to-square"></span></button>

                                                        @endif

                                                        @if (has_permission('manage', 'delete'))

                                                        <button

                                                    class="btn btn-link p-0 ms-2 delete-btn" type="button" data-bs-toggle="tooltip"

                                                    data-bs-placement="top" title="Delete" data-id="${staff.id}"><span

                                                        class="text-danger fas fa-trash-alt"></span></button>

                                                        @endif

                                                        </div>

                                

                            </td>

                           

                        </tr>`;

                        });

                        $("tbody.list").html(rows);

                        new List('tableExample3', {

                            valueNames: ["userid", "name", "phone", "credentials", "role",

                                "status", "date"

                            ],

                            page: 10,

                            pagination: true

                        });

                    }

                });

            }



            function convertLabUserRoles(role) {

                switch (role) {

                    case 1:

                        return '<span class="badge bg-success">Admin</span>';

                    case 2:

                        return '<span class="badge bg-warning text-dark">Manager</span>';

                    case 3:

                        return '<span class="badge bg-danger">Technician</span>';

                    case 4:

                        return '<span class="badge bg-danger">Phlebotomist</span>';

                    case 5:

                        return '<span class="badge bg-danger">Doctor</span>';

                    default:

                        return '<span class="badge bg-secondary">Unknown</span>';

                }

            }



            $(document).on('click', '.change-status-btn', function() {

                let id = $(this).data('id');

                let currentStatus = $(this).data('status');

                let newStatus = currentStatus == 1 ? 0 : 1;



                Swal.fire({

                    title: "Are you sure?",

                    text: `You are about to change status to ${newStatus === 1 ? 'Active' : 'Disabled'}.`,

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#3085d6",

                    cancelButtonColor: "#d33",

                    confirmButtonText: "Yes, change it!",

                    preConfirm: () => {

                        return $.ajax({

                            url: "{{ route('manage.staff.status') }}",

                            type: "POST",

                            data: {

                                _token: "{{ csrf_token() }}",

                                id: id,

                                status: newStatus

                            },

                            beforeSend: function() {

                                Swal.showLoading();

                            }

                        }).then(response => {

                            if (response.success) {

                                return response;

                            } else {

                                throw new Error(response.message);

                            }

                        }).catch(error => {

                            Swal.showValidationMessage(

                                `Request failed: ${error.message}`);

                        });

                    },

                    allowOutsideClick: () => !Swal.isLoading()

                }).then((result) => {

                    if (result.isConfirmed && result.value) {

                        fetchData(); // Refresh the table

                        Swal.fire("Updated!", result.value.message, "success");

                    }

                });

            });









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

                        password: "Password is required",

                        gender: "Gender is required",

                        profile: {

                            extension: "Only JPG, JPEG, PNG, or GIF files are allowed",

                            filesize: "Profile image must be less than 2MB"

                        }

                    },

                    errorPlacement: function(error, element) {

                        error.addClass("text-danger");

                        if (element.is(":radio") || element.is(":checkbox")) {

                            error.appendTo(element.parent());

                        } else {

                            error.insertAfter(element);

                        }

                    },

                    submitHandler: function(form) {

                        $('.loading').show();

                        var formData = new FormData(form);

                        $.ajax({

                            url: "{{ route('lab.user.store') }}",

                            type: "POST",

                            data: formData,

                            contentType: false,

                            processData: false,

                            success: function(response) {

                                $('.loading').hide();

                                Swal.fire("Success!", response.success, "success");

                                $('#addModal').modal('hide');

                                window.location.reload();

                            },

                            error: function(xhr) {

                                console.log(xhr);

                                $('.loading').hide();

                                let errorMessage = "An error occurred!";

                                if (xhr.responseJSON && xhr.responseJSON.message) {

                                    errorMessage = xhr.responseJSON.message;

                                }

                                Swal.fire("Error!", errorMessage, "error");

                            }

                        });

                    }

                });



                // ✅ Submit form on button click

                $('#submitLabUserBtn').on('click', function() {
              
                    if ($("#storeUser").valid()) {

                        $("#storeUser").submit(); // Triggers jQuery Validate's submitHandler

                    }

                });

            });





            // Open Edit Modal & Load Data

            $(document).on('click', '.edit-btn', function() {

                $('.loading').show();

                let userId = $(this).data('id');



                $.ajax({

                    url: '/lab/user/' + userId + '/edit',

                    type: 'GET',

                    success: function(response) {

                        var user = response.user;

                        var permissions = response.permissions || {};



                        $('#edit_id').val(user.id);

                        $('#edit_name').val(user.name);

                        $('#edit_phone').val(user.phone);

                        $('#edit_email').val(user.email);

                        $('#edit_username').val(user.username);

                        $('#edit_lab_user_role').val(user.lab_user_role).change();

                        if (user.user_details) {

                            let details = user.user_details; // Access first element

                            $('#edit_address').val(details.address || '');

                            $('#edit_city').val(details.city || '');

                            $('#edit_state').val(details.state || '');

                            $('#edit_country').val(details.country || '');

                            $('#edit_pin').val(details.pin || '');

                        } else {

                            // ✅ Set empty values if no user_details

                            $('#edit_address').val('');

                            $('#edit_city').val('');

                            $('#edit_state').val('');

                            $('#edit_country').val('');

                            $('#edit_pin').val('');

                        }



                        // Select Gender

                        $('input[name="gender"]').prop('checked', false);



                        if (user.gender) {

                            $('input[name="gender"][value="' + user.gender + '"]').prop(

                                'checked', true);

                        }



                        $('input[type="checkbox"][name^="modules"]').prop('checked',

                            false); // Reset all checkboxes first



                        $.each(permissions, function(moduleId, perms) {

                            if (perms.can_view) {

                                $('#edit_view_' + moduleId).prop('checked', true);

                            }

                            if (perms.can_create) {

                                $('#edit_create_' + moduleId).prop('checked', true);

                            }

                            if (perms.can_edit) {

                                $('#edit_edit_' + moduleId).prop('checked', true);

                            }

                            if (perms.can_delete) {

                                $('#edit_delete_' + moduleId).prop('checked', true);

                            }

                        });



                        $('#editModal').modal('show');

                        $('.loading').hide();

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

                let staffId = $(this).data('id');



                Swal.fire({

                    title: "Are you sure?",

                    text: "This will delete the staff and all related data!",

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#d33",

                    cancelButtonColor: "#3085d6",

                    confirmButtonText: "Yes, delete it!"

                }).then((result) => {

                    if (result.isConfirmed) {

                        $('.loading').show();



                        $.ajax({

                            url: `/user/${staffId}`, // <-- URL to DELETE

                            type: "DELETE",

                            data: {

                                _token: "{{ csrf_token() }}"

                            },

                            success: function(response) {

                                $('.loading').hide();



                                if (response.success) {

                                    Swal.fire("Deleted!",

                                        "The lab staff have been deleted.",

                                        "success");

                                    fetchData();

                                } else {

                                    Swal.fire("Error!", "Something went wrong.",

                                        "error");

                                }

                            },

                            error: function(xhr) {

                                $('.loading').hide();

                                Swal.fire("Error!", "Failed to delete staff.", "error");

                            }

                        });

                    }

                });

            });



        });

    </script>

    <script>

        $(document).on('change', '.check-all-add', function() {

            let perm = $(this).data('permission');

            let checked = $(this).is(':checked');

            $('.add-perm-' + perm).prop('checked', checked);

        });



        // Check all for Edit Modal

        $('#checkAllView').on('change', function() {

            $('input[id^="edit_view_"]').prop('checked', this.checked);

        });

        $('#checkAllCreate').on('change', function() {

            $('input[id^="edit_create_"]').prop('checked', this.checked);

        });

        $('#checkAllEdit').on('change', function() {

            $('input[id^="edit_edit_"]').prop('checked', this.checked);

        });

        $('#checkAllDelete').on('change', function() {

            $('input[id^="edit_delete_"]').prop('checked', this.checked);

        });

    </script>

@endsection

