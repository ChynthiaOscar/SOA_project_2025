<!-- Edit Table Modal -->
<div class="modal fade" id="editTableModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.tables.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Pilih Nomor Meja</label>
                    <select name="number" class="form-control" required>
                        @foreach ($tables as $table)
                            <option value="{{ $table->number }}">Meja {{ $table->number }}</option>
                        @endforeach
                    </select>
                    <label>Jumlah Kursi</label>
                    <input type="number" name="seat_count" class="form-control" required>
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1">Tersedia</option>
                        <option value="0">Tidak Tersedia</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>
