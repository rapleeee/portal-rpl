@extends('layouts.app')

@section('title', $judul)

@push('styles')
    <style>
        .quiz-page { display: grid; gap: 24px; }
        .quiz-hero { padding: clamp(24px, 5vw, 40px); border-radius: 18px; background: var(--mint); border: 1px solid #bddfce; }
        .quiz-hero h1 { margin-top: 16px; }
        .quiz-hero p { max-width: 620px; margin: 0; color: var(--muted); }
        .quiz-layout { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(240px, .65fr); gap: 20px; align-items: start; }
        .quiz-card { padding: clamp(20px, 4vw, 32px); background: white; border: 1px solid var(--line); border-radius: 14px; }
        .quiz-card h2 { margin-bottom: 8px; }
        .quiz-card-intro { margin: 0 0 24px; color: var(--muted); }
        .quiz-form { display: grid; gap: 18px; }
        .quiz-field { display: grid; gap: 7px; }
        .quiz-field label { font-weight: 700; }
        .quiz-field input, .quiz-field textarea { width: 100%; padding: 12px 14px; color: var(--ink); font: inherit; border: 1px solid #bdcbd3; border-radius: 8px; background: #fff; }
        .quiz-field textarea { min-height: 180px; resize: vertical; }
        .quiz-field input:focus, .quiz-field textarea:focus { border-color: var(--navy); outline: 3px solid #15345120; }
        .quiz-hint { color: var(--muted); font-size: .85rem; }
        .quiz-submit { justify-self: start; padding: 11px 18px; border: 0; border-radius: 8px; background: var(--navy); color: white; font: inherit; font-weight: 700; cursor: pointer; }
        .quiz-submit:hover { background: #214b6d; }
        .quiz-error { color: #a12622; font-size: .9rem; }
        .quiz-notice { padding: 14px 16px; border: 1px solid #bddfce; border-radius: 9px; background: var(--mint); }
        .quiz-question { margin-top: 18px; padding: 18px; border-left: 4px solid var(--orange); border-radius: 6px; background: #fff8f1; }
        .quiz-question p { margin: 8px 0 0; font-weight: 650; }
        .quiz-answer { margin: 12px 0 0; white-space: pre-wrap; overflow-wrap: anywhere; }
        .quiz-tips { margin: 16px 0 0; padding-left: 20px; color: var(--muted); }
        @media (max-width: 700px) { .quiz-layout { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('content')
    <div class="quiz-page">
        <section class="quiz-hero" aria-labelledby="judul-fitur">
            <span class="badge">Absen {{ $nomor }} · Kuis esai</span>
            <h1 id="judul-fitur">{{ $judul }}</h1>
            <p>Uji pemahaman Git dengan menjawab satu pertanyaan esai. Tulis jawabanmu dengan jelas dan gunakan bahasamu sendiri.</p>
        </section>

        <div class="quiz-layout">
            <section class="quiz-card" aria-labelledby="judul-form">
                <h2 id="judul-form">Jawaban kamu</h2>
                <p class="quiz-card-intro">Isi identitas dan tulis jawaban pada kolom yang tersedia.</p>

                @if (session('status'))
                    <p class="quiz-notice" role="status">{{ session('status') }}</p>
                @endif

                <form class="quiz-form" action="{{ route('quiz.store') }}" method="POST">
                    @csrf

                    <div class="quiz-field">
                        <label for="name">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $jawaban['name'] ?? '') }}" maxlength="255" autocomplete="name" required>
                        @error('name')
                            <span class="quiz-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="quiz-field">
                        <label for="kelas">Kelas</label>
                        <input id="kelas" name="kelas" type="text" value="{{ old('kelas', $jawaban['kelas'] ?? '') }}" maxlength="255" placeholder="Contoh: XI RPL" required>
                        @error('kelas')
                            <span class="quiz-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="quiz-field">
                        <label for="input">Jawaban esai</label>
                        <textarea id="input" name="input" maxlength="5000" placeholder="Tuliskan jawabanmu di sini..." required>{{ old('input', $jawaban['input'] ?? '') }}</textarea>
                        <span class="quiz-hint">Maksimal 5.000 karakter.</span>
                        @error('input')
                            <span class="quiz-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="quiz-submit" type="submit">Kirim jawaban</button>
                </form>
            </section>

            <aside class="quiz-card" aria-labelledby="judul-pertanyaan">
                <span class="badge">Pertanyaan 1 dari 1</span>
                <div class="quiz-question">
                    <h2 id="judul-pertanyaan">Jelaskan fungsi perintah Git</h2>
                    <p>{{ $pertanyaan }}</p>
                </div>
                <ul class="quiz-tips">
                    <li>Jelaskan dengan kalimat sendiri.</li>
                    <li>Sertakan tujuan perintah tersebut.</li>
                    <li>Periksa kembali jawaban sebelum dikirim.</li>
                </ul>

                @if (isset($jawaban['input']))
                    <div class="quiz-question">
                        <h2>Jawaban terakhir</h2>
                        <p class="quiz-answer">{{ $jawaban['input'] }}</p>
                    </div>
                @endif
            </aside>
        </div>
    </div>
@endsection
