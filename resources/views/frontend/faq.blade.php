@extends('frontend.includes.layout')

@section('css')



@endsection

@section('content')



<main class="main">

    <!-- faq area -->

    <div class="faq-area py-100">

        <div class="container">
            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">


                        <h2 class="site-title">FAQ's</h2>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-12">
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $key }}">
                                <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}"
                                    aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $key }}">
                                    <span><i class="far fa-question-circle me-2"></i></span>
                                    {{ $faq->question }}
                                </button>
                            </h2>

                            <div id="collapse{{ $key }}"
                                class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $key }}"
                                data-bs-parent="#faqAccordion">

                                <div class="accordion-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>

            </div>

        </div>

    </div>

    <!-- faq area end -->



</main>



@endsection

@section('js')



@endsection