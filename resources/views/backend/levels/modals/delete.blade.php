<div class="modal fade" id="deleteLevelModal{{ $level->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{__('Are you sure you want to delete this level?')}}</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{__('This will also delete:')}}
                    <ul class="mb-0">
                        <li>{{__('All subjects in this level')}}</li>
                        <li>{{__('All related files')}}</li>
                        <li>{{__('All student enrollments')}}</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>{{__('Cancel')}}
                </button>
                <form action="{{ route('Adminlevel.destroy', $level) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>{{__('Delete Level')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>