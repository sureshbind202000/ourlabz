@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Website Enquiries</h5>
            </div>
        </div>
    </div>

    <div class="card-body pt-0">

        <div id="tableExample3" data-list='{"valueNames":["name","email","subject","date"],"page":10,"pagination":true}'>

            <div class="row justify-content-end g-0">
                <div class="col-auto col-sm-5 mb-3">
                    <form>
                        <div class="input-group">
                            <input class="form-control form-control-sm shadow-none search"
                                   type="search" placeholder="Search..." aria-label="search"/>
                            <div class="input-group-text bg-transparent">
                                <span class="fa fa-search fs-10 text-600"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive scrollbar">
                <table class="table table-bordered table-striped fs-10 mb-0">
                    <thead class="bg-200">
                        <tr>
                            <th>S.No.</th>
                            <th data-sort="name">Name</th>
                            <th data-sort="email">Email</th>
                            <th data-sort="subject">Subject</th>
                            <th>Message</th>
                            <th data-sort="date">Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="list">
                        @foreach($enquiries as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="name">{{ $item->name }}</td>
                            <td class="email">{{ $item->email }}</td>
                            <td class="subject">{{ $item->subject }}</td>
                            <td>{{ Str::limit($item->message, 60) }}</td>
                            <td class="date">{{ $item->created_at->format('d M Y, h:i A') }}</td>

                            <td>
                                <button class="btn btn-sm btn-danger deleteEnquiry" data-id="{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" data-list-pagination="prev">
                    <span class="fas fa-chevron-left"></span>
                </button>

                <ul class="pagination mb-0"></ul>

                <button class="btn btn-sm btn-falcon-default ms-1" type="button" data-list-pagination="next">
                    <span class="fas fa-chevron-right"></span>
                </button>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).on('click', '.deleteEnquiry', function() {
        let id = $(this).data('id');
        let url = "{{ route('website.contact.enquiry.delete', ':id') }}".replace(':id', id);

        Swal.fire({
            title: "Are you sure?",
            text: "This enquiry will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        Swal.fire("Deleted!", res.message, "success").then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    });
</script>
@endsection