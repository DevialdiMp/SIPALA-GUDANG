@extends('layouts.admin')
@section('content')

    <style>
        .dashboard-screen {
            height: calc(100vh - 100px);
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow: hidden;
            padding: 12px 16px;
        }

        .dashboard-header {
            flex-shrink: 0;
        }

        .dashboard-actions,
        .dashboard-stats {
            flex-shrink: 0;
        }

        .dashboard-bottom {
            flex: 1;
            min-height: 0;
        }

        .dashboard-bottom>div {
            min-height: 0;
        }

        .dashboard-table-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .dashboard-table-body {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }

        .dashboard-table-body table {
            font-size: 0.78rem;
            white-space: nowrap;
        }

        .dashboard-table-body thead {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .dashboard-stats .card {
            min-height: 72px;
        }

        .dashboard-actions .btn {
            min-height: 55px;
        }

        @media (max-width: 767px) {
            .dashboard-screen {
                height: auto;
                overflow: visible;
            }

            .dashboard-bottom {
                flex: none;
            }

            .dashboard-bottom .card {
                min-height: 250px;
            }
        }
    </style>

    <div class="dashboard-screen">
        {{-- HEADER --}}
        <div class="dashboard-header card border-0 shadow-sm rounded-3">
            <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                <div class="bg-primary-subtle text-primary rounded-2 d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-speedometer2 fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Dashboard Gudang</h6>
                    <small class="text-secondary">
                        Sistem Manajemen Peminjaman dan Pengelolaan Alat Gudang.
                    </small>
                </div>
            </div>
        </div>

        {{-- MENU TRANSAKSI --}}
        <div class="dashboard-actions row g-2">
            <div class="col-6">
                <a href="{{ route('transaksi.peminjaman.index') }}"
                    class="btn btn-primary w-100 d-flex align-items-center text-start px-3 rounded-3 shadow-sm">
                    <i class="bi bi-box-arrow-up fs-5 me-2"></i>
                    <div>
                        <div class="fw-bold small">Peminjaman Alat</div>
                        <small class="opacity-75" style="font-size: 0.68rem;">
                            Proses alat keluar
                        </small>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="{{ route('transaksi.pengembalian.index') }}"
                    class="btn btn-success w-100 d-flex align-items-center text-start px-3 rounded-3 shadow-sm">
                    <i class="bi bi-box-arrow-in-down fs-5 me-2"></i>
                    <div>
                        <div class="fw-bold small">Pengembalian Alat</div>
                        <small class="opacity-75" style="font-size: 0.68rem;">
                            Proses alat masuk
                        </small>
                    </div>
                </a>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="dashboard-stats row g-2">
            <div class="col-3">
                <div class="card border-0 shadow-sm border-start border-primary border-3 rounded-3">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-secondary">Total Alat</small>
                            <h5 class="fw-bold mb-0">{{ $totalAlat }}</h5>
                        </div>
                        <i class="bi bi-tools text-primary fs-4 opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-0 shadow-sm border-start border-success border-3 rounded-3">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-secondary">Tersedia</small>
                            <h5 class="fw-bold text-success mb-0">{{ $alatTersedia }}</h5>
                        </div>
                        <i class="bi bi-check-circle text-success fs-4 opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-0 shadow-sm border-start border-warning border-3 rounded-3">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-secondary">Dipinjam</small>
                            <h5 class="fw-bold text-warning mb-0">{{ $alatDipinjam }}</h5>
                        </div>
                        <i class="bi bi-box-arrow-up-right text-warning fs-4 opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-0 shadow-sm border-start border-danger border-3 rounded-3">
                    <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-secondary">Rusak</small>
                            <h5 class="fw-bold text-danger mb-0">{{ $alatRusak }}</h5>
                        </div>
                        <i class="bi bi-exclamation-triangle text-danger fs-4 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="dashboard-bottom row g-2">
            {{-- PEMINJAMAN AKTIF --}}
            <div class="col-md-6 h-100">
                <div class="dashboard-table-card card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold small">
                                <i class="bi bi-clock-history text-warning me-1"></i>
                                Peminjaman Aktif
                            </span>
                        </div>
                    </div>

                    <div class="dashboard-table-body">
                        @php
                            $groupedPeminjaman = [];
                            foreach ($peminjamanAktif as $item) {
                                $key = $item->teknisi->nama_teknisi . '_' . $item->waktu_pinjam->format('Y-m-d H:i');
                                $groupedPeminjaman[$key][] = $item;
                            }
                        @endphp
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-2">Teknisi</th>
                                    <th>Nama Alat</th>
                                    <th>Waktu Pinjam</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupedPeminjaman as $group)
                                    @foreach ($group as $index => $item)
                                        <tr>
                                            @if ($index === 0)
                                                <td class="ps-3 fw-semibold" rowspan="{{ count($group) }}">
                                                    {{ $item->teknisi->nama_teknisi }}
                                                </td>
                                            @endif
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $item->alat->nama_alat }}
                                                </div>
                                                <small class="text-secondary">
                                                    {{ $item->alat->kode }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="fw-medium">
                                                    {{ $item->waktu_pinjam->translatedFormat('l, d F Y') }}
                                                </div>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $item->waktu_pinjam->format('H:i') }} WIB
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                    Dipinjam
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                            Tidak ada peminjaman alat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SELURUH DATA ALAT --}}
            <div class="col-md-6 h-100">
                <div class="dashboard-table-card card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold small">
                                <i class="bi bi-tools text-primary me-1"></i>
                                Seluruh Data Alat
                            </span>
                        </div>
                    </div>

                    <div class="dashboard-table-body">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 py-2">Kode</th>
                                    <th>Nama Alat</th>
                                    <th class="text-center">Kondisi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($semuaAlat ?? [] as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->kode }}
                                            </span>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $item->nama_alat }}
                                        </td>
                                        <td class="text-center">
                                            @if ($item->kondisi === 'baik')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                    Baik
                                                </span>
                                            @elseif($item->kondisi === 'perlu_perhatian')
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                    Perhatian
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                    Rusak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-secondary py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                            Belum ada data alat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
