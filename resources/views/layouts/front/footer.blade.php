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

<!-- cart -->
<div class="scrim" id="scrim"></div>
<aside class="drawer" id="drawer" aria-label="Shopping cart" aria-hidden="true">
    <div class="drawer-head">
        <h3>Your order</h3>
        <button class="close" id="closeCart">Close</button>
    </div>
    <div class="lines" id="lines"></div>
    <div class="drawer-foot">
        <div class="total"><span>Subtotal</span><span id="subtotal">$0.00</span></div>
        <p class="ship">Shipping and tax calculated at checkout. Ebooks are delivered by email within minutes.</p>
        <button class="checkout" id="checkout">Proceed to checkout</button>
    </div>
</aside>

<div class="toast" id="toast" role="status" aria-live="polite"></div>
