<div class="modal fade" id="deleteSubjectModal{{$subject->id  }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Delete Level')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{__('Are you sure you want to delete this File?')}}</p>
       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>{{__('Cancel')}}
                </button>
                <form action="{{ route('Adminsubject.destroy',$subject->id ) }}" method="POST">
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