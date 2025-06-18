<!-- Add Slot Modal -->
<div class="modal fade" id="addSlotModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.slots.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Slot Waktu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Waktu Mulai</label>
                    <input type="time" name="start_time" class="form-control" required>
                    <label>Waktu Selesai</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
