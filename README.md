# Portal Kelas XI RPL

Proyek kolaborasi XI RPL SMK PESAT. Guru menyediakan proyek awal di branch `main`. Setiap siswa mengembangkan **satu fitur sesuai nomor absen**, lalu mengajukannya melalui **satu Pull Request** ke repository kelas.

## 1. Jalankan proyek

Siapkan **PHP 8.3 atau lebih baru**, Composer, Git, dan akun GitHub. Starter menggunakan Laravel 13, Blade, CSS, dan JavaScript biasa. Tidak perlu menyiapkan database atau menjalankan npm untuk membuka starter.

1. Masuk ke akun GitHub yang diundang guru. Terima undangan, buka repository kelas, lalu salin URL dari tombol **Code → HTTPS**.
2. Ganti `URL_REPO_GURU` dan `NAMA_FOLDER_REPO` dengan URL dan nama folder yang sebenarnya:

   ```bash
   git clone URL_REPO_GURU
   cd NAMA_FOLDER_REPO
   composer install
   ```

3. Jika `.env` belum ada, buat salinannya dari `.env.example`:

   **Windows PowerShell**

   ```powershell
   Copy-Item .env.example .env
   ```

   **macOS / Linux**

   ```bash
   cp .env.example .env
   ```

4. Jalankan `php artisan key:generate` jika `APP_KEY` masih kosong, lalu jalankan server:

   ```bash
   php artisan serve
   ```

5. Buka [http://127.0.0.1:8000](http://127.0.0.1:8000). Dashboard menampilkan 23 fitur. Klik nomor fitur untuk membuka halaman awalnya. Sebagai contoh, halaman absen 07 berada di `/fitur/07`.

Jika portal menampilkan error database, periksa `.env`: starter menggunakan `SESSION_DRIVER=file`, `CACHE_STORE=file`, dan `QUEUE_CONNECTION=sync`. Setelah memperbaiki konfigurasi, jalankan `php artisan config:clear`. Jika repo tidak bisa diakses, periksa akun GitHub dan status undangan.

## 2. Pilih tugas sesuai absen

Nomor absen mengikuti LKPD. Gunakan **dua digit** pada URL, nama file, dan awalan nama branch. Contoh: absen 07 mengerjakan `resources/views/fitur/07.blade.php`, pada halaman `/fitur/07`.

| Absen | Fitur |
| --- | --- |
| 01 | Jadwal pelajaran |
| 02 | Jadwal piket |
| 03 | Kalender kegiatan kelas |
| 04 | Papan pengumuman |
| 05 | FAQ kelas |
| 06 | Daftar materi |
| 07 | Pencarian referensi belajar |
| 08 | Glosarium RPL |
| 09 | Kuis Git dasar |
| 10 | Galeri proyek siswa |
| 11 | Daftar tugas dengan filter status |
| 12 | Penghitung hari menuju tenggat |
| 13 | Checklist tugas pribadi |
| 14 | Ringkasan progres tugas |
| 15 | Riwayat pengumpulan tugas |
| 16 | Timer Pomodoro |
| 17 | Kalkulator rata-rata nilai |
| 18 | Daftar perangkat lab |
| 19 | Daftar ekstrakurikuler |
| 20 | Daftar prestasi kelas |
| 21 | Panduan penggunaan portal |
| 22 | Kontak layanan sekolah |
| 23 | Daftar kelompok belajar |

### File yang dikerjakan

- `resources/views/fitur/NN.blade.php`: isi halaman fitur milikmu. Pertahankan penggunaan layout yang sudah ada.
- `public/fitur/NN/`: opsional untuk CSS, JavaScript, atau gambar khusus fitur milikmu. Buat folder ini hanya jika dibutuhkan.
- Untuk CSS atau JavaScript khusus, pakai `@push('styles')` dan `@push('scripts')` pada view fitur. Layout starter sudah menyediakan kedua stack.

Biarkan route, layout, navigasi, dashboard, dan file fitur siswa lain tetap utuh. Gunakan data contoh atau fiktif bila diperlukan. Jika fiturnya perlu perubahan bersama, diskusikan dahulu dengan guru.

## 3. Buat branch, kerjakan, dan uji

Contoh untuk absen 07. Ganti nomor dan nama branch sesuai fitur sendiri. Jalankan dari folder proyek dengan kondisi kerja lokal bersih:

```bash
git switch main
git pull --ff-only origin main
git switch -c feat/07-referensi-belajar
git status
```

Isi placeholder fiturnya, lalu uji di browser. Untuk fitur pencarian, misalnya, coba kata kunci yang cocok dan kata kunci yang tidak ada. Pastikan hasilnya sesuai sebelum mengambil tangkapan layar.

Pilih hanya file tugasmu untuk di-commit. Jika kamu menambahkan aset, tambahkan file aset milikmu secara eksplisit sebelum commit.

```bash
git add resources/views/fitur/07.blade.php
git diff --staged
git commit -m "Tambah pencarian referensi belajar"
git push -u origin feat/07-referensi-belajar
```

Jangan push langsung ke `main`. Jangan commit `.env`, token, atau kredensial. Jika `git pull --ff-only` gagal atau ada konflik, catat pesan error dan minta guru memeriksa sebelum melanjutkan.

## 4. Buka Pull Request dan tindak lanjuti

Buat PR pada **repository guru**. Pilih **base** `main` dan **compare** branch fitur milikmu. Buka **Files changed** untuk memastikan isi PR sesuai tugas.

**Contoh judul:** `[07] Pencarian referensi belajar`

```text
Perubahan:
- Jelaskan apa yang dibuat.

Cara menguji:
1. Buka /fitur/07.
2. Masukkan kata kunci yang cocok, lalu cek hasil.
3. Coba kata kunci yang tidak ditemukan dan periksa kondisi hasil kosong.

Bukti:
- Lampirkan tangkapan layar fitur yang berjalan.
```

Selama menunggu pemeriksaan guru, tinjau satu PR teman dan beri satu komentar yang menyebut bagian yang diperiksa serta hasil pengamatanmu. Jika guru meminta revisi, lakukan commit dan push lagi ke **branch yang sama**. PR yang sudah terbuka akan ikut diperbarui.

Guru melakukan merge setelah perubahan siap. Jika PR sudah merged, ambil pembaruan di laptop:

```bash
git switch main
git pull --ff-only origin main
```

## 5. Kumpulkan bukti

Kumpulkan **tautan PR** dan **tangkapan layar fitur yang berjalan**. PR yang siap diperiksa tetap boleh dikumpulkan meskipun belum di-merge.

## Catatan untuk guru sebelum membagikan repo

- Pastikan dashboard, 23 tautan fitur, dan semua placeholder bisa dibuka pada hasil clone bersih.
- Pastikan `.env.example` tersedia, `.env` diabaikan Git, dan pengaturan starter tidak membutuhkan database.
- Periksa `git status` dan perubahan yang akan masuk commit. Buat initial commit pada `main`, lalu unggah ke repository kelas dan undang akun GitHub siswa.
- Bagikan URL repository bersama LKPD. Tetapkan agar siswa bekerja di branch masing-masing dan guru meninjau PR sebelum merge.

## Struktur starter

Root repository yang dibagikan guru adalah isi folder `portal-kelas-xi-rpl`.

- `config/fitur.php`: katalog bersama nomor absen dan nama fitur.
- `routes/web.php`: dashboard dan route fitur dengan validasi katalog.
- `resources/views/layouts/app.blade.php`: layout dan stack aset bersama.
- `resources/views/dashboard.blade.php`: 23 kartu fitur.
- `resources/views/fitur/01.blade.php` sampai `23.blade.php`: placeholder terpisah.
- `public/css/app.css`: gaya bersama, dimuat langsung tanpa Vite.
- `public/fitur/NN/`: folder opsional yang dibuat siswa saat diperlukan.
- `tests/smoke.php`: pemeriksaan dashboard, placeholder, dan 404 tanpa database.

Tidak perlu menjalankan migration, npm, atau build aset. Setelah instalasi di atas, jalankan `composer test` untuk memeriksa starter. Dependensi dikunci dalam `composer.lock`.

Contoh aset khusus pada view fitur (buat file asetnya terlebih dahulu):

```blade
@push('styles')
    <link rel="stylesheet" href="{{ asset('fitur/07/style.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('fitur/07/script.js') }}" defer></script>
@endpush
```
