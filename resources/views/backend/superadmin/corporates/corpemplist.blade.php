@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">All Employees</h5>
                <input type="hidden" name="corpId" id="corpId" value="{{$id}}">
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
                                <th class="text-900" data-sort="phone">Email</th>
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

@endsection
@section('js')
<script>
    $(document).ready(function() {
        fetchEmployees();

        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function fetchEmployees() {
            var corpId= $('#corpId').val();
            $.ajax({
                url: "{{ route('corporate.get.empList') }}",
                type: "GET",
                data:{
                    corpId:corpId
                },
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
                            <td>${employee.created_at ? formatDate(employee.created_at) : '-'}</td>
                            <td>
                             <a class="btn btn-link p-0 " href="{{ url('/') }}/employee/${employee.user_id}/profile" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View" data-id="${employee.id}"><span
                                                    class="text-secondary fas fa-eye"></span></a>
                                                          
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
    });
</script>
@endsection