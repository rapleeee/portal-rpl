@extends('layouts.app')

@section('title', $judul)

@push('styles')
    <!-- Tailwind CSS Play CDN & Nonaktifkan Preflight agar navbar & footer bawaan tetap rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false }
        }
    </script>
@endpush

@section('content')
    <section class="placeholder" aria-labelledby="judul-fitur">
        <span class="badge">Absen {{ $nomor }}</span>
        <h1 id="judul-fitur">{{ $judul }}</h1>
        <p>Layanan terpadu untuk pengaduan, kendala fasilitas, urusan administrasi, dan bimbingan konseling SMK PESAT.</p>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <section class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4 mb-5">
                <h2 class="text-xl font-bold text-[#153451] m-0">Kirim Pesan / Pengaduan</h2>
                <p class="text-xs text-slate-500 mt-1 mb-0">Isi data formulir berikut secara lengkap.</p>
            </div>

            <div id="alertSuccess" class="hidden mb-5 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm flex items-start gap-3">
                <span class="text-base">✓</span>
                <div>
                    <strong class="block">Pesan Berhasil Dikirim!</strong>
                    <span id="alertDetails" class="text-xs text-emerald-700">Tiket pengaduan Anda berhasil ditambahkan ke riwayat mockup.</span>
                </div>
            </div>

            <form id="contactForm" autocomplete="off" class="space-y-4">
                <div>
                    <label for="namaLengkap" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="namaLengkap" required placeholder="cth. Tristan Pratama"
                        class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>
                <div>
                    <label for="nis" class="block text-xs font-semibold text-slate-700 mb-1">
                        Nomor Induk Siswa (NIS) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nis" pattern="[0-9]{4,12}" required placeholder="cth. 232410022"
                        class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>
                <div>
                    <label for="kategoriLayanan" class="block text-xs font-semibold text-slate-700 mb-1">
                        Kategori Layanan <span class="text-red-500">*</span>
                    </label>
                    <select id="kategoriLayanan" required
                        class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition cursor-pointer">
                        <option value="" disabled selected>-- Pilih Kategori Layanan --</option>
                        <option value="Tata Usaha & Administrasi">Tata Usaha & Administrasi Siswa</option>
                        <option value="Bimbingan Konseling (BK)">Bimbingan Konseling (BK)</option>
                        <option value="Lab Komputer / Sarana RPL">Lab Komputer & Sarana RPL</option>
                        <option value="Kurikulum & Pembelajaran">Kurikulum & Pembelajaran</option>
                        <option value="Perpustakaan">Perpustakaan & Literasi</option>
                    </select>
                </div>
                <div>
                    <label for="subjek" class="block text-xs font-semibold text-slate-700 mb-1">
                        Subjek Pesan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="subjek" required placeholder="cth. Kendala Login Akun Praktikum"
                        class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>

                <div>
                    <label for="isiPesan" class="block text-xs font-semibold text-slate-700 mb-1">
                        Isi Pesan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="isiPesan" rows="4" required placeholder="Tuliskan kendala atau pertanyaan Anda secara rinci..."
                        class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition resize-y"></textarea>
                </div>

                <div class="flex gap-3 pt-3">
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#153451] hover:bg-[#0f273d] text-white text-sm font-semibold cursor-pointer border-0 transition">
                        Kirim Pesan
                    </button>
                    <button type="button" id="btnReset" class="px-5 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold cursor-pointer border-0 transition">
                        Reset
                    </button>
                </div>
            </form>
        </section>

        <!-- Kolom Info & Mockup Riwayat -->
        <aside class="space-y-6">
            <!-- Info Kontak Sekolah -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-base font-bold text-[#153451] m-0">Pusat Layanan</h3>
                <p class="text-xs text-slate-500 mt-1 mb-4">Informasi operasional & bantuan langsung</p>

                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="font-bold text-slate-800 block mb-0.5">🕒 Jam Operasional</span>
                        <span>Senin – Jumat : 07.00 – 15.30 WIB</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-800 block mb-0.5">📍 Lokasi Ruang Layanan</span>
                        <span>Gedung Tata Usaha & BK Lantai 1 SMK PESAT</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-800 block mb-0.5">✉️ Email Resmi</span>
                        <span>layanan@smkpesat.sch.id</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Mockup Tiket -->
            
        </aside>
    </div>
@endsection

@push('scripts')

@endpush
