@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    .cd .lead { max-width: 660px; margin: 0 0 22px; color: var(--muted); }

    .cd-hero { background: var(--navy); color: #fff; border-radius: 14px; padding: clamp(18px, 4vw, 28px); margin-bottom: 20px; }
    .cd-label { margin: 0 0 8px; font-size: .72rem; font-weight: 750; letter-spacing: .14em; text-transform: uppercase; color: var(--mint); }
    .cd-hero-nama { margin: 0 0 18px; font-size: clamp(1.15rem, 3vw, 1.6rem); line-height: 1.3; }
    .cd-digits { display: flex; flex-wrap: wrap; gap: 10px; }
    .cd-unit { min-width: 72px; flex: 1 1 72px; text-align: center; background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .18); border-radius: 10px; padding: 12px 10px; }
    .cd-unit strong { display: block; font-size: clamp(1.6rem, 5vw, 2.2rem); line-height: 1.1; font-variant-numeric: tabular-nums; }
    .cd-unit span { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--mint); }
    .cd-hero-tanggal { margin: 16px 0 0; font-size: .88rem; color: #cfe0ea; }
    .cd-hero.is-empty { background: #fff; color: var(--ink); border: 1px dashed var(--line); }
    .cd-hero.is-empty .cd-label,
    .cd-hero.is-empty .cd-hero-tanggal { color: var(--muted); }

    .cd-form { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 16px; background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 18px; margin-bottom: 20px; }
    .cd-field { display: flex; flex-direction: column; gap: 6px; }
    .cd-field--nama { grid-column: 1 / -1; }
    .cd-field label { font-size: .82rem; font-weight: 650; }
    .cd-field input,
    .cd-field select { font: inherit; padding: 10px 12px; border: 1px solid var(--line); border-radius: 8px; background: #fbfdfe; color: var(--ink); }
    .cd-field input:focus,
    .cd-field select:focus { border-color: var(--orange); outline: none; box-shadow: 0 0 0 3px rgba(244, 162, 97, .2); }
    .cd-hint { font-size: .76rem; color: var(--muted); }
    .cd-form-actions { grid-column: 1 / -1; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .cd-btn { font: inherit; font-weight: 650; padding: 10px 18px; border: 0; border-radius: 8px; background: var(--navy); color: #fff; cursor: pointer; }
    .cd-btn:hover { background: #0f2840; }
    .cd-error { margin: 0; color: #a3351a; font-size: .85rem; font-weight: 600; }

    .cd-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-bottom: 14px; }
    .cd-filter { display: flex; align-items: center; gap: 8px; font-size: .88rem; }
    .cd-filter select { font: inherit; padding: 8px 10px; border: 1px solid var(--line); border-radius: 8px; background: #fff; color: var(--ink); }
    .cd-count { margin: 0; color: var(--muted); font-size: .88rem; }

    .cd-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 12px; }
    .cd-card { background: #fff; border: 1px solid var(--line); border-left: 5px solid var(--orange); border-radius: 12px; padding: 16px 18px; display: flex; flex-direction: column; gap: 8px; }
    .cd-card.is-terlewat { border-left-color: #c9d4da; opacity: .78; }
    .cd-card-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .cd-kategori { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; background: #fff0e2; color: #7b4118; }
    .cd-kategori--ujian { background: #e7f0fb; color: #1f4d78; }
    .cd-kategori--kegiatan { background: var(--mint); color: #1d6b4f; }
    .cd-kategori--lainnya { background: #eef1f4; color: var(--muted); }
    .cd-status { font-size: .78rem; font-weight: 650; color: var(--muted); }
    .cd-card.is-terlewat .cd-status { color: #a3351a; }
    .cd-card-nama { margin: 0; font-size: 1rem; line-height: 1.4; }
    .cd-card-tanggal { margin: 0; font-size: .82rem; color: var(--muted); }
    .cd-card-digits { display: flex; flex-wrap: wrap; gap: 8px; }
    .cd-mini { min-width: 58px; text-align: center; background: #f4f8fa; border: 1px solid var(--line); border-radius: 8px; padding: 8px 6px; }
    .cd-mini strong { display: block; font-size: 1.15rem; line-height: 1.2; font-variant-numeric: tabular-nums; }
    .cd-mini span { font-size: .68rem; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); }
    .cd-hapus { align-self: flex-end; font: inherit; font-size: .8rem; font-weight: 650; color: #a3351a; background: transparent; border: 1px solid var(--line); border-radius: 8px; padding: 6px 12px; cursor: pointer; }
    .cd-hapus:hover { background: #fdf0ec; border-color: #e4b6a3; }

    .cd-empty { text-align: center; background: #fff; border: 1px dashed var(--line); border-radius: 12px; padding: 28px; }
    .cd-empty p { margin: 0 0 14px; color: var(--muted); }
    .cd-note { margin: 22px 0 0; font-size: .8rem; color: var(--muted); }
    .visually-hidden { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0; }

    @media (max-width: 640px) {
        .cd-form { grid-template-columns: 1fr; }
        .cd-toolbar { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush

@section('content')
    <section class="placeholder cd" aria-labelledby="judul-fitur">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p class="lead">Catat tenggat tugas, ujian, atau kegiatan kelas, lalu lihat hitungan mundurnya diperbarui setiap detik. Urutan daftar otomatis dari tenggat yang paling dekat.</p>

        <div class="cd-hero" id="tenggat-terdekat">
            <p class="cd-label">Tenggat terdekat</p>
            <h2 class="cd-hero-nama" id="hero-nama">Memuat…</h2>
            <div class="cd-digits" id="hero-digit">
                <span class="cd-unit"><strong data-unit="hari">0</strong><span>hari</span></span>
                <span class="cd-unit"><strong data-unit="jam">0</strong><span>jam</span></span>
                <span class="cd-unit"><strong data-unit="menit">0</strong><span>menit</span></span>
                <span class="cd-unit"><strong data-unit="detik">0</strong><span>detik</span></span>
            </div>
            <p class="cd-hero-tanggal" id="hero-tanggal"></p>
            <p class="visually-hidden" id="live-ringkasan" aria-live="polite"></p>
        </div>

        <form class="cd-form" id="form-tenggat" novalidate>
            <div class="cd-field cd-field--nama">
                <label for="input-nama">Nama tenggat</label>
                <input type="text" id="input-nama" name="nama" placeholder="Contoh: Kumpul tugas Praktikum RPL" required>
            </div>
            <div class="cd-field">
                <label for="input-tanggal">Tanggal</label>
                <input type="date" id="input-tanggal" name="tanggal" required>
            </div>
            <div class="cd-field">
                <label for="input-waktu">Waktu (opsional)</label>
                <input type="time" id="input-waktu" name="waktu">
                <span class="cd-hint">Kosongkan bila tenggat seharian penuh, dihitung sampai 23:59.</span>
            </div>
            <div class="cd-field">
                <label for="input-kategori">Kategori</label>
                <select id="input-kategori" name="kategori">
                    <option value="Tugas">Tugas</option>
                    <option value="Ujian">Ujian</option>
                    <option value="Kegiatan">Kegiatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="cd-form-actions">
                <button class="cd-btn" type="submit">Tambah tenggat</button>
                <p class="cd-error" id="form-error" role="alert"></p>
            </div>
        </form>

        <div class="cd-toolbar">
            <div class="cd-filter">
                <label for="filter-status">Tampilkan</label>
                <select id="filter-status">
                    <option value="semua">Semua tenggat</option>
                    <option value="akan-datang">Hanya yang akan datang</option>
                    <option value="terlewat">Hanya yang sudah terlewat</option>
                </select>
            </div>
            <p class="cd-count" id="jumlah-tenggat">0 tenggat</p>
        </div>

        <ul class="cd-list" id="daftar-tenggat"></ul>

        <div class="cd-empty" id="state-kosong" hidden>
            <p>Belum ada tenggat. Tambahkan satu lewat formulir di atas, atau muat data contoh berikut.</p>
            <button class="cd-btn" type="button" id="btn-contoh">Muat data contoh</button>
        </div>

        <div class="cd-empty" id="state-tidak-ada" hidden>
            <p>Tidak ada tenggat pada filter ini. Coba pilih filter lain.</p>
        </div>

        <p class="cd-note">Data tersimpan di browser ini (localStorage) dan tidak dikirim ke server mana pun. Menghapus semua tenggat akan mengosongkan daftar; gunakan tombol Muat data contoh untuk mengisinya ulang.</p>
    </section>
@endsection

@push('scripts')
<script>
    (() => {
        'use strict';

        const KUNCI = 'portal12.tenggat';
        const KATEGORI = ['Tugas', 'Ujian', 'Kegiatan', 'Lainnya'];
        const SATU_DETIK = 1000;
        const JEDA_UMUMAN = 60 * SATU_DETIK;

        const el = {
            hero: document.getElementById('tenggat-terdekat'),
            heroNama: document.getElementById('hero-nama'),
            heroTanggal: document.getElementById('hero-tanggal'),
            heroDigit: document.getElementById('hero-digit'),
            live: document.getElementById('live-ringkasan'),
            form: document.getElementById('form-tenggat'),
            nama: document.getElementById('input-nama'),
            tanggal: document.getElementById('input-tanggal'),
            waktu: document.getElementById('input-waktu'),
            kategori: document.getElementById('input-kategori'),
            galat: document.getElementById('form-error'),
            filter: document.getElementById('filter-status'),
            daftar: document.getElementById('daftar-tenggat'),
            kosong: document.getElementById('state-kosong'),
            tidakAda: document.getElementById('state-tidak-ada'),
            jumlah: document.getElementById('jumlah-tenggat'),
            btnContoh: document.getElementById('btn-contoh'),
        };

        let data = muat();
        if (data === null) {
            data = dataContoh();
            simpan(data);
        }

        let terakhirUmumkan = 0;

        function tanggalValid(tanggal) {
            if (!/^\d{4}-\d{2}-\d{2}$/.test(tanggal)) {
                return false;
            }
            const [tahun, bulan, hari] = tanggal.split('-').map(Number);
            const hasil = new Date(tahun, bulan - 1, hari);
            return hasil.getFullYear() === tahun
                && hasil.getMonth() === bulan - 1
                && hasil.getDate() === hari;
        }

        function waktuValid(waktu) {
            return waktu === '' || /^([01]\d|2[0-3]):[0-5]\d$/.test(waktu);
        }

        function targetDate(item) {
            const [tahun, bulan, hari] = item.tanggal.split('-').map(Number);
            if (item.waktu) {
                const [jam, menit] = item.waktu.split(':').map(Number);
                return new Date(tahun, bulan - 1, hari, jam, menit, 0);
            }
            return new Date(tahun, bulan - 1, hari, 23, 59, 59);
        }

        function itemValid(item) {
            return item
                && typeof item.nama === 'string'
                && item.nama.trim() !== ''
                && /^\d{4}-\d{2}-\d{2}$/.test(item.tanggal || '')
                && KATEGORI.includes(item.kategori);
        }

        function muat() {
            try {
                const raw = localStorage.getItem(KUNCI);
                if (raw === null) {
                    return null;
                }
                const parsed = JSON.parse(raw);
                return Array.isArray(parsed) ? parsed.filter(itemValid) : null;
            } catch (error) {
                return null;
            }
        }

        function simpan() {
            localStorage.setItem(KUNCI, JSON.stringify(data));
        }

        function uid() {
            return Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 8);
        }

        function tanggalContoh(hariLagi) {
            const sekarang = new Date();
            sekarang.setDate(sekarang.getDate() + hariLagi);
            const pad = (nilai) => String(nilai).padStart(2, '0');
            return sekarang.getFullYear() + '-' + pad(sekarang.getMonth() + 1) + '-' + pad(sekarang.getDate());
        }

        function dataContoh() {
            return [
                { id: uid(), nama: 'Kumpul tugas Praktikum RPL', tanggal: tanggalContoh(2), waktu: '16:00', kategori: 'Tugas' },
                { id: uid(), nama: 'Latihan presentasi kelompok', tanggal: tanggalContoh(5), waktu: '', kategori: 'Kegiatan' },
                { id: uid(), nama: 'Ujian Tengah Semester', tanggal: tanggalContoh(9), waktu: '08:00', kategori: 'Ujian' },
            ];
        }

        function formatTanggal(item) {
            const target = targetDate(item);
            let teks = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
            }).format(target);
            if (item.waktu) {
                teks += ' · pukul ' + item.waktu;
            }
            return teks;
        }

        function labelStatus(item, now) {
            const sisa = targetDate(item) - now;
            if (sisa <= 0) {
                return 'Terlewat';
            }
            const hari = Math.floor(sisa / (SATU_DETIK * 86400));
            if (hari === 0) {
                return 'Hari ini';
            }
            if (hari === 1) {
                return 'Besok';
            }
            return hari + ' hari lagi';
        }

        function digit(item, now) {
            const sisa = Math.max(0, targetDate(item) - now);
            const totalDetik = Math.floor(sisa / SATU_DETIK);
            return {
                hari: Math.floor(totalDetik / 86400),
                jam: Math.floor((totalDetik % 86400) / 3600),
                menit: Math.floor((totalDetik % 3600) / 60),
                detik: totalDetik % 60,
            };
        }

        function isiDigit(wadah, nilai) {
            wadah.querySelector('[data-unit="hari"]').textContent = nilai.hari;
            wadah.querySelector('[data-unit="jam"]').textContent = nilai.jam;
            wadah.querySelector('[data-unit="menit"]').textContent = nilai.menit;
            wadah.querySelector('[data-unit="detik"]').textContent = nilai.detik;
        }

        function tenggatBerikutnya(now) {
            return data
                .filter((item) => targetDate(item) > now)
                .sort((a, b) => targetDate(a) - targetDate(b))[0] || null;
        }

        function renderHero(now) {
            const berikutnya = tenggatBerikutnya(now);
            el.hero.classList.toggle('is-empty', berikutnya === null);
            el.heroDigit.hidden = berikutnya === null;

            if (berikutnya === null) {
                el.heroNama.textContent = 'Belum ada tenggat yang akan datang';
                el.heroTanggal.textContent = 'Tambahkan tenggat pertama menggunakan formulir di atas.';
                el.live.textContent = '';
                return;
            }

            el.heroNama.textContent = berikutnya.nama;
            el.heroTanggal.textContent = formatTanggal(berikutnya);
            isiDigit(el.heroDigit, digit(berikutnya, now));
        }

        function buatKartu(item) {
            const li = document.createElement('li');
            li.className = 'cd-card';
            li.dataset.id = item.id;

            const head = document.createElement('div');
            head.className = 'cd-card-head';

            const kategori = document.createElement('span');
            kategori.className = 'cd-kategori cd-kategori--' + item.kategori.toLowerCase();
            kategori.textContent = item.kategori;

            const statusEl = document.createElement('span');
            statusEl.className = 'cd-status';

            head.append(kategori, statusEl);

            const nama = document.createElement('h3');
            nama.className = 'cd-card-nama';
            nama.textContent = item.nama;

            const tanggal = document.createElement('p');
            tanggal.className = 'cd-card-tanggal';
            tanggal.textContent = formatTanggal(item);

            const digits = document.createElement('div');
            digits.className = 'cd-card-digits';
            ['hari', 'jam', 'menit', 'detik'].forEach((unit) => {
                const mini = document.createElement('span');
                mini.className = 'cd-mini';
                const strong = document.createElement('strong');
                strong.dataset.unit = unit;
                const label = document.createElement('span');
                label.textContent = unit;
                mini.append(strong, label);
                digits.appendChild(mini);
            });

            const hapus = document.createElement('button');
            hapus.type = 'button';
            hapus.className = 'cd-hapus';
            hapus.dataset.hapus = item.id;
            hapus.textContent = 'Hapus';

            li.append(head, nama, tanggal, digits, hapus);
            return li;
        }

        function renderList(now) {
            const filter = el.filter.value;
            const tersaring = data
                .filter((item) => {
                    const sisa = targetDate(item) - now;
                    if (filter === 'akan-datang') {
                        return sisa > 0;
                    }
                    if (filter === 'terlewat') {
                        return sisa <= 0;
                    }
                    return true;
                })
                .sort((a, b) => {
                    const sisaA = targetDate(a) - now;
                    const sisaB = targetDate(b) - now;
                    const aAkanDatang = sisaA > 0 ? 0 : 1;
                    const bAkanDatang = sisaB > 0 ? 0 : 1;
                    if (aAkanDatang !== bAkanDatang) {
                        return aAkanDatang - bAkanDatang;
                    }
                    return aAkanDatang === 0 ? sisaA - sisaB : sisaB - sisaA;
                });

            el.daftar.replaceChildren();
            tersaring.forEach((item) => el.daftar.appendChild(buatKartu(item)));

            const adaData = data.length !== 0;
            el.kosong.hidden = adaData;
            el.tidakAda.hidden = !(adaData && tersaring.length === 0);
            el.jumlah.textContent = adaData
                ? data.length + ' tenggat'
                : 'Belum ada tenggat';
        }

        function tick() {
            const now = new Date();

            const berikutnya = tenggatBerikutnya(now);
            el.heroDigit.hidden = berikutnya === null;
            if (berikutnya !== null) {
                isiDigit(el.heroDigit, digit(berikutnya, now));
                if (now - terakhirUmumkan > JEDA_UMUMAN) {
                    terakhirUmumkan = now.getTime();
                    const nilai = digit(berikutnya, now);
                    el.live.textContent = berikutnya.nama + ': sisa ' + nilai.hari + ' hari '
                        + nilai.jam + ' jam ' + nilai.menit + ' menit.';
                }
            }

            el.daftar.querySelectorAll('.cd-card').forEach((kartu) => {
                const item = data.find((d) => d.id === kartu.dataset.id);
                if (!item) {
                    return;
                }
                const sisa = targetDate(item) - now;
                const statusEl = kartu.querySelector('.cd-status');
                const digits = kartu.querySelector('.cd-card-digits');

                if (sisa <= 0) {
                    kartu.classList.add('is-terlewat');
                    digits.hidden = true;
                    statusEl.textContent = 'Terlewat';
                    return;
                }

                kartu.classList.remove('is-terlewat');
                digits.hidden = false;
                statusEl.textContent = labelStatus(item, now);
                isiDigit(digits, digit(item, now));
            });
        }

        function render() {
            const now = new Date();
            renderHero(now);
            renderList(now);
            tick();
        }

        el.form.addEventListener('submit', (event) => {
            event.preventDefault();
            const nama = el.nama.value.trim();
            const tanggal = el.tanggal.value;

            if (nama === '' || tanggal === '') {
                el.galat.textContent = 'Isi nama tenggat dan tanggal terlebih dahulu.';
                return;
            }
            if (!tanggalValid(tanggal)) {
                el.galat.textContent = 'Tanggal tidak valid, periksa kembali tanggal yang dipilih.';
                return;
            }
            if (!waktuValid(el.waktu.value)) {
                el.galat.textContent = 'Waktu tidak valid, gunakan format JJ:MM.';
                return;
            }

            data.push({
                id: uid(),
                nama: nama,
                tanggal: tanggal,
                waktu: el.waktu.value || '',
                kategori: el.kategori.value,
            });
            simpan();

            el.form.reset();
            el.kategori.value = 'Tugas';
            el.galat.textContent = '';
            render();
        });

        el.daftar.addEventListener('click', (event) => {
            const tombol = event.target.closest('[data-hapus]');
            if (!tombol) {
                return;
            }
            data = data.filter((item) => item.id !== tombol.dataset.hapus);
            simpan();
            render();
        });

        el.filter.addEventListener('change', render);
        el.btnContoh.addEventListener('click', () => {
            data = dataContoh();
            simpan();
            render();
        });

        render();
        setInterval(tick, SATU_DETIK);
    })();
</script>
@endpush
