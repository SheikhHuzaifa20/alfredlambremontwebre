@php
    $page = DB::table('pages')->where('id', '9')->first();
@endphp

@extends('layouts.main')

@section('content')
    <!-- ============ HERO ============ -->
    <div id="top" class="hero">
        <svg class="starfield" aria-hidden="true"></svg>
        <div class="wrap">
            <div>
                <h1>{{$page->name}}</h1>
            </div>
        </div>
    </div>

    <!-- ============ ABOUT ============ -->
    <div class="about" id="about">
        <div class="wrap bottom-para">
            <div>
                <style>
                    h3 {
                        font-family: var(--display);
                        font-weight: 400;
                        font-size: clamp(30px, 3.6vw, 46px);
                        line-height: 1.1;
                        margin: 10px 0 22px
                    }

                    h2 {
                        font-family: var(--display);
                        font-weight: 400;
                        font-size: clamp(30px, 3.6vw, 30px);
                        margin: 10px 0 22px
                    }
                </style>
                {!! $page->content !!}

            </div>
        </div>
    </div>
@endsection
