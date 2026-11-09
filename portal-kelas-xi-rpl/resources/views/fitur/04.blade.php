@extends('layouts.app')

@section('title', $judul)

@section('content')
    <style>
        .pg-pengumuman { max-width: 760px; margin: 0 auto; padding: 1rem; }
        .pg-pengumuman h1 { margin: .5rem 0 1.25rem; }

        .pg-pengumuman .bar-atas {
            display: flex; justify-content: space-between; align-items: center;
            gap: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap;
        }
        .pg-pengumuman .bar-atas h1 { margin: .25rem 0 0; }

        .pg-pengumuman .alert-sukses {
            background: #e7f6ec; color: #166534; border: 1px solid #b7e4c7;
            padding: .75rem 1rem; border-radius: 8px; margin-bottom: 1rem;
        }

        .pg-pengumuman button {
            font: inherit; font-weight: 600; cursor: pointer;
            border: 0; border-radius: 8px; padding: .6rem 1.1rem;
        }
        .pg-pengumuman .btn-utama { background: #2563eb; color: #fff; }
        .pg-pengumuman .btn-utama:hover { background: #1d4ed8; }
        .pg-pengumuman .btn-batal { background: #f3f4f6; color: #374151; }
        .pg-pengumuman .btn-batal:hover { background: #e5e7eb; }

        /* Pop up */
        .pg-pengumuman dialog {
            width: min(520px, calc(100% - 2rem)); border: 0; border-radius: 12px;
            padding: 0; box-shadow: 0 10px 40px rgba(0,0,0,.25);
        }
        .pg-pengumuman dialog::backdrop { background: rgba(17,24,39,.55); }
        .pg-pengumuman .form-pengumuman {
            display: flex; flex-direction: column; gap: .4rem; padding: 1.25rem;
        }
        .pg-pengumuman .form-pengumuman h2 { margin: 0 0 .5rem; font-size: 1.2rem; }
        .pg-pengumuman label { font-weight: 600; font-size: .9rem; margin-top: .5rem; }
        .pg-pengumuman input[type="text"],
        .pg-pengumuman textarea {
            width: 100%; box-sizing: border-box; padding: .6rem .75rem;
            border: 1px solid #d1d5db; border-radius: 8px;
            font: inherit; resize: vertical;
        }
        .pg-pengumuman input[type="text"]:focus,
        .pg-pengumuman textarea:focus {
            outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.15);
        }
        .pg-pengumuman .error { color: #b91c1c; font-size: .85rem; }
        .pg-pengumuman .aksi-form {
            display: flex; justify-content: flex-end; gap: .5rem; margin-top: .75rem;
        }

        /* Daftar */
        .pg-pengumuman .pengumuman-item {
            background: #fff; border: 1px solid #e5e7eb; border-left: 4px solid #2563eb;
            border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }
        .pg-pengumuman .pengumuman-item header {
            display: flex; justify-content: space-between; align-items: baseline; gap: 1rem;
        }
        .pg-pengumuman .pengumuman-item h2 { margin: 0; font-size: 1.15rem; }
        .pg-pengumuman .pengumuman-item time {
            color: #6b7280; font-size: .85rem; white-space: nowrap;
        }
        .pg-pengumuman .pengumuman-item p { margin: .6rem 0; line-height: 1.55; white-space: pre-line; }
        .pg-pengumuman .catatan {
            background: #fffbeb; border: 1px solid #fde68a; color: #92400e;
            padding: .5rem .75rem; border-radius: 8px; font-size: .9rem;
        }
        .pg-pengumuman .pengumuman-item form { margin-top: .5rem; }
        .pg-pengumuman .pengumuman-item button {
            background: #fee2e2; color: #b91c1c; padding: .4rem .8rem; font-size: .85rem;
        }
        .pg-pengumuman .pengumuman-item button:hover { background: #fecaca; }

        .pg-pengumuman .kosong { text-align: center; color: #6b7280; padding: 2rem 0; }

        @media (max-width: 520px) {
            .pg-pengumuman .pengumuman-item header { flex-direction: column; gap: .2rem; }
        }
    </style>

    <div class="pg-pengumuman">
        <section aria-labelledby="judul-fitur">
            <div class="bar-atas">
                <div>
                    <span class="badge">Absen {{ $nomor }}</span>
                    <h1 id="judul-fitur">{{ $judul }}</h1>
                </div>
                <button type="button" class="btn-utama" id="buka-form">+ Tambah Pengumuman</button>
            </div>

            @if (session('sukses'))
                <p class="alert-sukses">{{ session('sukses') }}</p>
            @endif

            {{-- Pop up form tambah --}}
            <dialog id="dialog-tambah" aria-labelledby="judul-dialog">
                <form action="{{ route('pengumuman.store') }}" method="POST" class="form-pengumuman">
                    @csrf
                    <h2 id="judul-dialog">Tambah Pengumuman</h2>

                    <label for="judul-input">Judul</label>
                    <input type="text" id="judul-input" name="judul" value="{{ old('judul') }}" required>
                    @error('judul') <small class="error">{{ $message }}</small> @enderror

                    <label for="isi">Isi</label>
                    <textarea id="isi" name="isi" rows="4" required>{{ old('isi') }}</textarea>
                    @error('isi') <small class="error">{{ $message }}</small> @enderror

                    <label for="catatan">Catatan (opsional)</label>
                    <textarea id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                    @error('catatan') <small class="error">{{ $message }}</small> @enderror

                    <div class="aksi-form">
                        <button type="button" class="btn-batal" id="tutup-form">Batal</button>
                        <button type="submit" class="btn-utama">Simpan</button>
                    </div>
                </form>
            </dialog>

            {{-- Daftar pengumuman --}}
            @forelse ($pengumuman as $p)
                <article class="pengumuman-item">
                    <header>
                        <h2>{{ $p->judul }}</h2>
                        <time datetime="{{ $p->created_at->toIso8601String() }}"
                              title="{{ $p->created_at->format('d M Y H:i') }}">
                            {{ $p->created_at->locale('en')->diffForHumans(['short' => true]) }}
                        </time>
                    </header>

                    <p>{{ $p->isi }}</p>

                    @if ($p->catatan)
                        <p class="catatan"><strong>Catatan:</strong> {{ $p->catatan }}</p>
                    @endif

                    <form action="{{ route('pengumuman.destroy', $p) }}" method="POST"
                          onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </article>
            @empty
                <p class="kosong">Belum ada pengumuman.</p>
            @endforelse
        </section>
    </div>

    <script>
        (function () {
            const dialog = document.getElementById('dialog-tambah');

            document.getElementById('buka-form').addEventListener('click', () => dialog.showModal());
            document.getElementById('tutup-form').addEventListener('click', () => dialog.close());

            // Tutup kalau klik area gelap di luar kotak
            dialog.addEventListener('click', (e) => {
                if (e.target === dialog) dialog.close();
            });

            // Buka lagi otomatis kalau ada error validasi
            @if ($errors->any())
                dialog.showModal();
            @endif
        })();
    </script>
@endsection