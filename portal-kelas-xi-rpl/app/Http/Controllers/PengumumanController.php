<?php

namespace App\Http\Controllers;

use App\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController 
{
    public function index()
    {
        return view('fitur.04', [
            'nomor'      => '04',
            'judul'      => config('fitur')['04'] ?? 'Pengumuman',
            'pengumuman' => Pengumuman::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')
            ->with('sukses', 'Pengumuman berhasil ditambahkan.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')
            ->with('sukses', 'Pengumuman berhasil dihapus.');
    }
}
