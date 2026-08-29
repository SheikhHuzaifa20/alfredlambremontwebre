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
                    <h3>Time Travel & US Presidency</h3>
                    <img src="{{ asset('assets/images/blog-1.webp') }}" class="img-fluid" alt="">
                    <p>CIA QUANTUM ACCESS PRESIDENTS: Bush Sr., Obama, Bush Jr., Clinton – All U.S. presidents
                        pre-indentified by U.S. quantum access. Bush Sr., Bush Jr, and Obama informed of this
                        pre-identification and trained to be CIA presidents.</p>
                    <p>1. Time Travel and Political Control</p>
                    <p><a
                            href="http://exopolitics.blogs.com/exopolitics/2011/12/time-travel-and-political-control.html">http://exopolitics.blogs.com/exopolitics/2011/12/time-travel-and-political-control.html</a>
                    </p>
                    <p>2. Obama pre-identified as President by secret DARPA-CIA time travel program</p>
                    <p><a
                            href="http://www.examiner.com/exopolitics-in-seattle/obama-pre-identified-as-president-by-secret-darpa-cia-time-travel-program">http://www.examiner.com/exopolitics-in-seattle/obama-pre-identified-as-president-by-secret-darpa-cia-time-travel-program</a>
                    </p>
                    <p>3. EXAMINER – Washington Times report: Newly released Obama birth certificate is a forensic
                        forgery</p>
                    <p><a
                            href="http://www.examiner.com/exopolitics-in-seattle/washington-times-report-newly-released-obama-birth-certificate-forensic-forgery">http://www.examiner.com/exopolitics-in-seattle/washington-times-report-newly-released-obama-birth-certificate-forensic-forgery</a>
                    </p>
                    <p>4. Hidden story behind Jesse Ventura & Piers Morgan’s CNN clash over Obama CIA ties</p>
                    <p><a
                            href="http://www.examiner.com/exopolitics-in-seattle/hidden-story-behind-jesse-ventura-piers-morgan-s-cnn-clash-over-obama-cia-ties">http://www.examiner.com/exopolitics-in-seattle/hidden-story-behind-jesse-ventura-piers-morgan-s-cnn-clash-over-obama-cia-ties</a>
                    </p>
                </div>
                <div class="posted-box-btn">
                    <h4>Recent Posts</h4>
                    <h4>Time Travel & US Presidency</h4>
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
