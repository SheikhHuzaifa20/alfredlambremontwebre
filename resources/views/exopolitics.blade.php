@extends('layouts.main')

@section('content')

    <!-- ============ HERO ============ -->
    <div id="top" class="hero">
        <svg class="starfield" aria-hidden="true"></svg>

        <div class="wrap">
            <div>
                <h1>Exopolitics</h1>
            </div>
        </div>
    </div>


    <div id="exopolitics">
        <div class="wrap">

            <div class="main-posted-boxes">

                @forelse($blogs as $blog)

                    <div class="posted-box">

                        <div class="posted-box-content">

                            <h5>
                                Posted by

                                <img src="{{ asset('assets/images/posted-1.png') }}"
                                    class="img-fluid"
                                    alt="">

                                <a href="{{ route('blog') }}">
                                    Admin
                                </a>

                                <img src="{{ asset('assets/images/share.png') }}"
                                    class="img-fluid profile-posted"
                                    alt="">

                                <a href="javascript:;">
                                    <i class="fa-regular fa-message"></i>
                                </a>
                            </h5>


                            {{-- Blog Title --}}
                            <h3>
                                {{ $blog->title }}
                            </h3>


                            {{-- Short Description --}}
                            <p>
                                {!! $blog->short_desc !!}
                            </p>

                        </div>


                        <div class="posted-box-btn">

                            {{-- Blog Detail Page --}}
                            <a href="{{ route('blog.detail', $blog->id) }}"
                                class="btn btn-solid">

                                Continue reading

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="posted-box">
                        <div class="posted-box-content">
                            <h3>No Blogs Found</h3>
                        </div>
                    </div>

                @endforelse

            </div>

        </div>
    </div>

@endsection