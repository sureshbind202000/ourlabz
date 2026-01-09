@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">All Comments</h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

            <div id="tableExample3" data-list='{"valueNames":["blog","name","email","rating"],"page":10,"pagination":true}'>
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
                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-200">
                            <tr>
                                <th class="text-900">S.No.</th>
                                <th class="text-900" data-sort="blog">Blog</th>
                                <th class="text-900" data-sort="name">Name</th>
                                <th class="text-900" data-sort="email">Email</th>
                                <th class="text-900">Comment</th>
                                <th class="text-900" data-sort="rating">Rating</th>
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
@endsection
@section('js')
<script>
    $(document).ready(function() {

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
        fetchComment();

        function fetchComment() {
            Swal.fire({
                title: 'Please wait...',
                text: 'Loading Comments...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('website.blog.comment.list') }}",
                type: "GET",
                success: function(data) {
                    Swal.close();
                    let rows = "";
                    $.each(data, function(index, comment) {
                        rows += `<tr>
                        <td>${index + 1}</td>
                        <td class="blog">
                         <a href="/blog/${comment.blog.slug}" target="_blank">${comment.blog.title}</a>
                        </td>
                        <td class="name">
                         ${comment.name}
                        </td>
                        <td class="email">
                         ${comment.email}
                        </td>
                        <td>
                         ${comment.comment}
                        </td>
                        <td class="rating">
                         ${comment.rating}
                        </td>
                        <td class="status">
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${comment.id}" ${comment.is_active == 1 ? 'checked' : ''} />
                        </div>
                        </td>
                        <td class="date">${formatDate(comment.created_at)}</td>
                        <td>
                        <div>
                            <button class="btn btn-link p-0  delete-btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="${comment.id}">
                            <span class="text-danger fas fa-trash-alt"></span>
                            </button>
                        </div>
                        </td>
                    </tr>`;
                    });
                    $("tbody.list").html(rows);
                    new List('tableExample3', {
                        valueNames: ['author', 'title', 'date'],
                        page: 10,
                        pagination: true
                    });
                }
            });
        }

        // Delete 
        $(document).on('click', '.delete-btn', function() {
            let commentId = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will delete the comment!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // SweetAlert loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Deleting comment...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/website/blog/comment/${commentId}`,
                        type: "DELETE",
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire("Deleted!",
                                    "The comment have been deleted.",
                                    "success");
                                fetchComment();
                            } else {
                                Swal.fire("Error!", "Something went wrong.",
                                    "error");
                            }

                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire("Error!", "Failed to delete comment.",
                                "error");
                        }
                    });
                }
            });
        });

        $(document).on('change', '.status-toggle', function() {
            var commentId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('website.blog.comment.status') }}",
                type: "POST",
                data: {
                    id: commentId,
                    status: status
                },
                beforeSend: function() {
                    // SweetAlert loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Updating status...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Status updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    fetchComment();
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

    });
</script>
@endsection