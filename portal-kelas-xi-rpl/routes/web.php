<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengumumanController;

Route::get('/', function () {
    return view('dashboard', ['fitur' => config('fitur')]);
})->name('dashboard');

// ===== Absen 04: Pengumuman (harus di ATAS route umum /fitur/{nomor}) =====
Route::get('/fitur/04', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::post('/fitur/04', [PengumumanController::class, 'store'])->name('pengumuman.store');
Route::delete('/fitur/04/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
// ==========================================================================

Route::get('/fitur/{nomor}', function (string $nomor) {
    $katalog = config('fitur');

    abort_unless(array_key_exists($nomor, $katalog), 404);

    return view('fitur.'.$nomor, [
        'nomor' => $nomor,
        'judul' => $katalog[$nomor],
    ]);
})->where('nomor', '[0-9]{2}')->name('fitur.show');