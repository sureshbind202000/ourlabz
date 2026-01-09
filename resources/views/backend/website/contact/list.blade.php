@extends('backend.includes.layout')

@section('content')

<div class="card mb-3">

    <div class="card-header">

        <div class="row flex-between-end">

            <div class="col-auto align-self-center">

                <h5 class="mb-0" data-anchor="data-anchor">Website Contact Us</h5>

            </div>

        </div>

    </div>

    <div class="card-body pt-0">

        <div class="tab-content">



            <form class="row text-dark" id="updateContact" method="POST">
                @csrf
                <input type="hidden" id="edit_id" name="id" value="{{ $contact->id ?? '' }}">

                <div class="mb-3 col-md-12">
                    <label for="about" class="form-label">About</label>
                    <textarea name="about" id="about" class="form-control" placeholder="Enter short about">{{ $contact->about ?? '' }}</textarea>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="office_address" class="form-label">Office Address</label>
                    <textarea name="office_address" id="office_address" class="form-control" placeholder="Enter office address">{{ $contact->office_address ?? '' }}</textarea>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="facebook" class="form-label">Facebook Link</label>
                    <input type="text" name="facebook" id="facebook" class="form-control" value="{{ $contact->facebook ?? '' }}" placeholder="Enter facebook link">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="twitter" class="form-label">Twitter Link</label>
                    <input type="text" name="twitter" id="twitter" class="form-control" value="{{ $contact->twitter ?? '' }}" placeholder="Enter twitter link">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="linkedin" class="form-label">LinkedIn Link</label>
                    <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ $contact->linkedin ?? '' }}" placeholder="Enter linkedin link">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="youtube" class="form-label">Youtube Link</label>
                    <input type="text" name="youtube" id="youtube" class="form-control" value="{{ $contact->youtube ?? '' }}" placeholder="Enter youtube link">
                </div>

                 <div class="mb-3 col-md-12">
                    <label for="map_address" class="form-label">Google Map Embed Code</label>
                    <textarea name="map_address" id="map_address" class="form-control" placeholder="Paste Google Maps Embed Code">{{ $contact->map_address ?? '' }}</textarea>
                </div>

                {{-- Phone fields --}}
                <div class="col-md-6 mb-2">
                    <label class="form-label">Phone</label>
                    <div id="phone-wrapper">
                        @if(!empty($contact->phone))
                        @foreach($contact->phone as $p)
                        <div class="d-flex mb-2 phone-row">
                            <input type="text" name="phone[]" class="form-control" value="{{ $p }}" placeholder="Enter phone">
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-phone">X</button>
                        </div>
                        @endforeach
                        @else
                        <div class="d-flex mb-2 phone-row">
                            <input type="text" name="phone[]" class="form-control" placeholder="Enter phone">
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-phone">X</button>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-success btn-sm" id="addPhone">+ Add Phone</button>
                </div>

                {{-- Email fields --}}
                <div class="col-md-6 mb-2">
                    <label class="form-label">Email</label>
                    <div id="email-wrapper">
                        @if(!empty($contact->email))
                        @foreach($contact->email as $e)
                        <div class="d-flex mb-2 email-row">
                            <input type="email" name="email[]" class="form-control" value="{{ $e }}" placeholder="Enter email">
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-email">X</button>
                        </div>
                        @endforeach
                        @else
                        <div class="d-flex mb-2 email-row">
                            <input type="email" name="email[]" class="form-control" placeholder="Enter email">
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-email">X</button>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-success btn-sm" id="addEmail">+ Add Email</button>
                </div>

                <div class="mb-3 mt-3">
                    <button class="btn btn-falcon-primary me-2" type="submit">Submit</button>
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
        $('#updateContact').submit(function(e) {
            e.preventDefault();

            let contactId = $('#edit_id').val();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            Swal.fire({
                title: 'Please wait...',
                text: 'Updating contact us...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: "/website/contact-us/" + contactId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire("Success!", response.success, "success");
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire("Error!", xhr.responseJSON?.message ?? "Something went wrong!", "error");
                }
            });
        });


    });


    $(document).ready(function() {

        // Add Phone
        $('#addPhone').click(function() {
            $('#phone-wrapper').append(`
            <div class="d-flex mb-2 phone-row">
                <input type="text" name="phone[]" class="form-control" placeholder="Enter phone">
                <button type="button" class="btn btn-sm btn-danger ms-2 remove-phone">X</button>
            </div>
        `);
        });

        // Remove Phone
        $(document).on('click', '.remove-phone', function() {
            $(this).closest('.phone-row').remove();
        });

        // Add Email
        $('#addEmail').click(function() {
            $('#email-wrapper').append(`
            <div class="d-flex mb-2 email-row">
                <input type="email" name="email[]" class="form-control" placeholder="Enter email">
                <button type="button" class="btn btn-sm btn-danger ms-2 remove-email">X</button>
            </div>
        `);
        });

        // Remove Email
        $(document).on('click', '.remove-email', function() {
            $(this).closest('.email-row').remove();
        });

    });
</script>


@endsection