@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    /* Styling khusus Fitur 21 - Panduan Penggunaan Portal */
    .help-center-wrapper {
        display: flex;
        flex-direction: column;
        gap: 32px;
        margin-top: 10px;
    }

    /* Hero Section */
    .hc-hero {
        background: linear-gradient(135deg, #153451 0%, #1e4a73 100%);
        color: #ffffff;
        border-radius: 18px;
        padding: clamp(32px, 5vw, 48px);
        box-shadow: 0 10px 25px rgba(21, 52, 81, 0.12);
        position: relative;
        overflow: hidden;
        border-bottom: 4px solid var(--orange);
    }

    .hc-hero::after {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(244, 162, 97, 0.25) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hc-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(4px);
        color: var(--mint);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 16px;
        border: 1px solid rgba(216, 243, 231, 0.3);
    }

    .hc-hero h1 {
        font-size: clamp(2rem, 4vw, 2.75rem);
        margin: 0 0 10px;
        color: #ffffff;
        letter-spacing: -0.02em;
    }

    .hc-hero-subtitle {
        color: #d1e2ef;
        font-size: 1.05rem;
        margin: 0 0 28px;
        max-width: 620px;
    }

    /* Search Bar */
    .hc-search-box {
        position: relative;
        max-width: 680px;
    }

    .hc-search-input {
        width: 100%;
        padding: 16px 20px 16px 52px;
        border-radius: 12px;
        border: 2px solid transparent;
        font-size: 1rem;
        color: var(--ink);
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        outline: none;
        transition: all 0.2s ease;
    }

    .hc-search-input:focus {
        border-color: var(--orange);
        box-shadow: 0 8px 24px rgba(244, 162, 97, 0.3);
    }

    .hc-search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #8396a5;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .hc-search-meta {
        margin-top: 10px;
        font-size: 0.85rem;
        color: #d1e2ef;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .hc-tag {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.78rem;
        cursor: pointer;
        transition: background 0.15s;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hc-tag:hover {
        background: var(--orange);
        border-color: var(--orange);
        color: #fff;
    }

    /* Section Headers */
    .hc-section-title {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 18px;
        border-bottom: 2px solid var(--line);
        padding-bottom: 10px;
    }

    .hc-section-title h2 {
        font-size: 1.35rem;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .hc-section-title p {
        color: var(--muted);
        font-size: 0.9rem;
        margin: 0;
    }

    /* Category Cards Grid */
    .hc-categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .hc-cat-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
        position: relative;
    }

    .hc-cat-card:hover, .hc-cat-card.active {
        border-color: var(--orange);
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(21, 52, 81, 0.08);
    }

    .hc-cat-card.active {
        background: #fffdfa;
        border-width: 2px;
    }

    .hc-cat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #eef5fa;
        color: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 14px;
        transition: 0.2s;
    }

    .hc-cat-card:hover .hc-cat-icon, .hc-cat-card.active .hc-cat-icon {
        background: #fff0e2;
        color: #c45d15;
    }

    .hc-cat-card h3 {
        margin: 0 0 6px;
        font-size: 1.05rem;
        color: var(--navy);
    }

    .hc-cat-card p {
        margin: 0;
        font-size: 0.82rem;
        color: var(--muted);
        line-height: 1.4;
    }

    /* Guide Tutorial Steps / Cards */
    .hc-guides-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .hc-guide-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 22px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        transition: all 0.2s;
        cursor: pointer;
    }

    .hc-guide-card:hover {
        border-color: #f4a261;
        box-shadow: 0 6px 18px rgba(21, 52, 81, 0.08);
        transform: translateY(-2px);
    }

    .hc-guide-number {
        font-size: 1.4rem;
        font-weight: 800;
        color: #f4a261;
        background: #fff5ed;
        min-width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ffd8bd;
        flex-shrink: 0;
    }

    .hc-guide-content {
        flex: 1;
    }

    .hc-guide-content h3 {
        margin: 0 0 6px;
        font-size: 1.1rem;
        color: var(--navy);
    }

    .hc-guide-content p {
        margin: 0 0 12px;
        font-size: 0.88rem;
        color: var(--muted);
    }

    .hc-guide-badge {
        font-size: 0.75rem;
        padding: 3px 8px;
        background: #e9f2f8;
        color: #1b4965;
        border-radius: 6px;
        font-weight: 600;
    }

    .hc-guide-action {
        color: #ad632b;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 6px;
    }

    /* FAQ Section */
    .hc-faq-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .hc-faq-item {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .hc-faq-item.open {
        border-color: #f4a261;
    }

    .hc-faq-question {
        padding: 18px 22px;
        font-weight: 650;
        font-size: 0.98rem;
        color: var(--navy);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        user-select: none;
        transition: background 0.15s;
    }

    .hc-faq-question:hover {
        background: #fafcff;
    }

    .hc-faq-icon {
        font-size: 1.2rem;
        color: var(--muted);
        transition: transform 0.25s ease;
    }

    .hc-faq-item.open .hc-faq-icon {
        transform: rotate(180deg);
        color: #ad632b;
    }

    .hc-faq-answer {
        padding: 0 22px 20px 22px;
        color: var(--muted);
        font-size: 0.9rem;
        line-height: 1.6;
        display: none;
        border-top: 1px dashed #eef2f5;
        padding-top: 14px;
    }

    .hc-faq-item.open .hc-faq-answer {
        display: block;
    }

    /* Support / Admin Contact Card */
    .hc-support-card {
        background: linear-gradient(135deg, #ffffff 0%, #f7fbfe 100%);
        border: 2px dashed #b9d3e6;
        border-radius: 16px;
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    .hc-support-info h3 {
        margin: 0 0 6px;
        font-size: 1.2rem;
        color: var(--navy);
    }

    .hc-support-info p {
        margin: 0;
        color: var(--muted);
        font-size: 0.92rem;
    }

    .hc-btn-support {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--navy);
        color: white !important;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 650;
        font-size: 0.9rem;
        transition: 0.2s;
        box-shadow: 0 4px 12px rgba(21, 52, 81, 0.2);
        white-space: nowrap;
    }

    .hc-btn-support:hover {
        background: #1e4a73;
        transform: translateY(-2px);
    }

    /* Modal Detail Tutorial */
    .hc-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 34, 53, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .hc-modal {
        background: #ffffff;
        width: min(720px, 100%);
        max-height: 85vh;
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        animation: hcModalIn 0.2s ease-out;
    }

    @keyframes hcModalIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .hc-modal-header {
        padding: 22px 26px;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fbfdfe;
    }

    .hc-modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: var(--navy);
    }

    .hc-modal-close {
        background: #f0f4f7;
        border: none;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--muted);
    }

    .hc-modal-close:hover {
        background: #e2eaf0;
        color: var(--navy);
    }

    .hc-modal-body {
        padding: 24px 26px;
        color: var(--ink);
    }

    .hc-step-list {
        margin: 16px 0 0;
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .hc-step-list li {
        color: var(--ink);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .hc-step-list strong {
        color: var(--navy);
    }

    .hc-tip-box {
        background: var(--mint);
        border: 1px solid #bddfce;
        border-radius: 10px;
        padding: 14px 18px;
        margin-top: 20px;
        font-size: 0.88rem;
        color: #174c35;
    }

    .hc-no-result {
        display: none;
        text-align: center;
        padding: 36px 20px;
        background: white;
        border-radius: 12px;
        border: 1px dashed var(--line);
        color: var(--muted);
    }

    /* Responsive adjustments */
    @media (max-width: 900px) {
        .hc-categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .hc-guides-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .hc-categories-grid {
            grid-template-columns: 1fr;
        }
        .hc-support-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .hc-btn-support {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="help-center-wrapper">

    {{-- HERO SECTION & SEARCH BAR --}}
    <section class="hc-hero" aria-labelledby="hero-title">
        <div class="hc-hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            HELP CENTER · PUSAT BANTUAN PORTAL
        </div>
        <h1 id="hero-title">Ada yang bisa kami bantu?</h1>
        <p class="hc-hero-subtitle">Cari panduan langkah demi langkah, telusuri tutorial fitur, atau temukan jawaban pertanyaan umum seputar Portal Kelas XI RPL.</p>

        {{-- SEARCH BAR --}}
        <div class="hc-search-box">
            <span class="hc-search-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </span>
            <input 
                type="text" 
                id="hcSearchInput" 
                class="hc-search-input" 
                placeholder="Cari panduan, topik, atau pertanyaan (misal: login, password, fitur)..."
                aria-label="Cari panduan bantuan portal"
            >
        </div>

        <div class="hc-search-meta">
            <span>Pencarian populer:</span>
            <span class="hc-tag" onclick="quickSearch('login')">Cara Login</span>
            <span class="hc-tag" onclick="quickSearch('lupa password')">Lupa Password</span>
            <span class="hc-tag" onclick="quickSearch('dashboard')">Dashboard</span>
            <span class="hc-tag" onclick="quickSearch('fitur')">Daftar Fitur</span>
            <span class="hc-tag" onclick="quickSearch('profil')">Edit Profil</span>
        </div>
    </section>

    {{-- KATEGORI BANTUAN --}}
    <section aria-labelledby="cat-heading">
        <div class="hc-section-title">
            <h2 id="cat-heading">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--orange)"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                Jelajahi Kategori Bantuan
            </h2>
            <p>Pilih kategori untuk memfilter topik panduan</p>
        </div>

        <div class="hc-categories-grid">
            {{-- Kategori 1 --}}
            <div class="hc-cat-card active" data-category="all" onclick="filterCategory('all', this)">
                <div class="hc-cat-icon">⭐</div>
                <h3>Semua Panduan</h3>
                <p>Tampilkan seluruh panduan dan alur tutorial portal.</p>
            </div>

            {{-- Kategori 2 --}}
            <div class="hc-cat-card" data-category="akun" onclick="filterCategory('akun', this)">
                <div class="hc-cat-icon">🔐</div>
                <h3>Akun &amp; Login</h3>
                <p>Panduan masuk akun, keamanan, dan pengaturan sesi.</p>
            </div>

            {{-- Kategori 3 --}}
            <div class="hc-cat-card" data-category="dashboard" onclick="filterCategory('dashboard', this)">
                <div class="hc-cat-icon">📊</div>
                <h3>Dashboard</h3>
                <p>Mengenal tata letak halaman utama dan navigasi portal.</p>
            </div>

            {{-- Kategori 4 --}}
            <div class="hc-cat-card" data-category="fitur" onclick="filterCategory('fitur', this)">
                <div class="hc-cat-icon">🚀</div>
                <h3>Fitur Portal</h3>
                <p>Cara mengakses dan menggunakan modul 23 fitur kelas.</p>
            </div>
        </div>
    </section>

    {{-- PANDUAN PENGGUNAAN PORTAL (TUTORIAL LANGKAH DEMI LANGKAH) --}}
    <section aria-labelledby="guides-heading">
        <div class="hc-section-title">
            <h2 id="guides-heading">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--orange)"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                Panduan Penggunaan Portal
            </h2>
            <p>Pilih panduan langkah demi langkah yang ingin kamu pelajari</p>
        </div>

        <div id="guidesGrid" class="hc-guides-grid">

            {{-- 01: Panduan Login --}}
            <div class="hc-guide-card searchable-item" data-category="akun" onclick="openGuideModal('login')">
                <div class="hc-guide-number">01</div>
                <div class="hc-guide-content">
                    <span class="hc-guide-badge">Akun &amp; Akses</span>
                    <h3>Panduan Login</h3>
                    <p>Langkah masuk ke akun portal menggunakan NIS/Email siswa dan kata sandi yang valid.</p>
                    <div class="hc-guide-action">
                        Baca Tutorial Lengkap
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </div>
                </div>
            </div>

            {{-- 02: Panduan Dashboard --}}
            <div class="hc-guide-card searchable-item" data-category="dashboard" onclick="openGuideModal('dashboard')">
                <div class="hc-guide-number">02</div>
                <div class="hc-guide-content">
                    <span class="hc-guide-badge">Tampilan Utama</span>
                    <h3>Panduan Dashboard</h3>
                    <p>Mengenal panel navigasi, ringkasan aktivitas kelas, dan daftar pintasan fitur.</p>
                    <div class="hc-guide-action">
                        Baca Tutorial Lengkap
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </div>
                </div>
            </div>

            {{-- 03: Panduan Fitur --}}
            <div class="hc-guide-card searchable-item" data-category="fitur" onclick="openGuideModal('fitur')">
                <div class="hc-guide-number">03</div>
                <div class="hc-guide-content">
                    <span class="hc-guide-badge">Modul Aplikasi</span>
                    <h3>Panduan Fitur</h3>
                    <p>Cara menjelajahi 23 fitur kelas XI RPL, mulai dari jadwal, piket, hingga kalkulator nilai.</p>
                    <div class="hc-guide-action">
                        Baca Tutorial Lengkap
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </div>
                </div>
            </div>

            {{-- 04: Panduan Profil --}}
            <div class="hc-guide-card searchable-item" data-category="akun" onclick="openGuideModal('profil')">
                <div class="hc-guide-number">04</div>
                <div class="hc-guide-content">
                    <span class="hc-guide-badge">Pengaturan</span>
                    <h3>Panduan Profil</h3>
                    <p>Cara memperbarui identitas akun, foto profil, dan mengganti kata sandi secara berkala.</p>
                    <div class="hc-guide-action">
                        Baca Tutorial Lengkap
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </div>
                </div>
            </div>

            {{-- 05: Panduan Logout --}}
            <div class="hc-guide-card searchable-item" data-category="akun" onclick="openGuideModal('logout')">
                <div class="hc-guide-number">05</div>
                <div class="hc-guide-content">
                    <span class="hc-guide-badge">Keamanan</span>
                    <h3>Panduan Logout</h3>
                    <p>Cara keluar dari sesi portal secara aman, terutama saat menggunakan perangkat lab komputer.</p>
                    <div class="hc-guide-action">
                        Baca Tutorial Lengkap
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </div>
                </div>
            </div>

        </div>

        <div id="noResultNotice" class="hc-no-result">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px; color:var(--muted);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <h4 style="margin:0 0 6px; color:var(--navy);">Tidak ada panduan atau FAQ yang sesuai</h4>
            <p style="margin:0; font-size:0.9rem;">Coba cari dengan kata kunci lain atau pilih kategori "Semua Panduan".</p>
        </div>
    </section>

    {{-- FAQ SECTION (PERTANYAAN YANG SERING DIAJUKAN) --}}
    <section aria-labelledby="faq-heading">
        <div class="hc-section-title">
            <h2 id="faq-heading">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--orange)"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                Pertanyaan yang Sering Diajukan (FAQ)
            </h2>
            <p>Jawaban cepat untuk pertanyaan yang paling sering ditanyakan</p>
        </div>

        <div class="hc-faq-container">
            {{-- FAQ 1 --}}
            <div class="hc-faq-item searchable-item" data-category="akun">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana cara login ke portal?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Kamu dapat masuk ke portal dengan mengakses halaman login, memasukkan email atau NIS yang telah terdaftar oleh wali kelas/admin sekolah, dan memasukkan kata sandi default yang telah dibagikan. Pastikan koneksi internet stabil.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="hc-faq-item searchable-item" data-category="akun">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana jika lupa password?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Jika kamu lupa kata sandi akun, klik tautan "Lupa Password" pada form login untuk menerima tautan reset kata sandi melalui email. Jika tidak memiliki akses email, silakan segera hubungi Admin Portal atau Wali Kelas XI RPL.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="hc-faq-item searchable-item" data-category="akun">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Kenapa tidak bisa login?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Pastikan kombinasi username/email dan kata sandi sudah benar (perhatikan huruf besar/kecil Caps Lock). Jika akun masih terkendala, periksa apakah akun kamu berstatus aktif atau hubungi admin portal untuk reset sesi login.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="hc-faq-item searchable-item" data-category="fitur">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana cara mengakses fitur yang ada di portal?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Semua fitur kelas dapat diakses langsung melalui halaman <strong>Dashboard</strong> utama. Klik kartu modul fitur sesuai kebutuhan kamu (misalnya Jadwal Pelajaran pada fitur 01, FAQ Kelas pada fitur 05, atau Panduan pada fitur 21).
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="hc-faq-item searchable-item" data-category="akun">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana cara mengubah profil dan data diri?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Buka menu profil di pojok kanan atas atau akses halaman Pengaturan Akun. Di sana kamu bisa mengubah informasi kontak, biodata singkat, foto profil, dan memperbarui kata sandi.
                </div>
            </div>

            {{-- FAQ 6 --}}
            <div class="hc-faq-item searchable-item" data-category="dashboard">
                <div class="hc-faq-question" onclick="toggleFaq(this)">
                    <span>Bagaimana jika halaman mengalami kendala atau error?</span>
                    <span class="hc-faq-icon">▾</span>
                </div>
                <div class="hc-faq-answer">
                    Coba muat ulang halaman (refresh browser dengan menekan <code>Ctrl + F5</code>). Jika masalah berlanjut, pastikan URL tujuan sudah sesuai dan laporkan tangkapan layar (screenshot) error kepada penanggung jawab fitur atau Admin Portal.
                </div>
            </div>
        </div>
    </section>

    {{-- HUBUNGI ADMIN (KONTAK BANTUAN) --}}
    <section class="hc-support-card" aria-labelledby="support-heading">
        <div class="hc-support-info">
            <h3 id="support-heading">Masih membutuhkan bantuan lebih lanjut?</h3>
            <p>Jika kendala belum terselesaikan melalui panduan dan FAQ di atas, kamu dapat langsung menghubungi tim Admin Portal Kelas XI RPL SMK PESAT.</p>
        </div>
        <div>
            <a href="https://wa.me/?text=Halo%20Admin%20Portal%20Kelas%20XI%20RPL,%20saya%20membutuhkan%20bantuan" target="_blank" rel="noopener noreferrer" class="hc-btn-support">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                Hubungi Admin Portal
            </a>
        </div>
    </section>

</div>

{{-- MODAL DETAIL TUTORIAL PANDUAN --}}
<div id="guideModalBackdrop" class="hc-modal-backdrop" onclick="handleBackdropClick(event)">
    <div class="hc-modal" role="dialog" aria-modal="true" aria-labelledby="modalGuideTitle">
        <div class="hc-modal-header">
            <div>
                <span id="modalGuideBadge" class="hc-guide-badge">Panduan Tutorial</span>
                <h3 id="modalGuideTitle" style="margin-top: 6px;">Detail Panduan</h3>
            </div>
            <button type="button" class="hc-modal-close" onclick="closeGuideModal()" aria-label="Tutup modal">✕</button>
        </div>
        <div class="hc-modal-body" id="modalGuideBody">
            {{-- Konten tutorial dinamis diisi oleh JS --}}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data Detail Panduan Langkah demi Langkah
    const guidesData = {
        login: {
            badge: "Akun & Akses · Langkah demi Langkah",
            title: "Panduan Masuk (Login) ke Portal",
            html: `
                <p>Ikuti langkah-langkah berikut untuk masuk ke akun Portal Kelas XI RPL:</p>
                <ol class="hc-step-list">
                    <li><strong>Buka Halaman Portal:</strong> Akses tautan portal sekolah di browser kamu (Google Chrome, Firefox, atau Edge disarankan).</li>
                    <li><strong>Masukkan Kredensial:</strong> Masukkan NIS (Nomor Induk Siswa) atau alamat email sekolah yang telah didaftarkan.</li>
                    <li><strong>Ketikkan Kata Sandi:</strong> Masukkan kata sandi dengan teliti. Perhatikan penggunaan huruf kapital dan simbol.</li>
                    <li><strong>Ingat Saya (Opsional):</strong> Centang kotak "Ingat Saya" hanya jika menggunakan perangkat pribadi (laptop sendiri). Jangan centang jika di Lab Komputer.</li>
                    <li><strong>Klik Tombol Masuk:</strong> Tekan tombol "Masuk / Login" untuk langsung diarahkan ke Dashboard utama.</li>
                </ol>
                <div class="hc-tip-box">
                    💡 <strong>Tips Keamanan:</strong> Jangan pernah membagikan username atau kata sandi portal kepada siapapun.
                </div>
            `
        },
        dashboard: {
            badge: "Navigasi · Langkah demi Langkah",
            title: "Panduan Mengenal & Menggunakan Dashboard",
            html: `
                <p>Dashboard adalah pusat navigasi utama tempat seluruh fitur kelas berkumpul:</p>
                <ol class="hc-step-list">
                    <li><strong>Header & Navigasi:</strong> Bagian atas menampilkan identitas Portal Kelas XI RPL SMK PESAT serta tombol pintas kembali ke dashboard saat berada di halaman fitur.</li>
                    <li><strong>Pengenalan Proyek:</strong> Kotak intro menjelaskan konsep kolaborasi 23 siswa, 23 fitur, dan 1 proyek bersama.</li>
                    <li><strong>Katalog Fitur:</strong> Menampilkan kartu 23 fitur kelas bernomor urut 01 sampai 23.</li>
                    <li><strong>Membuka Modul:</strong> Cukup klik kartu fitur mana pun (misal fitur 01 untuk jadwal pelajaran) untuk langsung menuju halaman yang bersangkutan.</li>
                </ol>
                <div class="hc-tip-box">
                    💡 <strong>Tips:</strong> Setiap halaman fitur menyediakan tombol navigasi "Kembali ke dashboard" di bar atas untuk mempermudah kamu berpindah modul.
                </div>
            `
        },
        fitur: {
            badge: "Eksplorasi · Langkah demi Langkah",
            title: "Panduan Mengakses & Menggunakan Fitur Portal",
            html: `
                <p>Portal ini dikembangkan bersama dengan 23 modul yang saling melengkapi:</p>
                <ol class="hc-step-list">
                    <li><strong>Kenali Nomor Fitur:</strong> Setiap fitur memiliki penomoran 2 digit (01 hingga 23) sesuai nomor absen LKPD siswa pengembang.</li>
                    <li><strong>Pilih Kategori Modul:</strong> Terdapat modul pembelajaran (Jadwal, Materi, Referensi), produktivitas (Tugas, Timer Pomodoro), dan bantuan (FAQ, Panduan Penggunaan, Kontak).</li>
                    <li><strong>Interaksi Fitur:</strong> Manfaatkan form pencarian, filter status, kalkulator interaktif, dan tombol aksi yang tersedia di masing-masing modul.</li>
                </ol>
                <div class="hc-tip-box">
                    💡 <strong>Catatan:</strong> Fitur 21 (Panduan Penggunaan Portal) bertindak sebagai pusat edukasi dan dokumentasi penggunaan bagi seluruh siswa.
                </div>
            `
        },
        profil: {
            badge: "Pengaturan Akun · Langkah demi Langkah",
            title: "Panduan Mengubah Profil & Informasi Akun",
            html: `
                <p>Tata cara mengelola informasi profil akun portal siswa:</p>
                <ol class="hc-step-list">
                    <li><strong>Menuju Menu Akun:</strong> Klik foto profil atau nama kamu di navigasi portal, lalu pilih "Pengaturan Akun" atau "Profil".</li>
                    <li><strong>Memperbarui Biodata:</strong> Periksa nama lengkap, nomor absen, dan alamat email. Pastikan data selalu mutakhir.</li>
                    <li><strong>Mengganti Kata Sandi:</strong> Untuk menjaga keamanan akun, perbarui kata sandi secara berkala dengan minimal 8 karakter kombinasi huruf dan angka.</li>
                    <li><strong>Simpan Perubahan:</strong> Klik tombol "Simpan Profil" dan pastikan muncul notifikasi bahwa data berhasil disimpan.</li>
                </ol>
                <div class="hc-tip-box">
                    💡 <strong>Tips:</strong> Gunakan kata sandi yang mudah diingat oleh dirimu sendiri namun sulit ditebak oleh orang lain.
                </div>
            `
        },
        logout: {
            badge: "Keamanan · Langkah demi Langkah",
            title: "Panduan Keluar (Logout) Secara Aman",
            html: `
                <p>Penting untuk selalu mengakhiri sesi portal terutama di fasilitas umum:</p>
                <ol class="hc-step-list">
                    <li><strong>Pastikan Pekerjaan Tersimpan:</strong> Sebelum logout, pastikan tugas, form, atau catatan yang sedang kamu kerjakan sudah tersimpan.</li>
                    <li><strong>Buka Menu Akun:</strong> Klik pada icon avatar atau nama kamu di menu navigasi.</li>
                    <li><strong>Pilih Logout:</strong> Klik opsi "Keluar / Logout".</li>
                    <li><strong>Konfirmasi Pengeluaran:</strong> Sesi kamu akan segera dihentikan dan halaman akan kembali ke tampilan login portal.</li>
                </ol>
                <div class="hc-tip-box">
                    ⚠️ <strong>Penting di Lab Komputer:</strong> Selalu logout dan tutup jendela browser setelah selesai menggunakan komputer lab SMK PESAT agar akunmu tidak disalahgunakan orang lain.
                </div>
            `
        }
    };

    // Fungsi Buka Modal Detail Tutorial
    function openGuideModal(key) {
        const item = guidesData[key];
        if (!item) return;

        document.getElementById('modalGuideBadge').textContent = item.badge;
        document.getElementById('modalGuideTitle').textContent = item.title;
        document.getElementById('modalGuideBody').innerHTML = item.html;
        document.getElementById('guideModalBackdrop').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // Fungsi Tutup Modal
    function closeGuideModal() {
        document.getElementById('guideModalBackdrop').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function handleBackdropClick(event) {
        if (event.target === document.getElementById('guideModalBackdrop')) {
            closeGuideModal();
        }
    }

    // Event listener keyboard ESC untuk menutup modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGuideModal();
        }
    });

    // Fungsi Accordion FAQ
    function toggleFaq(element) {
        const item = element.parentElement;
        const isOpen = item.classList.contains('open');

        // Opsional: Tutup item lain agar rapi
        document.querySelectorAll('.hc-faq-item').forEach(i => i.classList.remove('open'));

        if (!isOpen) {
            item.classList.add('open');
        }
    }

    // Fungsi Filter Kategori
    function filterCategory(category, element) {
        document.querySelectorAll('.hc-cat-card').forEach(c => c.classList.remove('active'));
        if (element) element.classList.add('active');

        const searchKeyword = document.getElementById('hcSearchInput').value.toLowerCase().trim();
        applyFilterAndSearch(category, searchKeyword);
    }

    // Fungsi Quick Search Tag
    function quickSearch(keyword) {
        const input = document.getElementById('hcSearchInput');
        input.value = keyword;
        input.dispatchEvent(new Event('input'));
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Live Search Event
    document.getElementById('hcSearchInput').addEventListener('input', function() {
        const activeCatCard = document.querySelector('.hc-cat-card.active');
        const activeCat = activeCatCard ? activeCatCard.getAttribute('data-category') : 'all';
        applyFilterAndSearch(activeCat, this.value.toLowerCase().trim());
    });

    // Penerapan Filter Kategori & Search
    function applyFilterAndSearch(category, keyword) {
        const items = document.querySelectorAll('.searchable-item');
        let visibleCount = 0;

        items.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            const itemText = item.textContent.toLowerCase();

            const matchesCat = (category === 'all' || itemCat === category);
            const matchesSearch = !keyword || itemText.includes(keyword);

            if (matchesCat && matchesSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noResultNotice = document.getElementById('noResultNotice');
        if (visibleCount === 0) {
            noResultNotice.style.display = 'block';
        } else {
            noResultNotice.style.display = 'none';
        }
    }
</script>
@endpush
