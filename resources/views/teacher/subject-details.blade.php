@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Subject Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
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
                    <div class="text-muted">Total Students</div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="h2 mb-0">{{ $marks->count() }}</div>
                    <div class="text-muted">Total Marks Given</div>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <div class="h2 mb-0">{{ number_format($marks->avg('score'), 1) }}%</div>
                    <div class="text-muted">Average Score</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Students Enrolled
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Latest Mark</th>
                            <th>Average</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                <td>
                                    @if($student->latestMark)
                                        <span class="badge bg-{{ $student->latestMark->score >= 70 ? 'success' : ($student->latestMark->score >= 50 ? 'warning' : 'danger') }}">
                                            {{ $student->latestMark->score }}%
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">No marks yet</span>
                                    @endif
                                </td>
                                <td>{{ number_format($student->marks_average, 1) }}%</td>
                                <td>
                                    <button class="btn btn-sm btn-primary add-mark-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addMarkModal"
                                            data-student-id="{{ $student->id }}"
                                            data-student-name="{{ $student->full_name }}">
                                        <i class="fas fa-plus"></i> Add Mark
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Mark Modal -->
<div class="modal fade" id="addMarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Mark for <span id="studentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addMarkForm" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="studentId">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Score *</label>
                        <input type="number" name="score" class="form-control" required min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Mark</button>
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