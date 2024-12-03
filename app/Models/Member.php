<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'members';

    // Primary key
    protected $primaryKey = 'id_anggota';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_anggota',
        'alamat',
        'nomor_telepon',
    ];

    // Relasi dengan Borrowing (hasMany)
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'id_anggota');
    }
}
