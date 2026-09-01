<footer>
    <div class="wrap">
        <div class="fgrid">
            <div>
                <div class="mark" style="font-size:26px">Alfred Lambremont Webre<span>JD &middot; MEd &middot;
                        Author &amp; futurist</span></div>
                <p style="margin-top:18px;max-width:34em;color:var(--parchment-dim);font-size:15px">Books are
                    printed and distributed through the IngramSpark network and delivered digitally through
                    Draft2Digital, Kobo and Lulu.</p>
            </div>
            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('books') }}">All books</a></li>
                    <li><a href="{{ route('about') }}">About Alfred</a></li>
                    <li><a href="{{ route('home') }}#speaking">Speaking</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4>Order &amp; support</h4>
                <ul>
                    <li><a href="{{ route('shipping-and-delivery') }}">Shipping &amp; delivery</a></li>
                    <li><a href="{{ route('returns') }}">Returns</a></li>
                    <li><a href="{{ route('bulk-and-course-orders') }}">Bulk &amp; course orders</a></li>
                    <li><a href="{{ route('foreign-rights') }}">Foreign rights</a></li>
                </ul>
            </div>
        </div>
        <div class="legal">
            <span>&copy; <span id="yr"></span> Alfred Lambremont Webre. All rights reserved.</span>
            <span>Privacy &middot; Terms &middot; Site by The Authors Atelier</span>
        </div>
    </div>
</footer>

<!-- ============================================================ -->
<!-- CART DRAWER -->
<!-- ============================================================ -->
<div class="scrim" id="scrim"></div>
<aside class="drawer" id="drawer" aria-label="Shopping cart" aria-hidden="true">
    <div class="drawer-head">
        <h3>Your order</h3>
        <button class="close" id="closeCart">Close</button>
    </div>
    <div class="lines" id="lines">
        <p class="cart-empty">Your order is empty.<br>Browse the catalogue to begin.</p>
    </div>
    <div class="drawer-foot">
        <div class="total">
            <span>Subtotal</span>
            <span id="subtotal">$0.00</span>
        </div>
        <p class="ship">Shipping and tax calculated at checkout. Ebooks are delivered by email within minutes.</p>
        <a href="{{ route('checkout') }}" class="checkout" id="checkoutBtn">Proceed to checkout</a>
    </div>
</aside>

<!-- ============================================================ -->
<!-- TOAST -->
<!-- ============================================================ -->
<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
    // ============================================
    // GLOBAL VARIABLES
    // ============================================
    const csrfToken = "{{ csrf_token() }}";
    const cartAddUrl = "{{ route('cart.add') }}";
    const cartRemoveUrl = "{{ route('cart.remove') }}";
    const cartDataUrl = "{{ route('cart.data') }}";
    const checkoutUrl = "{{ route('checkout') }}";

    // ============================================
    // TOAST FUNCTION
    // ============================================
    window.showToast = function(message) {
        const toast = document.getElementById('toast');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(toast._timer);
        toast._timer = setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    };

    // ============================================
    // RENDER CART ITEMS - FIXED
    // ============================================
    window.renderCart = function(cartData) {
        const linesEl = document.getElementById('lines');
        const subtotalEl = document.getElementById('subtotal');
        const cartCountEl = document.getElementById('cartCount');

        if (!linesEl) return;

        console.log('Rendering cart with data:', cartData);

        // If no cart data or empty
        if (!cartData || cartData.length === 0) {
            linesEl.innerHTML = '<p class="cart-empty">Your order is empty.<br>Browse the catalogue to begin.</p>';
            if (subtotalEl) subtotalEl.textContent = '$0.00';
            if (cartCountEl) cartCountEl.textContent = '0';
            return;
        }

        let total = 0;
        let count = 0;
        let html = '';

        // Loop through all items in cart
        cartData.forEach(function(item) {
            // Calculate item total
            const itemTotal = (item.baseprice || 0) * (item.qty || 1);
            total += itemTotal;
            count += (item.qty || 1);

            // Get item details
            const itemName = item.name || 'Product';
            const itemFormat = item.mat_language || 'Paperback';
            const itemKey = item.key || 'item_' + item.id;

            console.log('Adding item to cart display:', itemName, 'Qty:', item.qty, 'Price:', item.baseprice);

            html += `
            <div class="line" data-key="${itemKey}">
                <div>
                    <h4>${itemName}</h4>
                    <p class="lf">${itemFormat}</p>
                    <div class="qty">
                        <button onclick="window.updateQty('${itemKey}', -1)">−</button>
                        <span>${item.qty || 1}</span>
                        <button onclick="window.updateQty('${itemKey}', 1)">+</button>
                    </div>
                </div>
                <div>
                    <p class="lp">$${itemTotal.toFixed(2)}</p>
                    <button class="remove" onclick="window.removeFromCart('${itemKey}')">Remove</button>
                </div>
            </div>
            `;
        });

        // Update cart display
        linesEl.innerHTML = html;
        if (subtotalEl) subtotalEl.textContent = '$' + total.toFixed(2);
        if (cartCountEl) cartCountEl.textContent = count;

        console.log('Total items in cart:', count, 'Total price:', total);
    };

    // ============================================
    // UPDATE QUANTITY
    // ============================================
    window.updateQty = function(key, delta) {
        fetch(cartDataUrl, {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.cart) return;
            const item = data.cart.find(i => i.key === key);
            if (!item) return;

            const newQty = Math.max(1, (item.qty || 1) + delta);

            fetch(cartAddUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    product_id: item.id,
                    format: item.mat_language || 'Paperback',
                    price: item.baseprice || 0,
                    qty: newQty
                })
            })
            .then(r => r.json())
            .then(result => {
                if (result.success) {
                    window.loadCart();
                }
            })
            .catch(() => window.loadCart());
        })
        .catch(() => window.loadCart());
    };

    // ============================================
    // REMOVE FROM CART
    // ============================================
    window.removeFromCart = function(key) {
        fetch(cartRemoveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ key: key })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.loadCart();
                window.showToast('Item removed from cart');
            }
        })
        .catch(() => window.loadCart());
    };

    // ============================================
    // LOAD CART DATA - MAIN FUNCTION
    // ============================================
    window.loadCart = function() {
        console.log('Loading cart data from:', cartDataUrl);
        
        fetch(cartDataUrl, {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => {
            console.log('Cart response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Cart data received:', data);
            
            // Update cart count in header
            const cartCountEl = document.getElementById('cartCount');
            if (cartCountEl && data.count !== undefined) {
                cartCountEl.textContent = data.count;
            }
            
            // Render cart items
            if (data.cart) {
                window.renderCart(data.cart);
            } else {
                window.renderCart([]);
            }
        })
        .catch(error => {
            console.error('Error loading cart:', error);
            window.renderCart([]);
        });
    };

    // ============================================
    // CART DRAWER - OPEN/CLOSE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const drawer = document.getElementById('drawer');
        const scrim = document.getElementById('scrim');
        const openBtn = document.getElementById('openCart');
        const closeBtn = document.getElementById('closeCart');

        window.openCart = function() {
            if (drawer) drawer.classList.add('open');
            if (scrim) scrim.classList.add('open');
            if (drawer) drawer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        window.closeCart = function() {
            if (drawer) drawer.classList.remove('open');
            if (scrim) scrim.classList.remove('open');
            if (drawer) drawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', window.openCart);
        if (closeBtn) closeBtn.addEventListener('click', window.closeCart);
        if (scrim) scrim.addEventListener('click', window.closeCart);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') window.closeCart();
        });

        // ============================================
        // CHECKOUT BUTTON
        // ============================================
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = checkoutUrl;
            });
        }

        // ============================================
        // MOBILE MENU
        // ============================================
        const menuToggle = document.getElementById('menuToggle');
        const nav = document.getElementById('nav');
        if (menuToggle && nav) {
            menuToggle.addEventListener('click', function() {
                const isOpen = nav.classList.toggle('open');
                this.setAttribute('aria-expanded', isOpen);
                this.textContent = isOpen ? 'Close' : 'Menu';
            });

            nav.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    this.classList.remove('open');
                    if (menuToggle) {
                        menuToggle.textContent = 'Menu';
                        menuToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }

        // ============================================
        // INIT - Load cart on page load
        // ============================================
        window.loadCart();

        const yrEl = document.getElementById('yr');
        if (yrEl) {
            yrEl.textContent = new Date().getFullYear();
        }
    });
</script>