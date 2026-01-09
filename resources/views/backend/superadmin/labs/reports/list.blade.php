@extends('backend.includes.layout')

@section('css')

    <style>

        .print-animate {

            animation: printReveal 2s ease-in-out forwards;

            transform-origin: top center;

            overflow: hidden;

            display: inline-block;

            width: 100%;

        }



        @keyframes printReveal {

            0% {

                clip-path: inset(0 0 100% 0);

                opacity: 0;

            }



            30% {

                opacity: 1;

            }



            100% {

                clip-path: inset(0 0 0 0);

                opacity: 1;

            }

        }

    </style>

@endsection

@section('content')

    <div class="row g-3 mb-3">

        <div class="col-xxl-12 col-xxl-12 order-xxl-1 order-lg-2 order-1">

            <div class="card h-100 bg-transparent shadow-none">

                <div class="card-header d-flex flex-between-center bg-white">

                    <h5 class="mb-0 text-nowrap py-2 py-xl-0">Lab Report Layout</h5>

                    <button id="load-preview-btn" class="btn btn-sm btn-falcon-primary ms-auto">

                        <i class="fa-solid fa-eye"></i> Load Preview

                    </button>

                    @if (has_permission('report-layout', 'create'))

                        <button class="btn btn-sm btn-primary bg-gradient ms-2" data-bs-toggle="modal"

                            data-bs-target="#layout-form-modal"><i class="fa-solid fa-plus"></i> Generate Layout</button>

                    @endif

                </div>

                <div class="card-body p-0">

                    <div class="h-100 w-75 mx-auto" id="report-preview">



                    </div>

                </div>

            </div>

        </div>



    </div>

    <div class="modal fade" id="layout-form-modal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">

            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">

                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"

                        data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">

                        <h4 class="mb-1" id="modalExampleDemoLabel">Upload Files </h4>

                    </div>

                    <div class="p-4">



                        <form id="generate-report-form" enctype="multipart/form-data">

                            <div class="row g-3 h-100">

                                <div class="col-12">

                                    <label class="form-label">

                                        Upload Header <span class="text-danger">*</span>

                                        <small class="text-muted fw-bold fs-11">(Full width, Recommended:

                                            1200×150px)</small>

                                    </label>

                                    <input class="form-control" type="file" name="header" accept="image/*" required />

                                </div>



                                <div class="col-12">

                                    <label class="form-label">

                                        Upload Footer <span class="text-danger">*</span>

                                        <small class="text-muted fw-bold fs-11">(Full width, Recommended:

                                            1200×120px)</small>

                                    </label>

                                    <input class="form-control" type="file" name="footer" accept="image/*" required />

                                </div>

                                <div class="col-12 mb-3">

                                    <input type="hidden" name="lab_id" value="{{ auth()->user()->lab_id }}">

                                    <button type="submit" class="btn btn-primary w-100" id="generateBtn">

                                        <i class="fa-solid fa-plus"></i> Generate

                                    </button>

                                </div>

                            </div>

                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>

        $(document).ready(function() {

            $('#generate-report-form').on('submit', function(e) {

                e.preventDefault();



                const formData = new FormData(this);



                Swal.fire({

                    title: 'Uploading...',

                    text: 'Please wait while the layout is being uploaded.',

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                    }

                });



                $.ajax({

                    url: "{{ route('report.layout.upload') }}",

                    type: "POST",

                    data: formData,

                    contentType: false,

                    processData: false,

                    success: function(response) {

                        Swal.close();



                        if (response.success) {

                            Swal.fire("Success!", response.message, "success");

                            $('#report-preview').html(response.preview_html);

                            window.location.reload();

                        } else {

                            Swal.fire("Error!", response.message, "error");

                        }

                    },

                    error: function(xhr) {

                        Swal.close();

                        Swal.fire("Error!", "Something went wrong.", "error");

                    }

                });

            });



            function loadReportPreview() {

                $.ajax({

                    url: "{{ route('report.layout.preview') }}",

                    method: "GET",

                    beforeSend: function() {

                        $('#report-preview').html(

                            '<div class="text-center p-5">Loading preview...</div>');

                    },

                    success: function(response) {

                        if (response.success) {

                            const animatedHtml = `<div class="print-animate">${response.html}</div>`;

                            $('#report-preview').html(animatedHtml);



                            // Optional scroll to preview

                            $('html, body').animate({

                                scrollTop: $('#report-preview').offset().top - 50

                            }, 500);

                        } else {

                            $('#report-preview').html('<div class="text-center text-muted">' + response

                                .html + '</div>');

                        }

                    },

                    error: function(xhr) {

                        console.log(xhr);

                        $('#report-preview').html(

                            '<div class="text-danger text-center p-4">Failed to load layout preview.</div>'

                        );

                    }

                });

            }



            // 🔁 Run on button click

            $('#load-preview-btn').on('click', loadReportPreview);





            loadReportPreview();











        });

    </script>

@endsection

