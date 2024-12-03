<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon; 

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'member'])->get();
        $books = Book::all();
        $members = Member::all();
        $pinjam = Book::whereHas('borrowings', function ($query) {
            $query->whereNull('tanggal_pengembalian');  // Filter peminjaman yang belum dikembalikan
        })->get();
        return view('admin.peminjaman.index', compact('borrowings', 'books', 'members','pinjam'));
    }

    // Menyimpan peminjaman baru
    public function store(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'id_buku' => 'required|exists:books,id_buku',  // Validasi untuk id_buku
        'id_anggota' => 'required|exists:members,id_anggota',  // Validasi untuk id_anggota
        'tanggal_peminjaman' => 'required|date',
        'tanggal_pengembalian' => 'nullable|date',
    ]);

    // Cek apakah buku sudah dipinjam dan belum dikembalikan
    $existingBorrowing = Borrowing::where('id_buku', $request->id_buku)
                                  ->whereNull('tanggal_pengembalian')  // Buku belum dikembalikan
                                  ->first();  // Ambil peminjaman pertama yang ditemukan

    // Jika buku sudah dipinjam dan belum dikembalikan
    if ($existingBorrowing) {
        // Cek apakah peminjaman ini sudah melewati batas waktu pengembalian
        $tanggalSekarang = now();  // Mendapatkan tanggal sekarang
        $tanggalPeminjaman = Carbon::parse($existingBorrowing->tanggal_peminjaman); // Ubah tanggal_peminjaman menjadi objek Carbon
        $tanggalBatasPengembalian = $tanggalPeminjaman->addDays(7); // Misalnya batas pengembalian 7 hari

        // Jika tanggal sekarang sudah lewat dari batas waktu pengembalian
        if ($tanggalSekarang > $tanggalBatasPengembalian) {
            return redirect()->route('borrowings.index')->with('error', 'Buku sudah dipinjam dan batas waktu pengembalian sudah lewat.');
        }

        // Jika buku masih dalam peminjaman dan belum melewati batas waktu pengembalian, beri pesan kesalahan
        return redirect()->route('borrowings.index')->with('error', 'Buku sudah dipinjam dan belum dikembalikan.');
    }

    // Jika tidak ada peminjaman yang belum dikembalikan, simpan peminjaman baru
    Borrowing::create([
        'id_buku' => $request->id_buku,
        'id_anggota' => $request->id_anggota,
        'tanggal_peminjaman' => $request->tanggal_peminjaman,
        'tanggal_pengembalian' => null,  // Buku belum dikembalikan
    ]);

    // Redirect ke halaman peminjaman dengan pesan sukses
    return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
}




    public function returnBook(Request $request, $id)
    {
        // Validasi untuk tanggal pengembalian
        $request->validate([
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
        ]);

        // Mencari data peminjaman berdasarkan ID
        $borrowing = Borrowing::findOrFail($id);

        // Perbarui tanggal pengembalian
        $borrowing->tanggal_pengembalian = $request->tanggal_pengembalian;
        $borrowing->save();

        // Update status buku menjadi tersedia setelah dikembalikan
        $borrowing->book->status = 'tersedia';
        $borrowing->book->save();

        // Redirect ke halaman peminjaman dengan pesan sukses
        return redirect()->route('borrowings.index')->with('success', 'Buku berhasil dikembalikan.');
    }
    

    
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'id_buku' => 'required|exists:books,id_buku',  // Validasi untuk id_buku
            'id_anggota' => 'required|exists:members,id_anggota',  // Validasi untuk id_anggota
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date',
        ]);
    
        // Mengupdate data peminjaman
        $borrowing->update([
            'id_buku' => $request->id_buku,
            'id_anggota' => $request->id_anggota,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);
    
        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }
    

    // Menghapus peminjaman
    public function destroy($id)
{
    $borrowing = Borrowing::findOrFail($id);
    $borrowing->delete();

    return redirect()->route('borrowings.index')->with('success', 'Peminjaman deleted successfully.');
}


}
