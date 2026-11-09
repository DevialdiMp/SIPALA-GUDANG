<div class="modal fade" id="teknisiModal" tabindex="-1" aria-labelledby="teknisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="teknisiForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header bg-light py-3">
                    <h5 class="modal-title fw-bold text-primary" id="teknisiModalLabel">Tambah Teknisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="modal_nama_teknisi" class="form-label">
                            Nama Teknisi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_teknisi" id="modal_nama_teknisi" class="form-control"
                            placeholder="Masukkan nama teknisi" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_no_hp" class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" id="modal_no_hp" class="form-control"
                            placeholder="Masukkan nomor HP">
                    </div>

                    <div class="mb-3">
                        <label for="modal_alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="modal_alamat" rows="3" class="form-control" placeholder="Masukkan alamat teknisi"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="saveButton">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow text-center p-3">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-3 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Data?</h5>
                <p class="text-muted small mb-4">Data teknisi ini akan dihapus secara permanen.</p>
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
        const teknisiModal = new bootstrap.Modal(document.getElementById('teknisiModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        function openCreateModal() {
            document.getElementById('teknisiModalLabel').innerText = 'Tambah Teknisi';
            document.getElementById('teknisiForm').action = "{{ route('masterdata.teknisi.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modal_nama_teknisi').value = '';
            document.getElementById('modal_no_hp').value = '';
            document.getElementById('modal_alamat').value = '';
            teknisiModal.show();
        }

        function openEditModal(teknisi) {
            document.getElementById('teknisiModalLabel').innerText = 'Edit Teknisi';
            document.getElementById('teknisiForm').action = `/masterdata/teknisi/${teknisi.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('modal_nama_teknisi').value = teknisi.nama_teknisi;
            document.getElementById('modal_no_hp').value = teknisi.no_hp ?? '';
            document.getElementById('modal_alamat').value = teknisi.alamat ?? '';
            teknisiModal.show();
        }

        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            deleteModal.show();
        }
    </script>
@endpush
