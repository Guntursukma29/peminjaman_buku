@extends('layouts.dashboard')

@section('content')
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Daftar Anggota</h2>
                    <br>
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMemberModal">
                        Tambah Anggota
                    </button>

                </div>
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->nama_anggota }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ $member->nomor_telepon }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editMemberModal{{ $member->id_anggota }}">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteMemberModal{{ $member->id_anggota }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Anggota --}}
                                <div class="modal fade" id="editMemberModal{{ $member->id_anggota }}" tabindex="-1"
                                    aria-labelledby="editMemberModalLabel{{ $member->id_anggota }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMemberModalLabel{{ $member->id_anggota }}">
                                                    Edit Anggota</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('members.update', $member->id_anggota) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                                                        <input type="text" class="form-control" id="nama_anggota"
                                                            name="nama_anggota" value="{{ $member->nama_anggota }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <input type="text" class="form-control" id="alamat"
                                                            name="alamat" value="{{ $member->alamat }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                                        <input type="text" class="form-control" id="nomor_telepon"
                                                            name="nomor_telepon" value="{{ $member->nomor_telepon }}"
                                                            required>
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

                                {{-- Modal Hapus Anggota --}}
                                <div class="modal fade" id="deleteMemberModal{{ $member->id_anggota }}" tabindex="-1"
                                    aria-labelledby="deleteMemberModalLabel{{ $member->id_anggota }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteMemberModalLabel{{ $member->id_anggota }}">Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('members.destroy', $member->id_anggota) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus anggota
                                                        <strong>{{ $member->nama_anggota }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addMemberModalLabel">Tambah Anggota</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('members.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_anggota" class="form-label">Nama Anggota</label>
                                            <input type="text" class="form-control" id="nama_anggota"
                                                name="nama_anggota" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="nomor_telepon"
                                                name="nomor_telepon" required>
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
            @endsection
