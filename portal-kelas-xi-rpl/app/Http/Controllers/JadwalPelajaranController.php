<?php

namespace App\Http\Controllers;

use App\Hari;
use App\Http\Requests\StorePelajaranRequest;
use App\Http\Requests\UpdatePelajaranRequest;
use App\Pelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request): View
    {
        $katalog = config('fitur');
        $hariAktif = Hari::tryFromRequest($request->query('hari'));
        $sedangEdit = null;

        if ($request->filled('edit')) {
            $sedangEdit = Pelajaran::query()->find($request->integer('edit'));

            if ($sedangEdit !== null) {
                $hariAktif = $sedangEdit->day;
            }
        }

        $pelajaran = Pelajaran::query()
            ->where('day', $hariAktif->value)
            ->orderBy('start_time')
            ->get();

        return view('fitur.01', [
            'nomor' => '01',
            'judul' => $katalog['01'],
            'hariList' => Hari::cases(),
            'hariAktif' => $hariAktif,
            'pelajaran' => $pelajaran,
            'sedangEdit' => $sedangEdit,
        ]);
    }

    public function store(StorePelajaranRequest $request): RedirectResponse
    {
        $pelajaran = Pelajaran::query()->create($request->validated());

        return redirect()
            ->route('jadwal.index', ['hari' => $pelajaran->day->value])
            ->with('status', 'Pelajaran berhasil ditambahkan.');
    }

    public function update(UpdatePelajaranRequest $request, Pelajaran $pelajaran): RedirectResponse
    {
        $pelajaran->update($request->validated());

        return redirect()
            ->route('jadwal.index', ['hari' => $pelajaran->day->value])
            ->with('status', 'Pelajaran berhasil diperbarui.');
    }

    public function destroy(Pelajaran $pelajaran): RedirectResponse
    {
        $hari = $pelajaran->day->value;
        $pelajaran->delete();

        return redirect()
            ->route('jadwal.index', ['hari' => $hari])
            ->with('status', 'Pelajaran berhasil dihapus.');
    }
}
