@extends('backend.includes.layout')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header">
            <div class="row gx-0 align-items-center">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor" id="manage-schedules">Manage Schedules<a class="anchorjs-link "
                            aria-label="Anchor" data-anchorjs-icon="#" href="#manage-schedules"
                            style="margin-left: 0.1875em; padding-right: 0.1875em; padding-left: 0.1875em;"></a></h5>
                </div>
                @php
                    $roleId = auth()->user()->role ?? null;
                @endphp
                @if ($roleId != 2 || has_permission('scheduling', 'create', 2))
                    <div class="col-auto d-flex order-md-0 ms-auto"><button class="btn btn-primary btn-sm ms-auto"
                            type="button" data-bs-toggle="modal" data-bs-target="#addScheduleModal"> <span
                                class="fas fa-plus me-2"></span>Add
                            Schedule</button></div>
                @endif

            </div>
        </div>
        <div class="card-body p-0 scrollbar">
            <div class="p-3">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Filter by Day</label>
                        <select id="filterDay" class="form-select">
                            <option value="">All Days</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="filterDate">Filter by Date</label>
                        <input class="form-control datetimepicker" id="filterDate" type="text" placeholder="dd/mm/yy"
                            data-options='{"disableMobile":true}' />
                    </div>
                    <div class="col-md-3">
                        <label>Filter by Month</label>
                        <input type="month" id="filterMonth" class="form-control" value="{{ now()->format('Y-m') }}" />
                    </div>
                    <div class="col-md-3">
                        <label>Scheduling For</label>
                        <select id="filterSchedulingFor" class="form-select">
                            <option value="">All Types</option>
                            <option value="1">Visiting</option>
                            <option value="2">Home Collection</option>
                            <option value="3">Corporate</option>
                        </select>
                    </div>
                </div>

                <div id="scheduleList" class="accordion">
                    <!-- Schedules will load here -->
                </div>
            </div>

        </div>

    </div>
    {{-- Add Schedule Modal --}}
    <div class="modal fade" id="addScheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border">
                <form id="addScheduleForm" autocomplete="off">
                    <div class="modal-header px-x1 bg-body-tertiary border-bottom-0">
                        <h5 class="modal-title">Create Schedule</h5><button class="btn-close me-n1" type="button"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-x1">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Scheduling For : </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="visiting" name="scheduling_for[]" type="checkbox"
                                        value="1" />
                                    <label class="form-check-label" for="visiting">Visiting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="homecollection" name="scheduling_for[]"
                                        type="checkbox" value="2" />
                                    <label class="form-check-label" for="homecollection">Home Collection</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="corporate" name="scheduling_for[]" type="checkbox"
                                        value="3" />
                                    <label class="form-check-label" for="corporate">Corporate</label>
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="timepicker2">Select Date</label>
                                <input class="form-control datetimepicker" id="timepicker2" type="text"
                                    placeholder="dd/mm/yy to dd/mm/yy"
                                    data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="start_time">Start Time</label>
                                <input class="form-control" id="start_time" type="time" placeholder="H:i" />
                            </div>
                            <div class="mb-3 col-6">
                                <label class="form-label" for="end_time">End Time</label>
                                <input class="form-control" id="end_time" type="time" placeholder="H:i" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time Interval (minutes):</label>
                                <input type="number" name="time_gap" class="form-control" placeholder="e.g. 30" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Excluding Days : </label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeSunday" name="excluding_days[]"
                                        type="checkbox" value="Sunday" />
                                    <label class="form-check-label" for="excludeSunday">Sunday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeMonday" name="excluding_days[]"
                                        type="checkbox" value="Monday" />
                                    <label class="form-check-label" for="excludeMonday">Monday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeTuesday" name="excluding_days[]"
                                        type="checkbox" value="Tuesday" />
                                    <label class="form-check-label" for="excludeTuesday">Tuesday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeWednesday" name="excluding_days[]"
                                        type="checkbox" value="Wednesday" />
                                    <label class="form-check-label" for="excludeWednesday">Wednesday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeThursday" name="excluding_days[]"
                                        type="checkbox" value="Thursday" />
                                    <label class="form-check-label" for="excludeThursday">Thursday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeFriday" name="excluding_days[]"
                                        type="checkbox" value="Friday" />
                                    <label class="form-check-label" for="excludeFriday">Friday</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="excludeSaturday" name="excluding_days[]"
                                        type="checkbox" value="Saturday" />
                                    <label class="form-check-label" for="excludeSaturday">Saturday</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="slots">Slots</label>
                                <input class="form-control" id="slots" type="number"
                                    placeholder="Enter no. of slots according to availability." />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end align-items-center bg-body-tertiary border-0">
                        <button class="btn btn-primary px-4" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit Schedule --}}
    <div class="modal fade" id="editScheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border">
                <form id="updateScheduleForm" autocomplete="off" method="Post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editScheduleId" name="id">

                    <div class="modal-header px-x1 bg-body-tertiary border-bottom-0">
                        <h5 class="modal-title">Edit Schedule</h5>
                        <button class="btn-close me-n1" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-x1">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Scheduling For:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="scheduling_for"
                                        id="edit_visiting" value="1">
                                    <label class="form-check-label" for="edit_visiting">Visiting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="scheduling_for"
                                        id="edit_homecollection" value="2">
                                    <label class="form-check-label" for="edit_homecollection">Home Collection</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="scheduling_for"
                                        id="edit_corporate" value="3">
                                    <label class="form-check-label" for="edit_corporate">Corporate</label>
                                </div>
                            </div>


                            <div class="mb-3 col-6">
                                <label class="form-label" for="edit_start_time">Start Time</label>
                                <input class="form-control" name="from_time" id="edit_start_time" type="time"
                                    placeholder="H:i" />
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label" for="edit_end_time">End Time</label>
                                <input class="form-control" name="to_time" id="edit_end_time" type="time"
                                    placeholder="H:i" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end align-items-center bg-body-tertiary border-0">
                        <button class="btn btn-primary px-4" type="submit">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Edit Slot --}}
    <div class="modal fade" id="editSlotsModal" tabindex="-1" aria-labelledby="editSlotsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editSlotsForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Slots for <span id="editSlotsDate"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newSlots" class="form-label">Number of Slots</label>
                            <input type="number" class="form-control" name="slots" id="newSlots" required
                                min="1">
                        </div>
                    </div>
                    <input type="hidden" name="date" id="editScheduleDate">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Slots</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const canEditSchedule = @json($roleId != 2 || has_permission('scheduling', 'edit', 2));
        const canDeleteSchedule = @json($roleId != 2 || has_permission('scheduling', 'delete', 2));
    </script>
    <script>
        $(document).ready(function() {
            const AUTH_USER_ROLE = "{{ auth()->user()->role }}";
            const AUTH_USER_ID = "{{ auth()->user()->user_id }}";
            const LAB_ID = "{{ auth()->user()->lab_id ?? 'null' }}";

            $('#addScheduleForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const formData = {
                    scheduler_id: AUTH_USER_ROLE == 2 ? LAB_ID : (AUTH_USER_ROLE == 3 ? AUTH_USER_ID :
                        null),
                    scheduling_for: [],
                    start_date: '',
                    end_date: '',
                    start_time: $('#start_time').val(),
                    end_time: $('#end_time').val(),
                    time_gap: $('input[name="time_gap"]').val(),
                    excluding_days: [],
                    slots: $('#slots').val()
                };

                // Get scheduling_for values
                $('input[name="scheduling_for[]"]:checked').each(function() {
                    formData.scheduling_for.push($(this).val());
                });

                // Get excluding_days values
                $('input[name="excluding_days[]"]:checked').each(function() {
                    formData.excluding_days.push($(this).val());
                });

                // Get date range or single date
                const rangeVal = $('#timepicker2').val().trim();
                if (rangeVal.includes(' to ')) {
                    const range = rangeVal.split(' to ');
                    formData.start_date = formatDate(range[0]);
                    formData.end_date = formatDate(range[1]);
                } else {
                    formData.start_date = formatDate(rangeVal);
                    formData.end_date = formatDate(rangeVal);
                }

                // Show loader using SweetAlert
                Swal.fire({
                    title: 'Saving schedule...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/schedules',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#addScheduleModal').modal('hide');
                        form[0].reset();
                        loadSchedules();
                    },
                    error: function(xhr) {
                        let message = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message,
                        });
                    }
                });
            });

            function formatDate(dateStr) {
                const parts = dateStr.split('/');
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }
            loadSchedules();

            $('#filterDay, #filterMonth, #filterSchedulingFor, #filterDate').on('change', function() {
                loadSchedules();
            });

            function getSchedulingForText(value) {
                switch (value) {
                    case 1:
                    case "1":
                        return "Visiting";
                    case 2:
                    case "2":
                        return "Home Collection";
                    case 3:
                    case "3":
                        return "Corporate";
                    default:
                        return "Unknown";
                }
            }

            function loadSchedules() {
                const day = $('#filterDay').val();
                const month = $('#filterMonth').val() || new Date().toISOString().slice(0, 7);
                const scheduling_for = $('#filterSchedulingFor').val();
                const filterDate = $('#filterDate').val();
                Swal.fire({
                    title: 'Loading schedules...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: '/schedules/filter',
                    method: 'GET',
                    data: {
                        day,
                        month,
                        scheduling_for,
                        filterDate
                    },
                    success: function(response) {
                        const container = $('#scheduleList');
                        container.empty();

                        if (response.length === 0) {
                            container.append(
                                '<div class="text-center py-4 text-muted">No schedules found.</div>'
                            );
                            Swal.close();
                            return;
                        }

                        // Sort schedules by date ascending
                        response.sort((a, b) => new Date(a.date) - new Date(b.date));

                        // Group schedules by date
                        const groupedSchedules = response.reduce((groups, schedule) => {
                            const date = schedule.date;

                            if (!groups[date]) {
                                groups[date] = [];
                            }
                            groups[date].push(schedule);
                            return groups;
                        }, {});

                        // Loop through grouped schedules and create collapsible sections
                        for (const [date, schedules] of Object.entries(groupedSchedules)) {
                            const slots = schedules[0].slots;
                            const booked = schedules[0].booked_count;
                            let section = `
            <div class="accordion-item">
                <h2 class="accordion-header d-flex justify-content-between align-items-center" id="heading-${date}">
        <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${date}" aria-expanded="false" aria-controls="collapse-${date}">
            <img src="{{ asset('assets/img/calendar.png') }}" class="img-fluid me-2" alt="Calendar">
            ${date} <span class="badge bg-primary ms-3">Slots: ${slots}</span> <span class="badge bg-success ms-2">Booked: ${booked}</span>
        </button>
        <div class="ms-auto me-3 d-flex">
    ${canEditSchedule ? `
            <button class="btn btn-sm btn-falcon-warning bg-gradient edit-slots-btn ms-2"
                title="Edit Slots"
                data-date="${date}"
                data-slots="${slots}">
                <i class="fas fa-pen"></i>
            </button>` : ''}

    ${canDeleteSchedule ? `
            <button class="btn btn-sm btn-falcon-danger bg-gradient delete-date-btn ms-2"
                title="Delete All for ${date}"
                data-date="${date}">
                <i class="fas fa-trash-alt"></i>
            </button>` : ''}
</div>
    </h2>
                <div id="collapse-${date}" class="accordion-collapse collapse" aria-labelledby="heading-${date}" data-bs-parent="#scheduleList">
                    <div class="accordion-body">
                        <div class="row">
        `;

                            // Add schedule cards within this date section
                            schedules.forEach(schedule => {
                                let card = `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge badge-subtle-primary"><i class="fas fa-calendar-check me-1"></i> ${getSchedulingForText(schedule.scheduling_for)}</span>
                                <div>
    ${canEditSchedule ? `
                <button class="btn btn-sm btn-falcon-primary bg-gradient edit-btn me-1" title="Edit" data-id="${schedule.id}">
                    <i class="fas fa-edit"></i>
                </button>` : ''}
    ${canDeleteSchedule ? `
                <button class="btn btn-sm btn-falcon-danger bg-gradient delete-btn" title="Delete" data-id="${schedule.id}">
                    <i class="fas fa-trash-alt"></i>
                </button>` : ''}
</div>
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-calendar-day text-success me-2"></i>
                                    <strong>${schedule.date}</strong> <span class="text-muted">(${schedule.day})</span>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    ${schedule.from_time} <i class="fas fa-arrow-right mx-1"></i> ${schedule.to_time}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>`;
                                section += card;
                            });

                            section += `
                        </div> <!-- End row -->
                    </div> <!-- End accordion-body -->
                </div> <!-- End accordion-collapse -->
            </div> <!-- End accordion-item -->
        `;

                            container.append(section);
                        }
                        Swal.close();
                    },
                    error: function() {
                        Swal.fire('Error', 'Could not load schedules', 'error');
                    }
                });
            }

            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Delete Schedule?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/schedules/${id}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            success: function() {
                                Swal.fire('Deleted!', 'Schedule has been deleted.',
                                    'success');
                                loadSchedules();
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete schedule',
                                    'error');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.delete-date-btn', function() {
                const date = $(this).data('date');
                Swal.fire({
                    title: `Delete all schedules for ${date}?`,
                    text: 'This will delete every schedule on this date. Action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete all!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/schedules/delete-by-date`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                date: date
                            },
                            success: function() {
                                Swal.fire('Deleted!',
                                    'All schedules for this date have been deleted.',
                                    'success');
                                loadSchedules();
                            },
                            error: function() {
                                Swal.fire('Error',
                                    'Failed to delete schedules for the date.',
                                    'error');
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.edit-btn', function() {
                Swal.fire({
                    title: 'Please Wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                var id = $(this).data('id');

                $.ajax({
                    url: '/schedules/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        // Set hidden ID (add this hidden input to your form if not already)
                        $('#editScheduleId').val(data.id);

                        $('#edit_start_time').val(data.from_time);
                        $('#edit_end_time').val(data.to_time);

                        // Scheduling checkboxes
                        $('input[name="scheduling_for"]').prop('checked', false); // Reset first
                        if (Array.isArray(data.scheduling_for)) {
                            $('input[name="scheduling_for"][value="' + val + '"]').prop(
                                'checked', true);
                        } else {
                            $('input[name="scheduling_for"][value="' + data.scheduling_for +
                                '"]').prop('checked', true);
                        }

                        Swal.close();
                        $('#editScheduleModal').modal('show');
                    },
                    error: function() {
                        Swal.fire('Error', 'Could not load schedule details', 'error');
                    }
                });
            });


            $('#updateScheduleForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Please Wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                var id = $('#editScheduleId').val();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/schedules/' + id,
                    method: 'PUT',
                    data: formData,
                    success: function() {
                        $('#editScheduleModal').modal('hide');
                        Swal.fire('Success', 'Schedule updated successfully', 'success');
                        Swal.close();
                        loadSchedules();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        let msg = xhr.responseJSON?.message || 'Update failed';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });

            // Edit Slot
            $(document).on('click', '.edit-slots-btn', function() {
                const date = $(this).data('date');
                const slots = $(this).data('slots');

                $('#editScheduleDate').val(date);
                $('#newSlots').val(slots);
                $('#editSlotsDate').text(date);

                $('#editSlotsModal').modal('show');
            });

            // Update Slot with SweetAlert loader
            $('#editSlotsForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                // Show SweetAlert loading
                Swal.fire({
                    title: 'Updating Slots...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/schedules/update-slots-by-date',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#editSlotsModal').modal('hide');
                        Swal.fire('Updated!', response.message, 'success');
                        $('#filterForm').submit(); // Optional, if you use it to re-filter
                        loadSchedules(); // Reload schedule list
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to update slots.', 'error');
                    }
                });
            });






        });
    </script>
@endsection
