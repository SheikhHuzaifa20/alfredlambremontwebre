@extends('layouts.main')

@section('content')

<!-- ============ HERO ============ -->
<div id="top" class="hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <div>
            <p class="eyebrow">Founder of Exopolitics &middot; 30 published titles</p>
            <h1>Mapping the <em>Omniverse</em>, one book at a time.</h1>
            <p class="lede">Fifty years of research into space law, dimensional cosmology, time-travel evidence and
                the future of human consciousness — collected here, and available direct from the author.</p>
            <div class="hero-cta">
                <a href="#books" class="btn btn-solid">Browse the catalogue</a>
                <a href="#about" class="btn btn-ghost">About Alfred</a>
            </div>
            <div class="credential">
                <span>Yale University</span><span>Yale Law School</span><span>Fulbright Scholar</span><span>Judge,
                    Kuala Lumpur War Crimes Tribunal</span>
            </div>
        </div>

        <!-- SIGNATURE: the three cosmological bands -->
        <div>
            <svg class="bands" viewBox="0 0 500 500" role="img"
                aria-label="Three concentric bands: Universe, Multiverse, Omniverse">
                <defs>
                    <radialGradient id="core" cx="50%" cy="50%">
                        <stop offset="0%" stop-color="#C8A24B" stop-opacity=".95" />
                        <stop offset="100%" stop-color="#C8A24B" stop-opacity="0" />
                    </radialGradient>
                </defs>
                <circle cx="250" cy="250" r="60" fill="url(#core)" />
                <circle cx="250" cy="250" r="8" fill="#EDE7DA" />
                <g class="band-ring spin-fast">
                    <circle cx="250" cy="250" r="105" fill="none" stroke="#EDE7DA" stroke-opacity=".3"
                        stroke-width="1" />
                    <circle cx="355" cy="250" r="4.5" fill="#EDE7DA" />
                </g>
                <g class="band-ring spin-mid">
                    <circle cx="250" cy="250" r="163" fill="none" stroke="#C8A24B" stroke-opacity=".45" stroke-width="1"
                        stroke-dasharray="3 7" />
                    <circle cx="250" cy="87" r="4" fill="#C8A24B" />
                </g>
                <g class="band-ring spin-slow">
                    <circle cx="250" cy="250" r="222" fill="none" stroke="#6FD3C7" stroke-opacity=".38"
                        stroke-width="1" />
                    <circle cx="28" cy="250" r="3.5" fill="#6FD3C7" />
                    <circle cx="472" cy="250" r="3.5" fill="#6FD3C7" />
                </g>
                <text class="band-label" x="250" y="368" text-anchor="middle">Universe</text>
                <text class="band-label" x="250" y="428" text-anchor="middle">Multiverse</text>
                <text class="band-label" x="250" y="488" text-anchor="middle">Omniverse</text>
            </svg>
        </div>
    </div>
</div>

<!-- ============ FEATURED ============ -->
<div class="featured">
    <div class="wrap">
        <div class="cover" style="max-width:500px">
            <img src="{{ asset('assets/images/alfred-webew.webp') }}" class="img-fluid" alt="">
            <img src="{{ asset('assets/images/awake-now.webp') }}" class="img-fluid" alt="">
        </div>
        <div>
            <span class="tag-new">New release</span>
            <h2>Awake Now: A Confessional</h2>
            <p class="lede">The most personal book Alfred has written. After five decades documenting what
                governments hide and what the cosmos reveals, he turns the same evidentiary eye on his own life —
                the awakenings, the costs, and what it means to stay awake once you are.</p>
            <div class="hero-cta">
                <button class="btn btn-solid" data-add="awake-now">Pre-order — $24.95</button>
                <a href="#books" class="btn btn-ghost">See all books</a>
            </div>
        </div>
    </div>
</div>

<!-- ============ SPEAKING + NEWSLETTER ============ -->
<section id="speaking">
    <div class="wrap two">
        <div class="card">
            <p class="eyebrow">Speaking &amp; media</p>
            <h3>Invite Alfred to your programme</h3>
            <p>Alfred takes a limited number of interviews, panels and lectures each season. He is most useful to
                producers who want the evidentiary version of these subjects rather than the sensational one.</p>
            <ul>
                <li>Podcast and radio interviews (remote, 45–90 minutes)</li>
                <li>Television and documentary contributions</li>
                <li>Conference keynotes on exopolitics and space law</li>
                <li>University lectures and graduate seminars</li>
            </ul>
            <a href="#contact" class="btn btn-ghost" style="margin-top:24px">Send a booking request</a>
        </div>

        <div class="card">
            <p class="eyebrow">The dispatch</p>
            <h3>New research, first</h3>
            <p>An occasional letter — new titles, findings that did not make it into the books, and where Alfred
                will be speaking next.</p>
            <div class="field">
                <input type="email" id="subEmail" placeholder="your@email.com" aria-label="Email address">
                <button class="btn btn-solid" id="subBtn">Subscribe</button>
            </div>
            <p class="note">Unsubscribe any time. Your address is never shared or sold.</p>
        </div>
    </div>
</section>

<!-- ============ CATALOGUE ============ -->
<section id="books">
    <div class="wrap">
        <div class="sec-head">
            <div>
                <p class="eyebrow">The catalogue</p>
                <h2>Every book, ordered direct</h2>
            </div>
            <p class="count"><span id="shown">0</span> titles shown</p>
        </div>

        <div class="filters" id="filters" role="group" aria-label="Filter books">
            <button data-f="all" aria-pressed="true">All</button>
            <button data-f="omniverse" aria-pressed="false">Omniverse</button>
            <button data-f="exopolitics" aria-pressed="false">Exopolitics</button>
            <button data-f="chronogarchy" aria-pressed="false">Time &amp; Chronogarchy</button>
            <button data-f="consciousness" aria-pressed="false">Consciousness &amp; Christ</button>
            <button data-f="inquiry" aria-pressed="false">Public Inquiry</button>
            <button data-f="es" aria-pressed="false">Español</button>
            <button data-f="de" aria-pressed="false">Deutsch</button>
        </div>

        <div class="grid home-books" id="grid"></div>
    </div>
</section>

<!-- ============ ABOUT ============ -->
<div class="about" id="about">
    <div class="wrap">
        <div>
            <img src="{{ asset('assets/images/author-img.png') }}" class="img-fluid" alt="">
        </div>
        <div>
            <p class="eyebrow">About the author</p>
            <h2
                style="font-family:var(--display);font-weight:400;font-size:clamp(30px,3.6vw,46px);line-height:1.1;margin:10px 0 22px">
                A lawyer's method, applied to the cosmos</h2>
            <p>Alfred Lambremont Webre trained as a lawyer and spent his early career inside the institutions most
                people only read about — general counsel to the New York City Environmental Protection
                Administration, consultant to the Ford Foundation's public interest environmental law programme, and
                a non-governmental representative at the United Nations in New York and Vienna.</p>
            <p>In 1977 he directed the Carter White House study on extraterrestrial communication. What he found
                there set the direction for everything since. His 2000 book <em>Exopolitics</em> founded a field:
                the study of relations among intelligent civilisations. In 2014 he proposed the Omniverse as a third
                cosmological body alongside the Universe and the Multiverse — the framework that now runs through
                most of his work.</p>
            <p>He was a co-architect of the Space Preservation Treaty and the Space Preservation Act introduced to
                the U.S. Congress, and served as a judge on the Kuala Lumpur War Crimes Tribunal. Across thirty
                books in three languages, the method has never changed: gather the evidence, weigh it as a court
                would, and publish what it shows.</p>

            <dl class="facts">
                <div class="fact">
                    <dt>Education</dt>
                    <dd>Yale University (Industrial Administration, Honors); Yale Law School (International Law);
                        University of Texas (Counseling); Fulbright Scholar</dd>
                </div>
                <div class="fact">
                    <dt>Taught</dt>
                    <dd>Taxation, Yale University Economics Department &middot; Constitutional Law, University of
                        Texas Government Department</dd>
                </div>
                <div class="fact">
                    <dt>Founded</dt>
                    <dd>Exopolitics (2000) &middot; the Omniverse cosmology (2014) &middot; the Positive Future
                        Equation</dd>
                </div>
                <div class="fact">
                    <dt>Published</dt>
                    <dd>30 titles in English, Spanish and German, from 1974 to the present</dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<section class="testimonials-card-slides">
    <div class="wrap">
        <div class="testmonial-heading">
            <h2>What Our Customer Say</h2>
        </div>
        <div class="testimonials-carousel owl-carousel owl-theme">
            <div class="item">
                <div class="card">
                    <h3>Thaddeus Vance <span><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i></span></h3>
                    <p>Alfred Lambremont Webre really bares his soul in this one. Turning fifty years of strict research
                        onto his own personal journey is brave. It made me reflect on what true awareness actually
                        demands from us every single day.
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <h3>Clea Braddock <span><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i></span></h3>
                    <p>I picked up this confessional expecting another standard research text, but Awake Now: A
                        Confessional completely blew me away. Seeing the heavy personal cost of his spiritual
                        awakening
                        is incredibly moving. It is a profoundly honest read that sticks with you.
                    </p>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <h3>Zev Calloway <span><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i></span></h3>
                    <p>Awake Now: A Confessional is such a compelling book. Applying a disciplined and factual lens
                        to a
                        spiritual awakening is brilliant. He does not hold back on the harsh realities and
                        revelations
                        of trying to stay truly awake.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection