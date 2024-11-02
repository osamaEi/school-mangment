@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <h1 class="mt-4">Level Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminlevel.index') }}">Levels</a></li>
        <li class="breadcrumb-item active">{{ $level->name }}</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="row">
        <!-- Level Information Card -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Level Information</h5>
                    <button class="btn btn-sm btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editLevelModal{{ $level->id }}">
                        <i class="fas fa-edit me-1"></i>Edit Level
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="small text-muted">Level Name</label>
                        <div class="h5">{{ $level->name }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="small text-muted">Description</label>
                        <div>{{ $level->description ?? 'No description available' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center mb-3">
                                <div class="h4 mb-0">{{ $level->subjects->count() }}</div>
                                <div class="small text-muted">Total Subjects</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mb-3">
                                <div class="h4 mb-0">{{ $level->students->count() }}</div>
                                <div class="small text-muted">Total Students</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Enrolled Students</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($level->students as $student)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $student->getPhotoUrlstudent() }}" 
                                         class="rounded-circle me-2" 
                                         width="40" height="40"
                                         style="object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $student->full_name }}</div>
                                        <div class="small text-muted">
                                            Enrolled: 
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-{{ $student->pivot->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($student->pivot->status) }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                <p class="mb-0">No students enrolled yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Section -->
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Subjects</h5>
                    <button class="btn btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#createSubjectModal">
                        <i class="fas fa-plus me-1"></i>Add Subject
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($level->subjects as $subject)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="card-title mb-0">{{ $subject->name }}</h5>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark p-0" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editSubjectModal{{ $subject->id }}">
                                                            <i class="fas fa-edit me-2"></i>Edit Subject
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#uploadFileModal{{ $subject->id }}">
                                                            <i class="fas fa-upload me-2"></i>Upload File
                                                        </button>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button class="dropdown-item text-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteSubjectModal{{ $subject->id }}">
                                                            <i class="fas fa-trash me-2"></i>Delete Subject
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $subject->description ?? 'No description available' }}</p>
                                        
                                        <!-- Subject Files -->
                                        <div class="mt-3">
                                            <h6 class="mb-2">
                                                <i class="fas fa-file me-1"></i>Files 
                                                <span class="badge bg-secondary">{{ $subject->files->count() }}</span>
                                            </h6>
                                            <div class="list-group list-group-flush">
                                                @foreach($subject->files as $file)
                                                    <div class="list-group-item p-2 d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-file me-2"></i>
                                                            {{ $file->title }}
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="" 
                                                               class="btn btn-outline-primary">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <button type="button" 
                                                                    class="btn btn-outline-danger"
                                                                    onclick="deleteFile({{ $file->id }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-book fa-3x mb-3"></i>
                                    <h5>No Subjects Added Yet</h5>
                                    <p>Click the "Add Subject" button to add your first subject.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals Section -->
@include('backend.levels.modals.edit', ['level' => $level])
@foreach($level->subjects as $subject)
    @include('backend.levels.modals.edit_subject', ['subject' => $subject])
    @include('backend.levels.modals.delete_subject', ['subject' => $subject])
    @include('backend.levels.modals.upload_file', ['subject' => $subject])
@endforeach
@include('backend.levels.modals.create_subject', ['level' => $level])

@push('styles')
<style>
.list-group-item img {
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.dropdown-item {
    cursor: pointer;
}

.dropdown-item i {
    width: 20px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize all tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // File upload preview
    $('input[type="file"]').change(function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
});

function deleteFile(fileId) {
    if (confirm('Are you sure you want to delete this file?')) {
        $.ajax({
            url: `/admin/subject-files/${fileId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection