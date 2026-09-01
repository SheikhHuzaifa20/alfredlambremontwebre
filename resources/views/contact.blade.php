@php
    $page = DB::table('pages')->where('id', '4')->first();
    $section = DB::table('sections')->where('page_id', 4)->get();
@endphp
@extends('layouts.main')

@section('content')
    <!-- ============ HERO ============ -->
    <div id="top" class="hero">
        <svg class="starfield" aria-hidden="true"></svg>
        <div class="wrap">
            <div>
                <h1>{{ $page->page_name }}</h1>
            </div>
        </div>
    </div>

    <!-- ============ CONTACT ============ -->
    <section id="contact" style="padding-top:50px">
        <div class="wrap">
            <div class="card">
                <p class="eyebrow">{{ $page->page_name }}</p>
                <h3>{!! $page->content !!}</h3>
                <form action="{{ route('inquiry.store') }}" method="POST">
                    @csrf

                    <div class="field">
                        <input type="text" id="cName" name="fname" placeholder="Your name" aria-label="Your name"
                            value="{{ old('fname') }}" required>

                        <input type="email" id="cEmail" name="email" placeholder="Your email" aria-label="Your email"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="field">
                        <textarea id="cMsg" name="notes" rows="4"
                            placeholder="How can we help? Please mention if this is a rights enquiry, a booking, or a bulk order."
                            aria-label="notes" required>{{ old('notes') }}</textarea>
                    </div>

                    <div class="field">
                        <button type="submit" class="btn btn-solid" id="sendBtn">
                            Send message
                        </button>
                    </div>
                </form>


                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- Error Message --}}
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p class="note">{{ $section[0]->value }}</p>
            </div>
        </div>
    </section>
@endsection
