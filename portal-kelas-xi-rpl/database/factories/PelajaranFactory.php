<?php

namespace Database\Factories;

use App\Hari;
use App\Pelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pelajaran>
 */
class PelajaranFactory extends Factory
{
    protected $model = Pelajaran::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $sequence = 0;
        $sequence++;

        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Pemrograman Web',
            'Basis Data',
            'PKN',
        ];

        $rooms = ['RPL-1', 'RPL-2', 'Lab 1', 'Lab 2'];
        $startHour = 7 + ($sequence % 8);

        return [
            'day' => Hari::cases()[$sequence % count(Hari::cases())]->value,
            'subject_name' => $subjects[$sequence % count($subjects)],
            'start_time' => sprintf('%02d:00', $startHour),
            'end_time' => sprintf('%02d:30', $startHour + 1),
            'teacher' => 'Guru '.$sequence,
            'room' => $rooms[$sequence % count($rooms)],
            'description' => 'Keterangan pelajaran '.$sequence,
        ];
    }

    public function forDay(Hari|string $hari): static
    {
        return $this->state(fn (): array => [
            'day' => $hari instanceof Hari ? $hari->value : $hari,
        ]);
    }
}
