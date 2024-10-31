{{-- resources/views/admin/teachers/show.blade.php --}}
@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Teacher Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminteacher.index') }}">Teachers</a></li>
        <li class="breadcrumb-item active">Teacher Details</li>
    </ol>

    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Personal Information
                </div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->first_name . ' ' . $teacher->last_name) }}&size=200&background=random" 
                         class="rounded-circle mb-3" width="150">
                    <h4>{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                    <p class="text-muted">Teacher</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="mailto:{{ $teacher->email }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Send Email
                        </a>
                        <a href="tel:{{ $teacher->phone }}" class="btn btn-info btn-sm">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Detailed Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->first_name }} {{ $teacher->last_name }} {{ $teacher->family_name }} {{ $teacher->family_name2 }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->phone }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Country</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->country }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Date of Birth</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->dob }} ({{ $teacher->age }} years old)
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit Teacher
                            </a>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>Delete Teacher
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-book me-1"></i>
                    Assigned Subjects
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Level</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this teacher? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection