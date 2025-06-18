<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.reservation.reject', $reservation->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectLabel">Tolak Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menolak reservasi ini?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
