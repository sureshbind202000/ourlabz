@extends('frontend.includes.layout')

@section('css')



@endsection

@section('content')



<main class="main">

    <!-- blog area -->

    <div class="blog-area py-100">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 mx-auto">

                    <div class="site-heading text-center">

                        <span class="site-title-tagline">Our Blog</span>

                        <h2 class="site-title">Our Latest News & <span>Blog</span></h2>

                    </div>

                </div>

            </div>

            <div class="row g-4">

                @foreach ($blogs as $blog)

                <div class="col-md-6 col-lg-4">

                    <div class="blog-item wow fadeInUp" data-wow-delay=".25s">

                        <div class="blog-item-img">

                            <img src="{{ asset($blog->thumbnail_image) }}" alt="Thumb">

                            <span class="blog-date"><i class="far fa-calendar-alt"></i>

                                {{ $blog->created_at->format('M d, Y') }}</span>

                        </div>

                        <div class="blog-item-info">

                            <div class="blog-item-meta">

                                <ul>

                                    <li><a href="{{ route('blog.details', ['slug' => $blog->slug]) }}"><i

                                                class="far fa-user-circle"></i> By {{ $blog->author }}</a>

                                    </li>

                                    <li><a

                                            href="{{ route('blog.details', ['slug' => $blog->slug]) }}#comment-section"><i

                                                class="far fa-comments"></i>

                                            {{ formatCount($blog->comments_count) }} Comments</a></li>

                                </ul>

                            </div>

                            <h4 class="blog-title">

                                <a

                                    href="{{ route('blog.details', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a>

                            </h4>

                            <p>{{ $blog->short_content }}</p>

                            <a class="theme-btn" href="{{ url('/blog', ['slug' => $blog->slug]) }}">Read

                                More<i class="fas fa-arrow-right"></i></a>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            <!-- pagination -->

            <div class="pagination-area mt-60">

                {{ $blogs->links('vendor.pagination.custom') }}

            </div>

            <!-- pagination end -->

        </div>

    </div>

    <!-- blog area end -->



</main>



@endsection

@section('js')



@endsection