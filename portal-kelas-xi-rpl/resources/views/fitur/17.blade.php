@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    .calc-container {
        margin-top: 20px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(21, 52, 81, 0.05);
        overflow: hidden;
    }

    .calc-header-box {
        background: linear-gradient(135deg, var(--navy) 0%, #1e4569 100%);
        color: #ffffff;
        padding: 24px 28px;
        border-bottom: 4px solid var(--orange);
    }

    .calc-header-box .badge-absen {
        display: inline-block;
        background: rgba(244, 162, 97, 0.25);
        color: #ffe6d3;
        border: 1px solid rgba(244, 162, 97, 0.5);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .calc-header-box h1 {
        margin: 0 0 6px 0;
        font-size: clamp(1.4rem, 3vw, 1.85rem);
        color: #ffffff;
    }

    .calc-header-box p {
        margin: 0;
        color: #d8f3e7;
        font-size: 0.92rem;
        max-width: 680px;
    }

    .calc-body {
        padding: 24px 28px;
    }

    /* Panel Pengaturan & Toolbar */
    .control-panel {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .control-group label {
        font-size: 0.88rem;
        font-weight: 650;
        color: var(--ink);
    }

    .control-input {
        padding: 7px 12px;
        border: 1px solid #c8d5de;
        border-radius: 6px;
        font-size: 0.88rem;
        color: var(--ink);
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .control-input:focus {
        outline: none;
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.25);
    }

    .control-input-num {
        width: 80px;
        text-align: center;
        font-weight: 700;
    }

    .toggle-wrap {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        cursor: pointer;
        user-select: none;
        color: var(--ink);
    }

    .toggle-wrap input[type="checkbox"] {
        accent-color: var(--navy);
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* Tabel Nilai */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .table-nilai {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        text-align: left;
    }

    .table-nilai thead {
        background: #f1f5f8;
        border-bottom: 2px solid var(--line);
    }

    .table-nilai th {
        padding: 12px 14px;
        font-weight: 700;
        color: var(--ink);
        white-space: nowrap;
    }

    .table-nilai td {
        padding: 10px 14px;
        border-bottom: 1px solid #eef2f5;
        vertical-align: middle;
    }

    .table-nilai tbody tr:last-child td {
        border-bottom: none;
    }

    .table-nilai tbody tr:hover {
        background-color: #fafcfe;
    }

    .table-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #c8d5de;
        border-radius: 6px;
        font-size: 0.9rem;
        color: var(--ink);
        box-sizing: border-box;
    }

    .table-input:focus {
        outline: none;
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.2);
    }

    .table-input.num {
        text-align: right;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .badge-status {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
    }

    .badge-lulus {
        background: #e6f7ef;
        color: #11734b;
        border: 1px solid #b7e8d1;
    }

    .badge-remed {
        background: #fdeeee;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .badge-netral {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.88rem;
        font-weight: 650;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn:active {
        transform: translateY(1px);
    }

    .btn-primary {
        background: var(--navy);
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #0e2439;
    }

    .btn-secondary {
        background: #eef3f7;
        color: var(--ink);
        border-color: #cbd8e2;
    }

    .btn-secondary:hover {
        background: #dfe8ee;
    }

    .btn-accent {
        background: var(--orange);
        color: #4a2405;
        border-color: #e5934f;
    }

    .btn-accent:hover {
        background: #e89552;
    }

    .btn-danger-outline {
        background: transparent;
        color: #dc2626;
        border-color: #fca5a5;
        padding: 6px 10px;
        font-size: 0.8rem;
    }

    .btn-danger-outline:hover {
        background: #fef2f2;
        border-color: #ef4444;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.8rem;
    }

    .action-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 28px;
    }

    .action-left {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* Kartu Hasil Perhitungan */
    .result-section {
        border-top: 2px dashed var(--line);
        padding-top: 28px;
    }

    .result-section h2 {
        font-size: 1.25rem;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #f9fbfd;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 16px;
        text-align: center;
    }

    .stat-card.highlight {
        background: #fdf8f4;
        border-color: #fbd3b2;
    }

    .stat-card.success {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .stat-card.danger {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .stat-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--ink);
        line-height: 1.1;
    }

    .stat-desc {
        font-size: 0.78rem;
        margin-top: 6px;
        color: var(--muted);
    }

    /* Detail Summary & Ekspor */
    .summary-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 18px 22px;
        margin-bottom: 20px;
    }

    .summary-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.88rem;
    }

    .summary-list li {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .summary-list li strong {
        color: var(--ink);
    }

    .result-footer-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-end;
    }

    .toast-msg {
        display: none;
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: var(--navy);
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 0.88rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }

    /* Print styling */
    @media print {
        header.site-header, footer.site-footer, .action-toolbar, .control-panel, .btn, .dashboard-link {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .calc-container {
            border: none !important;
            box-shadow: none !important;
        }
        .calc-header-box {
            background: white !important;
            color: black !important;
            padding: 0 0 16px 0 !important;
            border-bottom: 2px solid black !important;
        }
        .calc-header-box h1 { color: black !important; }
        .calc-header-box p { color: #555 !important; }
        .badge-absen { border: 1px solid #333 !important; color: #000 !important; }
    }

    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .calc-header-box, .calc-body {
            padding: 18px 16px;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .action-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .action-left {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="calc-container">
    <!-- Header Fitur -->
    <header class="calc-header-box" aria-labelledby="judul-fitur">
        <span class="badge-absen">Absen {{ $nomor }} · XI RPL</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p>Hitung rata-rata nilai mata pelajaran secara otomatis dengan indikator KKM, predikat mutu (A–D), analisis nilai tertinggi/terendah, dan dukungan bobot pelajaran.</p>
    </header>

    <div class="calc-body">
        <!-- Pengaturan KKM & Bobot -->
        <section class="control-panel" aria-label="Pengaturan Kalkulator">
            <div class="control-group">
                <label for="input-kkm">Standar KKM:</label>
                <input type="number" id="input-kkm" class="control-input control-input-num" min="0" max="100" value="75" step="1">
                <span style="font-size: 0.8rem; color: var(--muted);">(Skala 0 - 100)</span>
            </div>

            <div class="control-group">
                <label class="toggle-wrap">
                    <input type="checkbox" id="toggle-bobot">
                    <span>Gunakan Pembobotan Nilai (SKS / Jam)</span>
                </label>
            </div>
        </section>

        <!-- Tabel Masukan Nilai -->
        <div class="table-responsive">
            <table class="table-nilai" id="tabel-nilai">
                <thead>
                    <tr>
                        <th style="width: 48px; text-align: center;">No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th style="width: 130px; text-align: right;">Nilai (0–100)</th>
                        <th style="width: 110px; text-align: right;" class="col-bobot" hidden>Bobot</th>
                        <th style="width: 120px; text-align: center;">Status KKM</th>
                        <th style="width: 70px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="baris-mapel-container">
                    <!-- Baris nilai dirender via JS -->
                </tbody>
            </table>
        </div>

        <!-- Tombol Aksi Tabel -->
        <div class="action-toolbar">
            <div class="action-left">
                <button type="button" class="btn btn-primary" id="btn-tambah-baris">
                    <span>+ Tambah Mata Pelajaran</span>
                </button>
                <button type="button" class="btn btn-secondary" id="btn-muat-preset">
                    <span>⚡ Muat Contoh Nilai RPL</span>
                </button>
                <button type="button" class="btn btn-secondary" id="btn-reset">
                    <span>🔄 Kosongkan</span>
                </button>
            </div>
            <div>
                <button type="button" class="btn btn-accent" id="btn-hitung">
                    <span>⚡ Hitung Sekarang</span>
                </button>
            </div>
        </div>

        <!-- Panel Hasil Perhitungan -->
        <section class="result-section" aria-labelledby="judul-hasil">
            <h2 id="judul-hasil">
                <span>Hasil Analisis &amp; Rata-rata</span>
            </h2>

            <div class="stats-grid">
                <div class="stat-card highlight">
                    <div class="stat-label">Nilai Rata-rata</div>
                    <div class="stat-value" id="res-rata-rata">0.00</div>
                    <div class="stat-desc" id="res-mode-ket">Rata-rata Sederhana</div>
                </div>

                <div class="stat-card" id="card-predikat">
                    <div class="stat-label">Predikat Mutu</div>
                    <div class="stat-value" id="res-predikat">-</div>
                    <div class="stat-desc" id="res-predikat-ket">Belum dihitung</div>
                </div>

                <div class="stat-card" id="card-status">
                    <div class="stat-label">Status Kelulusan</div>
                    <div class="stat-value" id="res-status" style="font-size: 1.35rem; margin-top: 5px;">-</div>
                    <div class="stat-desc" id="res-status-ket">Berdasarkan KKM: 75</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total Pelajaran</div>
                    <div class="stat-value" id="res-total-mapel">0</div>
                    <div class="stat-desc" id="res-rasio-kkm">0 Tuntas / 0 Remedial</div>
                </div>
            </div>

            <!-- Detail Tambahan -->
            <div class="summary-card">
                <ul class="summary-list">
                    <li>
                        <span>Total Nilai Akumulasi:</span>
                        <strong id="res-total-nilai">0</strong>
                    </li>
                    <li>
                        <span>Nilai Tertinggi:</span>
                        <strong id="res-tertinggi">-</strong>
                    </li>
                    <li>
                        <span>Nilai Terendah:</span>
                        <strong id="res-terendah">-</strong>
                    </li>
                    <li>
                        <span>Kategori Kelulusan:</span>
                        <strong id="res-kategori-ringkasan">-</strong>
                    </li>
                </ul>
            </div>

            <!-- Tombol Ekspor / Cetak -->
            <div class="result-footer-actions">
                <button type="button" class="btn btn-secondary" id="btn-salin-ringkasan">
                    <span>📋 Salin Ringkasan Teks</span>
                </button>
                <button type="button" class="btn btn-secondary" id="btn-cetak">
                    <span>🖨️ Cetak / Simpan PDF</span>
                </button>
            </div>
        </section>
    </div>
</div>

<div id="toast" class="toast-msg" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kkmInput = document.getElementById('input-kkm');
    const toggleBobot = document.getElementById('toggle-bobot');
    const container = document.getElementById('baris-mapel-container');
    const btnTambah = document.getElementById('btn-tambah-baris');
    const btnPreset = document.getElementById('btn-muat-preset');
    const btnReset = document.getElementById('btn-reset');
    const btnHitung = document.getElementById('btn-hitung');
    const btnSalin = document.getElementById('btn-salin-ringkasan');
    const btnCetak = document.getElementById('btn-cetak');
    const toast = document.getElementById('toast');

    // Preset data mapel XI RPL SMK Pesat
    const presetRPL = [
        { mapel: 'Pemrograman Web & Perangkat Bergerak', nilai: 88, bobot: 4 },
        { mapel: 'Pemrograman Berorientasi Objek (PBO)', nilai: 85, bobot: 4 },
        { mapel: 'Basis Data', nilai: 90, bobot: 3 },
        { mapel: 'Pemodelan Perangkat Lunak', nilai: 82, bobot: 2 },
        { mapel: 'Produk Kreatif & Kewirausahaan (PKK)', nilai: 80, bobot: 2 },
        { mapel: 'Matematika Terapan', nilai: 78, bobot: 2 },
        { mapel: 'Bahasa Inggris Kejuruan', nilai: 86, bobot: 2 },
        { mapel: 'Bahasa Indonesia', nilai: 84, bobot: 2 }
    ];

    let rowCounter = 0;

    function showToast(message) {
        toast.textContent = message;
        toast.style.display = 'block';
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => {
            toast.style.display = 'none';
        }, 2500);
    }

    function createRow(mapel = '', nilai = '', bobot = 1) {
        rowCounter++;
        const tr = document.createElement('tr');
        tr.className = 'baris-mapel';
        tr.dataset.id = rowCounter;

        const isBobotActive = toggleBobot.checked;

        tr.innerHTML = `
            <td style="text-align: center; font-weight: 600;" class="nomor-urut"></td>
            <td>
                <input type="text" class="table-input input-nama" placeholder="Contoh: Pemrograman Web" value="${escapeHtml(mapel)}">
            </td>
            <td>
                <input type="number" class="table-input num input-nilai" min="0" max="100" step="0.1" placeholder="0–100" value="${nilai !== '' ? nilai : ''}">
            </td>
            <td class="col-bobot" ${isBobotActive ? '' : 'hidden'}>
                <input type="number" class="table-input num input-bobot" min="1" max="20" step="1" value="${bobot || 1}">
            </td>
            <td style="text-align: center;">
                <span class="badge-status badge-netral" data-role="status-kkm">-</span>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn btn-danger-outline btn-sm btn-hapus" title="Hapus baris ini">✕</button>
            </td>
        `;

        // Event listener saat nilai berubah
        const inputNilai = tr.querySelector('.input-nilai');
        const inputNama = tr.querySelector('.input-nama');
        const inputBobot = tr.querySelector('.input-bobot');
        const btnHapus = tr.querySelector('.btn-hapus');

        inputNilai.addEventListener('input', function () {
            validateScoreInput(this);
            updateRowStatus(tr);
            calculate();
        });

        inputNama.addEventListener('input', calculate);
        inputBobot.addEventListener('input', calculate);

        btnHapus.addEventListener('click', function () {
            if (container.querySelectorAll('.baris-mapel').length <= 1) {
                // Jangan hapus jika tersisa satu, cukup kosongkan
                inputNama.value = '';
                inputNilai.value = '';
                inputBobot.value = 1;
                updateRowStatus(tr);
                calculate();
                showToast('Baris terakhir dikosongkan.');
                return;
            }
            tr.remove();
            renumberRows();
            calculate();
        });

        container.appendChild(tr);
        renumberRows();
        updateRowStatus(tr);
        return tr;
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function renumberRows() {
        const rows = container.querySelectorAll('.baris-mapel');
        rows.forEach((row, index) => {
            const noCell = row.querySelector('.nomor-urut');
            if (noCell) noCell.textContent = index + 1;
        });
    }

    function validateScoreInput(input) {
        let val = parseFloat(input.value);
        if (isNaN(val)) return;
        if (val < 0) input.value = 0;
        if (val > 100) input.value = 100;
    }

    function updateRowStatus(row) {
        const nilaiInput = row.querySelector('.input-nilai');
        const badge = row.querySelector('[data-role="status-kkm"]');
        if (!badge || !nilaiInput) return;

        const kkmVal = parseFloat(kkmInput.value) || 75;

        const val = parseFloat(nilaiInput.value);
        if (isNaN(val) || nilaiInput.value.trim() === '') {
            badge.className = 'badge-status badge-netral';
            badge.textContent = '-';
            return;
        }

        if (val >= kkmVal) {
            badge.className = 'badge-status badge-lulus';
            badge.textContent = '✓ Tuntas';
        } else {
            badge.className = 'badge-status badge-remed';
            badge.textContent = '✗ Remedial';
        }
    }

    function toggleBobotVisibility() {
        const active = toggleBobot.checked;
        const colHeaders = document.querySelectorAll('.col-bobot');
        colHeaders.forEach(el => {
            if (active) {
                el.removeAttribute('hidden');
            } else {
                el.setAttribute('hidden', 'hidden');
            }
        });
        calculate();
    }

    function calculate() {
        const kkmVal = parseFloat(kkmInput.value) || 75;
        const isBobotActive = toggleBobot.checked;
        const rows = container.querySelectorAll('.baris-mapel');

        let totalBobot = 0;
        let totalNilai = 0;
        let weightedSum = 0;
        let validEntries = [];
        let tuntasCount = 0;
        let remedCount = 0;

        rows.forEach((row, idx) => {
            updateRowStatus(row);

            const nama = row.querySelector('.input-nama').value.trim() || `Mata Pelajaran ${idx + 1}`;
            const nilaiRaw = row.querySelector('.input-nilai').value;
            const bobotRaw = row.querySelector('.input-bobot').value;

            if (nilaiRaw !== '' && !isNaN(parseFloat(nilaiRaw))) {
                const nilai = parseFloat(nilaiRaw);
                const bobot = isBobotActive ? (parseFloat(bobotRaw) || 1) : 1;

                totalNilai += nilai;
                totalBobot += bobot;
                weightedSum += (nilai * bobot);

                validEntries.push({ nama, nilai, bobot });

                if (nilai >= kkmVal) {
                    tuntasCount++;
                } else {
                    remedCount++;
                }
            }
        });

        const totalMapel = validEntries.length;

        // Elemen output
        const elRata = document.getElementById('res-rata-rata');
        const elMode = document.getElementById('res-mode-ket');
        const elPredikat = document.getElementById('res-predikat');
        const elPredikatKet = document.getElementById('res-predikat-ket');
        const elStatus = document.getElementById('res-status');
        const elStatusKet = document.getElementById('res-status-ket');
        const elCardStatus = document.getElementById('card-status');
        const elCardPredikat = document.getElementById('card-predikat');
        const elTotalMapel = document.getElementById('res-total-mapel');
        const elRasioKkm = document.getElementById('res-rasio-kkm');
        const elTotalNilai = document.getElementById('res-total-nilai');
        const elTertinggi = document.getElementById('res-tertinggi');
        const elTerendah = document.getElementById('res-terendah');
        const elKategoriRingkasan = document.getElementById('res-kategori-ringkasan');

        if (totalMapel === 0) {
            elRata.textContent = '0.00';
            elMode.textContent = isBobotActive ? 'Rata-rata Berbobot' : 'Rata-rata Sederhana';
            elPredikat.textContent = '-';
            elPredikatKet.textContent = 'Belum ada nilai diinput';
            elStatus.textContent = '-';
            elStatusKet.textContent = `Berdasarkan KKM: ${kkmVal}`;
            elCardStatus.className = 'stat-card';
            elCardPredikat.className = 'stat-card';
            elTotalMapel.textContent = '0';
            elRasioKkm.textContent = '0 Tuntas / 0 Remedial';
            elTotalNilai.textContent = '0';
            elTertinggi.textContent = '-';
            elTerendah.textContent = '-';
            elKategoriRingkasan.textContent = 'Belum ada data';
            return;
        }

        const rataRata = isBobotActive ? (weightedSum / totalBobot) : (totalNilai / totalMapel);

        elRata.textContent = rataRata.toFixed(2);
        elMode.textContent = isBobotActive
            ? `Rata-rata Berbobot (Total ${totalBobot} Bobot)`
            : `Rata-rata Sederhana (${totalMapel} Mapel)`;

        // Predikat Mutu
        let predikat = 'D';
        let predikatKet = 'Kurang / Perlu Remedial';
        if (rataRata >= 90) {
            predikat = 'A';
            predikatKet = 'Sangat Memuaskan';
        } else if (rataRata >= 80) {
            predikat = 'B';
            predikatKet = 'Baik';
        } else if (rataRata >= kkmVal) {
            predikat = 'C';
            predikatKet = 'Cukup (Tuntas KKM)';
        }

        elPredikat.textContent = predikat;
        elPredikatKet.textContent = predikatKet;

        // Status Kelulusan (Tuntas jika rata-rata >= KKM dan tidak ada yang di bawah KKM atau ditentukan rata-rata)
        const isLulus = rataRata >= kkmVal;
        if (isLulus && remedCount === 0) {
            elStatus.textContent = 'TUNTAS SEMPURNA';
            elStatusKet.textContent = `Semua mapel memenuhi KKM (${kkmVal})`;
            elCardStatus.className = 'stat-card success';
        } else if (isLulus && remedCount > 0) {
            elStatus.textContent = 'TUNTAS BERSYARAT';
            elStatusKet.textContent = `Rata-rata lulus, ${remedCount} mapel perlu remedial`;
            elCardStatus.className = 'stat-card highlight';
        } else {
            elStatus.textContent = 'BELUM TUNTAS';
            elStatusKet.textContent = `Rata-rata di bawah KKM (${kkmVal})`;
            elCardStatus.className = 'stat-card danger';
        }

        // Statistik detail
        elTotalMapel.textContent = totalMapel;
        elRasioKkm.textContent = `${tuntasCount} Tuntas / ${remedCount} Remedial`;
        elTotalNilai.textContent = isBobotActive ? `${weightedSum.toFixed(1)} (Bobot: ${totalBobot})` : totalNilai.toFixed(1);

        // Cari Tertinggi & Terendah
        let highest = validEntries[0];
        let lowest = validEntries[0];

        validEntries.forEach(item => {
            if (item.nilai > highest.nilai) highest = item;
            if (item.nilai < lowest.nilai) lowest = item;
        });

        elTertinggi.textContent = `${highest.nilai} (${highest.nama})`;
        elTerendah.textContent = `${lowest.nilai} (${lowest.nama})`;

        if (remedCount === 0) {
            elKategoriRingkasan.textContent = 'Seluruh mata pelajaran telah tuntas KKM.';
        } else {
            elKategoriRingkasan.textContent = `Terdapat ${remedCount} mata pelajaran belum tuntas KKM.`;
        }
    }

    // Event Handlers
    btnTambah.addEventListener('click', () => {
        const row = createRow();
        row.querySelector('.input-nama').focus();
    });

    btnPreset.addEventListener('click', () => {
        container.innerHTML = '';
        presetRPL.forEach(item => {
            createRow(item.mapel, item.nilai, item.bobot);
        });
        calculate();
        showToast('8 Mata pelajaran XI RPL dimuat!');
    });

    btnReset.addEventListener('click', () => {
        if (confirm('Kosongkan semua baris nilai?')) {
            container.innerHTML = '';
            createRow();
            calculate();
            showToast('Form berhasil dikosongkan.');
        }
    });

    btnHitung.addEventListener('click', () => {
        calculate();
        showToast('✓ Hasil kalkulasi berhasil diperbarui!');
        const target = document.querySelector('.result-section');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    kkmInput.addEventListener('input', () => {
        validateScoreInput(kkmInput);
        calculate();
    });

    toggleBobot.addEventListener('change', toggleBobotVisibility);

    btnSalin.addEventListener('click', () => {
        const rataRata = document.getElementById('res-rata-rata').textContent;
        const predikat = document.getElementById('res-predikat').textContent;
        const status = document.getElementById('res-status').textContent;
        const kkmVal = kkmInput.value;
        const total = document.getElementById('res-total-mapel').textContent;
        const tertinggi = document.getElementById('res-tertinggi').textContent;
        const terendah = document.getElementById('res-terendah').textContent;
        const rasio = document.getElementById('res-rasio-kkm').textContent;

        const summaryText = `[RINGKASAN NILAI SISWA - XI RPL]\n` +
            `• Rata-rata Nilai: ${rataRata}\n` +
            `• Predikat Mutu : ${predikat}\n` +
            `• Status KKM    : ${status} (KKM: ${kkmVal})\n` +
            `• Total Mapel   : ${total} (${rasio})\n` +
            `• Nilai Tertinggi: ${tertinggi}\n` +
            `• Nilai Terendah : ${terendah}\n` +
            `-- Portal Kelas XI RPL SMK PESAT --`;

        navigator.clipboard.writeText(summaryText).then(() => {
            showToast('Ringkasan nilai berhasil disalin ke clipboard!');
        }).catch(() => {
            showToast('Gagal menyalin ringkasan.');
        });
    });

    btnCetak.addEventListener('click', () => {
        window.print();
    });

    // Inisialisasi awal: Muat 4 baris kosong atau contoh
    createRow('Pemrograman Web & Perangkat Bergerak', 85, 4);
    createRow('Pemrograman Berorientasi Objek (PBO)', 88, 4);
    createRow('Basis Data', 90, 3);
    createRow('Matematika', 74, 2);
    calculate();
});
</script>
@endpush
