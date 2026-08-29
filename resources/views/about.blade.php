@php
    $page = DB::table('pages')->where('id', '2')->first();
    $section = DB::table('sections')->where('page_id', 2)->get();
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

<!-- ============ ABOUT ============ -->
<div class="about" id="about">
    <div class="wrap">
        <div>
            <img src="{{ $page->image }}" class="img-fluid" alt="">
        </div>
        <div>
            <p class="eyebrow">{{ $page->page_name }}</p>
            <h2
                style="font-family:var(--display);font-weight:400;font-size:clamp(30px,3.6vw,46px);line-height:1.1;margin:10px 0 22px">
                {{ $page->name }}</h2>
            {!! $page->content !!}
        </div>

    </div>
    <div class="wrap bottom-para">
        <div>
            {!! $section[0]->value !!}
        </div>
    </div>
</div>

@endsection
