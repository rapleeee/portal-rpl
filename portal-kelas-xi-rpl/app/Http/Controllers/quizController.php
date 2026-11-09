<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class quizController
{
    public function index(): View
    {
        return view('fitur.09', [
            'nomor' => '09',
            'judul' => config('fitur.09'),
            'pertanyaan' => 'Jelaskan fungsi perintah git commit dalam alur kerja Git.',
            'jawaban' => session('quiz_submission'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'input' => ['required', 'string', 'max:5000'],
        ]);

        $request->session()->put('quiz_submission', $validated);

        return redirect()
            ->route('quiz.show')
            ->with('status', 'Jawaban berhasil dikirim.');
    }
}
