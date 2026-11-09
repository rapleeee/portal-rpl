@extends('layouts.app')

@section('title', $judul)

@section('content')
    <section class="placeholder" aria-labelledby="judul-fitur">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p>Fitur ini akan dikerjakan oleh siswa absen 15.</p>
    </section>
@endsection
