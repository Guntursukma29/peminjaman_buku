@extends('layouts.dashboard')

@section('content')
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h1 class="mt-4">Daftar buku</h1>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBookModal">
                        Tambah Buku
                    </button>
                </div>
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: '{{ session('success') }}',
                        });
                    </script>
                @endif
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $index => $book)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $book->judul_buku }}</td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->tahun_terbit }}</td>
                                    <td class="text-white">
                                        @if ($book->status == 'tersedia')
                                            <span class="badge  bg-md bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-md bg-danger">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editBookModal{{ $book->id_buku }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('books.destroy', $book->id_buku) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                <div class="modal fade" id="editBookModal{{ $book->id_buku }}" tabindex="-1"
                                    aria-labelledby="editBookModalLabel{{ $book->id_buku }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBookModalLabel{{ $book->id_buku }}">
                                                    Edit
                                                    Buku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('books.update', $book->id_buku) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="judul_buku" class="form-label">Judul Buku</label>
                                                        <input type="text" class="form-control" id="judul_buku"
                                                            name="judul_buku" value="{{ $book->judul_buku }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="penulis" class="form-label">Penulis</label>
                                                        <input type="text" class="form-control" id="penulis"
                                                            name="penulis" value="{{ $book->penulis }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tahun_terbit" class="form-label">Tahun
                                                            Terbit</label>
                                                        <input type="number" class="form-control" id="tahun_terbit"
                                                            name="tahun_terbit" value="{{ $book->tahun_terbit }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="close" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteBookModal{{ $book->id_buku }}" tabindex="-1"
                                    aria-labelledby="deleteBookModalLabel{{ $book->id_buku }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteBookModalLabel{{ $book->id_buku }}">
                                                    Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('books.destroy', $book->id_buku) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus buku
                                                        <strong>{{ $book->judul_buku }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="close" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Modal Edit Buku --}}

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data buku.</td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBookModalLabel">Tambah Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('books.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="judul_buku" class="form-label">Judul Buku</label>
                                            <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="penulis" class="form-label">Penulis</label>
                                            <input type="text" class="form-control" id="penulis" name="penulis"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                            <input type="number" class="form-control" id="tahun_terbit"
                                                name="tahun_terbit" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
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
