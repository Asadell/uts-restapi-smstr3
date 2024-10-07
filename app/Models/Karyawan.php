<?php

namespace App\Models;

use App\Enum\KaryawanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'karyawan';

    protected $fillable = [
        'nama_lengkap', 
        'email', 
        'password', 
        'nomor_telepon', 
        'tanggal_lahir', 
        'alamat', 
        'tanggal_masuk', 
        'departemen_id', 
        'jabatan_id', 
        'status', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'status' => KaryawanStatus::class,
            'password' => 'hashed',
        ];
    }

    public function departemen() {
        return $this->belongsTo(Departemen::class);
    }

    public function jabatan() {
        return $this->belongsTo(Jabatan::class);
    }

    // public function absensi() {
    //     return $this->hasMany(Absensi::class);
    // }

    // public function gaji() {
    //     return $this->hasMany(Gaji::class);
    // }
}
