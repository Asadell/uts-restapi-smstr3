<?php

namespace App\Enum;

enum AbsensiStatus : string
{
    case HADIR = 'hadir';
    case IZIN = 'izin';
    case SAKIT = 'sakit';
    case ALPHA = 'alpha';
}
