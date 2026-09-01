document.addEventListener('DOMContentLoaded', function() {
    // Starfield
    const svg = document.querySelector('.starfield');
    if (svg) {
        let stars = '';
        for (let i = 0; i < 90; i++) {
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            const r = Math.random() * 1.3 + 0.3;
            const o = Math.random() * 0.5 + 0.12;
            stars += `<circle cx="${x}%" cy="${y}%" r="${r}" fill="#EDE7DA" opacity="${o.toFixed(2)}"/>`;
        }
        svg.innerHTML = stars;
    }

    // Year
    const yrEl = document.getElementById('yr');
    if (yrEl) {
        yrEl.textContent = new Date().getFullYear();
    }

    // Mobile Menu
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
});