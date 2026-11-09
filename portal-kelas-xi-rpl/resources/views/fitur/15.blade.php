@extends('layouts.app')

@section('title', $judul)

@section('content')
    <section class="placeholder" aria-labelledby="judul-fitur">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>

        <div class="feature-grid">
            <div class="feature-card">
                <h2 class="border-bottom">Tugas 1</h2>
                <h4>Deskripsi Tugas 1</h4>
                <p>Tanggal penyelesaian: <span class="summary">07-04-2026</span></p>
            </div>
                <div class="feature-card">
                    <h2 class="border-bottom">Tugas 2</h2>
                    <h4>Deskripsi Tugas 2</h4>
                    <p>Tanggal penyelesaian: <span class="summary">07-04-2026</span></p>
                </div>
                <div class="feature-card">
                    <h2 class="border-bottom">Tugas 3</h2>
                    <h4>Deskripsi Tugas 3</h4>
                    <p>Tanggal penyelesaian: <span class="summary">07-04-2026</span></p>
                </div>
        </div>            
    </section>
@endsection
