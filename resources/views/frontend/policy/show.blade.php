@extends('frontend.includes.layout')
@section('seo_tags')
<title>{{ $policy->title }}</title>
@endsection
@section('content')



<main class="main">

    <!-- privacy policy -->

    <div class="py-100">

        <div class="container">
            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">

                        <h2 class="site-title">{{ $policy->title }}</span></h2>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col">

                    <div class="terms-content">
                        {!! $policy->content !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- privacy policy end -->



</main>





@endsection

@section('js')



@endsection