@extends('layouts.app')

@section('title', 'Jadwal Pelajaran Mingguan')

@push('styles')
<style>
    .jadwal {
        --jadwal-surface: #ffffff;
        --jadwal-soft: #eef5f8;
        --jadwal-ok: #1f6b4a;
        --jadwal-danger: #9b2c2c;
        --jadwal-danger-soft: #fdecec;
    }

    .jadwal-hero {
        display: grid;
        gap: 12px;
        margin-bottom: 28px;
    }

    .jadwal-hero h1 {
        margin: 0;
        font-size: clamp(1.7rem, 3.4vw, 2.35rem);
        letter-spacing: -.03em;
        line-height: 1.15;
    }

    .jadwal-hero p {
        margin: 0;
        max-width: 58ch;
        color: var(--muted);
    }

    .jadwal-fact {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        padding: 8px 12px;
        border-radius: 8px;
        background: var(--navy);
        color: #fff;
        font-size: .85rem;
        font-weight: 650;
    }

    .jadwal-alert {
        margin-bottom: 18px;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid #bddfce;
        background: var(--mint);
        color: var(--jadwal-ok);
        font-size: .92rem;
    }

    .jadwal-alert.is-error {
        border-color: #f0c2c2;
        background: var(--jadwal-danger-soft);
        color: var(--jadwal-danger);
    }

    .jadwal-alert ul {
        margin: 8px 0 0;
        padding-left: 18px;
    }

    .hari-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 22px;
    }

    .hari-nav a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 8px 14px;
        border: 1px solid var(--line);
        border-radius: 10px;
        background: var(--jadwal-surface);
        text-decoration: none;
        font-size: .92rem;
        font-weight: 650;
        transition: border-color .15s ease, background-color .15s ease, transform .15s ease;
    }

    .hari-nav a:hover {
        border-color: #ad632b;
        transform: translateY(-1px);
    }

    .hari-nav a[aria-current="page"] {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .jadwal-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(280px, .9fr);
        gap: 20px;
        align-items: start;
    }

    .jadwal-panel {
        background: var(--jadwal-surface);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 22px;
    }

    .panel-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .panel-head h2 {
        margin: 0;
        font-size: 1.2rem;
    }

    .panel-head p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: .9rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid transparent;
        font: inherit;
        font-size: .9rem;
        font-weight: 650;
        cursor: pointer;
        text-decoration: none;
        transition: background-color .15s ease, border-color .15s ease, transform .15s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-primary {
        background: var(--navy);
        color: #fff;
    }

    .btn-primary:hover {
        background: #10283d;
    }

    .btn-secondary {
        background: #fff0e2;
        color: #7b4118;
        border-color: #f0d2b4;
    }

    .btn-ghost {
        background: transparent;
        color: var(--ink);
        border-color: var(--line);
    }

    .btn-danger {
        background: var(--jadwal-danger-soft);
        color: var(--jadwal-danger);
        border-color: #f0c2c2;
    }

    .btn-sm {
        min-height: 40px;
        padding: 6px 12px;
        font-size: .84rem;
    }

    .empty-state {
        padding: 28px 18px;
        border: 1px dashed var(--line);
        border-radius: 12px;
        background: var(--jadwal-soft);
        text-align: center;
    }

    .empty-state strong {
        display: block;
        margin-bottom: 6px;
        font-size: 1rem;
    }

    .empty-state p {
        margin: 0;
        color: var(--muted);
        font-size: .92rem;
    }

    .lesson-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        gap: 12px;
    }

    .lesson-item {
        display: grid;
        grid-template-columns: 118px minmax(0, 1fr) auto;
        gap: 14px;
        align-items: start;
        padding: 14px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: #fbfdfe;
    }

    .lesson-time {
        font-variant-numeric: tabular-nums;
        font-weight: 700;
        font-size: .92rem;
        color: var(--navy);
    }

    .lesson-body h3 {
        margin: 0 0 6px;
        font-size: 1.02rem;
        line-height: 1.35;
    }

    .lesson-meta {
        margin: 0;
        color: var(--muted);
        font-size: .86rem;
    }

    .lesson-desc {
        margin: 8px 0 0;
        color: var(--ink);
        font-size: .88rem;
    }

    .lesson-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
    }

    .jadwal-form {
        display: grid;
        gap: 14px;
    }

    .jadwal-form h2 {
        margin: 0;
        font-size: 1.15rem;
    }

    .jadwal-form .hint {
        margin: -4px 0 0;
        color: var(--muted);
        font-size: .88rem;
    }

    .field {
        display: grid;
        gap: 6px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .field label {
        font-size: .88rem;
        font-weight: 650;
    }

    .field .optional {
        font-weight: 500;
        color: var(--muted);
    }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid var(--line);
        border-radius: 10px;
        background: #fff;
        color: var(--ink);
        font: inherit;
    }

    .field textarea {
        min-height: 96px;
        resize: vertical;
    }

    .field input:focus-visible,
    .field select:focus-visible,
    .field textarea:focus-visible {
        outline: 3px solid #bd5a12;
        outline-offset: 2px;
        border-color: #bd5a12;
    }

    .field .error {
        color: var(--jadwal-danger);
        font-size: .82rem;
    }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 4px;
    }

    @media (max-width: 900px) {
        .jadwal-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .lesson-item {
            grid-template-columns: 1fr;
        }

        .lesson-actions {
            justify-content: flex-start;
        }

        .field-row {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .hari-nav a,
        .btn {
            transition: none;
        }

        .hari-nav a:hover,
        .btn:hover,
        .btn:active {
            transform: none;
        }
    }
</style>
@endpush

@section('content')
<section class="jadwal" aria-labelledby="judul-jadwal">
    <header class="jadwal-hero">
        <h1 id="judul-jadwal">Jadwal Pelajaran Mingguan</h1>
        <p>Kelola jadwal XI RPL dari Senin sampai Minggu: tambah, ubah, atau hapus pelajaran per hari.</p>
        <span class="jadwal-fact">7 hari · diurutkan dari jam mulai</span>
    </header>

    @if (session('status'))
        <div class="jadwal-alert" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="jadwal-alert is-error" role="alert">
            Periksa kembali isian formulir.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <nav class="hari-nav" aria-label="Pilih hari">
        @foreach ($hariList as $hari)
            <a
                href="{{ route('jadwal.index', ['hari' => $hari->value]) }}"
                @if ($hari === $hariAktif) aria-current="page" @endif
            >{{ $hari->value }}</a>
        @endforeach
    </nav>

    <div class="jadwal-layout">
        <section class="jadwal-panel" aria-labelledby="judul-daftar-hari">
            <div class="panel-head">
                <div>
                    <h2 id="judul-daftar-hari">{{ $hariAktif->value }}</h2>
                    <p>{{ $pelajaran->count() }} pelajaran pada hari ini</p>
                </div>
                <a class="btn btn-secondary" href="{{ route('jadwal.index', ['hari' => $hariAktif->value]) }}#form-pelajaran">Tambah Pelajaran</a>
            </div>

            @if ($pelajaran->isEmpty())
                <div class="empty-state">
                    <strong>Belum ada jadwal pelajaran</strong>
                    <p>Tambahkan pelajaran pertama untuk hari {{ $hariAktif->value }}.</p>
                </div>
            @else
                <ul class="lesson-list">
                    @foreach ($pelajaran as $item)
                        <li class="lesson-item">
                            <div class="lesson-time">
                                {{ $item->start_time->format('H:i') }} – {{ $item->end_time->format('H:i') }}
                            </div>
                            <div class="lesson-body">
                                <h3>{{ $item->subject_name }}</h3>
                                <p class="lesson-meta">
                                    @if ($item->teacher)
                                        {{ $item->teacher }}
                                    @else
                                        Guru belum diisi
                                    @endif
                                    ·
                                    @if ($item->room)
                                        {{ $item->room }}
                                    @else
                                        Ruangan belum diisi
                                    @endif
                                </p>
                                @if ($item->description)
                                    <p class="lesson-desc">{{ $item->description }}</p>
                                @endif
                            </div>
                            <div class="lesson-actions">
                                <a class="btn btn-ghost btn-sm" href="{{ route('jadwal.index', ['hari' => $hariAktif->value, 'edit' => $item->id]) }}#form-pelajaran">Edit</a>
                                <form method="POST" action="{{ route('jadwal.destroy', $item) }}" onsubmit="return confirm('Hapus pelajaran {{ $item->subject_name }} dari hari {{ $hariAktif->value }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="jadwal-panel" id="form-pelajaran" aria-labelledby="judul-form-pelajaran">
            @php
                $isEdit = $sedangEdit !== null;
                $formDay = old('day', $isEdit ? $sedangEdit->day->value : $hariAktif->value);
            @endphp

            <form
                class="jadwal-form"
                method="POST"
                action="{{ $isEdit ? route('jadwal.update', $sedangEdit) : route('jadwal.store') }}"
            >
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <h2 id="judul-form-pelajaran">{{ $isEdit ? 'Ubah Pelajaran' : 'Tambah Pelajaran' }}</h2>
                <p class="hint">{{ $isEdit ? 'Perbarui data lalu simpan perubahan.' : 'Isi data wajib, lalu simpan ke hari yang dipilih.' }}</p>

                <div class="field">
                    <label for="day">Hari</label>
                    <select id="day" name="day" required>
                        @foreach ($hariList as $hari)
                            <option value="{{ $hari->value }}" @selected($formDay === $hari->value)>{{ $hari->value }}</option>
                        @endforeach
                    </select>
                    @error('day') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="subject_name">Nama pelajaran</label>
                    <input id="subject_name" name="subject_name" type="text" value="{{ old('subject_name', $isEdit ? $sedangEdit->subject_name : '') }}" required maxlength="255">
                    @error('subject_name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="start_time">Jam mulai</label>
                        <input id="start_time" name="start_time" type="time" value="{{ old('start_time', $isEdit ? $sedangEdit->start_time->format('H:i') : '') }}" required>
                        @error('start_time') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label for="end_time">Jam selesai</label>
                        <input id="end_time" name="end_time" type="time" value="{{ old('end_time', $isEdit ? $sedangEdit->end_time->format('H:i') : '') }}" required>
                        @error('end_time') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="teacher">Nama guru <span class="optional">(opsional)</span></label>
                    <input id="teacher" name="teacher" type="text" value="{{ old('teacher', $isEdit ? $sedangEdit->teacher : '') }}" maxlength="255">
                    @error('teacher') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="room">Ruangan <span class="optional">(opsional)</span></label>
                    <input id="room" name="room" type="text" value="{{ old('room', $isEdit ? $sedangEdit->room : '') }}" maxlength="255">
                    @error('room') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="description">Keterangan <span class="optional">(opsional)</span></label>
                    <textarea id="description" name="description" maxlength="2000">{{ old('description', $isEdit ? $sedangEdit->description : '') }}</textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                    @if ($isEdit)
                        <a class="btn btn-ghost" href="{{ route('jadwal.index', ['hari' => $hariAktif->value]) }}">Batal</a>
                    @endif
                </div>
            </form>
        </section>
    </div>
</section>
@endsection
