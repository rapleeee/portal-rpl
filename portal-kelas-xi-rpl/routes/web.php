<?php

use App\Http\Controllers\JadwalPelajaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['fitur' => config('fitur')]);
})->name('dashboard');

Route::get('/fitur/01', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
Route::post('/fitur/01/pelajaran', [JadwalPelajaranController::class, 'store'])->name('jadwal.store');
Route::put('/fitur/01/pelajaran/{pelajaran}', [JadwalPelajaranController::class, 'update'])->name('jadwal.update');
Route::delete('/fitur/01/pelajaran/{pelajaran}', [JadwalPelajaranController::class, 'destroy'])->name('jadwal.destroy');

Route::get('/fitur/{nomor}', function (string $nomor) {
    $katalog = config('fitur');

    abort_unless(array_key_exists($nomor, $katalog), 404);

    return view('fitur.'.$nomor, [
        'nomor' => $nomor,
        'judul' => $katalog[$nomor],
    ]);
})->where('nomor', '[0-9]{2}')->name('fitur.show');
