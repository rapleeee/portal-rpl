<?php

use App\Hari;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

function check(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}

check(config('session.driver') === 'file', 'Session harus menggunakan file.');
check(config('cache.default') === 'file', 'Cache harus menggunakan file.');
check(config('queue.default') === 'sync', 'Queue harus menggunakan sync.');

function visit(string $path): Response
{
    global $kernel;
    $request = Request::create('http://localhost'.$path);
    $response = $kernel->handle($request);
    $kernel->terminate($request, $response);

    return $response;
}

preg_match_all('/^\| (\d{2}) \| (.*?) \|$/m', file_get_contents(__DIR__.'/../README.md'), $rows, PREG_SET_ORDER);
check(count($rows) === 23, 'README harus memuat 23 fitur.');
check(count(config('fitur')) === 23, 'Katalog harus memuat 23 fitur.');
check(count(glob(__DIR__.'/../resources/views/fitur/*.blade.php')) === 23, 'Harus ada tepat 23 view fitur.');

$dashboard = visit('/');
check($dashboard->getStatusCode() === 200, 'Dashboard gagal.');
$document = new DOMDocument;
@$document->loadHTML($dashboard->getContent());
$xpath = new DOMXPath($document);
$cards = $xpath->query('//a[contains(concat(" ", normalize-space(@class), " "), " feature-card ")]');
check($cards->length === 23, 'Dashboard harus mempunyai tepat 23 kartu.');

$connections = config('database.connections');

foreach ($rows as $index => [, $nomor, $judul]) {
    check(config('fitur')[$nomor] === $judul, "Katalog tidak cocok untuk $nomor.");
    $card = $cards->item($index);
    check(parse_url($card->getAttribute('href'), PHP_URL_PATH) === '/fitur/'.$nomor, "Tautan salah untuk $nomor.");
    check(str_contains($card->textContent, $judul), "Judul kartu salah untuk $nomor.");
    check(str_contains($card->textContent, 'Absen '.$nomor), "Nomor kartu salah untuk $nomor.");

    if ($nomor === '01') {
        continue;
    }

    $app['config']->set('database.connections', []);
    $page = visit('/fitur/'.$nomor);
    $app['config']->set('database.connections', $connections);
    check($page->getStatusCode() === 200, "Halaman $nomor gagal.");
    check(str_contains($page->getContent(), e($judul)), "Judul halaman salah untuk $nomor.");

    if ($nomor === '09') {
        check(str_contains($page->getContent(), 'name="name"'), 'Kuis harus meminta nama.');
        check(str_contains($page->getContent(), 'name="kelas"'), 'Kuis harus meminta kelas.');
        check(str_contains($page->getContent(), 'name="input"'), 'Kuis harus menyediakan jawaban esai.');
        check(str_contains($page->getContent(), 'name="_token"'), 'Form kuis harus menyertakan token CSRF.');

        continue;
    }

    check(str_contains($page->getContent(), "Fitur ini akan dikerjakan oleh siswa absen $nomor."), "Placeholder salah untuk $nomor.");
}

$quizGetRoute = app('router')->getRoutes()->match(Request::create('http://localhost/fitur/09'));
$quizPostRoute = app('router')->getRoutes()->match(Request::create('http://localhost/fitur/09', 'POST'));
check($quizGetRoute->getActionName() === App\Http\Controllers\quizController::class.'@index', 'GET kuis harus terhubung ke controller.');
check($quizPostRoute->getActionName() === App\Http\Controllers\quizController::class.'@store', 'POST kuis harus terhubung ke controller.');
$app['config']->set('database.connections', $connections);
Artisan::call('migrate:fresh', ['--force' => true]);
$page01 = visit('/fitur/01');
check($page01->getStatusCode() === 200, 'Halaman 01 gagal.');
check(str_contains($page01->getContent(), 'Jadwal Pelajaran Mingguan'), 'Judul jadwal 01 tidak ditemukan.');
check(str_contains($page01->getContent(), 'Belum ada jadwal pelajaran'), 'Empty state jadwal 01 tidak ditemukan.');
check(str_contains($page01->getContent(), 'Tambah Pelajaran'), 'Tombol tambah pelajaran 01 tidak ditemukan.');

foreach (Hari::cases() as $hari) {
    check(str_contains($page01->getContent(), $hari->value), "Navigasi hari {$hari->value} tidak ditemukan.");
}

foreach (['24', '00', '99', '1', '001', 'abc', '01.css', '01/extra'] as $invalid) {
    check(visit('/fitur/'.$invalid)->getStatusCode() === 404, "Nomor $invalid harus menghasilkan 404.");
}

check(! str_contains($dashboard->getContent(), '/build/'), 'Dashboard tidak boleh memerlukan build Vite.');
check(in_array('.env', file(__DIR__.'/../.gitignore', FILE_IGNORE_NEW_LINES), true), '.env harus diabaikan Git.');
echo "LULUS: 23 kartu dan tautan, halaman kuis 09 terhubung ke controller, placeholder lain sesuai README, 8 URL tidak valid menghasilkan 404, tanpa koneksi database.\n";
echo "LULUS: 23 kartu dan tautan, fitur 01 jadwal pelajaran aktif, 22 placeholder sesuai README, 8 URL tidak valid menghasilkan 404.\n";
