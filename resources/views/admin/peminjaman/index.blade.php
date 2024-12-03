@extends('layouts.dashboard')

@section('content')
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Peminjaman</h2>
                    <br>
                    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addBorrowingModal">
                        Tambah Peminjaman
                    </button>

                </div>
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Anggota</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrowings as $index => $borrowing)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $borrowing->book->judul_buku }}</td>
                                    <td>{{ $borrowing->member->nama_anggota }}</td>
                                    <td>{{ $borrowing->tanggal_peminjaman }}</td>
                                    <<td>
                                        @if ($borrowing->tanggal_pengembalian)
                                            {{ $borrowing->tanggal_pengembalian }}
                                        @else
                                            @if (!$borrowing->tanggal_pengembalian)
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#returnModal{{ $borrowing->id_peminjaman }}">
                                                    Kembalikan
                                                </button>
                                            @endif
                                        @endif
                                        </td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-warning" data-toggle="modal"
                                                data-target="#editBorrowingModal{{ $borrowing->id_peminjaman }}">
                                                Edit
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">Hapus</button>
                                            </form>
                                        </td>

                                </tr>
                                @foreach ($borrowings as $borrowing)
                                    <div class="modal fade" id="returnModal{{ $borrowing->id_peminjaman }}" tabindex="-1"
                                        aria-labelledby="returnModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('borrowings.return', $borrowing->id_peminjaman) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="returnModalLabel">Kembalikan Buku</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                                            <input type="date" name="tanggal_pengembalian"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-success">Kembalikan
                                                            Buku</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach



                                <!-- Modal Edit Peminjaman -->
                                <div class="modal fade" id="editBorrowingModal{{ $borrowing->id_peminjaman }}"
                                    tabindex="-1" aria-labelledby="editBorrowingModalLabel{{ $borrowing->id_peminjaman }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editBorrowingModalLabel{{ $borrowing->id_peminjaman }}">
                                                    Edit Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('borrowings.update', $borrowing->id_peminjaman) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="id_buku" class="form-label">Buku</label>
                                                        <select class="form-control" id="id_buku" name="id_buku">
                                                            @foreach ($books as $book)
                                                                <option value="{{ $book->id_buku }}"
                                                                    {{ $book->id_buku == $borrowing->id_buku ? 'selected' : '' }}>
                                                                    {{ $book->judul_buku }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_anggota" class="form-label">Anggota</label>
                                                        <select class="form-control" id="id_anggota" name="id_anggota">
                                                            @foreach ($members as $member)
                                                                <option value="{{ $member->id_anggota }}"
                                                                    {{ $member->id_anggota == $borrowing->id_anggota ? 'selected' : '' }}>
                                                                    {{ $member->nama_anggota }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_peminjaman" class="form-label">Tanggal
                                                            Peminjaman</label>
                                                        <input type="date" class="form-control" id="tanggal_peminjaman"
                                                            name="tanggal_peminjaman"
                                                            value="{{ $borrowing->tanggal_peminjaman }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_pengembalian" class="form-label">Tanggal
                                                            Pengembalian</label>
                                                        <input type="date" class="form-control" id="tanggal_pengembalian"
                                                            name="tanggal_pengembalian"
                                                            value="{{ $borrowing->tanggal_pengembalian }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="addBorrowingModal" tabindex="-1"
                        aria-labelledby="addBorrowingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBorrowingModalLabel">Tambah Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('borrowings.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id_buku" class="form-label">Pilih Buku</label>
                                            <select name="id_buku" class="form-control" id="id_buku" required>
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id_buku }}">{{ $book->judul_buku }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_buku')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_anggota" class="form-label">Pilih Anggota</label>
                                            <select name="id_anggota" class="form-control" id="id_anggota" required>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id_anggota }}">{{ $member->nama_anggota }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_anggota')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                            <input type="date" class="form-control" id="tanggal_peminjaman"
                                                name="tanggal_peminjaman" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
