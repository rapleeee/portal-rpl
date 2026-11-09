<?php

use App\Http\Controllers\quizController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['fitur' => config('fitur')]);
})->name('dashboard');

Route::get('/fitur/09', [quizController::class, 'index'])->name('quiz.show');
Route::post('/fitur/09', [quizController::class, 'store'])->name('quiz.store');
// ===== Absen 04: Pengumuman (harus di ATAS route umum /fitur/{nomor}) =====
Route::get('/fitur/04', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::post('/fitur/04', [PengumumanController::class, 'store'])->name('pengumuman.store');
Route::delete('/fitur/04/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
// ==========================================================================
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

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
