<div class="modal fade" id="addMarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Add Mark for')}} <span id="studentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addMarkForm" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="studentId">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{__('Score')}} *</label>
                        <input type="number" name="score" class="form-control" required min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Remarks')}}</label>
                        <textarea name="remarks" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save Mark')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>