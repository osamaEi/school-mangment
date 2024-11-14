<div class="modal fade" id="editSubjectModal{{ $subject->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>{{__('Edit Subject')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Adminsubject.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{__('Subject Name')}} *</label>
                        <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Description')}}</label>
                        <textarea name="description" class="form-control" rows="3">{{ $subject->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>{{__('Cancel')}}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>{{__('Update Subject')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>