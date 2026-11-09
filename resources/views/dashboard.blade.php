@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="intro" aria-labelledby="judul-dashboard">
        <p class="eyebrow">RUANG KOLABORASI KELAS</p>
        <h1 id="judul-dashboard">Satu kelas, satu portal.</h1>
        <p>Bangun bersama, mulai dari fitur milikmu. Pilih nomor absen untuk membuka halaman tugas, lalu kembangkan melalui Pull Request.</p>
        <span class="summary">{{ count($fitur) }} fitur · 23 kesempatan belajar</span>
    </section>
    <section aria-labelledby="judul-daftar">
        <div class="section-heading">
            <h2 id="judul-daftar">Daftar fitur kelas</h2>
            <p>Pilih sesuai nomor absenmu</p>
        </div>
        <div class="feature-grid">
            @foreach ($fitur as $nomor => $judul)
                <a class="feature-card" href="{{ route('fitur.show', ['nomor' => sprintf('%02d', $nomor)]) }}">
                    <span class="badge">Absen {{ sprintf('%02d', $nomor) }}</span>
                    <h3>{{ $judul }}</h3>
                    <span class="card-action">Buka halaman <span aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
    </section>
@endsection
