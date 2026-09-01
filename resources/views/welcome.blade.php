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
                        <circle cx="250" cy="250" r="163" fill="none" stroke="#C8A24B" stroke-opacity=".45"
                            stroke-width="1" stroke-dasharray="3 7" />
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
    <style>
        .lastest {
            height: 535px;
            aspect-ratio: unset;

        }
    </style>
    <div class="featured">
        <div class="wrap">
            <div class="cover lastest" style="width:100%; max-width:500px;">
                @if ($latestProduct && $latestProduct->primaryImage)
                    <img src="{{ asset($latestProduct->primaryImage->image_path) }}" class="img-fluid"
                        alt="{{ $latestProduct->name }}" style="width:100%; height:auto;">
                @else
                    <img src="{{ asset('assets/images/awake-now.webp') }}" class="img-fluid" alt="Book cover"
                        style="width:100%; height:auto;">
                @endif
            </div>
            <div>
                @if ($latestProduct)
                    <span class="tag-new">New release</span>
                    <h2>{{ $latestProduct->name }}</h2>
                    <div class="lede">{!! $latestProduct->description !!}</div>
                    <div class="hero-cta">
                        <!-- Direct Checkout Button -->
                        <button type="button" class="btn btn-solid pre-order-btn"
                            data-product-id="{{ $latestProduct->id }}" data-format="Paperback"
                            data-price="{{ $latestProduct->paperback_price ?: 24.95 }}">
                            Pre-order — ${{ number_format($latestProduct->paperback_price ?: 24.95, 2) }}
                        </button>
                        <a href="{{ route('books') }}" class="btn btn-ghost">See all books</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============ SPEAKING + NEWSLETTER ============ -->
    <section id="speaking">
        <div class="wrap two">
            <div class="card">
                <p class="eyebrow">{{ $page->name }}</p>
                {!! $page->content !!}
                <a href="#contact" class="btn btn-ghost" style="margin-top:24px">Send a booking request</a>
            </div>

            <div class="card">
                <p class="eyebrow">{{ $section[0]->value }}</p>
                <h3>{{ $section[1]->value }}</h3>
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
                <p class="count"><span id="shown">{{ $products->count() }}</span> titles shown</p>
            </div>

            <!-- FILTERS -->
            <div class="filters" id="filters" role="group" aria-label="Filter books">
                <button class="filter-btn active" data-filter="all">All</button>
                @foreach ($categories as $cat)
                    <button class="filter-btn" data-filter="{{ $cat->id }}">{{ $cat->name }}</button>
                @endforeach
            </div>

            <!-- PRODUCTS GRID - 6 Products -->
            <div class="grid home-books" id="grid">
                @forelse($products as $product)
                    @php
                        // Use category_id directly (comma-separated IDs from DB)
                        $rawCategoryIds = array_filter(array_map('trim', explode(',', $product->category_id ?? '')));
                        $filterKeysString = !empty($rawCategoryIds) ? implode(',', $rawCategoryIds) : 'all';

                        // Build formats
                        $formats = [];
                        if ($product->paperback_price && $product->paperback_price > 0) {
                            $formats[] = ['f' => 'Paperback', 'p' => (float) $product->paperback_price];
                        }
                        if ($product->ebook_price && $product->ebook_price > 0) {
                            $formats[] = ['f' => 'eBook', 'p' => (float) $product->ebook_price];
                        }
                        if ($product->rustica_price && $product->rustica_price > 0) {
                            $formats[] = ['f' => 'Rústica', 'p' => (float) $product->rustica_price];
                        }
                        if ($product->taschenbuch_price && $product->taschenbuch_price > 0) {
                            $formats[] = ['f' => 'Taschenbuch', 'p' => (float) $product->taschenbuch_price];
                        }
                        if (empty($formats)) {
                            $formats[] = ['f' => 'Paperback', 'p' => 0];
                        }
                    @endphp
                    <article class="book" data-categories="{{ $filterKeysString }}"
                        data-lang="{{ $product->language ?? 'en' }}" data-product-id="{{ $product->id }}">

                        <!-- Book Cover -->
                        <div class="cover">
                            @if ($product->primaryImage && $product->primaryImage->image_path)
                                <img src="{{ asset($product->primaryImage->image_path) }}" class="img-fluid"
                                    alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="cover-placeholder"><span>{{ substr($product->name, 0, 2) }}</span></div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div class="book-body">
                            <p class="meta">
                                {{ $product->created_at ? $product->created_at->format('Y') : date('Y') }}
                                &middot;
                                {{ $product->language == 'es' ? 'Español' : ($product->language == 'de' ? 'Deutsch' : 'English') }}
                            </p>
                            <h3>{{ $product->name }}</h3>
                            <div class="blurb">{!! $product->description ?? ($product->short_description ?? '') !!}</div>

                            <!-- Formats -->
                            <div class="formats" role="group" aria-label="Choose format for {{ $product->name }}">
                                @foreach ($formats as $index => $format)
                                    <button class="format-btn" data-product="{{ $product->id }}"
                                        data-index="{{ $index }}" data-price="{{ $format['p'] }}"
                                        data-format="{{ $format['f'] }}">
                                        {{ $format['f'] }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Price -->
                            <div class="price-row">
                                <span class="price" id="price-{{ $product->id }}">
                                    ${{ number_format($formats[0]['p'] ?? 0, 2) }}
                                </span>
                            </div>

                            <!-- Add to Cart -->
                            <button class="add add-to-cart" data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}">
                                Add to cart
                            </button>

                            <!-- View Details -->
                            {{-- <a href="{{ route('book.detail', $product->slug ?? $product->id) }}"
                                class="view-detail-btn">View Details →</a> --}}
                        </div>
                    </article>
                @empty
                    <p class="empty">No products found.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============ ABOUT ============ -->
    <div class="about" id="about">
        <div class="wrap">

            <div>
                <img src="{!! $section[6]->value !!}" class="img-fluid" alt="">
            </div>
            <div>
                <p class="eyebrow">{{ $section[3]->value }}</p>
                <h2
                    style="font-family:var(--display);font-weight:400;font-size:clamp(30px,3.6vw,46px);line-height:1.1;margin:10px 0 22px">
                    {{ $section[4]->value }}</h2>
                {!! $section[5]->value !!}


                <dl class="facts">
                    <div class="fact">
                        <dt>{{ $section[7]->value }}</dt>
                        <dd>{{ $section[8]->value }}</dd>
                    </div>
                    <div class="fact">
                        <dt>{{ $section[9]->value }}</dt>
                        <dd>{{ $section[10]->value }}</dd>
                    </div>
                    <div class="fact">
                        <dt>{{ $section[11]->value }}</dt>
                        <dd>{{ $section[12]->value }}</dd>
                    </div>
                    <div class="fact">
                        <dt>{{ $section[13]->value }}</dt>
                        <dd>{{ $section[14]->value }}</dd>
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
                @foreach ($testinomial as $testimonial)
                    <div class="item">
                        <div class="card">
                            <h3>{{ $testimonial->title }} <span>
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </span></h3>
                            <p>{!! $testimonial->description !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script>
        // ============================================================
        // BUILD BOOKS DATA FROM DOM (same approach as books page)
        // ============================================================
        function buildBooksFromDOM() {
            const books = [];
            document.querySelectorAll('#grid article.book').forEach(el => {
                const formatBtns = el.querySelectorAll('.formats button, .format-btn');
                const formats = [];
                formatBtns.forEach(btn => {
                    formats.push({
                        f: btn.dataset.format || btn.textContent.trim(),
                        p: parseFloat(btn.dataset.price || 0)
                    });
                });
                books.push({
                    id: el.dataset.productId,
                    slug: el.dataset.slug || el.dataset.productId,
                    cat: (el.dataset.categories || '').split(',').map(c => c.trim()).filter(Boolean),
                    lang: el.dataset.lang || 'en',
                    title: el.querySelector('h3')?.textContent?.trim() || '',
                    year: el.querySelector('.meta')?.textContent?.split('·')[0]?.trim() || '',
                    blurb: el.querySelector('.blurb')?.innerHTML || '',
                    bookimg: el.querySelector('.cover img')?.src || '',
                    formats: formats,
                });
            });
            return books;
        }

        const BOOKS = buildBooksFromDOM();
        const state = {
            filter: 'all',
            chosen: {}
        };
        const grid = document.getElementById('grid');

        function money(n) {
            return '$' + Number(n).toFixed(2);
        }

        // ============================================================
        // RENDER — exactly like books page
        // ============================================================
        function render() {
            if (!grid) return;

            let list = BOOKS.filter(b => {
                if (state.filter === 'all') return true;
                return (b.cat && b.cat.includes(state.filter)) || b.lang === state.filter;
            });

            const shown = document.getElementById('shown');
            // "All" tab shows only 6 on home page
            const displayList = state.filter === 'all' ? list.slice(0, 6) : list;
            if (shown) shown.textContent = displayList.length;

            if (!displayList.length) {
                grid.innerHTML = '<p class="empty">No titles in this collection yet. Choose another filter.</p>';
                return;
            }

            grid.innerHTML = displayList.map(b => {
                const idx = state.chosen[b.id] ?? 0;
                const fmt = b.formats[idx] || b.formats[0] || {
                    f: 'Paperback',
                    p: 0
                };

                return `
            <article class="book" data-product-id="${b.id}" data-categories="${b.cat.join(',')}" data-lang="${b.lang}" data-slug="${b.slug}">
                <div class="cover">
                    ${b.bookimg
                        ? `<img src="${b.bookimg}" class="img-fluid" alt="${b.title}" loading="lazy">`
                        : `<div class="cover-placeholder"><span>${b.title.slice(0,2)}</span></div>`}
                </div>
                <div class="book-body">
                    <p class="meta">${b.year} &middot; ${b.lang === 'es' ? 'Español' : b.lang === 'de' ? 'Deutsch' : 'English'}</p>
                    <h3>${b.title}</h3>
                    <div class="blurb">${b.blurb}</div>
                    <div class="formats" role="group" aria-label="Choose format">
                        ${b.formats.map((f, i) => `<button class="format-btn" data-product="${b.id}" data-index="${i}" data-price="${f.p}" data-format="${f.f}" aria-pressed="${i === idx ? 'true' : 'false'}">${f.f}</button>`).join('')}
                    </div>
                    <div class="price-row"><span class="price" id="price-${b.id}">${money(fmt.p)}</span></div>
                    <button class="add add-to-cart" data-product-id="${b.id}" data-product-name="${b.title}">Add to cart</button>
                    
                </div>
            </article>`;
            }).join('');

            attachCardEvents();
        }

        // ============================================================
        // FILTER TABS
        // ============================================================
        document.getElementById('filters')?.addEventListener('click', function(e) {
            const btn = e.target.closest('button[data-filter]');
            if (!btn) return;
            state.filter = btn.dataset.filter;
            this.querySelectorAll('button').forEach(b => b.classList.toggle('active', b === btn));
            render();
        });

        // ============================================================
        // FORMAT + ADD TO CART EVENTS
        // ============================================================
        function attachCardEvents() {
            document.querySelectorAll('#grid .format-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pid = this.dataset.product;
                    const idx = parseInt(this.dataset.index);
                    const price = parseFloat(this.dataset.price || 0);
                    state.chosen[pid] = idx;
                    const priceEl = document.getElementById('price-' + pid);
                    if (priceEl) priceEl.textContent = money(price);
                    this.closest('.formats').querySelectorAll('button').forEach(b => b.setAttribute(
                        'aria-pressed', 'false'));
                    this.setAttribute('aria-pressed', 'true');
                });
            });

            document.querySelectorAll('#grid .add-to-cart').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pid = this.dataset.productId;
                    const name = this.dataset.productName;
                    const b = BOOKS.find(x => x.id == pid);
                    if (!b) return;
                    const i = state.chosen[pid] ?? 0;
                    const fmt = b.formats[i] || b.formats[0] || {
                        f: 'Paperback',
                        p: 0
                    };

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: pid,
                                format: fmt.f,
                                price: fmt.p,
                                qty: 1
                            })
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                const cc = document.getElementById('cartCount');
                                if (cc && data.count !== undefined) cc.textContent = data.count;
                                if (typeof window.loadCart === 'function') window.loadCart();
                                if (typeof window.openCart === 'function') window.openCart();
                                if (typeof window.showAlert === 'function') window.showAlert(data.message || 'Book added to cart!', 'success');
                            }
                        }).catch(() => {});

                    const origText = this.textContent;
                    this.classList.add('done');
                    this.textContent = 'Added ✓';
                    setTimeout(() => {
                        this.classList.remove('done');
                        this.textContent = origText;
                    }, 1400);
                });
            });
        }

        // ============================================================
        // PRE-ORDER DIRECT CHECKOUT
        // ============================================================
        document.querySelector('.pre-order-btn')?.addEventListener('click', function() {
            const pid = this.dataset.productId;
            const format = this.dataset.format || 'Paperback';
            const price = parseFloat(this.dataset.price || 24.95);
            const btn = this;

            btn.disabled = true;
            btn.textContent = 'Redirecting to checkout...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: pid,
                        format: format,
                        price: price,
                        qty: 1
                    })
                })
                .then(r => r.json())
                .then(() => {
                    window.location.href = '{{ route('checkout') }}';
                })
                .catch(() => {
                    window.location.href = '{{ route('checkout') }}';
                });
        });

        // ============================================================
        // NEWSLETTER SUBSCRIBE
        // ============================================================
        document.getElementById('subBtn')?.addEventListener('click', function() {
            const emailEl = document.getElementById('subEmail');
            const email = emailEl?.value?.trim();
            const btn = this;

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showSubMsg('Please enter a valid email address.', false);
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Subscribing...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            fetch('{{ route('newsletter.submit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        newsletter_email: email
                    })
                })
                .then(r => r.json())
                .then(data => {
                    showSubMsg(data.message, data.status);
                    if (data.status) {
                        if (emailEl) emailEl.value = '';
                        btn.textContent = 'Subscribed ✓';
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Subscribe';
                    }
                })
                .catch(() => {
                    showSubMsg('Something went wrong. Please try again.', false);
                    btn.disabled = false;
                    btn.textContent = 'Subscribe';
                });
        });

        function showSubMsg(msg, success) {
            let el = document.getElementById('subMsg');
            if (!el) {
                el = document.createElement('p');
                el.id = 'subMsg';
                el.style.cssText = 'font-size:13px;margin-top:8px;';
                document.getElementById('subBtn')?.parentElement?.insertAdjacentElement('afterend', el);
            }
            el.textContent = msg;
            el.style.color = success ? '#6FD3C7' : '#E07070';
        }

        // ============================================================
        // INIT
        // ============================================================
        render();
    </script>
@endsection
