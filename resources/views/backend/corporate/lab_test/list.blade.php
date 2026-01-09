@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Corporate Lab Test</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <form class="row" id="updateLabTest" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id" value="{{ $lab_test->id ?? '' }}">

                    <div class="mb-3 col-md-12">
                        <label for="title" class="form-label">Title </label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $lab_test->title ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content" class="form-label">Contnet</label>
                        <textarea name="content" id="content" rows="5" class="form-control" placeholder="Enter Contnet">{{ $lab_test->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($lab_test->image ?? '') }}" alt="" height="100">
                    </div>


                    <div class="mb-3">
                        <button class="btn btn-falcon-primary me-2">Submit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <!-- Edit Package Modal End -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            // Update AJAX
            $('#updateLabTest').submit(function(e) {
                e.preventDefault();

                let labTestId = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                // SweetAlert loading indicator
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating lab test content...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/corporate-lab-test/' + labTestId,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.close();
                        Swal.fire("Success!", response.success, "success");
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.close();
                        let errorMessage = "Something went wrong.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire("Error!", errorMessage, "error");
                    }
                });
            });

        });
    </script>
@endsection
