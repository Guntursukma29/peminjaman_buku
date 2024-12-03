<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BookController extends Controller
{
    public function index()
    {
        // Ambil semua buku dengan menghitung peminjaman yang belum dikembalikan
        $books = Book::withCount(['borrowings as is_borrowed' => function ($query) {
            $query->where(function ($query) {
                // Memeriksa apakah peminjaman belum ada tanggal pengembalian
                $query->whereNull('tanggal_pengembalian')
                    // Atau peminjaman belum waktunya untuk dikembalikan
                    ->orWhere('tanggal_pengembalian', '>', now());
            });
        }])->get();

        // Ubah status berdasarkan kondisi peminjaman
        foreach ($books as $book) {
            // Jika ada peminjaman yang belum dikembalikan, statusnya tidak tersedia
            $book->status = $book->is_borrowed > 0 ? 'tidak tersedia' : 'tersedia';
        }

        return view('admin.buku.index', compact('books'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        // Simpan buku baru
        Book::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'status' => 'tersedia', // Nilai default untuk status
        ]);

        // Menggunakan SweetAlert untuk sukses

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');    }

    // Mengupdate data buku
    public function update(Request $request, Book $book)
    {
        // Validasi input dari form
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        // Update data buku
        $book->update($request->all());

        // Menggunakan SweetAlert untuk sukses

        return redirect()->route('books.index')->with('Sukses', 'Buku berhasil diperbarui.');
    }

    // Menghapus buku
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('Sukses', 'Buku berhasil dihapus.');
    }
}
