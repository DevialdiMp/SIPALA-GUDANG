<div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('transaksi.peminjaman.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-light py-3">
                    <h5 class="modal-title fw-bold text-primary" id="peminjamanModalLabel">Form Peminjaman Alat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label">Nama Teknisi <span class="text-danger">*</span></label>
                        <select name="teknisi_id" class="form-select @error('teknisi_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach ($teknisiList ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('teknisi_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_teknisi }}
                                </option>
                            @endforeach
                        </select>
                        @error('teknisi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Alat <span class="text-danger">*</span></label>
                        <div class="border rounded p-3" style="max-height: 250px; overflow-y: auto;">
                            @forelse($alatTersedia ?? [] as $item)
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alat_ids[]" value="{{ $item->id }}"
                                        class="form-check-input" id="alat{{ $item->id }}"
                                        {{ in_array($item->id, old('alat_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alat{{ $item->id }}">
                                        <strong>{{ $item->nama_alat }}</strong>
                                        <span class="text-muted">({{ $item->kode }})</span>
                                        @if ($item->kondisi === 'baik')
                                            <span class="badge bg-success ms-1">
                                                {{ ucfirst($item->kondisi) }}
                                            </span>
                                        @elseif ($item->kondisi === 'perlu_perhatian')
                                            <span class="badge bg-warning text-dark ms-1">
                                                Perlu Perhatian
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Tidak ada alat yang tersedia untuk dipinjam.</p>
                            @endforelse
                        </div>
                        @error('alat_ids')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('alat_ids.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info small mb-0">
                        <i class="fas fa-info-circle me-1"></i> Waktu peminjaman dan kondisi awal alat akan dicatat
                        otomatis oleh sistem.
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Simpan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailPeminjamanModal" tabindex="-1" aria-labelledby="detailPeminjamanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title fw-bold text-primary" id="detailPeminjamanModalLabel">Detail Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-4">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-bold text-muted" width="40%">Teknisi</td>
                        <td id="detail_peminjaman_teknisi">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Nama Alat</td>
                        <td id="detail_peminjaman_alat">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kode Alat</td>
                        <td id="detail_peminjaman_kode">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Waktu Pinjam</td>
                        <td id="detail_peminjaman_waktu">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Kondisi Alat</td>
                        <td id="detail_peminjaman_kondisi">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Status</td>
                        <td id="detail_peminjaman_status">: -</td>
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
        const peminjamanModal = new bootstrap.Modal(document.getElementById('peminjamanModal'));
        const detailPeminjamanModal = new bootstrap.Modal(document.getElementById('detailPeminjamanModal'));

        function openPeminjamanModal() {
            peminjamanModal.show();
        }

        function openDetailPeminjamanModal(item) {
            document.getElementById('detail_peminjaman_teknisi').innerText = `: ${item.teknisi.nama_teknisi}`;
            document.getElementById('detail_peminjaman_alat').innerText = `: ${item.alat.nama_alat}`;
            document.getElementById('detail_peminjaman_kode').innerText = `: ${item.alat.kode}`;
            document.getElementById('detail_peminjaman_waktu').innerText = `: ${formatDatePeminjaman(item.waktu_pinjam)}`;
            let kondisiBadge = '';

            if (item.kondisi_pinjam === 'baik') {
                kondisiBadge = '<span class="badge bg-success">Baik</span>';
            } else if (item.kondisi_pinjam === 'perlu_perhatian') {
                kondisiBadge = '<span class="badge bg-warning text-dark">Perlu Perhatian</span>';
            } else if (item.kondisi_pinjam === 'rusak') {
                kondisiBadge = '<span class="badge bg-danger">Rusak</span>';
            }

            document.getElementById('detail_peminjaman_kondisi').innerHTML =
                `: ${kondisiBadge}`;

            let statusBadge = item.status === 'dipinjam' ?
                '<span class="badge bg-warning text-dark">Dipinjam</span>' :
                '<span class="badge bg-success">Dikembalikan</span>';
            document.getElementById('detail_peminjaman_status').innerHTML = `: ${statusBadge}`;

            detailPeminjamanModal.show();
        }

        function formatDatePeminjaman(dateString) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options).replace(',', '');
        }

        function capitalizeFirstLetterPeminjaman(string) {
            return string ? string.charAt(0).toUpperCase() + string.slice(1) : '-';
        }

        @if ($errors->any())
            document.addEventListener("DOMContentLoaded", function() {
                peminjamanModal.show();
            });
        @endif
    </script>
@endpush
