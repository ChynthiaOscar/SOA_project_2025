<!-- Delete Table Modal -->
<div class="modal fade" id="deleteTableModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.tables.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Pilih Nomor Meja</label>
                    <select name="number" class="form-control" required>
                        @foreach ($tables as $table)
                            <option value="{{ $table->number }}">Meja {{ $table->number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
