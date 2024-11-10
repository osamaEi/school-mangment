{{-- resources/views/backend/students/index.blade.php --}}
@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Students Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">Students</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                Students List
            </div>
            <a href="{{ route('Adminstudent.create') }}" class="btn btn-primary" style="margin-left:600px;">
                <i class="fas fa-plus me-2"></i>Add New Student
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <table id="studentsTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Student Information</th>
                        <th>Current Level</th>
                        <th>Performance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $student->getPhotoUrlstudent() }}" 
                                     alt="{{ $student->full_name }}"
                                     class="rounded-circle me-3" 
                                     width="50" height="50"
                                     style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold">{{ $student->first_name }} {{ $student->last_name }}</div>
                                    <div class="text-muted small">{{ $student->email }}</div>
                                    <div class="text-muted small">
                                        <i class="fas fa-phone me-1"></i>{{ $student->phone }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($currentLevel = $student->currentLevel())
                                <span class="badge bg-primary">{{ $currentLevel->name }}</span>
                                <div class="text-muted small">
                                    Since {{ $currentLevel->pivot->enrolled_at }}
                                </div>
                            @else
                                <span class="badge bg-secondary">No Active Level</span>
                            @endif
                        </td>
                        <td>

                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" 
                                       type="checkbox" 
                                       {{ $student->status ? 'checked' : '' }}
                                       data-student-id="{{ $student->id }}">
                                <label class="form-check-label">
                                    {{ $student->status ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('Adminstudent.show', $student) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('Adminstudent.edit', $student) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $student->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@foreach($students as $student)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
<!-- Continuing from previous index.blade.php -->
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
    <img src="{{ $student->photo ? Storage::url($student->photo) : asset('images/default-user.png') }}" 
         class="rounded-circle mb-3" width="100" height="100"
         style="object-fit: cover;">
    <h5>Delete Student Account</h5>
    <p>Are you sure you want to delete {{ $student->full_name }}'s account?</p>
    <div class="text-muted small mb-3">
        <div>Current Level: {{ $student->currentLevel()?->name ?? 'None' }}</div>
        <div>Marks Recorded: {{ $student->marks->count() }}</div>
    </div>
    <p class="text-danger"><small>This action cannot be undone. All associated data will be permanently deleted.</small></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <form action="{{ route('Adminstudent.destroy', $student) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-1"></i>Delete Student
        </button>
    </form>
</div>
</div>
</div>
</div>
@endforeach
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
<script>
$(document).ready(function() {
// Initialize DataTable
$('#studentsTable').DataTable({
"pageLength": 10,
"order": [[0, "asc"]]
});

// Handle status toggle
$('.status-toggle').change(function() {
const studentId = $(this).data('student-id');
const statusLabel = $(this).next('label');
const isActive = this.checked;

fetch(`/admin/students/${studentId}/toggle-status`, {
method: 'POST',
headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
}
})
.then(response => response.json())
.then(data => {
statusLabel.text(isActive ? 'Active' : 'Inactive');
toastr.success(data.message);
})
.catch(error => {
toastr.error('Failed to update status');
this.checked = !isActive; // Revert the toggle
});
});
});
</script>
@endpush
@endsection