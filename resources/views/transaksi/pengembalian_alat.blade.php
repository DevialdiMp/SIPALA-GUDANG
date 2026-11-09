@extends('layouts.admin')
@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Pengembalian Alat</h1>
                <p class="text-muted mb-0">Kelola riwayat dan proses pengembalian alat oleh teknisi.</p>
            </div>
            @if ($mode === 'index')
                <button type="button" class="btn btn-primary" onclick="openPengembalianModal()">
                    <i class="fas fa-undo me-1"></i> Proses Pengembalian
                </button>
            @endif
        </div>
        @if ($mode === 'show')
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Detail Pengembalian</h6>
                </div>
                <div class="card-body">
                    <p><strong>Teknisi:</strong> {{ $pengembalian->teknisi->nama_teknisi }}</p>
                    <p><strong>Alat:</strong> {{ $pengembalian->alat->nama_alat }} ({{ $pengembalian->alat->kode }})</p>
                    <p><strong>Waktu Pinjam:</strong> {{ $pengembalian->waktu_pinjam->format('d-m-Y H:i') }}</p>
                    <p><strong>Waktu Kembali:</strong> {{ $pengembalian->waktu_kembali?->format('d-m-Y H:i') ?? '-' }}</p>
                    <p><strong>Kondisi Pinjam:</strong> {{ ucfirst($pengembalian->kondisi_pinjam) }}</p>
                    <p><strong>Kondisi Kembali:</strong> {{ ucfirst($pengembalian->kondisi_kembali) }}</p>
                    <p><strong>Catatan:</strong> {{ $pengembalian->catatan ?? '-' }}</p>

                    <a href="{{ route('transaksi.pengembalian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
        @else
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('transaksi.pengembalian.index') }}" class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="q" class="form-control"
                                placeholder="Cari teknisi, alat, atau kode..." value="{{ request('q') }}">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary">Cari</button>
                            @if (request('q'))
                                <a href="{{ route('transaksi.pengembalian.index') }}"
                                    class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Riwayat Pengembalian</h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">No</th>
                                <th>Teknisi</th>
                                <th>Nama Alat</th>
                                <th>Waktu Pinjam</th>
                                <th>Waktu Kembali</th>
                                <th width="100" class="text-center">Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pengembalian as $item)
                                <tr>
                                    <td>{{ $pengembalian->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->teknisi->nama_teknisi }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->alat->nama_alat }}</div>
                                        <span class="badge bg-light text-secondary border">{{ $item->alat->kode }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="fw-semibold text-dark">
                                                {{ $item->waktu_pinjam?->translatedFormat('d F Y') ?? '-' }}
                                            </span>
                                            @if ($item->waktu_pinjam)
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $item->waktu_pinjam->format('H:i') }} WIB
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->waktu_kembali)
                                            <div class="d-flex flex-column gap-1">
                                                <span class="fw-semibold text-dark">
                                                    {{ $item->waktu_kembali->translatedFormat('d F Y') }}
                                                </span>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $item->waktu_kembali->format('H:i') }} WIB
                                                </small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info text-white rounded-pill"
                                            onclick="openDetailModal({{ json_encode($item) }})" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada riwayat pengembalian alat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($pengembalian->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
                            <span class="text-muted">
                                Menampilkan
                                <span class="fw-semibold">{{ $pengembalian->firstItem() ?? 0 }}</span> sampai
                                <span class="fw-semibold">{{ $pengembalian->lastItem() ?? 0 }}</span> dari
                                <span class="fw-semibold">{{ $pengembalian->total() }}</span> data pengembalian
                            </span>
                            <div class="pagination-sm mb-0">
                                {{ $pengembalian->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
        @endif
    </div>

    @include('modals.modal_pengembalian')
@endsection
