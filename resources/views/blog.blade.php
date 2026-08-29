@extends('layouts.main')

@section('content')

<!-- ============ HERO ============ -->
<div id="top" class="hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <div>
            <h1>Blog</h1>
        </div>
    </div>
</div>

<div id="blog-inner">
    <div class="wrap">
        <div class="blog-detail">
            <div class="posted-box">
                <div class="posted-box-content">
                    <h5>Posted by <img src="{{ asset('assets/images/posted-1.png') }}" class="img-fluid" alt=""> <a href="{{ route('blog') }}">Admin </a>
                        <img src="{{ asset('assets/images/share.png') }}" class="img-fluid profile-posted" alt=""> <a href="javascript:;"><i
                                class="fa-regular fa-message"></i></a>
                    </h5>
                    <h3>{{$blog->title}}</h3>
                    <img src="{{ asset($blog->image) }}" class="img-fluid" alt="">
                    {!! $blog->description !!}
                </div>
                <div class="posted-box-btn">
                    <h4>Recent Posts</h4>
                    <h4>{{$blog->title}}</h4>
                    <p><span>April 4, 2024 1 Comment</span></p>
                    <h4>The Chronogarchy: Time Travel Revelations Are Featured In 8 New Non-Fiction Books By Futurist
                        Alfred Lambremont Webre</h4>
                    <p><span>April 4, 2024 1 Comment</span></p>
                    <h4>About Alfred Lambremont Webre</h4>
                    <p><span>April 4, 2024 1 Comment</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
