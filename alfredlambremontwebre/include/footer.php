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
                    <li><a href="books.php">All books</a></li>
                    <li><a href="about.php">About Alfred</a></li>
                    <li><a href="index.php#speaking">Speaking</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4>Order &amp; support</h4>
                <ul>
                    <li><a href="shipping-and-delivery.php">Shipping &amp; delivery</a></li>
                    <li><a href="returns.php">Returns</a></li>
                    <li><a href="bulk-and-course-orders.php">Bulk &amp; course orders</a></li>
                    <li><a href="foreign-rights.php">Foreign rights</a></li>
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="js/script.js" defer></script>

<script>
    $('.testimonials-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        navText: ['<i class="fa-solid fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    })
</script>


</body>

</html>