@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    /* ── Hero Banner ─────────────────────────────────────────── */
    .glos-hero {
        background: linear-gradient(135deg, #1a3a5c 0%, #0f2640 60%, #1a3a5c 100%);
        border-radius: 20px;
        padding: clamp(28px, 5vw, 52px) clamp(24px, 5vw, 48px);
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 32px;
        overflow: hidden;
        position: relative;
        border: 1px solid #2a4f73;
    }
    .glos-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        background: radial-gradient(circle, rgba(100,180,255,.13) 0%, transparent 70%);
        border-radius: 50%;
    }
    .glos-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 160px; height: 160px;
        background: radial-gradient(circle, rgba(244,162,97,.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .glos-hero-icon {
        font-size: 5rem;
        line-height: 1;
        flex-shrink: 0;
        filter: drop-shadow(0 4px 16px rgba(0,0,0,.35));
        z-index: 1;
    }
    .glos-hero-text { z-index: 1; }
    .glos-hero-text .badge-hero {
        display: inline-block;
        background: rgba(244,162,97,.18);
        color: #f4a261;
        border: 1px solid rgba(244,162,97,.35);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .08em;
        margin-bottom: 12px;
    }
    .glos-hero-text h1 {
        margin: 0 0 10px;
        font-size: clamp(1.9rem, 4vw, 2.8rem);
        color: #fff;
        letter-spacing: -.03em;
        line-height: 1.15;
    }
    .glos-hero-text h1 span { color: #64b4ff; }
    .glos-hero-text p {
        margin: 0;
        color: #94b8d6;
        font-size: .97rem;
        max-width: 480px;
        line-height: 1.6;
    }
    .glos-hero-deco {
        margin-left: auto;
        font-size: 7rem;
        opacity: .07;
        flex-shrink: 0;
        z-index: 0;
        line-height: 1;
    }

    /* ── Toolbar ─────────────────────────────────────────────── */
    .glos-toolbar {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .glos-search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .glos-search-wrap svg {
        position: absolute;
        left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #7a95aa;
        pointer-events: none;
    }
    #glos-search {
        width: 100%;
        padding: 11px 16px 11px 42px;
        border: 1.5px solid #dce5e9;
        border-radius: 10px;
        font-size: .95rem;
        background: white;
        color: #203b51;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    #glos-search:focus {
        border-color: #64b4ff;
        box-shadow: 0 0 0 3px rgba(100,180,255,.18);
    }
    #glos-search::placeholder { color: #9bb5c5; }

    /* ── Category Filter Tabs ────────────────────────────────── */
    .glos-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .glos-tab {
        padding: 7px 18px;
        border-radius: 20px;
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid #dce5e9;
        background: white;
        color: #526575;
        transition: all .18s ease;
        user-select: none;
    }
    .glos-tab:hover { border-color: #64b4ff; color: #1a3a5c; }
    .glos-tab.active {
        background: #1a3a5c;
        border-color: #1a3a5c;
        color: white;
    }
    .glos-tab[data-cat="pemrograman"].active { background: #2563eb; border-color: #2563eb; }
    .glos-tab[data-cat="database"].active    { background: #059669; border-color: #059669; }
    .glos-tab[data-cat="web"].active         { background: #d97706; border-color: #d97706; }
    .glos-tab[data-cat="tools"].active       { background: #7c3aed; border-color: #7c3aed; }
    .glos-tab[data-cat="konsep"].active      { background: #db2777; border-color: #db2777; }

    /* ── Stats Bar ───────────────────────────────────────────── */
    .glos-stats {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .glos-count {
        font-size: .88rem;
        color: #526575;
    }
    .glos-count strong { color: #153451; }

    /* ── Grid ────────────────────────────────────────────────── */
    .glos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }
    @media (max-width: 700px) { .glos-grid { grid-template-columns: 1fr; } }

    /* ── Card ────────────────────────────────────────────────── */
    .glos-card {
        background: white;
        border: 1.5px solid #e4ecf0;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        cursor: pointer;
        transition: border-color .18s, box-shadow .18s, transform .18s;
        position: relative;
    }
    .glos-card:hover {
        border-color: #64b4ff;
        box-shadow: 0 6px 24px rgba(21,52,81,.1);
        transform: translateY(-2px);
    }
    .glos-card-num {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 800;
        flex-shrink: 0;
        letter-spacing: .02em;
    }
    .glos-card-body { flex: 1; min-width: 0; }
    .glos-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #153451;
        margin: 0 0 5px;
        line-height: 1.35;
    }
    .glos-card-desc {
        font-size: .84rem;
        color: #526575;
        margin: 0 0 10px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .glos-card-cat {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: .74rem;
        font-weight: 600;
    }
    .glos-card-arrow {
        color: #9bb5c5;
        flex-shrink: 0;
        align-self: center;
        transition: transform .18s, color .18s;
    }
    .glos-card:hover .glos-card-arrow { transform: translateX(4px); color: #1a3a5c; }

    /* category color tokens */
    .cat-pemrograman { background: #eff6ff; color: #2563eb; }
    .cat-database     { background: #ecfdf5; color: #059669; }
    .cat-web          { background: #fffbeb; color: #d97706; }
    .cat-tools        { background: #f5f3ff; color: #7c3aed; }
    .cat-konsep       { background: #fdf2f8; color: #db2777; }

    .num-pemrograman { background: #eff6ff; color: #2563eb; }
    .num-database     { background: #ecfdf5; color: #059669; }
    .num-web          { background: #fffbeb; color: #d97706; }
    .num-tools        { background: #f5f3ff; color: #7c3aed; }
    .num-konsep       { background: #fdf2f8; color: #db2777; }

    /* ── Detail Modal ────────────────────────────────────────── */
    .glos-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(10,25,40,.55);
        backdrop-filter: blur(4px);
        z-index: 100;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    .glos-modal-backdrop.open { display: flex; animation: fadeIn .2s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .glos-modal {
        background: white;
        border-radius: 20px;
        padding: 36px;
        max-width: 540px;
        width: 100%;
        position: relative;
        box-shadow: 0 24px 60px rgba(0,0,0,.22);
        animation: slideUp .2s ease;
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .glos-modal-close {
        position: absolute;
        top: 16px; right: 16px;
        background: #f6f9fb;
        border: none; cursor: pointer;
        width: 34px; height: 34px;
        border-radius: 8px;
        font-size: 1.1rem;
        color: #526575;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .glos-modal-close:hover { background: #e4ecf0; }
    .glos-modal-num {
        display: inline-flex;
        align-items: center; justify-content: center;
        width: 48px; height: 48px;
        border-radius: 14px;
        font-size: .9rem; font-weight: 800;
        margin-bottom: 16px;
    }
    .glos-modal h2 {
        font-size: 1.55rem;
        color: #153451;
        margin: 0 0 10px;
        line-height: 1.25;
    }
    .glos-modal-cat { margin-bottom: 18px; }
    .glos-modal-desc {
        color: #3d5569;
        line-height: 1.75;
        margin: 0 0 20px;
        font-size: .97rem;
    }
    .glos-modal-contoh {
        background: #f0f7ff;
        border-left: 4px solid #64b4ff;
        border-radius: 0 10px 10px 0;
        padding: 14px 18px;
        font-size: .9rem;
        color: #2a4f73;
        line-height: 1.6;
    }
    .glos-modal-contoh strong { display: block; margin-bottom: 4px; color: #1a3a5c; }

    /* ── Empty State ─────────────────────────────────────────── */
    #glos-empty {
        display: none;
        text-align: center;
        padding: 60px 20px;
        color: #526575;
        grid-column: 1 / -1;
    }
    #glos-empty svg { margin-bottom: 16px; color: #c5d7e3; }
    #glos-empty p { margin: 0; font-size: 1rem; }
    #glos-empty small { color: #9bb5c5; }
</style>
@endpush

@section('content')

{{-- Hero Banner --}}
<section class="glos-hero" aria-labelledby="judul-fitur">
    <div class="glos-hero-icon" aria-hidden="true">📚</div>
    <div class="glos-hero-text">
        <span class="badge-hero">ABSEN {{ $nomor }}</span>
        <h1 id="judul-fitur">Glosarium <span>RPL</span></h1>
        <p>Daftar istilah penting dalam dunia <strong style="color:#94d2ff">Rekayasa Perangkat Lunak</strong> untuk menambah wawasan kamu!</p>
    </div>
    <div class="glos-hero-deco" aria-hidden="true">⚙️</div>
</section>

{{-- Search + Tabs --}}
<div class="glos-toolbar">
    <div class="glos-search-wrap">
        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" id="glos-search" placeholder="Cari istilah RPL..." autocomplete="off" aria-label="Cari istilah glosarium">
    </div>
</div>

<div class="glos-tabs" role="tablist" aria-label="Filter kategori">
    <button class="glos-tab active" data-cat="semua" role="tab" aria-selected="true">Semua</button>
    <button class="glos-tab" data-cat="pemrograman" role="tab" aria-selected="false">Pemrograman</button>
    <button class="glos-tab" data-cat="database" role="tab" aria-selected="false">Database</button>
    <button class="glos-tab" data-cat="web" role="tab" aria-selected="false">Web</button>
    <button class="glos-tab" data-cat="tools" role="tab" aria-selected="false">Tools</button>
    <button class="glos-tab" data-cat="konsep" role="tab" aria-selected="false">Konsep</button>
</div>

<div class="glos-stats">
    <span class="glos-count">Menampilkan <strong id="glos-visible-count">30</strong> dari <strong>30</strong> istilah</span>
</div>

{{-- Grid Istilah --}}
<div class="glos-grid" id="glos-grid" role="list">

    {{-- Pemrograman --}}
    <article class="glos-card" data-cat="pemrograman" data-title="Algoritma" data-desc="Urutan langkah-langkah logis dan sistematis untuk menyelesaikan suatu masalah. Algoritma adalah fondasi dari setiap program komputer." data-contoh="Contoh: Algoritma pengurutan seperti Bubble Sort, Quick Sort digunakan untuk mengurutkan data dalam array." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">01</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Algoritma</h3>
            <p class="glos-card-desc">Urutan langkah-langkah logis untuk menyelesaikan suatu masalah secara sistematis.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="pemrograman" data-title="Variabel" data-desc="Tempat penyimpanan data sementara dalam memori komputer yang memiliki nama dan nilai. Nilai variabel dapat berubah selama program berjalan." data-contoh="Contoh: int nilai = 90; — variabel 'nilai' bertipe integer dengan nilai 90." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">02</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Variabel</h3>
            <p class="glos-card-desc">Tempat penyimpanan data sementara dalam memori yang memiliki nama dan nilai.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="pemrograman" data-title="Fungsi / Function" data-desc="Blok kode yang dapat digunakan kembali (reusable) dan dirancang untuk melakukan tugas tertentu. Fungsi menerima input (parameter) dan menghasilkan output (return value)." data-contoh="Contoh: function hitungLuas(p, l) { return p * l; } — fungsi untuk menghitung luas persegi panjang." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">03</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Fungsi / Function</h3>
            <p class="glos-card-desc">Blok kode reusable yang dirancang untuk melakukan tugas tertentu dan mengembalikan nilai.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="pemrograman" data-title="OOP (Object-Oriented Programming)" data-desc="Paradigma pemrograman yang mengorganisir kode menjadi objek-objek yang memiliki atribut (data) dan metode (perilaku). Konsep utama: Class, Object, Inheritance, Encapsulation, Polymorphism." data-contoh="Contoh: Class 'Siswa' memiliki atribut nama & nilai, serta metode tampilkanData()." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">04</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">OOP (Object-Oriented Programming)</h3>
            <p class="glos-card-desc">Paradigma pemrograman berbasis objek dengan konsep Class, Inheritance, dan Encapsulation.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="pemrograman" data-title="Array" data-desc="Struktur data yang menyimpan kumpulan elemen dengan tipe data yang sama dalam satu variabel, diakses menggunakan indeks yang dimulai dari 0." data-contoh="Contoh: $nilai = [85, 90, 78, 92]; — array berisi 4 nilai ujian, diakses dengan $nilai[0] = 85." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">05</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Array</h3>
            <p class="glos-card-desc">Struktur data yang menyimpan kumpulan elemen bertipe sama dalam satu variabel berindeks.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="pemrograman" data-title="Debugging" data-desc="Proses mencari, mengidentifikasi, dan memperbaiki bug (kesalahan) dalam kode program. Merupakan keterampilan penting bagi setiap programmer." data-contoh="Contoh: Menggunakan console.log() atau var_dump() untuk memeriksa nilai variabel saat runtime." role="listitem" tabindex="0">
        <div class="glos-card-num num-pemrograman">06</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Debugging</h3>
            <p class="glos-card-desc">Proses mencari dan memperbaiki bug (kesalahan) dalam kode program secara sistematis.</p>
            <span class="glos-card-cat cat-pemrograman">Pemrograman</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    {{-- Database --}}
    <article class="glos-card" data-cat="database" data-title="Database" data-desc="Kumpulan data yang terorganisir dan disimpan secara sistematis dalam komputer, dapat diakses, dikelola, dan diperbarui. Biasanya dikelola oleh DBMS (Database Management System)." data-contoh="Contoh: MySQL, PostgreSQL, SQLite adalah sistem database populer yang digunakan dalam pengembangan web." role="listitem" tabindex="0">
        <div class="glos-card-num num-database">07</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Database</h3>
            <p class="glos-card-desc">Kumpulan data terorganisir yang dikelola oleh DBMS dan dapat diakses serta diperbarui.</p>
            <span class="glos-card-cat cat-database">Database</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="database" data-title="SQL (Structured Query Language)" data-desc="Bahasa standar untuk berkomunikasi dengan database relasional. Digunakan untuk membuat, membaca, memperbarui, dan menghapus data (CRUD)." data-contoh="Contoh: SELECT * FROM siswa WHERE nilai > 80; — mengambil data siswa dengan nilai di atas 80." role="listitem" tabindex="0">
        <div class="glos-card-num num-database">08</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">SQL (Structured Query Language)</h3>
            <p class="glos-card-desc">Bahasa standar untuk berkomunikasi dengan database relasional (CRUD operations).</p>
            <span class="glos-card-cat cat-database">Database</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="database" data-title="Primary Key" data-desc="Kolom atau kombinasi kolom dalam tabel database yang secara unik mengidentifikasi setiap baris. Nilai Primary Key tidak boleh NULL dan harus unik untuk setiap record." data-contoh="Contoh: Kolom 'id' dengan tipe AUTO_INCREMENT di tabel siswa berfungsi sebagai Primary Key." role="listitem" tabindex="0">
        <div class="glos-card-num num-database">09</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Primary Key</h3>
            <p class="glos-card-desc">Kolom unik yang mengidentifikasi setiap baris dalam tabel, tidak boleh NULL atau duplikat.</p>
            <span class="glos-card-cat cat-database">Database</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="database" data-title="Query" data-desc="Perintah atau permintaan yang dikirimkan ke database untuk mengambil, memasukkan, mengubah, atau menghapus data sesuai kriteria tertentu." data-contoh="Contoh: INSERT INTO siswa (nama, nilai) VALUES ('Kayla', 95); — query untuk menambah data siswa baru." role="listitem" tabindex="0">
        <div class="glos-card-num num-database">10</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Query</h3>
            <p class="glos-card-desc">Perintah ke database untuk mengambil, memasukkan, mengubah, atau menghapus data.</p>
            <span class="glos-card-cat cat-database">Database</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="database" data-title="Migrasi (Migration)" data-desc="Proses mengelola perubahan struktur database secara terversioning menggunakan kode. Memudahkan kolaborasi tim dan pelacakan perubahan skema database." data-contoh="Contoh: php artisan make:migration create_siswa_table — membuat file migrasi baru di Laravel." role="listitem" tabindex="0">
        <div class="glos-card-num num-database">11</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Migrasi (Migration)</h3>
            <p class="glos-card-desc">Pengelolaan perubahan struktur database secara terversioning menggunakan kode program.</p>
            <span class="glos-card-cat cat-database">Database</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    {{-- Web --}}
    <article class="glos-card" data-cat="web" data-title="HTML (HyperText Markup Language)" data-desc="Bahasa markup standar untuk membuat struktur dan konten halaman web. HTML menggunakan elemen berupa tag untuk mendefinisikan judul, paragraf, link, gambar, dan konten lainnya." data-contoh="Contoh: &lt;h1&gt;Glosarium RPL&lt;/h1&gt; — tag heading untuk menampilkan judul utama halaman." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">12</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">HTML (HyperText Markup Language)</h3>
            <p class="glos-card-desc">Bahasa markup standar untuk membuat struktur dan konten halaman web menggunakan tag.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="web" data-title="CSS (Cascading Style Sheets)" data-desc="Bahasa stylesheet yang digunakan untuk mengatur tampilan dan tata letak halaman web. CSS memisahkan konten (HTML) dari presentasi visual (warna, font, layout)." data-contoh="Contoh: body { background-color: #f0f0f0; font-family: Arial; } — mengatur latar dan font halaman." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">13</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">CSS (Cascading Style Sheets)</h3>
            <p class="glos-card-desc">Bahasa stylesheet untuk mengatur tampilan, warna, font, dan tata letak halaman web.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="web" data-title="JavaScript" data-desc="Bahasa pemrograman yang membuat halaman web menjadi interaktif dan dinamis. Dapat berjalan di browser (frontend) maupun server (backend dengan Node.js)." data-contoh="Contoh: document.getElementById('btn').addEventListener('click', () => alert('Halo!')); — event click button." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">14</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">JavaScript</h3>
            <p class="glos-card-desc">Bahasa pemrograman untuk membuat halaman web interaktif, berjalan di browser maupun server.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="web" data-title="API (Application Programming Interface)" data-desc="Antarmuka yang memungkinkan dua aplikasi atau sistem berkomunikasi satu sama lain. REST API menggunakan HTTP methods (GET, POST, PUT, DELETE) untuk pertukaran data dalam format JSON." data-contoh="Contoh: Aplikasi cuaca mengambil data suhu dari API OpenWeatherMap menggunakan GET request." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">15</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">API (Application Programming Interface)</h3>
            <p class="glos-card-desc">Antarmuka komunikasi antar aplikasi, biasanya menggunakan HTTP dan format JSON.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="web" data-title="Framework" data-desc="Kerangka kerja yang menyediakan struktur, library, dan tools untuk mempercepat pengembangan perangkat lunak. Framework mengurangi kode boilerplate dan mendorong praktik terbaik." data-contoh="Contoh: Laravel (PHP), React (JS), Django (Python) adalah framework populer untuk pengembangan web." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">16</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Framework</h3>
            <p class="glos-card-desc">Kerangka kerja yang mempercepat pengembangan software dengan struktur dan library siap pakai.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="web" data-title="Blade Template" data-desc="Mesin template bawaan Laravel yang memudahkan pembuatan tampilan HTML dengan sintaks PHP yang bersih. Mendukung template inheritance, komponen, dan direktif khusus seperti @@foreach dan @@if." data-contoh="Contoh: @@foreach($siswa as $s) &lt;li&gt;@{{ $s->nama }}&lt;/li&gt; @@endforeach — menampilkan daftar nama siswa." role="listitem" tabindex="0">
        <div class="glos-card-num num-web">17</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Blade Template</h3>
            <p class="glos-card-desc">Mesin template Laravel dengan sintaks bersih, mendukung @@foreach, @@if, dan inheritance.</p>
            <span class="glos-card-cat cat-web">Web</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    {{-- Tools --}}
    <article class="glos-card" data-cat="tools" data-title="Git" data-desc="Sistem version control terdistribusi yang melacak perubahan kode sumber selama pengembangan perangkat lunak. Memungkinkan kolaborasi tim, branching, merging, dan rollback perubahan." data-contoh="Contoh: git commit -m 'feat: tambah fitur glosarium' — menyimpan snapshot perubahan kode." role="listitem" tabindex="0">
        <div class="glos-card-num num-tools">18</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Git</h3>
            <p class="glos-card-desc">Sistem version control untuk melacak perubahan kode, mendukung branching dan kolaborasi tim.</p>
            <span class="glos-card-cat cat-tools">Tools</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="tools" data-title="GitHub" data-desc="Platform hosting berbasis web untuk version control menggunakan Git. Menyediakan fitur kolaborasi seperti Pull Request, Issues, Actions, dan Pages untuk proyek open-source maupun private." data-contoh="Contoh: Membuat Pull Request dari branch feat/08-glosarium ke main untuk review kode tim." role="listitem" tabindex="0">
        <div class="glos-card-num num-tools">19</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">GitHub</h3>
            <p class="glos-card-desc">Platform hosting Git untuk kolaborasi kode, Pull Request, Issues, dan CI/CD dengan Actions.</p>
            <span class="glos-card-cat cat-tools">Tools</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="tools" data-title="Pull Request (PR)" data-desc="Mekanisme di GitHub untuk mengusulkan perubahan kode dari satu branch ke branch lain. Tim dapat mereview, memberi komentar, dan menyetujui PR sebelum kode digabungkan ke branch utama." data-contoh="Contoh: Membuka PR dari feat/08-glosarium ke main agar guru bisa mereview dan merge kode kamu." role="listitem" tabindex="0">
        <div class="glos-card-num num-tools">20</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Pull Request (PR)</h3>
            <p class="glos-card-desc">Mekanisme GitHub untuk mengusulkan dan mereview perubahan kode sebelum digabung ke branch utama.</p>
            <span class="glos-card-cat cat-tools">Tools</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="tools" data-title="Composer" data-desc="Dependency manager untuk PHP yang memudahkan instalasi dan pengelolaan library pihak ketiga. Menggunakan file composer.json untuk mendefinisikan dependensi proyek." data-contoh="Contoh: composer require laravel/framework — menginstal Laravel framework ke proyek PHP kamu." role="listitem" tabindex="0">
        <div class="glos-card-num num-tools">21</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Composer</h3>
            <p class="glos-card-desc">Dependency manager PHP untuk menginstal dan mengelola library pihak ketiga via composer.json.</p>
            <span class="glos-card-cat cat-tools">Tools</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    {{-- Konsep --}}
    <article class="glos-card" data-cat="konsep" data-title="SDLC (Software Development Life Cycle)" data-desc="Model proses pengembangan perangkat lunak yang mencakup tahapan: Perencanaan, Analisis, Perancangan, Implementasi, Pengujian, dan Pemeliharaan." data-contoh="Contoh: Proyek web kelas melalui tahap analisis kebutuhan → desain UI → coding → testing → deployment." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">22</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">SDLC (Software Development Life Cycle)</h3>
            <p class="glos-card-desc">Siklus hidup pengembangan perangkat lunak: Perencanaan → Analisis → Desain → Implementasi → Testing.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="MVC (Model-View-Controller)" data-desc="Pola arsitektur perangkat lunak yang memisahkan aplikasi menjadi tiga komponen: Model (data & logika bisnis), View (tampilan UI), dan Controller (pengatur aliran data)." data-contoh="Contoh: Di Laravel, Controller menerima request, mengambil data dari Model, lalu mengirim ke View (Blade)." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">23</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">MVC (Model-View-Controller)</h3>
            <p class="glos-card-desc">Arsitektur yang memisahkan Model (data), View (tampilan), dan Controller (logika aliran).</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="Open Source" data-desc="Perangkat lunak yang kode sumbernya tersedia secara publik dan dapat dilihat, dimodifikasi, serta didistribusikan oleh siapa saja sesuai lisensinya." data-contoh="Contoh: Laravel, Linux, dan Python adalah proyek open source yang digunakan secara global." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">24</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Open Source</h3>
            <p class="glos-card-desc">Perangkat lunak dengan kode sumber publik yang bebas dilihat, dimodifikasi, dan didistribusikan.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="CRUD" data-desc="Singkatan dari empat operasi dasar dalam manajemen data: Create (membuat), Read (membaca), Update (memperbarui), dan Delete (menghapus). Dasar dari hampir semua aplikasi web." data-contoh="Contoh: Fitur manajemen siswa: tambah siswa (C), lihat daftar (R), edit data (U), hapus siswa (D)." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">25</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">CRUD</h3>
            <p class="glos-card-desc">Empat operasi dasar data: Create, Read, Update, Delete — fondasi hampir semua aplikasi web.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="Responsive Design" data-desc="Pendekatan desain web yang membuat tampilan halaman web menyesuaikan diri secara otomatis dengan ukuran layar perangkat, dari smartphone hingga desktop." data-contoh="Contoh: Menggunakan CSS media query @media (max-width: 768px) untuk menyesuaikan layout di mobile." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">26</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Responsive Design</h3>
            <p class="glos-card-desc">Desain web yang otomatis menyesuaikan tampilan dengan berbagai ukuran layar menggunakan CSS.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="Deployment" data-desc="Proses memindahkan aplikasi dari lingkungan pengembangan (development) ke lingkungan produksi (production) agar dapat diakses oleh pengguna akhir melalui internet." data-contoh="Contoh: Upload file ke hosting, konfigurasi domain, dan jalankan migration agar aplikasi bisa online." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">27</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Deployment</h3>
            <p class="glos-card-desc">Proses memindahkan aplikasi dari development ke production agar dapat diakses pengguna di internet.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="Agile" data-desc="Metodologi pengembangan perangkat lunak yang mengutamakan iterasi cepat, kolaborasi tim, dan adaptasi terhadap perubahan kebutuhan. Dikerjakan dalam sprint pendek (1-4 minggu)." data-contoh="Contoh: Tim RPL mengerjakan fitur dalam sprint 2 minggu: plan → develop → test → review → repeat." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">28</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Agile</h3>
            <p class="glos-card-desc">Metodologi pengembangan iteratif dengan sprint pendek yang fleksibel terhadap perubahan kebutuhan.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="UI/UX Design" data-desc="UI (User Interface) merancang tampilan visual aplikasi, sedangkan UX (User Experience) berfokus pada pengalaman dan kemudahan pengguna saat menggunakan aplikasi." data-contoh="Contoh: Membuat wireframe di Figma sebelum coding untuk memastikan navigasi mudah dipahami pengguna." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">29</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">UI/UX Design</h3>
            <p class="glos-card-desc">UI merancang tampilan visual, UX memastikan pengalaman pengguna yang mudah dan menyenangkan.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    <article class="glos-card" data-cat="konsep" data-title="Enkripsi" data-desc="Proses mengubah data menjadi format tidak terbaca (ciphertext) menggunakan algoritma kriptografi, sehingga hanya pihak yang memiliki kunci yang dapat membaca data aslinya." data-contoh="Contoh: Password user di-hash menggunakan bcrypt sebelum disimpan di database untuk keamanan." role="listitem" tabindex="0">
        <div class="glos-card-num num-konsep">30</div>
        <div class="glos-card-body">
            <h3 class="glos-card-title">Enkripsi</h3>
            <p class="glos-card-desc">Proses mengamankan data dengan mengubahnya menjadi format tidak terbaca menggunakan algoritma kriptografi.</p>
            <span class="glos-card-cat cat-konsep">Konsep</span>
        </div>
        <svg class="glos-card-arrow" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </article>

    {{-- Empty State --}}
    <div id="glos-empty" role="status" aria-live="polite">
        <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <p>Istilah tidak ditemukan</p>
        <small>Coba kata kunci lain atau pilih kategori berbeda</small>
    </div>

</div>{{-- /.glos-grid --}}

{{-- Detail Modal --}}
<div class="glos-modal-backdrop" id="glos-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="glos-modal">
        <button class="glos-modal-close" id="glos-modal-close" aria-label="Tutup detail">✕</button>
        <div class="glos-modal-num" id="modal-num"></div>
        <h2 id="modal-title"></h2>
        <div class="glos-modal-cat" id="modal-cat"></div>
        <p class="glos-modal-desc" id="modal-desc"></p>
        <div class="glos-modal-contoh" id="modal-contoh"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const cards     = Array.from(document.querySelectorAll('.glos-card'));
    const tabs      = Array.from(document.querySelectorAll('.glos-tab'));
    const searchEl  = document.getElementById('glos-search');
    const countEl   = document.getElementById('glos-visible-count');
    const emptyEl   = document.getElementById('glos-empty');
    const modal     = document.getElementById('glos-modal');
    const modalClose= document.getElementById('glos-modal-close');

    let activeCat = 'semua';
    let searchQ   = '';

    function filterCards() {
        let visible = 0;
        cards.forEach(card => {
            const cat   = card.dataset.cat;
            const title = card.querySelector('.glos-card-title').textContent.toLowerCase();
            const desc  = card.querySelector('.glos-card-desc').textContent.toLowerCase();
            const matchCat  = activeCat === 'semua' || cat === activeCat;
            const matchSearch = searchQ === '' || title.includes(searchQ) || desc.includes(searchQ);
            const show = matchCat && matchSearch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        countEl.textContent = visible;
        emptyEl.style.display = visible === 0 ? 'block' : 'none';
    }

    // Category tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
            tab.classList.add('active');
            tab.setAttribute('aria-selected','true');
            activeCat = tab.dataset.cat;
            filterCards();
        });
    });

    // Search
    searchEl.addEventListener('input', () => {
        searchQ = searchEl.value.trim().toLowerCase();
        filterCards();
    });

    // Modal open
    const catLabels = {
        pemrograman: { label: 'Pemrograman', cls: 'cat-pemrograman num-pemrograman' },
        database:    { label: 'Database',     cls: 'cat-database num-database' },
        web:         { label: 'Web',           cls: 'cat-web num-web' },
        tools:       { label: 'Tools',         cls: 'cat-tools num-tools' },
        konsep:      { label: 'Konsep',        cls: 'cat-konsep num-konsep' },
    };

    cards.forEach((card, i) => {
        function openModal() {
            const cat   = card.dataset.cat;
            const info  = catLabels[cat] || { label: cat, cls: '' };
            const num   = card.querySelector('.glos-card-num').textContent;
            document.getElementById('modal-num').className  = 'glos-modal-num ' + info.cls;
            document.getElementById('modal-num').textContent = num;
            document.getElementById('modal-title').textContent = card.dataset.title;
            document.getElementById('modal-cat').innerHTML  = `<span class="glos-card-cat ${info.cls.split(' ')[0]}">${info.label}</span>`;
            document.getElementById('modal-desc').textContent = card.dataset.desc;
            document.getElementById('modal-contoh').innerHTML = `<strong>💡 Contoh</strong>${card.dataset.contoh}`;
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            modalClose.focus();
        }
        card.addEventListener('click', openModal);
        card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(); } });
    });

    // Modal close
    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
})();
</script>
@endpush
