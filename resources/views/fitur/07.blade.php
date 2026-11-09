@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    .search-wrap {
        margin-top: 20px;
        padding: clamp(24px, 6vw, 48px);
        background: white;
        border: 1px solid var(--line);
        border-top: 5px solid var(--orange);
        border-radius: 14px;
    }
    .search-wrap .badge { margin-bottom: 0; }
    .search-wrap h1 { margin-top: 18px; margin-bottom: 6px; }
    .search-wrap .lead {
        color: var(--muted);
        margin: 0 0 28px;
    }

    /* Input bar */
    .search-bar {
        display: flex;
        gap: 10px;
        align-items: stretch;
        margin-bottom: 28px;
    }
    .search-bar input {
        flex: 1;
        padding: 12px 16px;
        font-size: 1rem;
        border: 1.5px solid var(--line);
        border-radius: 10px;
        outline: none;
        background: #f6f9fb;
        color: var(--ink);
        transition: border-color .15s;
    }
    .search-bar input:focus {
        border-color: var(--orange);
        background: white;
    }
    .search-bar button {
        padding: 12px 22px;
        background: var(--navy);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: .95rem;
        font-weight: 650;
        cursor: pointer;
        transition: background .15s;
    }
    .search-bar button:hover { background: #1e4a6e; }
    .search-bar button:focus-visible { outline: 3px solid #bd5a12; outline-offset: 3px; }

    /* Result list */
    .result-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .result-card {
        padding: 20px 22px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: white;
        transition: border-color .15s, box-shadow .15s;
    }
    .result-card:hover { border-color: #ad632b; box-shadow: 0 4px 16px #15345110; }
    .result-card .rc-label {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        color: #7b4118;
        background: #fff0e2;
        display: inline-block;
        padding: 3px 9px;
        border-radius: 5px;
        margin-bottom: 8px;
    }
    .result-card h3 {
        margin: 0 0 6px;
        font-size: 1.05rem;
        line-height: 1.4;
    }
    .result-card p {
        margin: 0;
        color: var(--muted);
        font-size: .9rem;
    }
    .result-card a {
        display: inline-block;
        margin-top: 12px;
        font-size: .85rem;
        font-weight: 650;
        color: #96501d;
        text-underline-offset: 4px;
    }
    .result-card a:hover { text-decoration: underline; }

    /* Highlight matched text */
    mark {
        background: #fff3cd;
        color: var(--ink);
        border-radius: 3px;
        padding: 0 2px;
    }

    /* Status bar */
    .result-status {
        font-size: .9rem;
        color: var(--muted);
        margin-bottom: 16px;
        min-height: 1.4em;
    }
    .result-status strong { color: var(--ink); }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 52px 24px;
        background: #f6f9fb;
        border: 1.5px dashed var(--line);
        border-radius: 14px;
    }
    .empty-state .es-icon {
        font-size: 2.8rem;
        margin-bottom: 14px;
    }
    .empty-state h2 {
        margin: 0 0 8px;
        font-size: 1.2rem;
        color: var(--ink);
    }
    .empty-state p {
        color: var(--muted);
        margin: 0;
        font-size: .92rem;
    }

    /* Suggestions chip list */
    .suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
        justify-content: center;
    }
    .chip {
        padding: 6px 14px;
        background: white;
        border: 1px solid var(--line);
        border-radius: 20px;
        font-size: .82rem;
        cursor: pointer;
        color: var(--ink);
        transition: border-color .12s, background .12s;
    }
    .chip:hover { border-color: var(--orange); background: #fff8f2; }
</style>
@endpush

@section('content')
<section class="search-wrap" aria-labelledby="judul-fitur">
    <span class="badge">Absen {{ $nomor }}</span>
    <h1 id="judul-fitur">{{ $judul }}</h1>
    <p class="lead">Ketik kata kunci untuk menemukan referensi belajar pemrograman &amp; RPL.</p>

    <form class="search-bar" id="searchForm" role="search" aria-label="Pencarian referensi">
        <label for="searchInput" class="sr-only">Kata kunci</label>
        <input
            type="search"
            id="searchInput"
            name="q"
            placeholder="Contoh: HTML, CSS, Git, Laravel…"
            autocomplete="off"
            spellcheck="false"
            aria-controls="resultStatus resultList"
        >
        <button type="submit">Cari</button>
    </form>

    <p class="result-status" id="resultStatus" aria-live="polite" aria-atomic="true"></p>

    <div id="resultList" class="result-list" role="list"></div>

    <div id="emptyState" class="empty-state" hidden>
        <div class="es-icon" aria-hidden="true">🔍</div>
        <h2 id="emptyTitle">Referensi tidak ditemukan</h2>
        <p id="emptyDesc">Tidak ada referensi yang cocok dengan kata kunci <strong id="emptyKeyword"></strong>. Coba kata kunci lain.</p>
        <div class="suggestions" id="suggestionChips" aria-label="Saran kata kunci"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── Data referensi ── */
    const REFERENCES = [
        {
            kategori: 'HTML & CSS',
            judul: 'Belajar HTML untuk Pemula',
            deskripsi: 'Panduan lengkap struktur dokumen HTML5, elemen semantik, formulir, dan aksesibilitas.',
            url: 'https://developer.mozilla.org/id/docs/Learn/HTML',
            tags: ['html', 'web', 'markup', 'frontend'],
        },
        {
            kategori: 'HTML & CSS',
            judul: 'Panduan CSS Modern',
            deskripsi: 'Flexbox, Grid, custom properties, dan teknik layout responsif untuk web.',
            url: 'https://developer.mozilla.org/id/docs/Learn/CSS',
            tags: ['css', 'flexbox', 'grid', 'responsif', 'frontend'],
        },
        {
            kategori: 'JavaScript',
            judul: 'JavaScript Dasar',
            deskripsi: 'Variabel, fungsi, array, objek, DOM manipulation, dan event handling.',
            url: 'https://developer.mozilla.org/id/docs/Learn/JavaScript',
            tags: ['javascript', 'js', 'dom', 'frontend'],
        },
        {
            kategori: 'JavaScript',
            judul: 'ES6+ & Fitur Modern JS',
            deskripsi: 'Arrow function, destructuring, promise, async/await, module, dan spread operator.',
            url: 'https://javascript.info/',
            tags: ['javascript', 'es6', 'promise', 'async', 'modul'],
        },
        {
            kategori: 'PHP',
            judul: 'PHP: Hypertext Preprocessor',
            deskripsi: 'Sintaks dasar PHP, array, fungsi, OOP, dan pengelolaan form serta sesi.',
            url: 'https://www.php.net/manual/id/getting-started.php',
            tags: ['php', 'backend', 'oop', 'server'],
        },
        {
            kategori: 'Laravel',
            judul: 'Dokumentasi Laravel',
            deskripsi: 'Routing, controller, model Eloquent, Blade template, middleware, dan autentikasi.',
            url: 'https://laravel.com/docs',
            tags: ['laravel', 'php', 'mvc', 'eloquent', 'blade', 'backend'],
        },
        {
            kategori: 'Git & GitHub',
            judul: 'Git — Sistem Kontrol Versi',
            deskripsi: 'Perintah dasar Git: init, add, commit, branch, merge, rebase, dan remote.',
            url: 'https://git-scm.com/book/id/v2',
            tags: ['git', 'github', 'version control', 'branch', 'commit'],
        },
        {
            kategori: 'Git & GitHub',
            judul: 'GitHub Pull Request & Kolaborasi',
            deskripsi: 'Cara fork, clone, push, membuat pull request, review kode, dan menyelesaikan konflik.',
            url: 'https://docs.github.com/id/pull-requests',
            tags: ['github', 'pull request', 'kolaborasi', 'fork', 'git'],
        },
        {
            kategori: 'Basis Data',
            judul: 'SQL untuk Pemula',
            deskripsi: 'SELECT, INSERT, UPDATE, DELETE, JOIN, index, dan transaksi pada basis data relasional.',
            url: 'https://www.w3schools.com/sql/',
            tags: ['sql', 'database', 'mysql', 'query', 'backend'],
        },
        {
            kategori: 'Basis Data',
            judul: 'MySQL — Panduan Resmi',
            deskripsi: 'Instalasi, konfigurasi, optimasi query, dan manajemen pengguna MySQL.',
            url: 'https://dev.mysql.com/doc/',
            tags: ['mysql', 'database', 'sql', 'backend'],
        },
        {
            kategori: 'RPL',
            judul: 'Rekayasa Perangkat Lunak (RPL)',
            deskripsi: 'SDLC, analisis kebutuhan, perancangan sistem, UML, pengujian, dan pemeliharaan perangkat lunak.',
            url: 'https://id.wikipedia.org/wiki/Rekayasa_perangkat_lunak',
            tags: ['rpl', 'sdlc', 'uml', 'analisis', 'sistem'],
        },
        {
            kategori: 'Alat Pengembang',
            judul: 'Visual Studio Code',
            deskripsi: 'Tips, shortcut, ekstensi, dan konfigurasi VS Code untuk produktivitas coding.',
            url: 'https://code.visualstudio.com/docs',
            tags: ['vscode', 'editor', 'ekstensi', 'alat'],
        },
        {
            kategori: 'Alat Pengembang',
            judul: 'Laragon — Dev Environment',
            deskripsi: 'Instalasi Laragon, konfigurasi virtual host, PHP, MySQL, dan Apache di Windows.',
            url: 'https://laragon.org/docs/',
            tags: ['laragon', 'localhost', 'apache', 'windows', 'alat'],
        },
    ];

    const SUGGESTIONS = ['HTML', 'CSS', 'JavaScript', 'Laravel', 'Git', 'SQL', 'PHP', 'RPL'];

    /* ── DOM refs ── */
    const form        = document.getElementById('searchForm');
    const input       = document.getElementById('searchInput');
    const resultList  = document.getElementById('resultList');
    const statusEl    = document.getElementById('resultStatus');
    const emptyState  = document.getElementById('emptyState');
    const emptyKw     = document.getElementById('emptyKeyword');
    const chips       = document.getElementById('suggestionChips');

    /* ── Build suggestion chips ── */
    SUGGESTIONS.forEach(function (word) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'chip';
        btn.textContent = word;
        btn.setAttribute('aria-label', 'Cari ' + word);
        btn.addEventListener('click', function () {
            input.value = word;
            runSearch(word);
        });
        chips.appendChild(btn);
    });

    /* ── Search logic ── */
    function normalize(str) {
        return str.toLowerCase().replace(/\s+/g, ' ').trim();
    }

    function highlight(text, keyword) {
        if (!keyword) return escHtml(text);
        const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const re = new RegExp('(' + escaped + ')', 'gi');
        return escHtml(text).replace(re, '<mark>$1</mark>');
    }

    function escHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function score(ref, kw) {
        const fields = [
            normalize(ref.judul),
            normalize(ref.deskripsi),
            normalize(ref.kategori),
            ref.tags.join(' '),
        ];
        let s = 0;
        if (fields[0].includes(kw)) s += 3;
        if (fields[3].includes(kw)) s += 2;
        if (fields[1].includes(kw)) s += 1;
        if (fields[2].includes(kw)) s += 1;
        return s;
    }

    function search(keyword) {
        const kw = normalize(keyword);
        if (!kw) return [];
        return REFERENCES
            .map(function (ref) { return { ref: ref, score: score(ref, kw) }; })
            .filter(function (item) { return item.score > 0; })
            .sort(function (a, b) { return b.score - a.score; })
            .map(function (item) { return item.ref; });
    }

    function renderCard(ref, keyword) {
        const kw = normalize(keyword);
        const card = document.createElement('article');
        card.className = 'result-card';
        card.setAttribute('role', 'listitem');
        card.innerHTML =
            '<span class="rc-label">' + escHtml(ref.kategori) + '</span>' +
            '<h3>' + highlight(ref.judul, kw) + '</h3>' +
            '<p>' + highlight(ref.deskripsi, kw) + '</p>' +
            '<a href="' + escHtml(ref.url) + '" target="_blank" rel="noopener noreferrer">' +
                'Buka referensi ↗' +
            '</a>';
        return card;
    }

    function runSearch(keyword) {
        const kw = keyword.trim();
        resultList.innerHTML = '';
        emptyState.hidden = true;
        statusEl.textContent = '';

        if (!kw) {
            statusEl.textContent = 'Masukkan kata kunci untuk mulai mencari.';
            return;
        }

        const results = search(kw);

        if (results.length === 0) {
            emptyKw.textContent = '\u201c' + kw + '\u201d';
            emptyState.hidden = false;
            statusEl.textContent = 'Tidak ada hasil untuk \u201c' + kw + '\u201d.';
            return;
        }

        statusEl.innerHTML =
            'Ditemukan <strong>' + results.length + '</strong> referensi untuk \u201c' + escHtml(kw) + '\u201d.';

        const fragment = document.createDocumentFragment();
        results.forEach(function (ref) {
            fragment.appendChild(renderCard(ref, kw));
        });
        resultList.appendChild(fragment);
    }

    /* ── Events ── */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        runSearch(input.value);
    });

    /* Live search after typing stops (300 ms debounce) */
    let debounceTimer;
    input.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            runSearch(input.value);
        }, 300);
    });
})();
</script>
@endpush
