@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Teachers Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">Teachers</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-chalkboard-teacher me-1"></i>
                Teachers List
            </div>
            <a href="{{ route('Adminteacher.create') }}" class="btn btn-primary" style="  margin-left: 605px;">
                <i class="fas fa-plus me-2"></i>Add New Teacher
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <table id="teachersTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th width="40%">Teacher Information</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Subjects</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $teacher->getPhotoUrlteacher() }}" 
                                     alt="{{ $teacher->full_name }}"
                                     class="rounded-circle me-3" 
                                     width="60" height="60"
                                     style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                                    <div class="text-muted">{{ $teacher->family_name }} {{ $teacher->family_name2 }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Joined {{ $teacher->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div><i class="fas fa-envelope me-2"></i>{{ $teacher->email }}</div>
                            <div><i class="fas fa-phone me-2"></i>{{ $teacher->phone }}</div>
                            <div><i class="fas fa-map-marker-alt me-2"></i>{{ $teacher->country }}</div>
                        </td>
                        <td>
                            {!! $teacher->status_badge !!}
                            <div class="small text-muted mt-1">
                                @if($teacher->status)
                                    <i class="fas fa-check-circle text-success"></i> Teaching
                                @else
                                    <i class="fas fa-pause-circle text-danger"></i> On Leave
                                @endif
                            </div>
                        </td>
                        <td>
                            @forelse($teacher->teachingSubjects as $subject)
                                <span class="badge bg-info me-1">{{ $subject->name }}</span>
                            @empty
                                <span class="text-muted">No subjects assigned</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('Adminteacher.show', $teacher) }}" 
                                   class="btn btn-info btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('Adminteacher.edit', $teacher) }}" 
                                   class="btn btn-warning btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $teacher->id }}"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $teachers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@foreach($teachers as $teacher)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $teacher->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="{{ $teacher->photo_url }}" 
                         alt="{{ $teacher->full_name }}"
                         class="rounded-circle" 
                         width="100" height="100"
                         style="object-fit: cover;">
                </div>
                <p>Are you sure you want to delete teacher <strong>{{ $teacher->full_name }}</strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('Adminteacher.destroy', $teacher) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- At the end of your layout file body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@push('styles')
<style>
    .table img {
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#teachersTable').DataTable({
            "pageLength": 10,
            "order": [[0, "asc"]],
            "language": {
                "search": "Quick search:",
                "searchPlaceholder": "Name, email, country..."
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
@endsection