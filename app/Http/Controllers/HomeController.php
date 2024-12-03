<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        // Ambil data total anggota
        $totalMembers = Member::count();
    
        // Ambil data total buku
        $totalBooks = Book::count();
    
        // Ambil data buku yang tersedia
        $availableBooks = Book::where('status', 'tersedia')->count();
    
        // Ambil data buku yang sedang dipinjam (belum dikembalikan)
        $borrowedBooks = Book::whereHas('borrowings', function ($query) {
            $query->whereNull('tanggal_pengembalian');
        })->count();
    
        // Ambil data peminjaman yang belum dikembalikan
        $borrowings = Borrowing::with(['book', 'member'])
            ->whereNull('tanggal_pengembalian') // Filter hanya yang belum dikembalikan
            ->get();
    
        // Pastikan tanggal_peminjaman adalah objek Carbon
        foreach ($borrowings as $borrowing) {
            $borrowing->tanggal_peminjaman = \Carbon\Carbon::parse($borrowing->tanggal_peminjaman);
            
            // Handle tanggal_pengembalian null case
            if ($borrowing->tanggal_pengembalian) {
                $borrowing->tanggal_pengembalian = \Carbon\Carbon::parse($borrowing->tanggal_pengembalian);
            } else {
                $borrowing->tanggal_pengembalian = null; // In case it's null
            }
        }
    
        return view('admin.index', compact('totalMembers', 'totalBooks', 'availableBooks', 'borrowedBooks', 'borrowings'));
    }
    
}
