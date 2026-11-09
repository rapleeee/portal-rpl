@extends('layouts.app')

@section('title', $judul)

@section('content')
    {{-- 1. DATA DAFTAR PROYEK --}}
    @php
        $daftarProyek = [
            [
                'judul' => 'Van Gogh Starry night',
                'siswa' => 'Fredi',
                'kategori' => 'Desain Grafis',
                'kategori_class' => 'desain',
                'deskripsi' => 'membuat ulang karya lukisan van gogh dari cat minyak dengan menggunakan teknik shading',
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJqptX4sin_z_PN4VtvmJMiNEYYrbhoFReakRensVZ0g&s=10',
                'views' => 437,
                'likes' => 12,
            ],
            [
                'judul' => 'Membuat website portofolio',
                'siswa' => 'Ali Husen',
                'kategori' => 'Desain Grafis',
                'kategori_class' => 'desain',
                'deskripsi' => 'Karya ini merupakan studi bentuk dengan menggunakan coding.',
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk096YsoHejwRIEN7KtesAwTFff_xBwahif30Kl5hUPg&s=10',
                'views' => 457,
                'likes' => 18,
            ],
            [
                'judul' => 'Membuat animasi berceritakan anak lokal yang sedang lomba agustus',
                'siswa' => 'Rafi',
                'kategori' => 'Multimedia',
                'kategori_class' => 'multimedia',
                'deskripsi' => 'Karya ini merupakan studi bentuk dengan membuat 3d animasi.',
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYHEdi6tfypADjp1memXYg3xZV9s8qcL4_zZQk_KfsoA&s=10',
                'views' => 380,
                'likes' => 25,
            ],
            [
                'judul' => 'Membuat design ruangan 3d yang bisa digerakan sendiri',
                'siswa' => 'Alfathrizy',
                'kategori' => 'Desain Grafis',
                'kategori_class' => 'desain',
                'deskripsi' => 'Pengembangan konsep ruangan kamar tidur.',
                'gambar' => 'https://assets.icandesignapp.com/images/99f01308858e8304d66d36aae2bb78438a07144e-1376x768-w1376.webp',
                'views' => 320,
                'likes' => 9,
            ],
            [
                'judul' => 'Kalkulator Warisan Islam (Faraid)',
                'siswa' => 'Daffa Maulana',
                'kategori' => 'Rekayasa Perangkat Lunak',
                'kategori_class' => 'rpl',
                'deskripsi' => 'Aplikasi web interaktif untuk mempermudah perhitungan pembagian hak waris sesuai syariat Islam.',
                'gambar' => 'https://www.shutterstock.com/image-vector/modern-web-design-white-calendar-260nw-1358507030.jpg',
                'views' => 610,
                'likes' => 45,
            ],
            [
                'judul' => 'Portofolio Digital Siswa RPL',
                'siswa' => 'M. Aidil Farhan',
                'kategori' => 'Rekayasa Perangkat Lunak',
                'kategori_class' => 'rpl',
                'deskripsi' => 'Website profil pribadi interaktif untuk memamerkan resume, keahlian coding, dan riwayat proyek.',
                'gambar' => 'https://picsum.photos/seed/portofolio/600/400',
                'views' => 540,
                'likes' => 31,
            ],
        ];
    @endphp

    {{-- 2. HEADER PENGANTAR --}}
    <div class="galeri-header">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p>Kumpulan karya dan proyek teknologi terbaik hasil kreasi siswa XI RPL SMK PESAT.</p>
    </div>

    {{-- 3. GRID KARTU PROYEK --}}
    <div class="galeri-grid">
        @foreach ($daftarProyek as $proyek)
            <article class="proyek-card">
                <!-- Sampul Gambar & Badge Kategori Melayang -->
                <div class="card-thumb">
                    <img src="{{ $proyek['gambar'] }}" alt="{{ $proyek['judul'] }}" loading="lazy">
                    <span class="badge-kategori badge-{{ $proyek['kategori_class'] }}">
                        {{ $proyek['kategori'] }}
                    </span>
                </div>

                <!-- Konten Teks -->
                <div class="card-content">
                    <h3 class="proyek-title">{{ $proyek['judul'] }}</h3>
                    <p class="proyek-desc">{{ $proyek['deskripsi'] }}</p>

                    <!-- Footer Kartu: Penulis & Stats -->
                    <div class="card-footer">
                        <span class="author-name">{{ strtoupper($proyek['siswa']) }}</span>
                        <div class="stats">
                            <span>👁 {{ $proyek['views'] }}</span>
                            <span>❤️ {{ $proyek['likes'] }}</span>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection

{{-- 4. STYLING CSS --}}
@push('styles')
<style>
    .galeri-header {
        margin-bottom: 28px;
        padding: clamp(20px, 4vw, 32px);
        background: white;
        border: 1px solid var(--line);
        border-top: 5px solid var(--orange);
        border-radius: 14px;
    }

    .galeri-header h1 {
        margin: 12px 0 6px;
    }

    .galeri-header p {
        color: var(--muted);
        margin: 0;
        font-size: 0.95rem;
    }

    /* Grid 3 Kolom Responsif */
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .proyek-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .proyek-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(21, 52, 81, 0.1);
        border-color: #cbd5e1;
    }

    /* Thumbnail Gambar */
    .card-thumb {
        position: relative;
        width: 100%;
        height: 190px;
        background: #e2e8f0;
    }

    .card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Badge Melayang di Atas Gambar */
    .badge-kategori {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }

    /* Variasi Warna Badge */
    .badge-desain { background-color: #6366f1; }       /* Ungu / Indigo */
    .badge-multimedia { background-color: #0d9488; }   /* Toska / Teal */
    .badge-rpl { background-color: #2563eb; }          /* Biru */

    /* Konten Teks */
    .card-content {
        padding: 18px 20px 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .proyek-title {
        font-size: 1rem;
        font-weight: 750;
        margin: 0 0 8px;
        color: #1e293b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .proyek-desc {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 18px;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Footer Kartu */
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 0.75rem;
    }

    .author-name {
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.05em;
    }

    .stats {
        display: flex;
        gap: 12px;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Responsif untuk Layar Tablet dan HP */
    @media (max-width: 900px) {
        .galeri-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .galeri-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush