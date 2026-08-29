@extends('layouts.main')

@section('content')

<!-- ============ HERO ============ -->
<div id="top" class="hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <div>
            <h1>Contact Us</h1>
        </div>
    </div>
</div>

<!-- ============ CONTACT ============ -->
<section id="contact" style="padding-top:50px">
    <div class="wrap">
        <div class="card">
            <p class="eyebrow">Contact</p>
            <h3>Rights, bookings and reader mail</h3>
            <div class="field"><input type="text" id="cName" placeholder="Your name" aria-label="Your name"><input
                    type="email" id="cEmail" placeholder="Your email" aria-label="Your email"></div>
            <div class="field"><textarea id="cMsg" rows="4"
                    placeholder="How can we help? Please mention if this is a rights enquiry, a booking, or a bulk order."
                    aria-label="Message"></textarea></div>
            <div class="field"><button class="btn btn-solid" id="sendBtn">Send message</button></div>
            <p class="note">Translation and foreign-rights enquiries welcome. Bulk and course-adoption orders are
                quoted directly.</p>
        </div>
    </div>
</section>

@endsection
