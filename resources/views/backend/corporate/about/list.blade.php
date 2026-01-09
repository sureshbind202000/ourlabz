@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Corporate About</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <form class="row" id="updateAbout" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id" value="{{ $about->id ?? '' }}">

                    <div class="mb-3 col-md-12">
                        <label for="title" class="form-label">Title </label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $about->title ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="heading" class="form-label">Heading</label>
                        <input type="text" class="form-control" id="heading" name="heading"
                            value="{{ $about->heading ?? '' }}" placeholder="Enter heading">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content" class="form-label">Contnet</label>
                        <textarea name="content" id="content" rows="5" class="form-control" placeholder="Enter Contnet">{{ $about->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($about->image ?? '') }}" alt="" height="100">
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
            $('#updateAbout').submit(function(e) {
                e.preventDefault();

                let aboutId = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                // SweetAlert loading indicator
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating about...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/corporate/about/' + aboutId,
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
