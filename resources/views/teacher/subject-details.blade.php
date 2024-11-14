@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('Subject Details')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item active">{{ $subject->name }}</li>
    </ol>

    <!-- Subject Info Card -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $subject->name }}</h5>
            <span class="badge bg-primary">Level: {{ $subject->level->name }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <div class="h2 mb-0">{{ $students->count() }}</div>
                    <div class="text-muted">Total Students')}}</div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="h2 mb-0">{{ $marks->count() }}</div>
                    <div class="text-muted">{{__('Total Marks Given')}}</div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="h2 mb-0">{{ number_format($marks->avg('score'), 1) }}%</div>
                    <div class="text-muted">{{__('Average Score')}}</div>
                </div>
            </div>
        </div>
    </div>


        <div class="col-12 mt-4">
            <div class="card shadow-sm">
                
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Subject Files')}}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('File Title')}}</th>
                                    <th>{{__('Uploaded By')}}</th>
                                    <th>{{__('Upload Date')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subject->files as $file)
                                    <tr>
                                        <td>{{ $file->subject->name }}</td>
                                        <td>{{ $file->title }}</td>
                                        <td>{{ $file->uploader->first_name }}</td>
                                        <td>{{ $file->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('student.download.file', $file->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-download me-1"></i>{{__('Download')}}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">
                                            {{__('No files available')}}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Students List -->
  
</div>

<!-- Add Mark Modal -->
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

@push('scripts')
<script>
$(document).ready(function() {
    // Handle Add Mark Modal
    $('.add-mark-btn').click(function() {
        const studentId = $(this).data('student-id');
        const studentName = $(this).data('student-name');
        
        $('#studentId').val(studentId);
        $('#studentName').text(studentName);
        $('#addMarkForm').attr('action', `/teacher/marks/${studentId}/store`);
    });
});
</script>
@endpush
@endsection