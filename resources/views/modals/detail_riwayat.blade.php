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
                        <td class="fw-bold" width="40%">Teknisi</td>
                        <td id="detail_peminjaman_teknisi">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nama Alat</td>
                        <td id="detail_peminjaman_alat">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kode Alat</td>
                        <td id="detail_peminjaman_kode">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Waktu Pinjam</td>
                        <td id="detail_peminjaman_waktu">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kondisi Pinjam</td>
                        <td id="detail_peminjaman_kondisi">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Waktu Kembali</td>
                        <td id="detail_peminjaman_waktu_kembali">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kondisi Kembali</td>
                        <td id="detail_peminjaman_kondisi_kembali">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Catatan</td>
                        <td id="detail_peminjaman_catatan">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status</td>
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
        document.addEventListener('DOMContentLoaded', function() {
            const detailModal = document.getElementById('detailPeminjamanModal');
            if (detailModal) {
                detailModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;

                    document.getElementById('detail_peminjaman_teknisi').textContent = ': ' + button
                        .getAttribute('data-teknisi');
                    document.getElementById('detail_peminjaman_alat').textContent = ': ' + button
                        .getAttribute('data-alat');
                    document.getElementById('detail_peminjaman_kode').textContent = ': ' + button
                        .getAttribute('data-kode');
                    document.getElementById('detail_peminjaman_waktu').textContent = ': ' + button
                        .getAttribute('data-waktu');
                    document.getElementById('detail_peminjaman_waktu_kembali').textContent = ': ' + button
                        .getAttribute('data-waktu-kembali');

                    let kondisi = button.getAttribute('data-kondisi');
                    let kondisiKembali = button.getAttribute('data-kondisi-kembali');

                    let kondisiBadge = '';
                    let kondisiKembaliBadge = '';

                    if (kondisi === 'baik') {
                        kondisiBadge = '<span class="badge bg-success">Baik</span>';
                    } else if (kondisi === 'perlu_perhatian') {
                        kondisiBadge = '<span class="badge bg-warning text-dark">Perlu Perhatian</span>';
                    } else if (kondisi === 'rusak') {
                        kondisiBadge = '<span class="badge bg-danger">Rusak</span>';
                    } else {
                        kondisiBadge = '<span class="text-muted">-</span>';
                    }

                    if (kondisiKembali === 'baik') {
                        kondisiKembaliBadge = '<span class="badge bg-success">Baik</span>';
                    } else if (kondisiKembali === 'perlu_perhatian') {
                        kondisiKembaliBadge =
                            '<span class="badge bg-warning text-dark">Perlu Perhatian</span>';
                    } else if (kondisiKembali === 'rusak') {
                        kondisiKembaliBadge = '<span class="badge bg-danger">Rusak</span>';
                    } else {
                        kondisiKembaliBadge = '<span class="text-muted">Belum dikembalikan</span>';
                    }

                    document.getElementById('detail_peminjaman_kondisi').innerHTML =
                        ': ' + kondisiBadge;

                    document.getElementById('detail_peminjaman_kondisi_kembali').innerHTML =
                        ': ' + kondisiKembaliBadge;

                    let catatan = button.getAttribute('data-catatan');
                    let catatanElement = document.getElementById('detail_peminjaman_catatan');
                    if (catatan && catatan.trim() !== '') {
                        catatanElement.textContent = ': ' + catatan;
                        catatanElement.classList.remove('text-muted');
                    } else {
                        catatanElement.textContent = ': Tidak ada catatan khusus.';
                        catatanElement.classList.add('text-muted');
                    }

                    document.getElementById('detail_peminjaman_status').textContent = ': ' + button
                        .getAttribute('data-status');
                });
            }
        });
    </script>
@endpush
