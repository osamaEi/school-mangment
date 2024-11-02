<div class="modal fade" id="createSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Adminsubject.store') }}" method="POST">
                @csrf
                <input type="hidden" name="level_id" value="{{ $level->id }}">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>