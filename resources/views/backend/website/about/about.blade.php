@extends('backend.includes.layout')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Website About</h5>
    </div>

    <div class="card-body">
        <form class="row" id="updateAbout" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id" name="id" value="{{ $about->id ?? '' }}">

            <!-- Heading -->
            <div class="mb-3 col-md-12">
                <label for="heading" class="form-label">Heading</label>
                <input type="text" class="form-control" id="heading" name="heading"
                    value="{{ $about->heading ?? '' }}" placeholder="Enter heading">
            </div>

            <!-- About Content -->
            <div class="mb-3 col-md-12">
                <label for="about_content" class="form-label">About Content</label>
                <textarea name="about_content" id="about_content" rows="5" class="form-control" placeholder="Enter content">{{ $about->about_content ?? '' }}</textarea>
            </div>

            <!-- Primary Image -->
            <div class="mb-3 col-md-6">
                <label for="primary_image" class="form-label">Primary Image</label>
                <input type="file" name="primary_image" id="primary_image" class="form-control">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Primary Image Preview</label>
                <br>
                @if(!empty($about->primary_image))
                <img src="{{ asset($about->primary_image) }}" alt="Primary Image" height="100">
                @endif
            </div>

            <!-- Secondary Image -->
            <div class="mb-3 col-md-6">
                <label for="secondary_image" class="form-label">Secondary Image</label>
                <input type="file" name="secondary_image" id="secondary_image" class="form-control">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Secondary Image Preview</label>
                <br>
                @if(!empty($about->secondary_image))
                <img src="{{ asset($about->secondary_image) }}" alt="Secondary Image" height="100">
                @endif
            </div>

            <!-- Experience Years -->
            <div class="mb-3 col-md-4">
                <label for="experience_years" class="form-label">Years of Experience</label>
                <input type="number" min="0" class="form-control" id="experience_years" name="experience_years"
                    value="{{ $about->experience_years ?? 0 }}">
            </div>

            <!-- Link -->
            <div class="mb-3 col-md-8">
                <label for="link" class="form-label">Optional Link</label>
                <input type="text" class="form-control" id="link" name="link" value="{{ $about->link ?? '' }}" placeholder="Enter link">
            </div>

            <!-- Keypoints -->
            <div class="mb-3 col-md-12">
                <label for="keypoints" class="form-label">Key Points</label>
                <div id="keypoints_wrapper">
                    @php
                    $keypoints = !empty($about->keypoints) ? $about->keypoints : [];
                    @endphp

                    @if(!empty($keypoints))
                    @foreach($keypoints as $index => $point)
                    <div class="input-group mb-2">
                        <input type="text" name="keypoints[]" class="form-control" value="{{ $point }}" placeholder="Enter key point">
                        <button class="btn btn-danger remove-keypoint" type="button">Remove</button>
                    </div>
                    @endforeach
                    @else
                    <div class="input-group mb-2">
                        <input type="text" name="keypoints[]" class="form-control" placeholder="Enter key point">
                        <button class="btn btn-danger remove-keypoint" type="button">Remove</button>
                    </div>
                    @endif
                </div>
                <button type="button" id="add_keypoint" class="btn btn-secondary btn-sm mt-2">Add Key Point</button>
            </div>

            <!-- Counts -->
            <div class="mb-3 col-md-3">
                <label for="total_sales" class="form-label">Total Sales (<i class="fa-solid fa-k"></i>)</label>
                <input type="number" min="0" class="form-control" id="total_sales" name="total_sales"
                    value="{{ $about->total_sales ?? 0 }}">
            </div>
            <div class="mb-3 col-md-3">
                <label for="happy_clients" class="form-label">Happy Clients (<i class="fa-solid fa-k"></i>)</label>
                <input type="number" min="0" class="form-control" id="happy_clients" name="happy_clients"
                    value="{{ $about->happy_clients ?? 0 }}">
            </div>
            <div class="mb-3 col-md-3">
                <label for="team_workers" class="form-label">Team Workers (<i class="fa-solid fa-plus"></i>)</label>
                <input type="number" min="0" class="form-control" id="team_workers" name="team_workers"
                    value="{{ $about->team_workers ?? 0 }}">
            </div>
            <div class="mb-3 col-md-3">
                <label for="win_awards" class="form-label">Win Awards (<i class="fa-solid fa-plus"></i>)</label>
                <input type="number" min="0" class="form-control" id="win_awards" name="win_awards"
                    value="{{ $about->win_awards ?? 0 }}">
            </div>

            <div class="mb-3 col-md-12">
                <button class="btn btn-falcon-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {

        // Add Keypoint
        $('#add_keypoint').click(function() {
            let keypointField = `
        <div class="input-group mb-2">
            <input type="text" name="keypoints[]" class="form-control" placeholder="Enter key point">
            <button class="btn btn-danger remove-keypoint" type="button">Remove</button>
        </div>`;
            $('#keypoints_wrapper').append(keypointField);
        });

        // Remove Keypoint
        $(document).on('click', '.remove-keypoint', function() {
            $(this).closest('.input-group').remove();
        });

        // Update AJAX
        $('#updateAbout').submit(function(e) {
            e.preventDefault();

            let aboutId = $('#edit_id').val();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Please wait...',
                text: 'Updating about...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/website/about-update/' + aboutId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
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