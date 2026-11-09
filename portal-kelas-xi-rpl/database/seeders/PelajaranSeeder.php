<?php

namespace Database\Seeders;

use App\Hari;
use App\Pelajaran;
use Illuminate\Database\Seeder;

class PelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contoh = [
            ['day' => Hari::Senin, 'subject_name' => 'Matematika', 'start_time' => '07:00', 'end_time' => '08:30', 'teacher' => 'Bu Sari', 'room' => 'RPL-1'],
            ['day' => Hari::Senin, 'subject_name' => 'Bahasa Indonesia', 'start_time' => '08:30', 'end_time' => '10:00', 'teacher' => 'Pak Budi', 'room' => 'RPL-1'],
            ['day' => Hari::Senin, 'subject_name' => 'IPA', 'start_time' => '10:15', 'end_time' => '11:45', 'teacher' => 'Bu Nina', 'room' => 'Lab 2'],
            ['day' => Hari::Selasa, 'subject_name' => 'Bahasa Inggris', 'start_time' => '07:00', 'end_time' => '08:30', 'teacher' => 'Mr. Andi', 'room' => 'RPL-2'],
            ['day' => Hari::Selasa, 'subject_name' => 'IPS', 'start_time' => '08:30', 'end_time' => '10:00', 'teacher' => 'Bu Rina', 'room' => 'RPL-2'],
            ['day' => Hari::Rabu, 'subject_name' => 'Pemrograman Web', 'start_time' => '07:00', 'end_time' => '09:00', 'teacher' => 'Pak Dimas', 'room' => 'Lab 1'],
        ];

        foreach ($contoh as $item) {
            Pelajaran::query()->create($item);
        }
    }
}
