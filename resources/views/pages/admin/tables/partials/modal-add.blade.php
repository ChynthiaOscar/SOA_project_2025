<!-- Add Table Modal -->
<div class="modal fade" id="addTableModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nomor Meja</label>
                    <input type="number" name="number" class="form-control" required>
                    <label>Jumlah Kursi</label>
                    <input type="number" name="seat_count" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
