<?php

use App\Hari;
use App\Pelajaran;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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

Artisan::call('migrate:fresh', ['--force' => true]);

$sessionCookie = null;

function visit(string $method, string $path, array $data = []): Symfony\Component\HttpFoundation\Response
{
    global $kernel, $sessionCookie;

    $cookies = [];
    if ($sessionCookie !== null) {
        $cookies[$sessionCookie->getName()] = $sessionCookie->getValue();
    }

    $request = Request::create('http://localhost'.$path, $method, $data, $cookies);

    if ($sessionCookie !== null) {
        $request->headers->set('Cookie', $sessionCookie->getName().'='.$sessionCookie->getValue());
    }

    $response = $kernel->handle($request);

    foreach ($response->headers->getCookies() as $cookie) {
        if (str_contains($cookie->getName(), 'session')) {
            $sessionCookie = $cookie;
        }
    }

    $kernel->terminate($request, $response);

    return $response;
}

$index = visit('GET', '/fitur/01?hari=Jumat');
check($index->getStatusCode() === 200, 'Index gagal.');
check(str_contains($index->getContent(), 'Belum ada jadwal pelajaran'), 'Empty state Jumat hilang.');

preg_match('/name="_token" value="([^"]+)"/', $index->getContent(), $tokenMatch);
check(isset($tokenMatch[1]), 'CSRF token tidak ditemukan.');
$token = $tokenMatch[1];

$store = visit('POST', '/fitur/01/pelajaran', [
    '_token' => $token,
    'day' => Hari::Jumat->value,
    'subject_name' => 'Basis Data',
    'start_time' => '09:00',
    'end_time' => '10:30',
    'teacher' => 'Pak Rafi',
    'room' => 'Lab 1',
    'description' => 'Relasi tabel',
]);
check(in_array($store->getStatusCode(), [302, 303], true), 'Store harus redirect.');
check(Pelajaran::query()->where('subject_name', 'Basis Data')->exists(), 'Store tidak menyimpan data.');

$created = Pelajaran::query()->where('subject_name', 'Basis Data')->firstOrFail();
$show = visit('GET', '/fitur/01?hari=Jumat');
check(str_contains($show->getContent(), 'Basis Data'), 'List Jumat tidak menampilkan pelajaran baru.');
check(str_contains($show->getContent(), '09:00'), 'Jam mulai tidak tampil.');

preg_match('/name="_token" value="([^"]+)"/', $show->getContent(), $tokenMatch);
$token = $tokenMatch[1];

$update = visit('POST', '/fitur/01/pelajaran/'.$created->id, [
    '_token' => $token,
    '_method' => 'PUT',
    'day' => Hari::Jumat->value,
    'subject_name' => 'Basis Data Lanjut',
    'start_time' => '09:15',
    'end_time' => '10:45',
    'teacher' => 'Pak Rafi',
    'room' => 'Lab 2',
    'description' => 'Normalisasi',
]);
check(in_array($update->getStatusCode(), [302, 303], true), 'Update harus redirect.');
$created->refresh();
check($created->subject_name === 'Basis Data Lanjut', 'Update nama gagal.');
check($created->start_time->format('H:i') === '09:15', 'Update jam gagal.');

$seninCountBefore = Pelajaran::query()->where('day', Hari::Senin->value)->count();
Pelajaran::factory()->forDay(Hari::Senin)->create(['subject_name' => 'Matematika Isolasi']);
$seninCountAfterCreate = Pelajaran::query()->where('day', Hari::Senin->value)->count();
check($seninCountAfterCreate === $seninCountBefore + 1, 'Factory Senin gagal.');

$showEdit = visit('GET', '/fitur/01?edit='.$created->id);
preg_match('/name="_token" value="([^"]+)"/', $showEdit->getContent(), $tokenMatch);
$token = $tokenMatch[1];

$delete = visit('POST', '/fitur/01/pelajaran/'.$created->id, [
    '_token' => $token,
    '_method' => 'DELETE',
]);
check(in_array($delete->getStatusCode(), [302, 303], true), 'Delete harus redirect.');
check(! Pelajaran::query()->whereKey($created->id)->exists(), 'Delete gagal menghapus.');
check(Pelajaran::query()->where('subject_name', 'Matematika Isolasi')->exists(), 'Delete mengubah data hari lain.');

$invalid = visit('POST', '/fitur/01/pelajaran', [
    '_token' => $token,
    'day' => Hari::Sabtu->value,
    'subject_name' => 'Salah Jam',
    'start_time' => '10:00',
    'end_time' => '09:00',
]);
check($invalid->getStatusCode() === 302, 'Validasi jam harus redirect back.');
check(! Pelajaran::query()->where('subject_name', 'Salah Jam')->exists(), 'Data invalid ikut tersimpan.');

echo "LULUS: CRUD jadwal pelajaran (create, update, delete, isolasi hari, validasi jam).\n";
