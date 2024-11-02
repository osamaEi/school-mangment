<div class="modal fade" id="uploadFileModal{{ $subject->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Adminsubject-file.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File *</label>
                        <input type="file" name="file" class="form-control" required>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Allowed files: PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Upload File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>