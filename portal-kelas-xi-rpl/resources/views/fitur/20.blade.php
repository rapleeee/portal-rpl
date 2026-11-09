
@extends('layouts.app')

@section('title', $judul)

@section('content')

@php
    $prestasi = [
        ['nama' => 'Lomba Cerdas Cermat', 'kategori' => 'Akademik', 'tingkat' => 'Sekolah', 'tanggal' => '12 Januari 2026', 'juara' => 'Juara 1'],
        ['nama' => 'Lomba Web Design', 'kategori' => 'Akademik', 'tingkat' => 'Kabupaten', 'tanggal' => '20 Februari 2026', 'juara' => 'Juara 2'],
        ['nama' => 'Turnamen Futsal', 'kategori' => 'Non-Akademik', 'tingkat' => 'Sekolah', 'tanggal' => '15 Maret 2026', 'juara' => 'Juara 1'],
        ['nama' => 'Lomba Desain Poster', 'kategori' => 'Akademik', 'tingkat' => 'Provinsi', 'tanggal' => '10 April 2026', 'juara' => 'Juara 3'],
        ['nama' => 'Lomba Kebersihan Kelas', 'kategori' => 'Non-Akademik', 'tingkat' => 'Sekolah', 'tanggal' => '5 Mei 2026', 'juara' => 'Juara 1'],
        ['nama' => 'Lomba Tari Tradisional', 'kategori' => 'Non-Akademik', 'tingkat' => 'Kabupaten', 'tanggal' => '18 Juni 2026', 'juara' => 'Juara 2'],
    ];

    $total = count($prestasi);
    $akademik = collect($prestasi)->where('kategori', 'Akademik')->count();
    $nonAkademik = collect($prestasi)->where('kategori', 'Non-Akademik')->count();
@endphp

<style>
    .prestasi-wrapper {
        width: 100%;
        padding: 20px 0;
        color: #263445;
    }

    .prestasi-header {
        margin-bottom: 28px;
    }

    .prestasi-header h2 {
        font-size: 25px;
        font-weight: 700;
        margin: 12px 0;
    }

    .prestasi-header p {
        color: #718096;
        margin: 0;
    }

    .prestasi-badge {
        display: inline-block;
        background: #fff0df;
        color: #a45112;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Statistik */
    .prestasi-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        width: 100%;
        margin-bottom: 28px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        min-width: 0;
    }

    .stat-card p {
        color: #718096;
        font-size: 14px;
        margin: 0 0 8px;
    }

    .stat-card h3 {
        font-size: 27px;
        font-weight: 700;
        margin: 0;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 23px;
        flex-shrink: 0;
    }

    .icon-blue {
        background: #eaf2ff;
        color: #3975d7;
    }

    .icon-green {
        background: #e6f7ed;
        color: #26985a;
    }

    .icon-orange {
        background: #fff2df;
        color: #e69a28;
    }

    /* Tabel */
    .prestasi-table-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
    }

    .table-heading {
        padding: 22px 24px;
        border-bottom: 1px solid #edf0f4;
    }

    .table-heading h3 {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .table-heading p {
        color: #8a94a3;
        font-size: 13px;
        margin: 0;
    }

    .table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .prestasi-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
        font-size: 14px;
    }

    .prestasi-table thead {
        background: #f8fafc;
    }

    .prestasi-table th {
        padding: 15px 18px;
        text-align: left;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .prestasi-table td {
        padding: 16px 18px;
        border-top: 1px solid #f0f2f5;
        white-space: nowrap;
    }

    .prestasi-table tbody tr:hover {
        background: #fafcff;
    }

    .prestasi-table .nomor {
        color: #94a3b8;
        width: 55px;
    }

    .prestasi-name {
        font-weight: 600;
        color: #334155;
    }

    .category-badge,
    .winner-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-akademik {
        color: #3474ce;
        background: #eaf2ff;
    }

    .badge-nonakademik {
        color: #a46b19;
        background: #fff3df;
    }

    .winner-badge {
        color: #218653;
        background: #e8f7ef;
    }

    .table-footer {
        padding: 15px 24px;
        border-top: 1px solid #edf0f4;
        color: #8490a0;
        font-size: 12px;
    }

    .prestasi-info {
        margin-top: 16px;
        color: #8a94a3;
        font-size: 12px;
    }

    /* Tampilan HP */
    @media (max-width: 650px) {
        .prestasi-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .stat-card {
            padding: 18px;
        }

        .prestasi-wrapper {
            padding: 12px 0;
        }
    }
</style>

<div class="prestasi-wrapper">

    {{-- Header --}}
    <div class="prestasi-header">
        <span class="prestasi-badge">Absen {{ $nomor }}</span>

        <h2>{{ $judul }}</h2>

        <p>
            Informasi pencapaian dan prestasi yang berhasil diraih oleh kelas.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="prestasi-stats">

        <div class="stat-card">
            <div>
                <p>Total Prestasi</p>
                <h3>{{ $total }}</h3>
            </div>
            
        </div>

        <div class="stat-card">
            <div>
                <p>Prestasi Akademik</p>
                <h3>{{ $akademik }}</h3>
            </div>
            
        </div>

        <div class="stat-card">
            <div>
                <p>Prestasi Non-Akademik</p>
                <h3>{{ $nonAkademik }}</h3>
            </div>
            
        </div>

    </div>

    {{-- Daftar Prestasi --}}
    <div class="prestasi-table-card">

        <div class="table-heading">
            <h3>Daftar Prestasi Kelas</h3>
            <p>Riwayat pencapaian dan penghargaan kelas.</p>
        </div>

        <div class="table-scroll">
            <table class="prestasi-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Prestasi</th>
                        <th>Kategori</th>
                        <th>Tingkat</th>
                        <th>Tanggal</th>
                        <th>Pencapaian</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($prestasi as $index => $item)
                        <tr>
                            <td class="nomor">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>

                            <td class="prestasi-name">
                                {{ $item['nama'] }}
                            </td>

                            <td>
                                @if ($item['kategori'] == 'Akademik')
                                    <span class="category-badge badge-akademik">
                                        Akademik
                                    </span>
                                @else
                                    <span class="category-badge badge-nonakademik">
                                        Non-Akademik
                                    </span>
                                @endif
                            </td>

                            <td>{{ $item['tingkat'] }}</td>

                            <td>{{ $item['tanggal'] }}</td>

                            <td>
                                <span class="winner-badge">
                                    <i class="bi bi-trophy"></i>
                                    {{ $item['juara'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:35px;">
                                Belum ada data prestasi kelas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="table-footer">
            Menampilkan {{ $total }} data prestasi.
        </div>

    </div>

   

</div>
@endsection
