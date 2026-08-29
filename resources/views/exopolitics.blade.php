@extends('layouts.main')

@section('content')

<!-- ============ HERO ============ -->
<div id="top" class="hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <div>
            <h1>Blogs</h1>
        </div>
    </div>
</div>

<div id="exopolitics">
    <div class="wrap">
        <div class="main-posted-boxes">

            <div class="posted-box">
                <div class="posted-box-content">
                    <h5>Posted by <img src="{{ asset('assets/images/posted-1.png') }}" class="img-fluid" alt=""> <a href="{{ route('blog') }}">Admin </a> <img
                            src="{{ asset('assets/images/share.png') }}" class="img-fluid profile-posted" alt=""> <a href="javascript:;"><i
                                class="fa-regular fa-message"></i></a></h5>
                    <h3>Time Travel & US Presidency</h3>
                    <p>CIA QUANTUM ACCESS PRESIDENTS: Bush Sr., Obama, Bush Jr., Clinton - All U.S. presidents
                        pre-indentified by U.S. quantum access. Bush Sr...</p>
                </div>
                <div class="posted-box-btn">
                    <a href="{{ route('blog') }}" class="btn btn-solid">Continue reading</a>
                </div>
            </div>
            <div class="posted-box">
                <div class="posted-box-content">
                    <h5>Posted by <img src="{{ asset('assets/images/posted-1.png') }}" class="img-fluid" alt=""> <a href="{{ route('blog') }}">Admin </a> <img
                            src="{{ asset('assets/images/share.png') }}" class="img-fluid profile-posted" alt=""> <a href="javascript:;"><i
                                class="fa-regular fa-message"></i></a></h5>
                    <h3>The Chronogarchy: Time Travel Revelations Are Featured In 8 New Non-Fiction Books By Futurist
                        Alfred Lambremont Webre</h3>
                    <p>The Chronogarchy: Time Travel Revelations Are Featured In New Non-Fiction Books By Futurist
                        Alfred Lambremont Webre THE CHRONOGARCHY: ...</p>
                </div>
                <div class="posted-box-btn">
                    <a href="{{ route('blog') }}" class="btn btn-solid">Continue reading</a>
                </div>
            </div>
            <div class="posted-box">
                <div class="posted-box-content">
                    <h5>Posted by <img src="{{ asset('assets/images/posted-1.png') }}" class="img-fluid" alt=""> <a href="{{ route('blog') }}">Admin </a> <img
                            src="{{ asset('assets/images/share.png') }}" class="img-fluid profile-posted" alt=""> <a href="javascript:;"><i
                                class="fa-regular fa-message"></i></a></h5>
                    <h3>About Alfred Lambremont Webre</h3>
                    <p>About Alfred Lambremont Webre, JD, MEd, founder of Exopolitics & co-discoverer of the Omniverse;
                        Acerca de Alfred Lambremont Webre,...</p>
                </div>
                <div class="posted-box-btn">
                    <a href="{{ route('blog') }}" class="btn btn-solid">Continue reading</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
