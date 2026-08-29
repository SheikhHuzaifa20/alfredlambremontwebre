<?php include "include/header.php" ?>
<?php include "include/menu.php" ?>


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

        <div class="grid" id="grid"></div>
    </div>
</section>


<?php include "include/footer.php" ?>