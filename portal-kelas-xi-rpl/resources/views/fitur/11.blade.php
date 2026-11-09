@extends('layouts.app')

@section('title', $judul)

@section('content')
    <section class="tugas-page" aria-labelledby="judul-fitur">
        <header class="tugas-hero">
            <div>
                <span class="tugas-badge">Absen {{ $nomor }}</span>
                <h1 id="judul-fitur">{{ $judul }}</h1>
                <p>Catat tugas kelas, cari dengan cepat, dan pantau status pengerjaannya.</p>
            </div>
            <div class="hero-icon" aria-hidden="true">✓</div>
        </header>

        <section class="tugas-panel form-panel" aria-labelledby="judul-form">
            <div class="panel-heading">
                <div>
                    <p class="eyebrow" id="mode-form">TUGAS BARU</p>
                    <h2 id="judul-form">Tambah tugas</h2>
                </div>
                <span class="panel-step">01</span>
            </div>

            <form id="tugas-form">
                <input type="hidden" id="tugas-id">
                <div class="form-grid">
                    <div class="form-field field-wide">
                        <label for="judul-tugas">Nama tugas</label>
                        <input id="judul-tugas" name="judul" type="text" maxlength="100" placeholder="Contoh: Membuat halaman profil" required>
                    </div>
                    <div class="form-field">
                        <label for="mata-pelajaran">Mata pelajaran</label>
                        <input id="mata-pelajaran" name="mata_pelajaran" type="text" maxlength="60" placeholder="Contoh: Pemrograman Web" required>
                    </div>
                    <div class="form-field">
                        <label for="tenggat">Tenggat</label>
                        <input id="tenggat" name="tenggat" type="date" required>
                    </div>
                    <div class="form-field">
                        <label for="status-tugas">Status</label>
                        <select id="status-tugas" name="status" required>
                            <option value="belum">Belum dikerjakan</option>
                            <option value="proses">Sedang dikerjakan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="button button-primary" id="tombol-simpan" type="submit">Tambah tugas</button>
                    <button class="button button-quiet" id="tombol-batal" type="button" hidden>Batal edit</button>
                </div>
            </form>
        </section>

        <section class="tugas-panel list-panel" aria-labelledby="judul-daftar">
            <div class="list-heading">
                <div>
                    <p class="eyebrow">RUANG KERJA KELAS</p>
                    <h2 id="judul-daftar">Daftar tugas</h2>
                </div>
                <span class="total-pill"><span id="jumlah-tugas">0</span> tugas</span>
            </div>

            <label class="search-box" for="cari-tugas">
                <span aria-hidden="true" class="search-icon">⌕</span>
                <input id="cari-tugas" type="search" placeholder="Cari nama tugas atau mata pelajaran..." autocomplete="off">
                <kbd>/</kbd>
            </label>

            <div class="list-toolbar">
                <div class="tugas-filters" role="group" aria-label="Filter status tugas">
                    <button class="tugas-filter is-active" type="button" data-filter="semua" aria-pressed="true">Semua</button>
                    <button class="tugas-filter" type="button" data-filter="belum" aria-pressed="false">Belum</button>
                    <button class="tugas-filter" type="button" data-filter="proses" aria-pressed="false">Dikerjakan</button>
                    <button class="tugas-filter" type="button" data-filter="selesai" aria-pressed="false">Selesai</button>
                </div>
                <span class="result-label" id="label-hasil" aria-live="polite">Belum ada tugas</span>
            </div>

            <div class="tugas-list" id="daftar-tugas"></div>
            <div class="empty-state" id="pesan-kosong" aria-live="polite">
                <h3>Belum ada tugas</h3>
                <p>Tambahkan tugas pertama menggunakan formulir di atas. Tugas yang kamu buat bisa dicari dan diubah kapan saja.</p>
            </div>
        </section>

        <p class="storage-note">Data disimpan di browser/perangkat ini. Data belum tersinkron otomatis dengan teman atau perangkat lain.</p>
    </section>
@endsection

@push('styles')
    <style>
        .tugas-page {
            --tugas-ink: #172b4d;
            --tugas-muted: #718096;
            --tugas-line: #e7ecf3;
            --tugas-blue: #3659d9;
            max-width: 980px;
            margin: 0 auto;
            padding: 30px 22px 42px;
            color: var(--tugas-ink);
        }

        .tugas-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
            padding: 8px 2px 14px;
        }

        .tugas-hero h1 {
            margin: 12px 0 7px;
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            letter-spacing: -0.04em;
        }

        .tugas-hero p {
            margin: 0;
            color: var(--tugas-muted);
        }

        .tugas-badge {
            display: inline-flex;
            align-items: center;
            border: 1px solid #dfe7ff;
            border-radius: 999px;
            padding: 6px 11px;
            background: #f1f4ff;
            color: #3659d9;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .hero-icon {
            display: grid;
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            place-items: center;
            border-radius: 18px;
            background: linear-gradient(145deg, #526ff0, #7964e8);
            box-shadow: 0 10px 22px rgb(73 91 207 / 22%);
            color: #fff;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .tugas-panel {
            border: 1px solid var(--tugas-line);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 28px rgb(30 52 90 / 5%);
        }

        .form-panel {
            margin-bottom: 22px;
            padding: 22px 24px 20px;
        }

        .panel-heading,
        .list-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .panel-heading {
            margin-bottom: 19px;
        }

        .eyebrow {
            margin: 0 0 5px;
            color: #8793a8;
            font-size: 0.69rem;
            font-weight: 800;
            letter-spacing: 0.12em;
        }

        .panel-heading h2,
        .list-heading h2 {
            margin: 0;
            font-size: 1.22rem;
            letter-spacing: -0.02em;
        }

        .panel-step {
            color: #d5dceb;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .field-wide {
            grid-column: 1 / -1;
        }

        .form-field label,
        .tugas-search-label {
            display: block;
            margin-bottom: 7px;
            color: #394960;
            font-size: 0.86rem;
            font-weight: 650;
        }

        .form-field input,
        .form-field select {
            box-sizing: border-box;
            width: 100%;
            min-height: 44px;
            border: 1px solid #dce3ed;
            border-radius: 9px;
            padding: 10px 12px;
            background: #fff;
            color: var(--tugas-ink);
            font: inherit;
            font-size: 0.92rem;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .form-field input:focus,
        .form-field select:focus,
        .search-box:focus-within {
            border-color: #7188ed;
            outline: 0;
            box-shadow: 0 0 0 3px rgb(76 105 224 / 13%);
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 17px;
        }

        .button {
            min-height: 41px;
            border: 0;
            border-radius: 9px;
            padding: 9px 15px;
            cursor: pointer;
            font: inherit;
            font-size: 0.9rem;
            font-weight: 700;
            transition: transform .15s ease, background .15s ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button-primary {
            background: var(--tugas-blue);
            color: #fff;
            box-shadow: 0 4px 10px rgb(54 89 217 / 18%);
        }

        .button-primary:hover {
            background: #294ac7;
        }

        .button-quiet {
            border: 1px solid var(--tugas-line);
            background: #fff;
            color: #56657c;
        }

        .list-panel {
            padding: 23px 24px 20px;
        }

        .list-heading {
            margin-bottom: 17px;
        }

        .total-pill {
            border-radius: 999px;
            padding: 7px 11px;
            background: #f2f5fa;
            color: #596981;
            font-size: 0.83rem;
            font-weight: 700;
        }

        .total-pill span {
            color: var(--tugas-ink);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            border: 1px solid #dce3ed;
            border-radius: 10px;
            padding: 0 12px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .search-icon {
            color: #8996aa;
            font-size: 1.6rem;
            line-height: 1;
        }

        .search-box input {
            width: 100%;
            border: 0;
            outline: 0;
            color: var(--tugas-ink);
            font: inherit;
            font-size: 0.91rem;
        }

        .search-box input::placeholder {
            color: #a0aabc;
        }

        .search-box kbd {
            border: 1px solid #e2e7ef;
            border-radius: 5px;
            padding: 2px 6px;
            color: #99a4b5;
            font-size: 0.75rem;
        }

        .list-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 16px 0;
        }

        .tugas-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .tugas-filter {
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 7px 10px;
            background: transparent;
            color: #738097;
            cursor: pointer;
            font: inherit;
            font-size: 0.83rem;
            font-weight: 650;
        }

        .tugas-filter:hover {
            background: #f5f7fb;
        }

        .tugas-filter.is-active {
            border-color: #e2e8ff;
            background: #f0f3ff;
            color: #3659d9;
        }

        .result-label {
            color: #8995a8;
            font-size: 0.82rem;
        }

        .tugas-list {
            display: grid;
            gap: 10px;
        }

        .tugas-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border: 1px solid #edf0f5;
            border-radius: 12px;
            padding: 15px 16px;
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .tugas-card:hover {
            border-color: #dce4f2;
            box-shadow: 0 5px 16px rgb(30 52 90 / 5%);
        }

        .tugas-main {
            min-width: 0;
        }

        .tugas-mapel {
            margin: 0 0 5px;
            color: #7d8aa0;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .tugas-card h3 {
            overflow-wrap: anywhere;
            margin: 0 0 6px;
            color: #263853;
            font-size: 1rem;
        }

        .tugas-tenggat {
            margin: 0;
            color: #8793a6;
            font-size: 0.82rem;
        }

        .tugas-right {
            display: flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 10px;
        }

        .tugas-status {
            border-radius: 999px;
            padding: 6px 9px;
            font-size: 0.75rem;
            font-weight: 750;
            white-space: nowrap;
        }

        .status-belum {
            background: #fff4e5;
            color: #a26208;
        }

        .status-proses {
            background: #edf1ff;
            color: #4058bd;
        }

        .status-selesai {
            background: #e8f7ef;
            color: #278050;
        }

        .task-actions {
            display: flex;
            gap: 6px;
        }

        .task-action {
            min-width: 34px;
            min-height: 34px;
            border: 1px solid #e7ebf2;
            border-radius: 8px;
            background: #fff;
            color: #65748b;
            cursor: pointer;
            font: inherit;
            font-size: 0.8rem;
            font-weight: 650;
        }

        .task-action:hover {
            border-color: #cdd7e8;
            background: #f7f9fc;
        }

        .task-action.delete:hover {
            border-color: #ffd5d2;
            background: #fff5f4;
            color: #c33f36;
        }

        .empty-state {
            padding: 34px 18px 26px;
            text-align: center;
        }

        .empty-icon {
            display: grid;
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            place-items: center;
            border-radius: 15px;
            background: #f1f4ff;
            color: #526fe0;
            font-size: 1.7rem;
        }

        .empty-state h3 {
            margin: 0 0 7px;
            color: #354760;
            font-size: 1rem;
        }

        .empty-state p {
            max-width: 440px;
            margin: 0 auto;
            color: #8793a6;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        .storage-note {
            margin: 13px 3px 0;
            color: #99a3b2;
            font-size: 0.78rem;
            text-align: right;
        }

        @media (max-width: 680px) {
            .tugas-page {
                padding: 20px 14px 32px;
            }

            .form-panel,
            .list-panel {
                padding: 18px 16px;
            }

            .tugas-hero {
                align-items: flex-start;
            }

            .hero-icon {
                width: 46px;
                height: 46px;
                flex-basis: 46px;
                border-radius: 14px;
                font-size: 1.45rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .field-wide {
                grid-column: auto;
            }

            .tugas-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .tugas-right {
                width: 100%;
                justify-content: space-between;
            }

            .storage-note {
                text-align: left;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (() => {
            const storageKey = 'portal-rpl-absen11-tugas-v1';
            const statusLabel = {
                belum: 'Belum dikerjakan',
                proses: 'Sedang dikerjakan',
                selesai: 'Selesai'
            };

            const initTugas = () => {
                const form = document.getElementById('tugas-form');
                const inputId = document.getElementById('tugas-id');
                const inputJudul = document.getElementById('judul-tugas');
                const inputMapel = document.getElementById('mata-pelajaran');
                const inputTenggat = document.getElementById('tenggat');
                const inputStatus = document.getElementById('status-tugas');
                const inputCari = document.getElementById('cari-tugas');
                const list = document.getElementById('daftar-tugas');
                const empty = document.getElementById('pesan-kosong');
                const count = document.getElementById('jumlah-tugas');
                const resultLabel = document.getElementById('label-hasil');
                const submitButton = document.getElementById('tombol-simpan');
                const cancelButton = document.getElementById('tombol-batal');
                const formTitle = document.getElementById('judul-form');
                const formMode = document.getElementById('mode-form');
                const filterButtons = document.querySelectorAll('.tugas-filter');

                if (!form || !list) return;

                let tugas = [];
                let filterAktif = 'semua';

                try {
                    const tersimpan = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    if (Array.isArray(tersimpan)) tugas = tersimpan;
                } catch (error) {
                    tugas = [];
                }

                const simpan = () => {
                    try {
                        localStorage.setItem(storageKey, JSON.stringify(tugas));
                    } catch (error) {
                        alert('Data tidak bisa disimpan di browser ini. Periksa pengaturan penyimpanan browser.');
                    }
                };

                const formatTanggal = (nilai) => {
                    if (!nilai) return 'Belum ditentukan';
                    const tanggal = new Date(`${nilai}T00:00:00`);
                    return new Intl.DateTimeFormat('id-ID', {
                        day: 'numeric', month: 'short', year: 'numeric'
                    }).format(tanggal);
                };

                const buatTombolAksi = (teks, label, kelas, aksi) => {
                    const tombol = document.createElement('button');
                    tombol.type = 'button';
                    tombol.className = `task-action ${kelas}`.trim();
                    tombol.textContent = teks;
                    tombol.setAttribute('aria-label', label);
                    tombol.addEventListener('click', aksi);
                    return tombol;
                };

                const render = () => {
                    const kataKunci = inputCari.value.trim().toLocaleLowerCase('id');
                    const terlihat = tugas.filter((item) => {
                        const teks = `${item.judul} ${item.mata_pelajaran} ${item.tenggat}`.toLocaleLowerCase('id');
                        const cocokKata = teks.includes(kataKunci);
                        const cocokStatus = filterAktif === 'semua' || item.status === filterAktif;
                        return cocokKata && cocokStatus;
                    });

                    list.replaceChildren();
                    count.textContent = tugas.length;
                    resultLabel.textContent = tugas.length === 0
                        ? 'Belum ada tugas'
                        : `Menampilkan ${terlihat.length} dari ${tugas.length} tugas`;
                    empty.hidden = terlihat.length > 0;

                    if (terlihat.length === 0) {
                        const kosong = tugas.length === 0;
                        empty.querySelector('h3').textContent = kosong ? 'Belum ada tugas' : 'Tugas tidak ditemukan';
                        empty.querySelector('p').textContent = kosong
                            ? 'Tambahkan tugas pertama menggunakan formulir di atas. Tugas yang kamu buat bisa dicari dan diubah kapan saja.'
                            : 'Coba kata kunci lain atau pilih filter status yang berbeda.';
                    }

                    terlihat.forEach((item) => {
                        const card = document.createElement('article');
                        card.className = 'tugas-card';

                        const main = document.createElement('div');
                        main.className = 'tugas-main';
                        const mapel = document.createElement('p');
                        mapel.className = 'tugas-mapel';
                        mapel.textContent = item.mata_pelajaran;
                        const title = document.createElement('h3');
                        title.textContent = item.judul;
                        const tenggat = document.createElement('p');
                        tenggat.className = 'tugas-tenggat';
                        tenggat.textContent = `Tenggat: ${formatTanggal(item.tenggat)}`;
                        main.append(mapel, title, tenggat);

                        const right = document.createElement('div');
                        right.className = 'tugas-right';
                        const badge = document.createElement('span');
                        badge.className = `tugas-status status-${item.status}`;
                        badge.textContent = statusLabel[item.status] || statusLabel.belum;
                        const actions = document.createElement('div');
                        actions.className = 'task-actions';
                        actions.append(
                            buatTombolAksi('Edit', `Edit ${item.judul}`, '', () => mulaiEdit(item.id)),
                            buatTombolAksi('Hapus', `Hapus ${item.judul}`, 'delete', () => hapusTugas(item.id))
                        );
                        right.append(badge, actions);
                        card.append(main, right);
                        list.append(card);
                    });
                };

                const resetForm = () => {
                    form.reset();
                    inputId.value = '';
                    formTitle.textContent = 'Tambah tugas';
                    formMode.textContent = 'TUGAS BARU';
                    submitButton.textContent = 'Tambah tugas';
                    cancelButton.hidden = true;
                };

                const mulaiEdit = (id) => {
                    const item = tugas.find((t) => t.id === id);
                    if (!item) return;
                    inputId.value = item.id;
                    inputJudul.value = item.judul;
                    inputMapel.value = item.mata_pelajaran;
                    inputTenggat.value = item.tenggat;
                    inputStatus.value = item.status;
                    formTitle.textContent = 'Edit tugas';
                    formMode.textContent = 'PERBARUI TUGAS';
                    submitButton.textContent = 'Simpan perubahan';
                    cancelButton.hidden = false;
                    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    inputJudul.focus({ preventScroll: true });
                };

                const hapusTugas = (id) => {
                    const item = tugas.find((t) => t.id === id);
                    if (!item || !confirm(`Yakin ingin menghapus tugas "${item.judul}"?`)) return;
                    tugas = tugas.filter((t) => t.id !== id);
                    simpan();
                    render();
                    if (inputId.value === id) resetForm();
                };

                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    const data = {
                        judul: inputJudul.value.trim(),
                        mata_pelajaran: inputMapel.value.trim(),
                        tenggat: inputTenggat.value,
                        status: inputStatus.value
                    };
                    if (!data.judul || !data.mata_pelajaran || !data.tenggat) return;

                    const idEdit = inputId.value;
                    if (idEdit) {
                        tugas = tugas.map((item) => item.id === idEdit ? { ...item, ...data } : item);
                    } else {
                        tugas.unshift({ id: `${Date.now()}-${Math.random().toString(16).slice(2)}`, ...data });
                    }

                    simpan();
                    resetForm();
                    render();
                });

                cancelButton.addEventListener('click', resetForm);
                inputCari.addEventListener('input', render);

                filterButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        filterAktif = button.dataset.filter;
                        filterButtons.forEach((item) => {
                            const aktif = item === button;
                            item.classList.toggle('is-active', aktif);
                            item.setAttribute('aria-pressed', aktif ? 'true' : 'false');
                        });
                        render();
                    });
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                        event.preventDefault();
                        inputCari.focus();
                    }
                });

                render();
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTugas);
            } else {
                initTugas();
            }
        })();
    </script>
@endpush
