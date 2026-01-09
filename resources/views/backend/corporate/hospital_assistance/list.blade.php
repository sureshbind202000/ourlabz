@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Corporate Hospital Assistance</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <form class="row" id="updateHospitalAssistance" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id" value="{{ $hospital_assistance->id ?? '' }}">

                    <div class="mb-3 col-md-12">
                        <label for="title" class="form-label">Title </label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $hospital_assistance->title ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="heading" class="form-label">Heading </label>
                        <input type="text" class="form-control" id="heading" name="heading"
                            value="{{ $hospital_assistance->heading ?? '' }}" placeholder="Enter heading.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content" class="form-label">Contnet</label>
                        <textarea name="content" id="content" rows="5" class="form-control" placeholder="Enter Contnet">{{ $hospital_assistance->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($hospital_assistance->image ?? '') }}" alt="" height="100">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="heading2" class="form-label">Heading 2 </label>
                        <input type="text" class="form-control" id="heading2" name="heading2"
                            value="{{ $hospital_assistance->heading2 ?? '' }}" placeholder="Enter heading.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content2" class="form-label">Contnet 2</label>
                        <textarea name="content2" id="content2" rows="5" class="form-control" placeholder="Enter Contnet">{{ $hospital_assistance->content2 ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_title1" class="form-label">Card Title 1</label>
                        <input type="text" class="form-control" id="card_title1" name="card_title1"
                            value="{{ $hospital_assistance->card_title1 ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_content1" class="form-label">Card Contnet1</label>
                        <textarea name="card_content1" id="card_content1" rows="5" class="form-control" placeholder="Enter Contnet">{{ $hospital_assistance->card_content1 ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_image1" class="form-label">Card Image 1</label>
                        <input type="file" name="card_image1" id="card_image1" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image1" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($hospital_assistance->card_image1 ?? '') }}" alt="" height="100">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_title2" class="form-label">Card Title 2</label>
                        <input type="text" class="form-control" id="card_title2" name="card_title2"
                            value="{{ $hospital_assistance->card_title2 ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_content2" class="form-label">Card Contnet2</label>
                        <textarea name="card_content2" id="card_content2" rows="5" class="form-control" placeholder="Enter Contnet">{{ $hospital_assistance->card_content2 ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_image2" class="form-label">Card Image 2</label>
                        <input type="file" name="card_image2" id="card_image2" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="card_image2" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($hospital_assistance->card_image2 ?? '') }}" alt="" height="100">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_title3" class="form-label">Card Title 3</label>
                        <input type="text" class="form-control" id="card_title3" name="card_title3"
                            value="{{ $hospital_assistance->card_title3 ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="card_content3" class="form-label">Card Contnet3</label>
                        <textarea name="card_content3" id="card_content3" rows="5" class="form-control" placeholder="Enter Contnet">{{ $hospital_assistance->card_content3 ?? '' }}</textarea>
                    </div>


                    <div class="mb-3 col-md-12">
                        <label for="card_image3" class="form-label">Card Image 2</label>
                        <input type="file" name="card_image3" id="card_image3" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="card_image3" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($hospital_assistance->card_image3 ?? '') }}" alt="" height="100">
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
            $('#updateHospitalAssistance').submit(function(e) {
                e.preventDefault();

                let hospitalAssistanceId = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                // SweetAlert loading indicator
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating hospital assistance content...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/corporate-hospital-assistance/' + hospitalAssistanceId,
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
