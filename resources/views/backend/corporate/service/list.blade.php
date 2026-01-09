@extends('backend.includes.layout')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                    <h5 class="mb-0" data-anchor="data-anchor">Corporate Services</h5>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="tab-content">

                <form class="row" id="updateService" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="edit_id" name="id" value="{{ $service->id ?? '' }}">

                    <div class="mb-3 col-md-12">
                        <label for="title" class="form-label">Title </label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $service->title ?? '' }}" placeholder="Enter title.">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="heading" class="form-label">Heading</label>
                        <input type="text" class="form-control" id="heading" name="heading"
                            value="{{ $service->heading ?? '' }}" placeholder="Enter heading">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" name="banner" id="banner" class="form-control">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="banner" class="form-label">Preview Banner</label>
                        <br>
                        <img src="{{ asset($service->banner ?? '') }}" alt="" height="100">
                    </div>

                    <h6 class="text-primary">
                        Online Consultation <i class="fa-solid fa-arrow-down"></i>
                    </h6>

                    <div class="mb-3 col-md-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $service->name ?? '' }}" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content" class="form-label">Contnet</label>
                        <textarea name="content" id="content" rows="3" class="form-control" placeholder="Enter Contnet">{{ $service->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($service->image ?? '') }}" alt="" height="100">
                    </div>

                    <h6 class="text-primary">
                        In-Clinic Consultation <i class="fa-solid fa-arrow-down"></i>
                    </h6>

                    <div class="mb-3 col-md-12">
                        <label for="name2" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name2" name="name2"
                            value="{{ $service->name2 ?? '' }}" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content2" class="form-label">Contnet</label>
                        <textarea name="content2" id="content2" rows="3" class="form-control" placeholder="Enter Contnet">{{ $service->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image2" class="form-label">Image</label>
                        <input type="file" name="image2" id="image2" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image2" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($service->image2 ?? '') }}" alt="" height="100">
                    </div>

                    <h6 class="text-primary">
                        Lab Tests <i class="fa-solid fa-arrow-down"></i>
                    </h6>

                    <div class="mb-3 col-md-12">
                        <label for="name3" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name3" name="name3"
                            value="{{ $service->name3 ?? '' }}" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content3" class="form-label">Contnet</label>
                        <textarea name="content3" id="content3" rows="3" class="form-control" placeholder="Enter Contnet">{{ $service->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image3" class="form-label">Image</label>
                        <input type="file" name="image3" id="image3" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image3" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($service->image3 ?? '') }}" alt="" height="100">
                    </div>


                    <h6 class="text-primary">
                        View All Services <i class="fa-solid fa-arrow-down"></i>
                    </h6>

                    <div class="mb-3 col-md-12">
                        <label for="name4" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name4" name="name4"
                            value="{{ $service->name4 ?? '' }}" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content4" class="form-label">Contnet</label>
                        <textarea name="content4" id="content4" rows="3" class="form-control" placeholder="Enter Contnet">{{ $service->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image4" class="form-label">Image</label>
                        <input type="file" name="image4" id="image4" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image4" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($service->image4 ?? '') }}" alt="" height="100">
                    </div>

                    <h6 class="text-primary">
                        Hospital Assistance <i class="fa-solid fa-arrow-down"></i>
                    </h6>

                    <div class="mb-3 col-md-12">
                        <label for="name5" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name5" name="name5"
                            value="{{ $service->name5 ?? '' }}" placeholder="Enter name">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="content5" class="form-label">Contnet</label>
                        <textarea name="content5" id="content5" rows="3" class="form-control" placeholder="Enter Contnet">{{ $service->content ?? '' }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="image5" class="form-label">Image</label>
                        <input type="file" name="image5" id="image5" class="form-control">
                    </div>

                    <div class="mb-5 col-md-12">
                        <label for="image5" class="form-label">Image Preview</label>
                        <br>
                        <img src="{{ asset($service->image5 ?? '') }}" alt="" height="100">
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
            $('#updateService').submit(function(e) {
                e.preventDefault();

                let serviceId = $('#edit_id').val();
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                // SweetAlert loading indicator
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Updating service...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/corporate-service/' + serviceId,
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
