<?php

namespace App;

use Database\Factories\PelajaranFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    /** @use HasFactory<PelajaranFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'day',
        'subject_name',
        'start_time',
        'end_time',
        'teacher',
        'room',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day' => Hari::class,
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }
}
