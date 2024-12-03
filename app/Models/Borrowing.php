<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'borrowings';

    // Primary key
    protected $primaryKey = 'id_peminjaman';
    protected $dates = ['tanggal_peminjaman', 'tanggal_pengembalian'];

    // Kolom yang bisa diisi
    protected $fillable = [
        'id_buku',
        'id_anggota',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];

    

    // Relasi dengan Book (belongsTo)
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku','id_buku');
    }

    // Relasi dengan Member (belongsTo)
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_anggota');
    }
}
