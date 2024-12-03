<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'books';

    // Primary key
    protected $primaryKey = 'id_buku';

    // Kolom yang bisa diisi
    protected $fillable = [
        'judul_buku',
        'penulis',
        'tahun_terbit',
        'status',
    ];

    // Relasi dengan Borrowing (hasMany)
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'id_buku','id_buku');
    }
}
