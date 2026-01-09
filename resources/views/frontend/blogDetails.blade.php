@extends('frontend.includes.layout')
@section('seo_tags')
<title>{{ $blog->meta_title ?? 'Blogs' }}</title>
<meta name="description" content="{{ $blog->meta_description ?? '' }}">
<meta name="keywords" content="{{ $blog->meta_keywords ?? '' }}">
@endsection

@section('content')
<main class="main">


    <!-- blog single area -->
    <div class="blog-single-area py-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xxl-9 mx-auto">
                    <div class="blog-single-wrap">
                        <div class="blog-single-content">
                            <div class="blog-thumb-img">
                                <img src="{{asset($blog->image)}}" alt="thumb">
                            </div>
                            <div class="blog-info">
                                <div class="blog-meta">
                                    <div class="blog-meta-left">
                                        <ul>
                                            <li><i class="far fa-user"></i> <a href="javascript:void(0);">{{$blog->author}}</a></li>
                                            <li><i class="far fa-comments"></i><a href="#comment-section">{{formatCount($blog_comments->count())}} Comments</a></li>
                                            <li><i class="far fa-thumbs-up"></i><a href="javascript:void(0);" onclick="likeBlog({{$blog->id}})"><span id="like-count-{{ $blog->id }}">{{ formatCount($blog->likes) }}</span> Like </a></li>
                                            <li><i class="far fa-eye"></i>{{$blog->views}} Views</li>
                                        </ul>
                                    </div>
                                    <div class="blog-meta-right">
                                        <a href="#" class="share-link"><i class="far fa-share-alt"></i>Share</a>
                                    </div>
                                </div>
                                <div class="blog-details">
                                    {!! $blog->content !!}
                                    <hr>
                                    <div class="blog-details-tags pb-20">
                                        <h5>Tags :</h5>
                                        @php
                                        $tags = explode(',', $blog->tags);
                                        @endphp
                                        <ul>
                                            @foreach($tags as $tag)
                                            <li><a href="#{{ ucfirst(trim($tag)) }}">{{ ucfirst(trim($tag)) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="comment-section">
                    <!-- review start -->
                    <div class="row">
                        <div class="col-sm-12 wow fadeInDown" data-wow-delay=".25s">
                            <h2 class="site-title pt-80 ps-5" id="simple-list-item-6">Comments</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 wow fadeInUp" data-wow-delay=".25s">
                            <!-- testimonial area -->
                            <div class="testimonial-area">
                                <div class="container">
                                    <div class="review-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                                        @foreach($blog_comments as $comment)
                                        <div class="testimonial-item">
                                            <div class="testimonial-author">
                                                <div class="testimonial-author-img">
                                                    <img src="{{asset('assets/img/user.png')}}" alt="Profile Image" style="height:50px;width:50px;">
                                                </div>
                                                <div class="testimonial-author-info">
                                                    <h4>{{$comment->name}}</h4>
                                                </div>
                                            </div>
                                            <div class="testimonial-quote">
                                                <p>
                                                    {{$comment->comment}}
                                                </p>
                                            </div>
                                            <div class="testimonial-rate">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=$comment->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                    @else
                                                    <i class="fas fa-star"></i>
                                                    @endif
                                                    @endfor
                                            </div>
                                            <div class="testimonial-quote-icon"><img src="{{asset('assets/img/icon/quote.svg')}}" alt=""></div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div id="review-section"></div>
                            <!-- testimonial area end -->
                        </div>
                        <div class="col-lg-4 wow fadeInUp" data-wow-delay=".25s">
                            <div id="reviewform">
                                <div class="blog-comments-form mt-0">
                                    <h4 class="mb-4">Leave A Comment</h4>
                                    <form id="commentForm" method="POST" action="{{ route('blog.comment.store') }}" autocomplete="off">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                                        <input type="text" name="website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px">

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control" placeholder="Your Name*" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control" placeholder="Your Email*" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <select name="rating" class="form-control form-select" required>
                                                        <option value="">Ratings</option>
                                                        <option value="5">5</option>
                                                        <option value="4">4</option>
                                                        <option value="3">3</option>
                                                        <option value="2">2</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea name="comment" class="form-control" rows="3" placeholder="Write comment here*" required></textarea>
                                                </div>
                                                <button type="submit" class="theme-btn">
                                                    <span class="far fa-paper-plane"></span> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog single area end -->

</main>

@endsection

@section('js')
<script>
    // testimonial slider
    $('.review-slider').owlCarousel({
        loop: false,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            }
            // 1400: {
            //     items: 4
            // }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);

            // Honeypot check
            let honeypot = form.find('input[name="website"]').val().trim();
            if (honeypot !== '') {
                showToast('error', 'Spam detected!');
                return;
            }

            Swal.fire({
                title: 'Submitting...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    Swal.close();
                    showToast('success', response.message || 'Comment submitted successfully!');
                    form.trigger('reset');
                },
                error: function(xhr) {
                    Swal.close();
                    let errorText = 'Something went wrong!';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            errorText = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorText += value[0] + '\n';
                            });
                        } else if (xhr.responseJSON.error) {
                            errorText = xhr.responseJSON.error;
                        }
                    }
                    showToast('error', errorText);
                }
            });
        });


    });

    function likeBlog(blogId) {
        $.ajax({
            url: "{{ route('blog.like') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                blog_id: blogId
            },
            success: function(response) {
                $('#like-count-' + blogId).text(response.likes);
                showToast('success', response.message);
            },
            error: function(xhr) {
                if (xhr.status === 409) {
                    showToast('info', xhr.responseJSON.message);
                } else {
                    showToast('error', 'Something went wrong!');
                }
            }
        });
    }
</script>

@endsection