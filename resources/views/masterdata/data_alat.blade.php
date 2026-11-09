@extends('layouts.admin')
@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Data Alat</h1>
                <p class="text-muted mb-0">
                    Kelola data dan kondisi alat inventaris.
                </p>
            </div>

            <button type="button" class="btn btn-primary" onclick="openCreateAlatModal()">
                <i class="bi bi-plus-circle me-1"></i> Tambah Alat
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <form action="{{ route('masterdata.alat.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <h6 class="m-0 fw-bold text-primary">Daftar Alat</h6>
                    </div>

                    <div class="col-md-4 ms-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control border-start-0 bg-light"
                                placeholder="Cari kode atau nama..." value="{{ request('q') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <select name="kondisi" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="">Semua Kondisi</option>
                            <option value="baik" {{ request('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak" {{ request('kondisi') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia
                            </option>
                            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam
                            </option>
                        </select>
                    </div>

                    @if (request()->hasAny(['q', 'kondisi', 'status']))
                        <div class="col-md-auto">
                            <a href="{{ route('masterdata.alat.index') }}" class="btn btn-outline-secondary btn-sm px-3"
                                title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="60">No.</th>
                                <th>Kode Alat</th>
                                <th>Nama Alat</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($alats as $item)
                                <tr>
                                    <td>{{ $alats->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama_alat }}</td>
                                    <td class="text-center">
                                        @if ($item->kondisi === 'baik')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Baik
                                            </span>
                                        @elseif ($item->kondisi === 'rusak')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Rusak
                                            </span>
                                        @elseif ($item->kondisi === 'perlu_perhatian')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Perlu Perhatian
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status === 'tersedia')
                                            <span class="badge bg-primary">Tersedia</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-warning text-white"
                                                onclick="openEditAlatModal({{ json_encode($item) }})" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="openDeleteAlatModal('{{ route('masterdata.alat.destroy', $item->id) }}')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Data alat belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($alats->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
                            <span class="text-muted">
                                Menampilkan
                                <span class="fw-semibold">{{ $alats->firstItem() ?? 0 }}</span> sampai
                                <span class="fw-semibold">{{ $alats->lastItem() ?? 0 }}</span> dari
                                <span class="fw-semibold">{{ $alats->total() }}</span> data alat
                            </span>
                            <div class="pagination-sm mb-0">
                                {{ $alats->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('modals.modal_alat')
@endsection
