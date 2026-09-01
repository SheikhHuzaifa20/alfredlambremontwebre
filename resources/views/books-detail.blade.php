@extends('layouts.main')

@section('content')

{{-- ===== HERO ===== --}}
<section class="book-detail-hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <a href="{{ route('books') }}" class="back-link">← Back to Books</a>
    </div>
</section>

{{-- ===== MAIN DETAIL ===== --}}
<section class="book-detail-section">
    <div class="wrap">
        <div class="bd-grid">

            {{-- Cover --}}
            <div class="bd-cover">
                @if($product->primaryImage && $product->primaryImage->image_path)
                    <img src="{{ asset($product->primaryImage->image_path) }}"
                         alt="{{ $product->name }}" class="bd-cover-img">
                @else
                    <div class="bd-cover-placeholder">
                        <span>{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="bd-info">
                <p class="meta">
                    {{ $product->created_at ? $product->created_at->format('Y') : date('Y') }}
                    @if($product->categories && $product->categories->isNotEmpty())
                        &middot; {{ $product->categories->pluck('name')->implode(', ') }}
                    @endif
                </p>

                <h1 class="bd-title">{{ $product->name }}</h1>

                @if($product->short_description)
                    <p class="bd-blurb">{{ $product->short_description }}</p>
                @endif

                {{-- Format Selector --}}
                <div class="bd-formats" id="formatGroup">
                    @foreach($formats as $i => $fmt)
                        <button class="bd-fmt-btn {{ $i === 0 ? 'active' : '' }}"
                                data-format="{{ $fmt['f'] }}"
                                data-price="{{ $fmt['p'] }}"
                                data-index="{{ $i }}">
                            {{ $fmt['f'] }}
                        </button>
                    @endforeach
                </div>

                <div class="bd-price-row">
                    <span class="bd-price" id="selectedPrice">
                        ${{ number_format($formats[0]['p'] ?? 0, 2) }}
                    </span>
                </div>

                {{-- Quantity --}}
                <div class="bd-qty-row">
                    <label class="bd-qty-label">Qty</label>
                    <div class="bd-qty">
                        <button id="qtyMinus" aria-label="Decrease">−</button>
                        <input type="number" id="qtyInput" value="1" min="1" max="99">
                        <button id="qtyPlus" aria-label="Increase">+</button>
                    </div>
                </div>

                {{-- Add to Cart --}}
                <button class="bd-add-btn" id="addToCartBtn"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        data-format="{{ $formats[0]['f'] ?? 'Paperback' }}"
                        data-price="{{ $formats[0]['p'] ?? 0 }}">
                    Add to Cart
                </button>

                @if($product->sku)
                    <p class="bd-sku">SKU: {{ $product->sku }}</p>
                @endif
            </div>
        </div>

        {{-- Full Description --}}
        @if($product->description || $product->text2)
        <div class="bd-desc-section">
            <h2 class="bd-desc-title">About This Book</h2>
            <div class="bd-desc-body">
                {!! $product->description !!}
                @if($product->text2)
                    {!! $product->text2 !!}
                @endif
            </div>
        </div>
        @endif

        {{-- Gallery --}}
        @if($product->galleryImages && $product->galleryImages->count())
        <div class="bd-gallery">
            <h2 class="bd-desc-title">Gallery</h2>
            <div class="bd-gallery-grid">
                @foreach($product->galleryImages as $img)
                    <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@section('css')
<style>
/* ---- Book Detail Page ---- */
.book-detail-hero {
    position: relative;
    padding: 60px 0 30px;
    overflow: hidden;
    background: linear-gradient(180deg, rgba(29,36,82,.7), rgba(11,16,38,0));
}
.book-detail-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(200,162,75,.08), transparent 55%);
    pointer-events: none;
}
.back-link {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--parchment-dim);
    border-bottom: 1px solid var(--rule);
    padding-bottom: 2px;
    transition: color .2s;
}
.back-link:hover { color: var(--brass); border-color: var(--brass); }

.book-detail-section { padding: 60px 0 100px; }

.bd-grid {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 60px;
    align-items: start;
}
@media(max-width:860px) {
    .bd-grid { grid-template-columns: 1fr; gap: 40px; }
    .bd-cover { max-width: 320px; margin: 0 auto; }
}

/* Cover */
.bd-cover {
    position: relative;
    border: 1px solid var(--rule);
    border-radius: 3px;
    background: var(--veil);
    overflow: hidden;
}
.bd-cover::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(115deg, transparent 0 13px, rgba(237,231,218,.04) 13px 14px);
    pointer-events: none;
}
.bd-cover-img { width: 100%; display: block; object-fit: cover; }
.bd-cover-placeholder {
    aspect-ratio: 3/4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--display);
    font-size: 80px;
    color: var(--brass);
    opacity: .5;
}

/* Info */
.bd-info .meta {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--parchment-dim);
    margin-bottom: 14px;
}
.bd-title {
    font-family: var(--display);
    font-weight: 400;
    font-size: clamp(28px, 3.5vw, 46px);
    line-height: 1.1;
    margin-bottom: 18px;
    letter-spacing: -.012em;
}
.bd-blurb {
    font-size: 17px;
    line-height: 1.72;
    color: #C4BEB1;
    margin-bottom: 28px;
    max-width: 54ch;
}

/* Formats */
.bd-formats {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}
.bd-fmt-btn {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .1em;
    text-transform: uppercase;
    border: 1px solid var(--rule);
    border-radius: 2px;
    padding: 9px 16px;
    color: var(--parchment-dim);
    cursor: pointer;
    transition: .18s;
    background: none;
}
.bd-fmt-btn:hover { border-color: var(--brass); color: var(--parchment); }
.bd-fmt-btn.active {
    border-color: var(--signal);
    color: var(--signal);
    background: rgba(111,211,199,.09);
}

/* Price */
.bd-price-row { margin-bottom: 24px; }
.bd-price {
    font-family: var(--mono);
    font-size: 30px;
    color: var(--parchment);
}

/* Qty */
.bd-qty-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 22px;
}
.bd-qty-label {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--parchment-dim);
}
.bd-qty {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1px solid var(--rule);
    border-radius: 2px;
    overflow: hidden;
}
.bd-qty button {
    width: 38px;
    height: 38px;
    background: rgba(29,36,82,.5);
    color: var(--parchment-dim);
    border: none;
    font-size: 18px;
    cursor: pointer;
    transition: background .15s;
    font-family: var(--mono);
}
.bd-qty button:hover { background: var(--brass); color: var(--ink); }
#qtyInput {
    width: 56px;
    height: 38px;
    text-align: center;
    background: transparent;
    border: none;
    border-left: 1px solid var(--rule);
    border-right: 1px solid var(--rule);
    color: var(--parchment);
    font-family: var(--mono);
    font-size: 15px;
    -moz-appearance: textfield;
    flex: unset;
    min-width: unset;
}
#qtyInput::-webkit-outer-spin-button,
#qtyInput::-webkit-inner-spin-button { -webkit-appearance: none; }

/* Add btn */
.bd-add-btn {
    display: block;
    width: 100%;
    max-width: 360px;
    background: var(--brass);
    color: var(--ink);
    font-family: var(--mono);
    font-size: 12px;
    letter-spacing: .14em;
    text-transform: uppercase;
    padding: 16px;
    border-radius: 2px;
    cursor: pointer;
    border: 1px solid var(--brass);
    transition: background .2s, transform .15s;
    margin-bottom: 18px;
}
.bd-add-btn:hover { background: #DCB963; border-color: #DCB963; }
.bd-add-btn.done { background: var(--signal); border-color: var(--signal); }
.bd-add-btn:disabled { opacity: .6; cursor: default; }

.bd-sku {
    font-family: var(--mono);
    font-size: 10.5px;
    letter-spacing: .1em;
    color: var(--parchment-dim);
}

/* Description */
.bd-desc-section {
    margin-top: 70px;
    padding-top: 50px;
    border-top: 1px solid var(--rule);
}
.bd-desc-title {
    font-family: var(--display);
    font-weight: 400;
    font-size: clamp(24px, 2.8vw, 36px);
    margin-bottom: 28px;
}
.bd-desc-body {
    font-size: 17px;
    line-height: 1.8;
    color: #C4BEB1;
    max-width: 72ch;
}
.bd-desc-body p { margin-bottom: 18px; }

/* Gallery */
.bd-gallery { margin-top: 60px; }
.bd-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    margin-top: 24px;
}
.bd-gallery-grid img {
    border-radius: 3px;
    border: 1px solid var(--rule);
    width: 100%;
    object-fit: cover;
    aspect-ratio: 4/3;
}

/* Toast notification */
#bd-toast {
    position: fixed;
    left: 50%;
    bottom: 34px;
    transform: translate(-50%, 140%);
    z-index: 100;
    background: var(--veil-2);
    border: 1px solid var(--brass);
    border-radius: 2px;
    padding: 13px 22px;
    font-family: var(--mono);
    font-size: 11.5px;
    letter-spacing: .1em;
    text-transform: uppercase;
    transition: transform .3s;
    max-width: 90vw;
    text-align: center;
    display: none;
}
#bd-toast.show { transform: translate(-50%, 0); display: block; }
</style>
@endsection

@section('js')
<script>
    window.CART_ADD_URL    = "{{ route('cart.add') }}";
    window.CART_SYNC_URL   = "{{ route('cart.sync') }}";
    window.CART_DATA_URL   = "{{ route('cart.data') }}";
    window.CSRF_TOKEN      = "{{ csrf_token() }}";

    const csrfToken = window.CSRF_TOKEN;
    let selectedFormat = @json($formats[0]['f'] ?? 'Paperback');
    let selectedPrice  = {{ $formats[0]['p'] ?? 0 }};

    // Toast
    function bdToast(msg, duration) {
        let t = document.getElementById('bd-toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'bd-toast';
            document.body.appendChild(t);
        }
        t.style.display = 'block';
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.style.display='none', 350); }, duration || 2600);
    }

    // Format selector
    document.querySelectorAll('.bd-fmt-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.bd-fmt-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedFormat = btn.dataset.format;
            selectedPrice  = parseFloat(btn.dataset.price);
            document.getElementById('selectedPrice').textContent = '$' + selectedPrice.toFixed(2);
            // update add-btn data attrs
            const addBtn = document.getElementById('addToCartBtn');
            addBtn.dataset.format = selectedFormat;
            addBtn.dataset.price  = selectedPrice;
        });
    });

    // Qty
    document.getElementById('qtyMinus').addEventListener('click', () => {
        const inp = document.getElementById('qtyInput');
        if (+inp.value > 1) inp.value = +inp.value - 1;
    });
    document.getElementById('qtyPlus').addEventListener('click', () => {
        const inp = document.getElementById('qtyInput');
        inp.value = +inp.value + 1;
    });

    // Add to Cart (AJAX → session, then update header cart count)
    document.getElementById('addToCartBtn').addEventListener('click', function () {
        const btn = this;
        const productId = btn.dataset.productId;
        const format    = btn.dataset.format;
        const price     = parseFloat(btn.dataset.price);
        const qty       = parseInt(document.getElementById('qtyInput').value) || 1;

        btn.disabled = true;
        btn.textContent = 'Adding...';

        fetch(window.CART_ADD_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId, format, price, qty })
        })
        .then(r => r.json())
        .then(data => {
            btn.classList.add('done');
            btn.textContent = 'Added ✓';
            bdToast('{{ $product->name }}' + ' added to cart');

            // Update cart count in header if element exists
            const cc = document.getElementById('cartCount');
            if (cc && data.count !== undefined) cc.textContent = data.count;

            setTimeout(() => {
                btn.classList.remove('done');
                btn.textContent = 'Add to Cart';
                btn.disabled = false;
            }, 1600);
        })
        .catch(() => {
            btn.textContent = 'Error — try again';
            btn.disabled = false;
            bdToast('Could not add to cart. Please try again.');
        });
    });

    // Init cart count from session
    fetch(window.CART_DATA_URL, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            const cc = document.getElementById('cartCount');
            if (cc && data.count !== undefined) cc.textContent = data.count;
        }).catch(() => {});
</script>
@endsection
