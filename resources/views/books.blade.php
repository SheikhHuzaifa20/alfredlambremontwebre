@extends('layouts.main')

@section('content')

    <!-- ============ HERO ============ -->
    <div id="top" class="hero">
        <svg class="starfield" aria-hidden="true"></svg>
        <div class="wrap">
            <div>
                <h1>Our Books</h1>
            </div>
        </div>
    </div>

    <!-- ============ CATALOGUE ============ -->
    <section id="books">
        <div class="wrap">
            <div class="sec-head">
                <div>
                    <h2>OUR FEATURED BOOKS</h2>
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

            <!-- PRODUCTS GRID -->
            <div class="grid" id="grid">
                @forelse($products as $product)
                    @php
                        // Use category_id directly (comma-separated IDs from DB)
                        $rawCategoryIds = array_filter(array_map('trim', explode(',', $product->category_id ?? '')));
                        $filterKeysString = !empty($rawCategoryIds) ? implode(',', $rawCategoryIds) : 'all';

                        // Build formats with price
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
                        data-lang="{{ $product->language ?? 'en' }}" data-product-id="{{ $product->id }}"
                        data-slug="{{ $product->slug ?? $product->id }}">

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

                            <!-- Formats - WITH PRICE DATA -->
                            <div class="formats" role="group" aria-label="Choose format for {{ $product->name }}">
                                @foreach ($formats as $index => $format)
                                    <button data-fmt="{{ $product->id }}:{{ $index }}"
                                        data-price="{{ $format['p'] }}" data-format="{{ $format['f'] }}"
                                        aria-pressed="{{ $index === 0 ? 'true' : 'false' }}">
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
                            <button class="add" data-add="{{ $product->id }}">Add to cart</button>

                            <!-- Stores -->
                            <div class="stores">Also at:
                                <a href="#">IngramSpark</a>
                                <a href="#">Draft2Digital</a>
                                <a href="#">Kobo</a>
                                <a href="#">Lulu</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="empty">No products found.</p>
                @endforelse
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script>
        // ============================================
        // BUILD DYNAMIC BOOKS FROM DATABASE
        // ============================================
        function buildBooksFromDOM() {
            const books = [];
            document.querySelectorAll('.book').forEach(el => {
                const formatBtns = el.querySelectorAll('.formats button');
                const formats = [];
                formatBtns.forEach(btn => {
                    formats.push({
                        f: btn.textContent.trim(),
                        p: parseFloat(btn.dataset.price || 0)
                    });
                });

                books.push({
                    id: el.dataset.productId || el.querySelector('.add')?.dataset.add,
                    slug: el.dataset.slug || '',
                    title: el.querySelector('h3')?.textContent || '',
                    year: el.querySelector('.meta')?.textContent?.split('·')[0]?.trim() || '',
                    cat: (el.dataset.categories || 'all').split(','),
                    lang: el.dataset.lang || 'en',
                    blurb: el.querySelector('.blurb')?.innerHTML || '',
                    bookimg: el.querySelector('.cover img')?.src || '',
                    formats: formats,
                    price: formats.length > 0 ? formats[0].p : 0
                });
            });
            return books;
        }

        const BOOKS = buildBooksFromDOM();
        const state = {
            filter: 'all',
            chosen: {},
            cart: []
        };
        const grid = document.getElementById('grid');

        function money(n) {
            return '$' + Number(n).toFixed(2);
        }

        // ============================================
        // RENDER FUNCTION
        // ============================================
        function render() {
            if (!grid) return;

            let list = BOOKS.filter(b => {
                if (state.filter === 'all') return true;
                return (b.cat && b.cat.includes(state.filter)) || b.lang === state.filter;
            });

            const shown = document.getElementById('shown');
            if (shown) shown.textContent = list.length;

            if (!list.length) {
                grid.innerHTML = '<p class="empty">No titles in this collection yet. Choose another filter.</p>';
                return;
            }

            const isHomePage = grid.classList.contains('home-books');
            if (isHomePage) list = list.slice(0, 6);

            grid.innerHTML = list.map(b => {
                const idx = state.chosen[b.id] ?? 0;
                const fmt = b.formats[idx] || b.formats[0] || {
                    f: 'Paperback',
                    p: 0
                };
                const detailUrl = '/books/' + (b.slug || b.id);

                return `
            <article class="book" data-product-id="${b.id}" data-categories="${(b.cat || ['all']).join(',')}" data-lang="${b.lang || 'en'}" data-slug="${b.slug || b.id}">
                <div class="cover">
                    ${b.bookimg ? `<img src="${b.bookimg}" class="img-fluid" alt="${b.title}" loading="lazy">` : `<div class="cover-placeholder"><span>${b.title?.slice(0, 2) || ''}</span></div>`}
                </div>
                <div class="book-body">
                    <p class="meta">${b.year || ''} &middot; ${b.lang === 'es' ? 'Español' : b.lang === 'de' ? 'Deutsch' : 'English'}</p>
                    <h3>${b.title || ''}</h3>
                    <div class="blurb">${b.blurb || ''}</div>
                    <div class="formats" role="group">
                        ${b.formats.map((f, i) => `<button data-fmt="${b.id}:${i}" data-price="${f.p}" data-format="${f.f}" aria-pressed="${i === idx ? 'true' : 'false'}">${f.f}</button>`).join('')}
                    </div>
                    <div class="price-row"><span class="price" id="price-${b.id}">${money(fmt.p)}</span></div>
                    <button class="add" data-add="${b.id}">Add to cart</button>
                    <div class="stores">Also at: <a href="#">IngramSpark</a> <a href="#">Draft2Digital</a> <a href="#">Kobo</a> <a href="#">Lulu</a></div>
                    
                </div>
            </article>`;
            }).join('');

            attachEvents();
        }

        // ============================================
        // EVENT LISTENERS
        // ============================================
        function attachEvents() {
            document.querySelectorAll('.formats button').forEach(btn => {
                btn.removeEventListener('click', formatClickHandler);
                btn.addEventListener('click', formatClickHandler);
            });

            document.querySelectorAll('.add').forEach(btn => {
                btn.removeEventListener('click', addClickHandler);
                btn.addEventListener('click', addClickHandler);
            });
        }

        // ============================================
        // FORMAT CLICK - UPDATE PRICE
        // ============================================
        function formatClickHandler(e) {
            const btn = e.currentTarget;
            const parts = btn.dataset.fmt.split(':');
            const id = parts[0];
            const index = parseInt(parts[1]);
            const price = parseFloat(btn.dataset.price || 0);

            state.chosen[id] = index;

            // Update price display
            const parent = btn.closest('.book');
            const priceSpan = parent.querySelector('.price');
            if (priceSpan) {
                priceSpan.textContent = money(price);
            }

            // Update active state
            const siblings = btn.closest('.formats').querySelectorAll('button');
            siblings.forEach(b => b.setAttribute('aria-pressed', 'false'));
            btn.setAttribute('aria-pressed', 'true');
        }

        // ============================================
        // ADD TO CART
        // ============================================
        function addClickHandler(e) {
            const btn = e.currentTarget;
            addToCart(btn.dataset.add, btn);
        }

        function addToCart(id, btn) {
            const b = BOOKS.find(x => x.id == id);
            if (!b) return;

            const i = state.chosen[id] ?? 0;
            const fmt = b.formats[i] || b.formats[0] || {
                f: 'Paperback',
                p: 0
            };
            const key = id + ':' + i;
            const line = state.cart.find(l => l.key === key);

            if (line) line.q++;
            else state.cart.push({
                key,
                id,
                title: b.title,
                fmt: fmt.f,
                price: fmt.p,
                q: 1
            });

            drawCart();
            toast(b.title.replace(/&amp;/g, '&').slice(0, 44) + ' added');

            if (btn) {
                btn.classList.add('done');
                btn.textContent = 'Added ✓';
                setTimeout(() => {
                    btn.classList.remove('done');
                    btn.textContent = 'Add to cart';
                }, 1400);
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: id,
                        format: fmt.f,
                        price: fmt.p,
                        qty: 1
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const cartCount = document.getElementById('cartCount');
                        if (cartCount && data.count !== undefined) {
                            cartCount.textContent = data.count;
                        }
                        if (typeof window.loadCart === 'function') window.loadCart();
                        if (typeof window.openCart === 'function') window.openCart();
                        if (typeof window.showAlert === 'function') window.showAlert(data.message || 'Book added to cart!', 'success');
                    }
                })
                .catch(() => {});
        }

        // ============================================
        // DRAW CART
        // ============================================
        const linesEl = document.getElementById('lines');

        function drawCart() {
            if (!linesEl) return;

            const count = state.cart.reduce((s, l) => s + l.q, 0);
            const cartCountEl = document.getElementById('cartCount');
            if (cartCountEl) cartCountEl.textContent = count;

            const total = state.cart.reduce((s, l) => s + l.q * l.price, 0);
            const subtotalEl = document.getElementById('subtotal');
            if (subtotalEl) subtotalEl.textContent = money(total);

            linesEl.innerHTML = state.cart.length ? state.cart.map(l => `
            <div class="line" data-key="${l.key}">
                <div>
                    <h4>${l.title}</h4>
                    <p class="lf">${l.fmt}</p>
                    <div class="qty">
                        <button data-q="${l.key}:-1">−</button>
                        <span>${l.q}</span>
                        <button data-q="${l.key}:1">+</button>
                    </div>
                </div>
                <div>
                    <p class="lp">${money(l.price * l.q)}</p>
                    <button class="remove" data-rm="${l.key}">Remove</button>
                </div>
            </div>
        `).join('') : '<p class="cart-empty">Your order is empty.<br>Browse the catalogue to begin.</p>';

            attachCartEvents();
        }

        function attachCartEvents() {
            linesEl?.querySelectorAll('[data-q]').forEach(btn => {
                btn.removeEventListener('click', qtyClickHandler);
                btn.addEventListener('click', qtyClickHandler);
            });

            linesEl?.querySelectorAll('[data-rm]').forEach(btn => {
                btn.removeEventListener('click', removeClickHandler);
                btn.addEventListener('click', removeClickHandler);
            });
        }

        function qtyClickHandler(e) {
            const btn = e.currentTarget;
            const parts = btn.dataset.q.split(':');
            const d = +parts[parts.length - 1];
            const key = parts.slice(0, -1).join(':');
            const line = state.cart.find(l => l.key === key);
            if (line) {
                line.q += d;
                if (line.q < 1) {
                    state.cart = state.cart.filter(l => l.key !== key);
                }
                drawCart();
            }
        }

        function removeClickHandler(e) {
            const btn = e.currentTarget;
            state.cart = state.cart.filter(l => l.key !== btn.dataset.rm);
            drawCart();
        }

        // ============================================
        // CART DRAWER OPEN/CLOSE
        // ============================================
        const drawer = document.getElementById('drawer');
        const scrim = document.getElementById('scrim');

        function openCart(o) {
            if (!drawer || !scrim) return;
            drawer.classList.toggle('open', o);
            scrim.classList.toggle('open', o);
            drawer.setAttribute('aria-hidden', String(!o));
            document.body.style.overflow = o ? 'hidden' : '';
        }

        document.getElementById('openCart')?.addEventListener('click', () => openCart(true));
        document.getElementById('closeCart')?.addEventListener('click', () => openCart(false));
        scrim?.addEventListener('click', () => openCart(false));
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') openCart(false);
        });

        // ============================================
        // FILTERS - TABS
        // ============================================
        document.getElementById('filters')?.addEventListener('click', function(e) {
            const btn = e.target.closest('button[data-filter]');
            if (!btn) return;

            state.filter = btn.dataset.filter;

            // Update active state
            this.querySelectorAll('button').forEach(b => {
                b.classList.toggle('active', b === btn);
            });

            render();
        });

        // ============================================
        // CHECKOUT
        // ============================================
        document.getElementById('checkoutBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (!state.cart.length) {
                toast('Add a book to your order first');
                return;
            }
            window.location.href = '{{ route('checkout') }}';
        });

        // ============================================
        // TOAST
        // ============================================
        let tId;
        const toastEl = document.getElementById('toast');

        function toast(msg) {
            if (!toastEl) return;
            toastEl.textContent = msg;
            toastEl.classList.add('show');
            clearTimeout(tId);
            tId = setTimeout(() => toastEl.classList.remove('show'), 2600);
        }

        // ============================================
        // STARFIELD
        // ============================================
        function createStarfield() {
            const svg = document.querySelector('.starfield');
            if (!svg) return;
            let s = '';
            for (let i = 0; i < 90; i++) {
                const x = Math.random() * 100,
                    y = Math.random() * 100;
                const r = Math.random() * 1.3 + .3,
                    o = Math.random() * .5 + .12;
                s += `<circle cx="${x}%" cy="${y}%" r="${r}" fill="#EDE7DA" opacity="${o.toFixed(2)}"/>`;
            }
            svg.innerHTML = s;
        }

        // ============================================
        // INIT
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            render();
            drawCart();
            createStarfield();

            const yrEl = document.getElementById('yr');
            if (yrEl) yrEl.textContent = new Date().getFullYear();
        });
    </script>
@endsection
