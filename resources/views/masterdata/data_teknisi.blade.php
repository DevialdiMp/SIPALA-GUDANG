@extends('layouts.admin')
@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Data Teknisi</h1>
                <p class="text-muted mb-0">
                    Kelola data teknisi yang melakukan peminjaman alat.
                </p>
            </div>

            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus me-1"></i> Tambah Teknisi
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="m-0 fw-bold text-primary">Daftar Teknisi</h6>

                    <form action="{{ route('masterdata.teknisi.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="q" class="form-control" placeholder="Cari nama atau nomor HP..."
                            value="{{ request('q') }}">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                        @if (request('q'))
                            <a href="{{ route('masterdata.teknisi.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No.</th>
                                <th>Nama Teknisi</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teknisis as $item)
                                <tr>
                                    <td>{{ $teknisis->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->nama_teknisi }}</td>
                                    <td>{{ $item->no_hp ?? '-' }}</td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-warning text-white"
                                                onclick="openEditModal({{ json_encode($item) }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="openDeleteModal('{{ route('masterdata.teknisi.destroy', $item->id) }}')"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Data teknisi belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($teknisis->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
                            <span class="text-muted">
                                Menampilkan
                                <span class="fw-semibold">{{ $teknisis->firstItem() ?? 0 }}</span> sampai
                                <span class="fw-semibold">{{ $teknisis->lastItem() ?? 0 }}</span> dari
                                <span class="fw-semibold">{{ $teknisis->total() }}</span> data teknisi
                            </span>

                            <div class="pagination-sm mb-0">
                                {{ $teknisis->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('modals.modal_teknisi')
@endsection
