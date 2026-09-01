@include('include.header')
@include('include.menu')

<!-- ============ HERO ============ -->
<div id="top" class="hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <div>
            <p class="eyebrow">{{ $banner->title }}</p>
            {!! $banner->description !!}
            <div class="hero-cta">
                <a href="{{ $banner->catalogue_link }}" class="btn btn-solid">{{ $banner->catalogue }}</a>
                <a href="{{ $banner->about_link }}" class="btn btn-ghost">{{ $banner->about }}</a>
            </div>
            <div class="credential">
                {!! $banner->text_2 !!}
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
            <p class="count"><span id="shown">{{ count($products) }}</span> titles shown</p>
        </div>

        <!-- FILTERS -->
        <div class="filters" id="filters" role="group" aria-label="Filter books">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="omniverse">Omniverse</button>
            <button class="filter-btn" data-filter="exopolitics">Exopolitics</button>
            <button class="filter-btn" data-filter="chronogarchy">Time &amp; Chronogarchy</button>
            <button class="filter-btn" data-filter="consciousness">Consciousness &amp; Christ</button>
            <button class="filter-btn" data-filter="inquiry">Public Inquiry</button>
            <button class="filter-btn" data-filter="es">Español</button>
            <button class="filter-btn" data-filter="de">Deutsch</button>
        </div>

        <!-- PRODUCTS GRID -->
        <div class="grid home-books" id="grid">
            @forelse($products as $product)
                @php
                    // Get all categories of the product
                    $categoryIds = array_filter(explode(',', $product->category_id));
                    $productCats = \App\Models\Category::whereIn('id', $categoryIds)->pluck('name')->map(fn($name) => strtolower(trim($name)))->toArray();
                    
                    // Map categories for filter keys
                    $filterKeys = [];
                    foreach ($productCats as $catName) {
                        if (str_contains($catName, 'omniverse')) $filterKeys[] = 'omniverse';
                        elseif (str_contains($catName, 'exopolitics')) $filterKeys[] = 'exopolitics';
                        elseif (str_contains($catName, 'chronogarchy') || str_contains($catName, 'time')) $filterKeys[] = 'chronogarchy';
                        elseif (str_contains($catName, 'consciousness')) $filterKeys[] = 'consciousness';
                        elseif (str_contains($catName, 'inquiry')) $filterKeys[] = 'inquiry';
                        elseif (str_contains($catName, 'español') || str_contains($catName, 'espa') || str_contains($catName, 'espanol')) $filterKeys[] = 'es';
                        elseif (str_contains($catName, 'deutsch') || str_contains($catName, 'german')) $filterKeys[] = 'de';
                    }
                    if (empty($filterKeys)) {
                        $filterKeys[] = 'all';
                    }
                    $filterKeysString = implode(',', array_unique($filterKeys));
                @endphp
                <article class="book" data-categories="{{ $filterKeysString }}" data-lang="{{ $product->language ?? 'en' }}">
                    
                    <!-- Book Cover -->
                    <a href="{{ route('book.detail', $product->slug ?? $product->id) }}" class="cover-link" style="display:block;text-decoration:none">
                        <div class="cover book-cover-img">
                            @if($product->primaryImage && $product->primaryImage->image_path)
                                <img src="{{ asset($product->primaryImage->image_path) }}" class="img-fluid db-cover-img" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="cover-placeholder"><span>{{ substr($product->name, 0, 2) }}</span></div>
                            @endif
                        </div>
                    </a>

                    <!-- Book Details -->
                    <div class="book-body">
                        <p class="meta">
                            {{ $product->created_at ? $product->created_at->format('Y') : date('Y') }} 
                            &middot; 
                            {{ $product->language == 'es' ? 'Español' : ($product->language == 'de' ? 'Deutsch' : 'English') }}
                        </p>
                        
                        <a href="{{ route('book.detail', $product->slug ?? $product->id) }}" class="book-title-link">
                            <h3>{{ $product->name }}</h3>
                        </a>
                        
                        <p class="blurb">{!! $product->description ?? '' !!}</p>

                        <!-- Formats / Price Buttons -->
                        <div class="formats" role="group" aria-label="Choose format for {{ $product->name }}">
                            @php
                                $formats = [];
                                if($product->paperback_price && $product->paperback_price > 0) {
                                    $formats[] = ['f' => 'Paperback', 'p' => $product->paperback_price];
                                }
                                if($product->ebook_price && $product->ebook_price > 0) {
                                    $formats[] = ['f' => 'eBook', 'p' => $product->ebook_price];
                                }
                                if($product->rustica_price && $product->rustica_price > 0) {
                                    $formats[] = ['f' => 'Rústica', 'p' => $product->rustica_price];
                                }
                                if($product->taschenbuch_price && $product->taschenbuch_price > 0) {
                                    $formats[] = ['f' => 'Taschenbuch', 'p' => $product->taschenbuch_price];
                                }
                                if(empty($formats)) {
                                    $formats[] = ['f' => 'Paperback', 'p' => 0];
                                }
                            @endphp

                            @foreach($formats as $index => $format)
                                <button class="format-btn" data-product="{{ $product->id }}" data-index="{{ $index }}" data-price="{{ $format['p'] }}" data-format="{{ $format['f'] }}">
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

                        <!-- Add to Cart Button -->
                        <button class="add add-to-cart" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                            Add to cart
                        </button>

                        <!-- View Details -->
                        <a href="{{ route('book.detail', $product->slug ?? $product->id) }}" class="view-detail-btn">View Details →</a>
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
            {{-- <div class="item">
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
            </div> --}}
        </div>
    </div>
</section>

<script>
    // CSRF Token and endpoints
    const csrfToken = "{{ csrf_token() }}";
    const cartAddUrl = "{{ route('cart.add') }}";
    const cartRemoveUrl = "{{ route('cart.remove') }}";
    const cartSyncUrl = "{{ route('cart.sync') }}";
    const bookDetailBase = "{{ url('books') }}/";

    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const books = document.querySelectorAll('.book');
        const shownSpan = document.getElementById('shown');

        function filterBooks(filter) {
            let visibleCount = 0;

            books.forEach(book => {
                const categories = (book.dataset.categories || 'all').toLowerCase().split(',');
                const lang = (book.dataset.lang || 'en').toLowerCase();

                let show = false;
                if (filter === 'all') {
                    show = true;
                } else {
                    show = categories.includes(filter) || lang === filter;
                }

                // Homepage limit: only show max 6 books for any filter/tab
                if (show && visibleCount < 6) {
                    book.style.display = '';
                    visibleCount++;
                } else {
                    book.style.display = 'none';
                }
            });

            // Update count
            if (shownSpan) {
                shownSpan.textContent = visibleCount;
            }

            // Show empty message if no books
            const grid = document.getElementById('grid');
            const emptyMsg = grid.querySelector('.empty-message');
            if (visibleCount === 0) {
                if (!emptyMsg) {
                    const msg = document.createElement('p');
                    msg.className = 'empty-message';
                    msg.textContent = 'No titles in this collection yet. Choose another filter.';
                    grid.appendChild(msg);
                }
            } else {
                if (emptyMsg) {
                    emptyMsg.remove();
                }
            }
        }

        // Initialize default view (limit 6)
        filterBooks('all');

        // Filter button clicks
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                filterBooks(filter);
            });
        });

        // ============================================
        // FORMAT SELECTION (Price change)
        // ============================================
        document.querySelectorAll('.format-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.product;
                const price = this.dataset.price;
                const format = this.dataset.format;

                // Update price display
                const priceSpan = document.getElementById('price-' + productId);
                if (priceSpan) {
                    priceSpan.textContent = '$' + parseFloat(price).toFixed(2);
                }

                // Update active state
                const parent = this.closest('.formats');
                parent.querySelectorAll('.format-btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                // Store selected format in data attribute for add to cart
                const bookArticle = this.closest('.book');
                bookArticle.dataset.selectedFormat = format;
                bookArticle.dataset.selectedPrice = price;
            });
        });

        // Set default active format (first one)
        document.querySelectorAll('.formats').forEach(group => {
            const firstBtn = group.querySelector('.format-btn');
            if (firstBtn) {
                firstBtn.classList.add('active');
                const productId = firstBtn.dataset.product;
                const price = firstBtn.dataset.price;
                const priceSpan = document.getElementById('price-' + productId);
                if (priceSpan) {
                    priceSpan.textContent = '$' + parseFloat(price).toFixed(2);
                }
                const bookArticle = firstBtn.closest('.book');
                bookArticle.dataset.selectedFormat = firstBtn.dataset.format;
                bookArticle.dataset.selectedPrice = firstBtn.dataset.price;
            }
        });

        // ============================================
        // ADD TO CART FUNCTIONALITY
        // ============================================
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const bookArticle = this.closest('.book');
                const format = bookArticle.dataset.selectedFormat || 'Paperback';
                const price = parseFloat(bookArticle.dataset.selectedPrice || 0);

                // AJAX call to add to cart
                fetch(cartAddUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        format: format,
                        price: price,
                        qty: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success feedback
                        this.textContent = 'Added ✓';
                        this.classList.add('done');
                        setTimeout(() => {
                            this.textContent = 'Add to cart';
                            this.classList.remove('done');
                        }, 1500);

                        // Sync state.cart and update drawer if helper is present
                        if (typeof window.addToCart === 'function') {
                            window.addToCart(productId, this);
                        } else {
                            const cartCount = document.getElementById('cartCount');
                            if (cartCount) {
                                cartCount.textContent = data.count || parseInt(cartCount.textContent || 0) + 1;
                            }
                            showToast(productName.substring(0, 44) + ' added to cart');
                        }
                    } else {
                        showToast('Error adding to cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error adding to cart');
                });
            });
        });

        // ============================================
        // TOAST NOTIFICATION
        // ============================================
        function showToast(message) {
            const toast = document.getElementById('toast') || createToast();
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }

        function createToast() {
            const toast = document.createElement('div');
            toast.id = 'toast';
            toast.style.cssText = `
                position: fixed;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                background: #333;
                color: #fff;
                padding: 12px 24px;
                border-radius: 8px;
                font-size: 14px;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
                max-width: 90%;
                text-align: center;
            `;
            document.body.appendChild(toast);
            return toast;
        }
    });
</script>

@include('include.footer')
