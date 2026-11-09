<?php

namespace App;

enum Hari: string
{
    case Senin = 'Senin';
    case Selasa = 'Selasa';
    case Rabu = 'Rabu';
    case Kamis = 'Kamis';
    case Jumat = 'Jumat';
    case Sabtu = 'Sabtu';
    case Minggu = 'Minggu';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function default(): self
    {
        return self::Senin;
    }

    public static function tryFromRequest(?string $hari): self
    {
        return self::tryFrom((string) $hari) ?? self::default();
    }
}
