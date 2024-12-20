@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <h1 class="mt-4">{{__('Level Details')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminlevel.index') }}">{{__('Levels')}}</a></li>
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
                    <h5 class="mb-0">{{__('Level Information')}}</h5>
                    <button class="btn btn-sm btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editLevelModal{{ $level->id }}">
                        <i class="fas fa-edit me-1"></i>{{__('Edit Level')}}
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="small text-muted">{{__('Level Name')}}</label>
                        <div class="h5">{{ $level->name }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="small text-muted">{{__('Description')}}</label>
                        <div>{{ $level->description ?? 'No description available' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center mb-3">
                                <div class="h4 mb-0">{{ $level->subjects->count() }}</div>
                                <div class="small text-muted">{{__('Total Subjects')}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mb-3">
                                <div class="h4 mb-0">{{ $level->students->count() }}</div>
                                <div class="small text-muted">{{__('Total Students')}}</div>
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
                                            {{__('Enrolled')}}: 
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
                                <p class="mb-0">{{__('No students enrolled yet')}}</p>
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
                        <i class="fas fa-plus me-1"></i>{{__('Add Subject')}}
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
                                                            <i class="fas fa-edit me-2"></i>{{__('Edit Subject')}}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#uploadFileModal{{ $subject->id }}">
                                                            <i class="fas fa-upload me-2"></i>{{__('Upload File')}}
                                                        </button>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button class="dropdown-item text-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteSubjectModal{{ $subject->id }}">
                                                            <i class="fas fa-trash me-2"></i>{{__('Delete Subject')}}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $subject->description ?? 'No description available' }}</p>
                                        
                                        <!-- Subject Files -->
                                   <!-- Subject Files -->
<div class="mt-3">
    <h6 class="mb-2">
        <i class="fas fa-file me-1"></i>Files 
        <span class="badge bg-secondary">{{ $subject->files->count() }}</span>
    </h6>
    <div class="list-group list-group-flush">
        @foreach($subject->files as $file)
            <div class="list-group-item p-2 d-flex justify-content-between align-items-center" id="file-{{ $file->id }}">
                <div>
                    @php
                        $extension = pathinfo($file->file_path, PATHINFO_EXTENSION);
                        $iconClass = match(strtolower($extension)) {
                            'pdf' => 'fa-file-pdf text-danger',
                            'doc', 'docx' => 'fa-file-word text-primary',
                            'xls', 'xlsx' => 'fa-file-excel text-success',
                            'ppt', 'pptx' => 'fa-file-powerpoint text-warning',
                            default => 'fa-file text-secondary'
                        };
                    @endphp
                    <i class="fas {{ $iconClass }} me-2"></i>
                    {{ $file->title }}
                </div>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.subject.file.download', $file->id) }}" 
                       class="btn btn-outline-primary"
                       title="Download">
                        <i class="fas fa-download"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-outline-danger"
                            onclick="deleteFile({{ $file->id }})"
                            title="Delete">
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
                                    <h5>{{__('No Subjects Added Yet')}}</h5>
                                    <p>{{__('Click the "Add Subject" button to add your first subject.')}}</p>
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

<script>
function deleteFile(fileId) {
    if (confirm('Are you sure you want to delete this file?')) {
        $.ajax({
            url: `/admin/subject-files/${fileId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                // Remove the file element from DOM
                $(`#file-${fileId}`).fadeOut(300, function() {
                    $(this).remove();
                    // Update the file count badge
                    let badge = $(this).closest('.card').find('.badge');
                    let count = parseInt(badge.text()) - 1;
                    badge.text(count);
                });
                
                // Show success message
                toastr.success('File deleted successfully');
            },
            error: function() {
                toastr.error('Failed to delete file');
            }
        });
    }
}

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // File upload preview
    $('input[type="file"]').change(function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.form-text').html(`Selected file: ${fileName}`);
    });
});
</script>

<style>
/* Add animation for file deletion */
.list-group-item {
    transition: all 0.3s ease;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
}

/* File type icons */
.fa-file-pdf { color: #dc3545; }
.fa-file-word { color: #0d6efd; }
.fa-file-excel { color: #198754; }
.fa-file-powerpoint { color: #fd7e14; }
</style>
@endsection