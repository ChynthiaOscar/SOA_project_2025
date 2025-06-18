<!-- Delete Slot Modal -->
<div class="modal fade" id="deleteSlotModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.slots.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Slot Waktu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Pilih Slot Waktu</label>
                    <select name="slot_id" class="form-control" required>
                        @foreach ($slots as $slot)
                            <option value="{{ $slot->id }}">
                                {{ $slot->start_time }} - {{ $slot->end_time }}
                            </option>
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
