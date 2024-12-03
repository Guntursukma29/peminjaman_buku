@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Card Total Anggota -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Anggota</h5>
                        <p class="card-text">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Total Buku -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Buku</h5>
                        <p class="card-text">{{ $totalBooks }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Buku yang Sedang Dipinjam -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Buku Dipinjam</h5>
                        <p class="card-text">{{ $borrowedBooks }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="white_shd full margin_bottom_30">
                <!-- Tabel Peminjaman Buku -->
                <div class="table_section padding_infor_info mt-4">
                    <h4>Daftar Peminjaman Buku</h4>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Buku</th>
                                    <th>Nama Anggota</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $borrowing->book->judul_buku }}</td>
                                        <td>{{ $borrowing->member->nama_anggota }}</td>
                                        <td>{{ $borrowing->tanggal_peminjaman->format('d-m-Y') }}</td>
                                        <td class="text-white">
                                            @if (is_null($borrowing->tanggal_pengembalian))
                                                <span class="badge bg-warning">Sedang Dipinjam</span>
                                            @elseif (!is_null($borrowing->tanggal_pengembalian) && \Carbon\Carbon::now()->gt($borrowing->tanggal_pengembalian))
                                                <span class="badge bg-danger">Belum Dikembalikan</span>
                                            @elseif (!is_null($borrowing->tanggal_pengembalian))
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
