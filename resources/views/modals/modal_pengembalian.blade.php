<div class="modal fade" id="pengembalianModal" tabindex="-1" aria-labelledby="pengembalianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title fw-bold text-primary" id="pengembalianModalLabel">Proses Pengembalian Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-4">
                @if (isset($peminjamanAktif) && $peminjamanAktif->isEmpty())
                    <div class="alert alert-info mb-0 text-center py-4">
                        <i class="fas fa-info-circle fa-2x mb-2 text-info"></i>
                        <p class="mb-0">Tidak ada alat yang sedang dipinjam saat ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Teknisi</th>
                                    <th>Nama Alat</th>
                                    <th>Waktu Pinjam</th>
                                    <th width="320">Aksi Pengembalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjamanAktif ?? [] as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->teknisi->nama_teknisi }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item->alat->nama_alat }}</div>
                                            <span
                                                class="badge bg-light text-secondary border">{{ $item->alat->kode }}</span>
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
                                        <td>
                                            <form action="{{ route('transaksi.pengembalian.store') }}" method="POST"
                                                class="p-2 bg-light rounded border">
                                                @csrf
                                                <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                                <div class="mb-2">
                                                    <label class="form-label small fw-semibold">
                                                        Kondisi Alat Saat Dikembalikan
                                                    </label>
                                                    <select name="kondisi_kembali" class="form-select form-select-sm"
                                                        required>
                                                        <option value="">-- Pilih Kondisi Pengembalian --</option>
                                                        <option value="{{ $item->kondisi_pinjam }}">
                                                            Sama seperti saat dipinjam
                                                            ({{ $item->kondisi_pinjam === 'perlu_perhatian' ? 'Perlu Perhatian' : ucfirst($item->kondisi_pinjam) }})
                                                        </option>
                                                        <option value="rusak">
                                                            Rusak
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="mb-2">
                                                    <textarea name="catatan" class="form-control form-control-sm" rows="1" placeholder="Catatan (opsional)"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-check-circle me-1"></i> Kembalikan Alat
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailPengembalianModal" tabindex="-1" aria-labelledby="detailPengembalianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title fw-bold text-primary" id="detailPengembalianModalLabel">Detail Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-4">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-bold text-muted" width="40%">Teknisi</td>
                        <td id="detail_teknisi">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Nama Alat</td>
                        <td id="detail_alat_kode">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Waktu Pinjam</td>
                        <td id="detail_waktu_pinjam">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Waktu Kembali</td>
                        <td id="detail_waktu_kembali">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kondisi Pinjam</td>
                        <td id="detail_kondisi_pinjam">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kondisi Kembali</td>
                        <td id="detail_kondisi_kembali">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Catatan</td>
                        <td id="detail_catatan">: -</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const pengembalianModal = new bootstrap.Modal(document.getElementById('pengembalianModal'));
        const detailPengembalianModal = new bootstrap.Modal(document.getElementById('detailPengembalianModal'));

        function openPengembalianModal() {
            pengembalianModal.show();
        }

        function openDetailModal(item) {
            document.getElementById('detail_teknisi').innerText = `: ${item.teknisi.nama_teknisi}`;
            document.getElementById('detail_alat_kode').innerText = `: ${item.alat.nama_alat} (${item.alat.kode})`;
            document.getElementById('detail_waktu_pinjam').innerText = `: ${formatDate(item.waktu_pinjam)}`;
            document.getElementById('detail_waktu_kembali').innerText =
                `: ${item.waktu_kembali ? formatDate(item.waktu_kembali) : '-'}`;

            let kondisiPinjamBadge = '';
            let kondisiKembaliBadge = '';

            if (item.kondisi_pinjam === 'baik') {
                kondisiPinjamBadge = '<span class="badge bg-success">Baik</span>';
            } else if (item.kondisi_pinjam === 'perlu_perhatian') {
                kondisiPinjamBadge = '<span class="badge bg-warning text-dark">Perlu Perhatian</span>';
            } else if (item.kondisi_pinjam === 'rusak') {
                kondisiPinjamBadge = '<span class="badge bg-danger">Rusak</span>';
            }

            if (item.kondisi_kembali === 'baik') {
                kondisiKembaliBadge = '<span class="badge bg-success">Baik</span>';
            } else if (item.kondisi_kembali === 'perlu_perhatian') {
                kondisiKembaliBadge = '<span class="badge bg-warning text-dark">Perlu Perhatian</span>';
            } else if (item.kondisi_kembali === 'rusak') {
                kondisiKembaliBadge = '<span class="badge bg-danger">Rusak</span>';
            }

            document.getElementById('detail_kondisi_pinjam').innerHTML =
                `: ${kondisiPinjamBadge || '-'}`;
            document.getElementById('detail_kondisi_kembali').innerHTML =
                `: ${kondisiKembaliBadge || '-'}`;
            document.getElementById('detail_catatan').innerText = `: ${item.catatan ?? '-'}`;
            detailPengembalianModal.show();
        }

        function formatDate(dateString) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options).replace(',', '');
        }

        function capitalizeFirstLetter(string) {
            return string ? string.charAt(0).toUpperCase() + string.slice(1) : '-';
        }
    </script>
@endpush
