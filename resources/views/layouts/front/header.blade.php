<header>
    <div class="wrap bar">
        <a href="{{ route('home') }}#top" class="mark">Alfred Lambremont Webre<span>JD &middot; MEd</span></a>
        <button class="menu-toggle" id="menuToggle" aria-expanded="false">Menu</button>
        <nav class="main" id="nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('books') }}">Books</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('exopolitics') }}">Exopolitics</a>
            <a href="{{ route('home') }}#speaking">Speaking</a>
            <a href="{{ route('contact') }}">Contact</a>
        </nav>
        <button class="cart-btn" id="openCart">Cart (<span id="cartCount">0</span>)</button>
    </div>
</header>
