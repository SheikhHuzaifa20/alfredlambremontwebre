/* ---------------------------------------------------------
   CATALOGUE DATA
   Edit prices, links and blurbs here — nothing else changes.
   Retail links intentionally exclude Amazon per author instruction.
--------------------------------------------------------- */
const BOOKS = [
    {
        id: "awake-now", title: "Awake Now: A Confessional", year: "2026", cat: ["consciousness"], lang: "en", tag: "New release",
        bookimg: "book-1.webp",
        blurb: "Five decades of research turned inward. Alfred applies the same evidentiary discipline to his own awakening — what it cost, what it revealed, and what staying awake asks of anyone.",
        formats: [{ f: "Paperback", p: 24.95 }, { f: "eBook", p: 11.99 }]
    },

    {
       id: "venus", title: "Exopolitics &amp; the Advanced Civilization on Venus", year: "2025", cat: ["exopolitics"], lang: "en",
        bookimg: "book-6.webp",
        blurb: "The testimony, documents and contact records behind one of exopolitics' most persistent claims, assembled and assessed in one volume.",
        formats: [{ f: "Paperback", p: 23.95 }, { f: "eBook", p: 11.99 }]
    },

    {
        id: "dimensional-ecology", title: "The Dimensional Ecology of the Omniverse", year: "2014", cat: ["omniverse"], lang: "en",
        bookimg: "book-3.webp",
        blurb: "A map built the way a lawyer builds a case: prima facie evidence for intelligent civilisations across the physical, spiritual and soul dimensions, weighed under the law of evidence.",
        formats: [{ f: "Paperback", p: 29.95 }, { f: "eBook", p: 14.99 }]
    },

    {
        id: "emergence", title: "Emergence of the Omniverse: Universe — Multiverse — Omniverse", year: "2020", cat: ["omniverse"], lang: "en",
        bookimg: "book-4.webp",
        blurb: "How humanity's picture of the cosmos expanded in three stages, and why the third changes what we can say about consciousness, time and the afterlife.",
        formats: [{ f: "Paperback", p: 21.95 }, { f: "eBook", p: 10.99 }]
    },

    {
        id: "exopolitics", title: "Exopolitics: Politics, Government and Law in the Universe", year: "2005", cat: ["exopolitics"], lang: "en",
        bookimg: "book-5.webp",
        blurb: "The founding text of the field. A framework for relations among intelligent civilisations — and an argument for why Earth's quarantine is a political fact, not a physical one.",
        formats: [{ f: "Paperback", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        
          id: "omniverse", title: "The Omniverse", year: "2015", cat: ["omniverse"], lang: "en",
        bookimg: "book-2.webp",
        blurb: "Transdimensional intelligence, time travel, the afterlife and the secret colony on Mars — the book that introduced the Omniverse as a third cosmological body alongside Universe and Multiverse.",
        formats: [{ f: "Paperback", p: 22.95 }, { f: "eBook", p: 12.99 }]
        
       
    },

    {
        id: "peace-in-space", title: "Peace in Space", year: "2024", cat: ["exopolitics"], lang: "en",
        bookimg: "book-7.webp",
        blurb: "The campaign to ban space weapons, told by a co-architect of the Space Preservation Treaty and the Space Preservation Act introduced to the U.S. Congress.",
        formats: [{ f: "Paperback", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "cataclysm", title: "The Age of Cataclysm", year: "1974", cat: ["exopolitics"], lang: "en",
        bookimg: "book-8.webp",
        blurb: "Alfred's first book, written a half-century ago on earthquake prediction and the politics of catastrophe. Still in print, and still uncomfortably current.",
        formats: [{ f: "Paperback", p: 17.95 }]
    },

    {
        id: "chronogarchy", title: "The Chronogarchy", year: "2022", cat: ["chronogarchy"], lang: "en",
        bookimg: "book-9.webp",
        blurb: "How interdimensional quantum-access time travel is used to manipulate human events, human history and the interlife — with the interviews and sources behind the claim.",
        formats: [{ f: "Paperback", p: 26.95 }, { f: "eBook", p: 13.99 }]
    },

    {
        id: "timelines", title: "Timelines of the Chronogarchy: A Multidimensional Novel", year: "2022", cat: ["chronogarchy"], lang: "en",
        bookimg: "book-10.webp",
        blurb: "The research turned into fiction. A novel that moves along competing timelines, written so the reader has to hold more than one version of history at once.",
        formats: [{ f: "Paperback", p: 18.95 }, { f: "eBook", p: 8.99 }]
    },

    {
        id: "time-screen", title: "Time Screen (Public Inquiry, Book 2)", year: "2022", cat: ["chronogarchy", "inquiry"], lang: "en",
        bookimg: "book-11.webp",
        blurb: "A hundred-year plot to break apart America, examined through time travel, treason and the documentary record — volume two of the ongoing Public Inquiry.",
        formats: [{ f: "Paperback", p: 21.95 }, { f: "eBook", p: 10.99 }]
    },

    {
        id: "diary-2022", title: "2022 Diary (Public Inquiry, Book 3)", year: "2023", cat: ["inquiry"], lang: "en",
        bookimg: "book-12.webp",
        blurb: "A working journal kept in real time as the year unfolded — dated entries, sources and provisional conclusions, published without hindsight edits.",
        formats: [{ f: "Paperback", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "break-up", title: "Will the United States Break Up Into Many Regions? — A Public Inquiry, Vol. I", year: "2024", cat: ["inquiry"], lang: "en",
        bookimg: "book-13.webp",
        blurb: "June 2023 to June 2024, collected. The question is put openly, the evidence is gathered publicly, and the reader is left to weigh it.",
        formats: [{ f: "Paperback", p: 24.95 }, { f: "eBook", p: 12.99 }]
    },

    {
        id: "ai-invasion", title: "AI Invasion: What ChatGPT &amp; Sudowrite Tell Me", year: "2023", cat: ["inquiry"], lang: "en",
        bookimg: "book-14.webp",
        blurb: "An extended interrogation of two AI systems about consciousness, agenda and the future — transcripts included, so the reader can judge the machines directly.",
        formats: [{ f: "Paperback", p: 17.95 }, { f: "eBook", p: 8.99 }]
    },

    {
        id: "apocalypse", title: "Apocalypse &amp; Transformation 2040–2046 A.D.", year: "2024", cat: ["consciousness"], lang: "en",
        bookimg: "book-15.webp",
        blurb: "A dated forecast built from the Positive Future Equation — what the projections show for the middle of this century, and the case for the transformation side of the ledger.",
        formats: [{ f: "Paperback", p: 22.95 }, { f: "eBook", p: 11.99 }]
    },

    {
        id: "journey", title: "My Journey Landing Heaven on Earth", year: "2015", cat: ["consciousness"], lang: "en",
        bookimg: "book-16.webp",
        blurb: "Volume one of the spiritual autobiography: the experiences that moved Alfred's work from law and policy toward soul, source and the interlife.",
        formats: [{ f: "Paperback", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "revelation", title: "A Revelation on the Life and Teachings of Jesus (Vol. II)", year: "2022", cat: ["consciousness"], lang: "en",
        bookimg: "book-17.webp",
        blurb: "Volume two. New multidimensional evidence on the historical Jesus, set against the canonical record and the missing texts.",
        formats: [{ f: "Paperback", p: 21.95 }, { f: "eBook", p: 10.99 }]
    },

    {
        id: "soul-infrastructure", title: "We Awakening Humanity Are the Soul Infrastructure of the Second Coming of Christ", year: "2023", cat: ["consciousness"], lang: "en",
        bookimg: "book-18.webp",
        blurb: "The argument that the Second Coming is not an arrival but an infrastructure — built out of awakening human souls, and already under construction.",
        formats: [{ f: "Paperback", p: 20.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "antichrists", title: "Tracking the AntiChrists", year: "2022", cat: ["consciousness"], lang: "en",
        bookimg: "book-19.webp",
        blurb: "Course text two in the Historical Jesus series: who the tradition names, what the multidimensional evidence adds, and how to tell the difference.",
        formats: [{ f: "Paperback", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "levesque", title: "The Levesque Cases", year: "2011", cat: ["exopolitics"], lang: "en",
        bookimg: "book-20.webp",
        blurb: "A casebook drawn from contact testimony, assembled and cross-examined the way a trial record would be.",
        formats: [{ f: "Paperback", p: 18.95 }]
    },

    {
        id: "exopolitica", title: "Exopolítica: La política, el gobierno y la ley en el universo", year: "2013", cat: ["exopolitics", "es"], lang: "es",
        bookimg: "book-21.webp",
        blurb: "La edición en español del texto fundacional de la exopolítica, traducida por Anna Renau Bahima.",
        formats: [{ f: "Rústica", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "aparicion", title: "La aparición del Omniverso: Universo — Multiverso — Omniverso", year: "2020", cat: ["omniverse", "es"], lang: "es",
        bookimg: "book-22.webp",
        blurb: "Cómo la imagen humana del cosmos se amplió en tres etapas, y por qué la tercera lo cambia todo.",
        formats: [{ f: "Rústica", p: 21.95 }, { f: "eBook", p: 10.99 }]
    },

    {
        id: "revelacion", title: "Una revelación sobre la vida y las enseñanzas de Jesús (Vol. II)", year: "2022", cat: ["consciousness", "es"], lang: "es",
        bookimg: "book-23.webp",
        blurb: "Volumen II de Mi viaje aterrizando el cielo en la tierra: nueva evidencia multidimensional sobre el Jesús histórico.",
        formats: [{ f: "Rústica", p: 21.95 }, { f: "eBook", p: 10.99 }]
    },

    {
        id: "anticristos", title: "Siguiendo a los Anticristos", year: "2023", cat: ["consciousness", "es"], lang: "es",
        bookimg: "book-24.webp",
        blurb: "La edición en español de Tracking the AntiChrists, con el material del curso completo.",
        formats: [{ f: "Rústica", p: 19.95 }, { f: "eBook", p: 9.99 }]
    },

    {
        id: "regiones", title: "¿Se dividirán los Estados Unidos en muchas regiones? — Una investigación pública", year: "2025", cat: ["inquiry", "es"], lang: "es",
        bookimg: "book-25.webp",
        blurb: "La investigación pública en español: la pregunta, las fuentes y la evidencia reunida hasta la fecha.",
        formats: [{ f: "Rústica", p: 24.95 }, { f: "eBook", p: 12.99 }]
    },

    {
        id: "omniversum", title: "Das Omniversum", year: "2017", cat: ["omniverse", "de"], lang: "de",
        bookimg: "book-26.webp",
        blurb: "Transdimensionale Intelligenz, hyperdimensionale Zivilisationen und die geheime Marskolonie — die deutsche Ausgabe von The Omniverse.",
        formats: [{ f: "Taschenbuch", p: 24.95 }, { f: "eBook", p: 12.99 }]
    }
];

/* Retail channels — Amazon deliberately excluded */
const STORES = [
    { n: "IngramSpark", u: "#" },
    { n: "Draft2Digital", u: "#" },
    { n: "Kobo", u: "#" },
    { n: "Lulu", u: "#" }
];

/* ---------------- render ---------------- */
const grid = document.getElementById('grid');
const state = { filter: 'all', chosen: {}, cart: [] };
const isHomePage = document.getElementById('grid').classList.contains('home-books');

function money(n) { return '$' + n.toFixed(2) }

function render() {
    // const list = BOOKS.filter(b => state.filter === 'all' ? true
    //     : (b.cat.includes(state.filter) || b.lang === state.filter));
        let list = BOOKS.filter(b => state.filter === 'all' ? true : (b.cat.includes(state.filter) || b.lang === state.filter) );
        
        if (isHomePage) { list = list.slice(0, 6); }
        
    // document.getElementById('shown').textContent = list.length;

    const shown = document.getElementById('shown');

    if (shown) {
        shown.textContent = list.length;
    }

    if (!list.length) {
        grid.innerHTML = '<p class="empty">No titles in this collection yet. Choose another filter.</p>';
        return;
    }

    grid.innerHTML = list.map(b => {
        const idx = state.chosen[b.id] ?? 0;
        const fmt = b.formats[idx];
        return `
    <article class="book">
      <div class="cover">
        <img src="assets/images/client-books/${b.bookimg}" class="img-fluid">
      </div>
      <div class="book-body">
        <p class="meta">${b.year} &middot; ${b.lang === 'es' ? 'Español' : b.lang === 'de' ? 'Deutsch' : 'English'}</p>
        <h3>${b.title}</h3>
        <p class="blurb">${b.blurb}</p>
        <div class="formats" role="group" aria-label="Choose format for ${b.title.replace(/&amp;/g, 'and')}">
          ${b.formats.map((f, i) => `<button data-fmt="${b.id}:${i}" aria-pressed="${i === idx}">${f.f}</button>`).join('')}
        </div>
        <div class="price-row"><span class="price">${money(fmt.p)}</span></div>
        <button class="add" data-add="${b.id}">Add to cart</button>
        <div class="stores">Also at: ${STORES.map(s => `<a href="${s.u}">${s.n}</a>`).join('')}</div>
      </div>
    </article>`;
    }).join('');
}


/* ---------------- interactions ---------------- */
document.getElementById('filters').addEventListener('click', e => {
    const b = e.target.closest('button[data-f]'); if (!b) return;
    state.filter = b.dataset.f;
    [...e.currentTarget.querySelectorAll('button')].forEach(x => x.setAttribute('aria-pressed', x === b));
    render();
});

render();

document.addEventListener('click', e => {
    const f = e.target.closest('[data-fmt]');
    if (f) {
        const [id, i] = f.dataset.fmt.split(':');
        state.chosen[id] = +i;
        render();
        return;
    }
    const a = e.target.closest('[data-add]');
    if (a) { addToCart(a.dataset.add, a); }
});

function addToCart(id, btn) {
    const b = BOOKS.find(x => x.id === id); if (!b) return;
    const i = state.chosen[id] ?? 0;
    const fmt = b.formats[i];
    const key = id + ':' + i;
    const line = state.cart.find(l => l.key === key);
    if (line) line.q++;
    else state.cart.push({ key, id, title: b.title, fmt: fmt.f, price: fmt.p, q: 1 });
    drawCart();
    toast(b.title.replace(/&amp;/g, '&').slice(0, 44) + ' added');
    if (btn && btn.classList.contains('add')) {
        btn.classList.add('done'); btn.textContent = 'Added ✓';
        setTimeout(() => { btn.classList.remove('done'); btn.textContent = 'Add to cart'; }, 1400);
    }
}

const linesEl = document.getElementById('lines');
function drawCart() {
    const count = state.cart.reduce((s, l) => s + l.q, 0);
    document.getElementById('cartCount').textContent = count;
    const total = state.cart.reduce((s, l) => s + l.q * l.price, 0);
    document.getElementById('subtotal').textContent = money(total);

    linesEl.innerHTML = state.cart.length ? state.cart.map(l => `
    <div class="line">
      <div>
        <h4>${l.title}</h4>
        <p class="lf">${l.fmt}</p>
        <div class="qty">
          <button data-q="${l.key}:-1" aria-label="Decrease quantity">−</button>
          <span>${l.q}</span>
          <button data-q="${l.key}:1" aria-label="Increase quantity">+</button>
        </div>
      </div>
      <div>
        <p class="lp">${money(l.price * l.q)}</p>
        <button class="remove" data-rm="${l.key}">Remove</button>
      </div>
    </div>`).join('')
        : '<p class="cart-empty">Your order is empty.<br>Browse the catalogue to begin.</p>';
}

linesEl.addEventListener('click', e => {
    const q = e.target.closest('[data-q]');
    if (q) {
        const p = q.dataset.q.split(':');
        const key = p[0] + ':' + p[1], d = +p[2];
        const line = state.cart.find(l => l.key === key);
        if (line) { line.q += d; if (line.q < 1) state.cart = state.cart.filter(l => l.key !== key); }
        drawCart(); return;
    }
    const r = e.target.closest('[data-rm]');
    if (r) { state.cart = state.cart.filter(l => l.key !== r.dataset.rm); drawCart(); }
});

const drawer = document.getElementById('drawer'), scrim = document.getElementById('scrim');
function openCart(o) {
    drawer.classList.toggle('open', o); scrim.classList.toggle('open', o);
    drawer.setAttribute('aria-hidden', String(!o));
}
document.getElementById('openCart').onclick = () => openCart(true);
document.getElementById('closeCart').onclick = () => openCart(false);
scrim.onclick = () => openCart(false);
document.addEventListener('keydown', e => { if (e.key === 'Escape') openCart(false) });

document.getElementById('checkout').onclick = () => {
    if (!state.cart.length) { toast('Add a book to your order first'); return; }
    toast('Connect payment gateway to complete checkout');
};

document.getElementById('subBtn').onclick = () => {
    const v = document.getElementById('subEmail').value.trim();
    toast(/^\S+@\S+\.\S+$/.test(v) ? 'Subscribed — thank you' : 'Enter a valid email address');
    if (/^\S+@\S+\.\S+$/.test(v)) document.getElementById('subEmail').value = '';
};
document.getElementById('sendBtn').onclick = () => {
    const n = document.getElementById('cName').value.trim(), m = document.getElementById('cMsg').value.trim();
    toast(n && m ? 'Message sent — we reply within two business days' : 'Add your name and a message');
};

const menuToggle = document.getElementById('menuToggle'), nav = document.getElementById('nav');
menuToggle.onclick = () => {
    const o = nav.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', String(o));
    menuToggle.textContent = o ? 'Close' : 'Menu';
};
nav.addEventListener('click', e => { if (e.target.tagName === 'A') { nav.classList.remove('open'); menuToggle.textContent = 'Menu' } });

let tId;
const toastEl = document.getElementById('toast');
function toast(msg) {
    toastEl.textContent = msg; toastEl.classList.add('show');
    clearTimeout(tId); tId = setTimeout(() => toastEl.classList.remove('show'), 2600);
}

/* starfield */
(function () {
    const svg = document.querySelector('.starfield');
    let s = '';
    for (let i = 0; i < 90; i++) {
        const x = Math.random() * 100, y = Math.random() * 100, r = Math.random() * 1.3 + .3, o = Math.random() * .5 + .12;
        s += `<circle cx="${x}%" cy="${y}%" r="${r}" fill="#EDE7DA" opacity="${o.toFixed(2)}"/>`;
    }
    svg.innerHTML = s;
})();

document.getElementById('yr').textContent = new Date().getFullYear();
render(); drawCart();
