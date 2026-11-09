@extends('layouts.admin')
@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Peminjaman Alat</h1>
                <p class="text-muted mb-0">Kelola data transaksi peminjaman alat oleh teknisi.</p>
            </div>

            <button type="button" class="btn btn-primary" onclick="openPeminjamanModal()">
                <i class="fas fa-plus me-1"></i> Peminjaman Baru
            </button>
        </div>

        @if ($mode === 'show')
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Detail Peminjaman</h6>
                </div>
                <div class="card-body">
                    <p><strong>Teknisi:</strong> {{ $peminjaman->teknisi->nama_teknisi }}</p>
                    <p><strong>Alat:</strong> {{ $peminjaman->alat->nama_alat }} ({{ $peminjaman->alat->kode }})</p>
                    <p><strong>Waktu Pinjam:</strong> {{ $peminjaman->waktu_pinjam->format('d-m-Y H:i') }}</p>
                    <p><strong>Kondisi Pinjam:</strong> {{ ucfirst($peminjaman->kondisi_pinjam) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($peminjaman->status) }}</p>

                    <a href="{{ route('transaksi.peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
        @else
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('transaksi.peminjaman.index') }}" class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="q" class="form-control"
                                placeholder="Cari teknisi, alat, atau kode..." value="{{ request('q') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam
                                </option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-primary">Cari</button>
                            @if (request()->hasAny(['q', 'status']))
                                <a href="{{ route('transaksi.peminjaman.index') }}"
                                    class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="40">No</th>
                                <th>Nama Teknisi</th>
                                <th>Nama Alat</th>
                                <th>Waktu Pinjam</th>
                                {{-- <th>Kondisi Alat</th> --}}
                                <th class="text-center">Status</th>
                                <th width="100" class="text-center">Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($peminjaman as $item)
                                <tr>
                                    <td class="text-center">{{ $peminjaman->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->teknisi->nama_teknisi }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->alat->nama_alat }}</div>
                                        <span class="badge bg-light text-secondary border">{{ $item->alat->kode }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="fw-semibold text-dark">
                                                {{ $item->waktu_pinjam->translatedFormat('d F Y') }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $item->waktu_pinjam->format('H:i') }} WIB
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status === 'dipinjam')
                                            <span
                                                class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info text-white rounded-pill"
                                            onclick="openDetailPeminjamanModal({{ json_encode($item) }})" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada data peminjaman alat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($peminjaman->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
                            <span class="text-muted">
                                Menampilkan
                                <span class="fw-semibold">{{ $peminjaman->firstItem() ?? 0 }}</span> sampai
                                <span class="fw-semibold">{{ $peminjaman->lastItem() ?? 0 }}</span> dari
                                <span class="fw-semibold">{{ $peminjaman->total() }}</span> data peminjaman
                            </span>
                            <div class="pagination-sm mb-0">
                                {{ $peminjaman->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    @include('modals.modal_peminjaman')
@endsection
