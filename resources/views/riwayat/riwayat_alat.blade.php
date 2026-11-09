@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-2">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 rounded-pill mb-2">
                    <i class="bi bi-clock-history me-1"></i> Log Aktivitas
                </span>
                <h3 class="fw-bold text-dark mb-1">Riwayat Transaksi</h3>
                <p class="text-secondary mb-0 small">
                    Pantau seluruh catatan transaksi peminjaman dan pengembalian alat gudang.
                </p>
            </div>

            @if ($mode === 'show')
                <div>
                    <a href="{{ route('riwayat.riwayat-transaksi.index') }}"
                        class="btn btn-outline-secondary px-4 rounded-pill fw-medium shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            @endif
        </div>

        @if ($mode === 'show')
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center">
                    <span
                        class="bg-primary-subtle text-primary p-2 rounded-3 me-2 d-inline-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-info-circle fs-6"></i>
                    </span>
                    <h5 class="fw-bold mb-0 text-dark">Detail Riwayat Transaksi</h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">ID Transaksi</span>
                                <span class="fw-bold text-dark fs-5">#{{ $riwayat->id }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <span class="text-muted small d-block mb-1">Status Transaksi</span>
                                <div>
                                    @if ($riwayat->status === 'dipinjam')
                                        <span
                                            class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-white rounded-3 border">
                                <span class="text-muted small d-block mb-1">Informasi Teknisi</span>
                                <div class="fw-bold text-dark">{{ $riwayat->teknisi->nama_teknisi }}</div>
                                <span class="text-secondary small">ID: {{ $riwayat->teknisi_id }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-white rounded-3 border">
                                <span class="text-muted small d-block mb-1">Informasi Alat</span>
                                <div class="fw-bold text-dark">{{ $riwayat->alat->nama_alat }}</div>
                                <div class="d-flex gap-2 mt-1">
                                    <span class="badge bg-light text-dark border">Kode: {{ $riwayat->alat->kode }}</span>
                                    <span class="badge bg-light text-secondary border">ID: {{ $riwayat->alat_id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-white rounded-3 border">
                                <span class="text-muted small d-block mb-1">Waktu & Kondisi Pinjam</span>
                                <div class="fw-medium text-dark"><i class="bi bi-calendar-event me-1 text-primary"></i>
                                    {{ $riwayat->waktu_pinjam?->format('d-m-Y H:i:s') ?? '-' }}</div>
                                <div class="small text-secondary mt-1">Kondisi: <span
                                        class="text-uppercase fw-semibold">{{ $riwayat->kondisi_pinjam ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-white rounded-3 border">
                                <span class="text-muted small d-block mb-1">Waktu & Kondisi Kembali</span>
                                <div class="fw-medium text-dark"><i class="bi bi-calendar-check me-1 text-success"></i>
                                    {{ $riwayat->waktu_kembali?->format('d-m-Y H:i:s') ?? '-' }}</div>
                                <div class="small text-secondary mt-1">
                                    Kondisi:
                                    @if ($riwayat->kondisi_kembali === 'baik')
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle">Baik</span>
                                    @elseif($riwayat->kondisi_kembali === 'perlu_perhatian')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Perlu
                                            Perhatian</span>
                                    @elseif($riwayat->kondisi_kembali === 'rusak')
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle">Rusak</span>
                                    @else
                                        <span class="text-muted">Belum dikembalikan</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white rounded-3 border">
                                <span class="text-muted small d-block mb-1">Catatan Transaksi</span>
                                <p class="text-muted mb-0 fw-medium">{{ $riwayat->catatan ?? 'Tidak ada catatan khusus.' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-secondary small">
                                <i class="bi bi-clock me-1"></i> Dibuat Pada:
                                {{ $riwayat->created_at?->format('d-m-Y H:i:s') ?? '-' }}
                            </div>
                        </div>

                        <div class="col-md-6 text-md-end">
                            <div class="text-secondary small">
                                <i class="bi bi-arrow-repeat me-1"></i> Diperbarui Pada:
                                {{ $riwayat->updated_at?->format('d-m-Y H:i:s') ?? '-' }}
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('riwayat.riwayat-transaksi.index') }}" class="btn btn-secondary px-4 rounded-pill fw-medium">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- FILTER DAN PENCARIAN --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('riwayat.riwayat-transaksi.index') }}" class="row g-3 align-items-center">

                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i
                                        class="bi bi-search"></i></span>
                                <input type="text" name="q" class="form-control bg-light border-start-0 ps-0"
                                    placeholder="Cari teknisi, alat, atau kode..." value="{{ request('q') }}">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <select name="status" class="form-select bg-light">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam
                                </option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <select name="kondisi_kembali" class="form-select bg-light">
                                <option value="">Semua Kondisi Kembali</option>
                                <option value="baik" {{ request('kondisi_kembali') === 'baik' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="perlu_perhatian"
                                    {{ request('kondisi_kembali') === 'perlu_perhatian' ? 'selected' : '' }}>Perlu
                                    Perhatian
                                </option>
                                <option value="rusak" {{ request('kondisi_kembali') === 'rusak' ? 'selected' : '' }}>Rusak
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm fw-medium">
                                Cari
                            </button>
                            <a href="{{ route('riwayat.riwayat-transaksi.index') }}" class="btn btn-light border text-secondary"
                                title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- TABEL RIWAYAT --}}
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="40">No</th>
                                <th>Nama Teknisi</th>
                                <th>Nama Alat</th>
                                <th>Waktu Pinjam</th>
                                <th class="text-center">Kondisi Awal</th>
                                <th>Waktu Kembali</th>
                                <th class="text-center">Kondisi Kembali</th>
                                <th class="text-center">Status</th>
                                <th width="100" class="text-center">Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($riwayat as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $riwayat->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        {{ $item->teknisi->nama_teknisi ?? '-' }}
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark">
                                            {{ $item->alat->nama_alat ?? '-' }}
                                        </div>
                                        <span class="badge bg-light text-secondary border">
                                            {{ $item->alat->kode ?? '-' }}
                                        </span>
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

                                    {{-- Kondisi Pinjam --}}
                                    <td class="text-center">
                                        @if ($item->kondisi_pinjam === 'baik')
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                Baik
                                            </span>
                                        @elseif ($item->kondisi_pinjam === 'perlu_perhatian')
                                            <span
                                                class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                Perlu Perhatian
                                            </span>
                                        @elseif ($item->kondisi_pinjam === 'rusak')
                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                Rusak
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Waktu Kembali --}}
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

                                    {{-- Kondisi Kembali --}}
                                    <td class="text-center">
                                        @if ($item->kondisi_kembali === 'baik')
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                Baik
                                            </span>
                                        @elseif ($item->kondisi_kembali === 'perlu_perhatian')
                                            <span
                                                class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                Perlu Perhatian
                                            </span>
                                        @elseif ($item->kondisi_kembali === 'rusak')
                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                Rusak
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if ($item->status === 'dipinjam')
                                            <span
                                                class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Detail --}}
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary text-white rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#detailPeminjamanModal"
                                            data-teknisi="{{ $item->teknisi->nama_teknisi ?? '-' }}"
                                            data-alat="{{ $item->alat->nama_alat ?? '-' }}"
                                            data-kode="{{ $item->alat->kode ?? '-' }}"
                                            data-waktu="{{ $item->waktu_pinjam?->format('d-m-Y H:i:s') ?? '-' }}"
                                            data-kondisi="{{ $item->kondisi_pinjam ?? '' }}"
                                            data-waktu-kembali="{{ $item->waktu_kembali?->format('d-m-Y H:i:s') ?? '-' }}"
                                            data-kondisi-kembali="{{ $item->kondisi_kembali ?? '' }}"
                                            data-catatan="{{ $item->catatan ?? '' }}" data-status="{{ $item->status }}">

                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Belum ada data riwayat transaksi peminjaman dan pengembalian alat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($riwayat->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
                            <span class="text-muted">
                                Menampilkan
                                <span class="fw-semibold">{{ $riwayat->firstItem() ?? 0 }}</span>
                                sampai
                                <span class="fw-semibold">{{ $riwayat->lastItem() ?? 0 }}</span>
                                dari
                                <span class="fw-semibold">{{ $riwayat->total() }}</span>
                                data riwayat
                            </span>
                            <div class="pagination-sm mb-0">
                                {{ $riwayat->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    @include('modals.detail_riwayat')
@endsection
