<div class="modal fade" id="alatModal" tabindex="-1" aria-labelledby="alatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="alatForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="alatFormMethod" value="POST">

                <div class="modal-header bg-light py-3">
                    <h5 class="modal-title fw-bold text-primary" id="alatModalLabel">Tambah Alat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="modal_kode" class="form-label">
                            Kode Alat <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode" id="modal_kode" class="form-control"
                            placeholder="Contoh: DMP-001" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_nama_alat" class="form-label">
                            Nama Alat <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_alat" id="modal_nama_alat" class="form-control"
                            placeholder="Masukkan nama alat" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_kondisi" class="form-label">
                            Kondisi Alat <span class="text-danger">*</span>
                        </label>
                        <select name="kondisi" id="modal_kondisi" class="form-select" required>
                            <option value="baik">Baik</option>
                            <option value="rusak">Perlu Perhatian</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteAlatModal" tabindex="-1" aria-labelledby="deleteAlatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow text-center p-3">
            <form id="deleteAlatForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="mb-3 text-danger">
                    <i class="bi bi-exclamation-circle fs-1"></i>
                </div>

                <h5 class="fw-bold mb-2">Hapus Data?</h5>
                <p class="text-muted small mb-4">Data alat ini akan dihapus secara permanen.</p>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary btn-sm w-50" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm w-50">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const alatModal = new bootstrap.Modal(document.getElementById('alatModal'));
        const deleteAlatModal = new bootstrap.Modal(document.getElementById('deleteAlatModal'));

        function openCreateAlatModal() {
            document.getElementById('alatModalLabel').innerText = 'Tambah Alat';
            document.getElementById('alatForm').action = "{{ route('masterdata.alat.store') }}";
            document.getElementById('alatFormMethod').value = 'POST';

            document.getElementById('modal_kode').value = '';
            document.getElementById('modal_nama_alat').value = '';
            document.getElementById('modal_kondisi').value = 'baik';

            alatModal.show();
        }

        function openEditAlatModal(alat) {
            document.getElementById('alatModalLabel').innerText = 'Edit Alat';
            document.getElementById('alatForm').action = `/masterdata/alat/${alat.id}`;
            document.getElementById('alatFormMethod').value = 'PUT';

            document.getElementById('modal_kode').value = alat.kode;
            document.getElementById('modal_nama_alat').value = alat.nama_alat;
            document.getElementById('modal_kondisi').value = alat.kondisi;

            alatModal.show();
        }

        function openDeleteAlatModal(actionUrl) {
            document.getElementById('deleteAlatForm').action = actionUrl;
            deleteAlatModal.show();
        }
    </script>
@endpush
