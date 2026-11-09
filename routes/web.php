<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['fitur' => config('fitur')]);
})->name('dashboard');

Route::get('/fitur/{nomor}', function (string $nomor) {
    $katalog = config('fitur');

    abort_unless(array_key_exists($nomor, $katalog), 404);

    return view('fitur.'.$nomor, [
        'nomor' => $nomor,
        'judul' => $katalog[$nomor],
    ]);
})->where('nomor', '[0-9]{2}')->name('fitur.show');
