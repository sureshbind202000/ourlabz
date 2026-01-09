@extends('backend.includes.layout')
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor">Homepage Features </h5>
            </div>
            <div class="col-auto align-self-center">
                <a href="https://fontawesome.com/search?ic=free" target="_blank">Search Icon <i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="tab-content">

           <form class="row" id="updateFeature" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id" value="{{$feature->id}}">
                   
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary bg-gradient rounded-circle fw-bold">1</button>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="icon" class="form-label">Icon </label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{$feature->icon}}" placeholder="Paste the fontawsome icon code">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$feature->title}}" placeholder="Enter feature title">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="content" class="form-label">Content</label>
                        <input type="text" class="form-control" id="content" name="content" value="{{$feature->content}}" placeholder="Enter feature content " maxlength="30">
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary bg-gradient rounded-circle fw-bold">2</button>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="icon2" class="form-label">Icon</label>
                        <input type="text" class="form-control" id="icon2" name="icon2" value="{{$feature->icon2}}" placeholder="Paste the fontawsome icon code">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="title2" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title2" name="title2" value="{{$feature->title2}}" placeholder="Enter feature title">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="content2" class="form-label">Content</label>
                        <input type="text" class="form-control" id="content2" name="content2" value="{{$feature->content2}}" placeholder="Enter feature content " maxlength="30">
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary bg-gradient rounded-circle fw-bold">3</button>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="icon3" class="form-label">Icon</label>
                        <input type="text" class="form-control" id="icon3" name="icon3" value="{{$feature->icon3}}" placeholder="Paste the fontawsome icon code">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="title3" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title3" name="title3" value="{{$feature->title3}}" placeholder="Enter feature title">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="content3" class="form-label">Content</label>
                        <input type="text" class="form-control" id="content3" name="content3" value="{{$feature->content3}}" placeholder="Enter feature content " maxlength="30">
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary bg-gradient rounded-circle fw-bold">4</button>
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="icon4" class="form-label">Icon</label>
                        <input type="text" class="form-control" id="icon4" name="icon4" value="{{$feature->icon4}}" placeholder="Paste the fontawsome icon code">
                    </div>

                    <div class="mb-4 col-md-4">
                        <label for="title4" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title4" name="title4" value="{{$feature->title4}}" placeholder="Enter feature title">
                    </div>

                    <div class="mb-4 col-md-4">
                        <label for="content4" class="form-label">Content</label>
                        <input type="text" class="form-control" id="content4" name="content4" value="{{$feature->content4}}" placeholder="Enter feature content " maxlength="30">
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
        $('#updateFeature').submit(function(e) {
            e.preventDefault();

            let featureId = $('#edit_id').val();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            // SweetAlert loading indicator
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating feature...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/website/home/feature/' + featureId,
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