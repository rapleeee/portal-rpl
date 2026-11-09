@extends('layouts.app')

@section('title', $judul)

@section('content')
    <style>
        /* Jadwal Piket - khusus halaman ini, memakai variabel dari app.css */
        .piket-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .piket-card {
            padding: 24px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 12px;
            transition: border-color .15s, box-shadow .15s;
        }

        .piket-card:hover {
            border-color: #ad632b;
            box-shadow: 0 4px 16px #15345110;
        }

        .piket-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 14px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--line);
        }

        .piket-head h3 {
            margin: 0;
        }

        .name-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .name-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .95rem;
        }

        .avatar {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--mint);
            color: var(--navy);
            font-size: .7rem;
            font-weight: 750;
            flex-shrink: 0;
        }

        .piket-card.is-today {
            border: 2px solid var(--orange);
            background: #fffaf5;
        }

        .piket-card.is-today .piket-head h3::after {
            content: "Hari ini";
            margin-left: 10px;
            padding: 3px 8px;
            border-radius: 6px;
            background: var(--navy);
            color: white;
            font-size: .7rem;
            font-weight: 700;
            vertical-align: middle;
        }

        .section-heading.with-line {
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 20px;
        }

        .tugas h2 {
            margin: 18px 0 16px;
        }

        .task-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .task-list li {
            position: relative;
            padding: 10px 14px 10px 38px;
            background: var(--mint);
            border-radius: 8px;
            color: var(--ink);
            font-size: .9rem;
        }

        .task-list li::before {
            content: "✓";
            position: absolute;
            left: 14px;
            color: var(--navy);
            font-weight: 800;
        }

        @media (max-width: 850px) {
            .piket-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {

            .piket-grid,
            .task-list {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .piket-card {
                transition: none;
            }
        }

        .minggu-picker {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .9rem;
            color: var(--muted);
        }

        .minggu-picker select {
            padding: 8px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: white;
            color: var(--ink);
            font: inherit;
            font-weight: 650;
            cursor: pointer;
        }
    </style>
    <section class="placeholder" aria-labelledby="judul-fitur">
        <p class="eyebrow">JADWAL PIKET</p>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p>Cek giliran piketmu dan tugas yang harus dikerjakan setiap hari sebelum pulang.</p>
        <span class="summary" id="today-summary">Hari ini</span>


        <div class="section-heading">
            <h2>Jadwal per hari</h2>
            <p>Senin – Jumat</p>
        </div>

        <div class="section-heading with-line">
            <h2>Jadwal per hari</h2>
            <label class="minggu-picker" for="pilih-minggu">
                <span>Lihat jadwal</span>
                <select id="pilih-minggu">
                    <option value="1">Minggu 1</option>
                    <option value="2">Minggu 2</option>
                    <option value="3">Minggu 3</option>
                </select>
            </label>
        </div>
        <div class="minggu-panel" data-minggu="1">
            <div class="piket-grid">
                <article class="piket-card" data-day="1">
                    <header class="piket-head">
                        <h3>Senin</h3><span class="badge">4 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">A</span> ABBAD NAILUN NABHAN</li>
                        <li><span class="avatar">H</span> HANIF EL HAKIM</li>
                        <li><span class="avatar">M</span> MOHAMMAD SYAFIQ ALFARISI</li>
                        <li><span class="avatar">M</span> MUHAMMAD ALIEF ALVIANSYAH</li>
                    </ul>
                </article>
                <article class="piket-card" data-day="2">
                    <header class="piket-head">
                        <h3>Selasa</h3><span class="badge">4 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">M</span>MUHAMAD RAFIE TAUFIK</li>
                        <li><span class="avatar">M</span> M.ALFATH FACHRIZY EL HAKIM</li>
                        <li><span class="avatar">M</span> MUHAMMAD KHAIRUL AZZAM</li>
                        <li><span class="avatar">Z</span> ZENTRISTAN VITADI</li>
                    </ul>
                </article>
            </div>
        </div>

        <div class="minggu-panel" data-minggu="2" hidden>
            <div class="piket-grid">
                <article class="piket-card" data-day="1">
                    <header class="piket-head">
                        <h3>Senin</h3><span class="badge">4 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">M</span> MUHAMMAD AIDIEL KAMIL</li>
                        <li><span class="avatar">M</span> MUH. AMMAR SIDIQ PUTRA MUAMAR</li>
                        <li><span class="avatar">A</span> AMMAR ZAHID ASKARULLAH</li>
                        <li><span class="avatar">A</span> ARGHAD FAWWAZ ANANDA</li>
                    </ul>
                </article>
                <article class="piket-card" data-day="2">
                    <header class="piket-head">
                        <h3>Selasa</h3><span class="badge">4 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">B</span>BELVA ALKEANNO WIBOWO</li>
                        <li><span class="avatar">S</span> SHAHJAHAN AFZAAL SAIFUDIN</li>
                        <li><span class="avatar">A</span> ALWI HUSEIN SHAHAB</li>
                        <li><span class="avatar">Z</span> ZHOFIR RAFIF MACHIKO</li>
                    </ul>
                </article>
            </div>
        </div>

        <div class="minggu-panel" data-minggu="3" hidden>
            <div class="piket-grid">
                <article class="piket-card" data-day="1">
                    <header class="piket-head">
                        <h3>Senin</h3><span class="badge">4 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">W</span> WYANET IN NAKEISHA</li>
                        <li><span class="avatar">S</span>SHAFIRA MULYANA</li>
                        <li><span class="avatar">R</span> RAIHANA AZARINE YULIANTORO</li>
                        <li><span class="avatar">K</span> KAYLA ARTALITA</li>
                    </ul>
                </article>
                <article class="piket-card" data-day="2">
                    <header class="piket-head">
                        <h3>Selasa</h3><span class="badge">3 orang</span>
                    </header>
                    <ul class="name-list">
                        <li><span class="avatar">A</span> ADITYA SALMAN SUNTANA</li>
                        <li><span class="avatar">M</span> MUHAMMAD ANUGRAH ASHRI</li>
                        <li><span class="avatar">M</span> MUHAMMAD DZAKWAN AL MAULIDIN</li>
                    </ul>
                </article>
            </div>
        </div>
        <script>
            // Tanggal Senin di Minggu 1 (ubah sesuai awal rotasi kelasmu)
            const MULAI = new Date('2026-11-09T00:00:00');
            const JUMLAH_MINGGU = 3;

            const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const sekarang = new Date();
            const selisihHari = Math.floor((sekarang - MULAI) / 86400000);
            const mingguIni = ((Math.floor(selisihHari / 7) % JUMLAH_MINGGU) + JUMLAH_MINGGU) % JUMLAH_MINGGU + 1;

            const pilih = document.getElementById('pilih-minggu');
            const panels = document.querySelectorAll('.minggu-panel');

            function tampilkan(minggu) {
                panels.forEach(p => p.hidden = p.dataset.minggu !== String(minggu));
            }

            // Tandai opsi minggu ini dan pilih otomatis
            pilih.querySelector('option[value="' + mingguIni + '"]').textContent += ' (minggu ini)';
            pilih.value = mingguIni;
            tampilkan(mingguIni);
            pilih.addEventListener('change', () => tampilkan(pilih.value));

            // Highlight kartu hari ini (hanya di minggu yang sedang berjalan)
            const hariIni = sekarang.getDay();
            const kartu = document.querySelector('.minggu-panel[data-minggu="' + mingguIni + '"] .piket-card[data-day="' + hariIni + '"]');
            const label = document.getElementById('today-summary');
            if (kartu) {
                kartu.classList.add('is-today');
                label.textContent = 'Hari ini: ' + hari[hariIni] + ' · ada piket';
            } else {
                label.textContent = 'Hari ini: ' + hari[hariIni] + ' · tidak ada piket';
            }
        </script>
@endsection