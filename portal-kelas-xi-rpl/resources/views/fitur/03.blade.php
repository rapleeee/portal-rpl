@extends('layouts.app')

@section('title', $judul)

@section('content')
@php
    // Data dummy kegiatan kelas XI RPL
    $kegiatan = [
        [
            'tanggal' => '11 Nov 2026',
            'hari' => 'Senin',
            'judul' => 'Deadline Pengumpulan Tugas Git & PR',
            'kategori' => 'Tugas',
            'warna' => '#f4a261',
            'jam' => 'Pulsek',
            'lokasi' => 'Repository Github King Pak Rafli'
        ],
        [
            'tanggal' => '23 Nov 2026',
            'hari' => 'Senin',
            'judul' => 'Sertikom Bersama Industri Tercinta',
            'kategori' => 'Ujian',
            'warna' => '#e63946',
            'jam' => '08:00 - 11:30',
            'lokasi' => 'Melalui Presentasi Offline dengan penguji dari industri dan pak rafli '
        ],
        [
            'tanggal' => '25 Nov 2026',
            'hari' => 'Rabu',
            'judul' => 'Peringatan Hari Guru',
            'kategori' => 'Event',
            'warna' => '#2a9d8f',
            'jam' => '09:00 - 12:00',
            'lokasi' => 'Kelas masing-masing'
        ],
    ];
@endphp

<div class="calendar-page">
    <!-- Header Halaman -->
    <div class="page-header">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1>{{ $judul }}</h1>
        <p>Jadwal agenda akademik, ujian, dan kegiatan seru XI RPL SMK PESAT.</p>
    </div>

    <!-- Layout 2 Kolom: Kalender Mini & Daftar Kegiatan -->
    <div class="calendar-layout">
        <!-- Kolom Kiri: Grid Kalender -->
        <section class="calendar-card" aria-label="Kalender Bulanan">
            <div class="calendar-header">
                <h2>November 2026</h2>
                <span class="badge-month">Bulan Ini</span>
            </div>
            
            <div class="calendar-grid">
                <!-- Nama Hari -->
                <div class="day-name">Sen</div>
                <div class="day-name">Sel</div>
                <div class="day-name">Rab</div>
                <div class="day-name">Kam</div>
                <div class="day-name">Jum</div>
                <div class="day-name">Sab</div>
                <div class="day-name">Min</div>

                <!-- Contoh Hari & Tanggal (1-30) -->
                
                @for ($tgl = 1; $tgl <= 30; $tgl++)
                    @php
                        // Cek apakah tanggal punya event
                        $punyaEvent = in_array($tgl, [11, 23, 25]);
                        $isToday = ($tgl == 9);
                    @endphp
                    <div class="day-cell {{ $isToday ? 'today' : '' }} {{ $punyaEvent ? 'has-event' : '' }}">
                        <span class="date-num">{{ $tgl }}</span>
                        @if ($punyaEvent)
                            <span class="dot-indicator"></span>
                        @endif
                    </div>
                @endfor
            </div>
        </section>

        <!-- Kolom Kanan: Daftar Agenda -->
        <section class="agenda-card" aria-label="Daftar Agenda">
            <h2>Agenda Mendatang</h2>
            <div class="agenda-list">
                @foreach ($kegiatan as $item)
                    <article class="event-item" @style(['border-left-color: ' . $item['warna']])>
                        <div class="event-meta">
                            <span class="event-date">{{ $item['hari'] }}, {{ $item['tanggal'] }}</span>
                            <span class="event-badge" @style(['background-color: ' . $item['warna'] . '20', 'color: ' . $item['warna']])>
                                {{ $item['kategori'] }}
                            </span>
                        </div>
                        <h3 class="event-title">{{ $item['judul'] }}</h3>
                        <div class="event-footer">
                            <span>🕒 {{ $item['jam'] }}</span>
                            <span>📍 {{ $item['lokasi'] }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
<style>
    .calendar-page {
        margin-top: 10px;
    }
    .page-header {
        margin-bottom: 24px;
    }
    .page-header h1 {
        margin: 10px 0 6px;
    }
    .page-header p {
        color: var(--muted);
        margin: 0;
    }
    
    .calendar-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
    }
    
    .calendar-card, .agenda-card {
        background: white;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 6px rgba(21, 52, 81, 0.04);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .calendar-header h2 {
        font-size: 1.25rem;
    }
    .badge-month {
        font-size: 0.8rem;
        background: var(--mint);
        color: var(--navy);
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Grid Kalender */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        text-align: center;
    }
    .day-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--muted);
        padding-bottom: 8px;
    }
    .day-cell {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f8fafc;
        font-size: 0.9rem;
        position: relative;
        cursor: pointer;
        transition: 0.15s;
    }
    .day-cell:hover {
        background: #eaf1f7;
    }
    .day-cell.today {
        background: var(--navy);
        color: white;
        font-weight: bold;
    }
    .day-cell.has-event {
        border: 1px solid var(--orange);
    }
    .dot-indicator {
        width: 6px;
        height: 6px;
        background: var(--orange);
        border-radius: 50%;
        position: absolute;
        bottom: 5px;
    }
    .day-cell.today .dot-indicator {
        background: #fff;
    }

    /* Agenda List */
    .agenda-card h2 {
        font-size: 1.25rem;
        margin-bottom: 20px;
    }
    .agenda-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .event-item {
        border: 1px solid var(--line);
        border-left: 5px solid var(--orange);
        border-radius: 8px;
        padding: 14px 16px;
        background: #ffffff;
        transition: transform 0.15s ease;
    }
    .event-item:hover {
        transform: translateY(-2px);
    }
    .event-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .event-date {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--muted);
    }
    .event-badge {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
    }
    .event-title {
        font-size: 1rem;
        margin: 0 0 10px 0;
        color: var(--ink);
    }
    .event-footer {
        display: flex;
        gap: 16px;
        font-size: 0.8rem;
        color: var(--muted);
    }

    /* Responsif untuk Layar HP */
    @media (max-width: 768px) {
        .calendar-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush