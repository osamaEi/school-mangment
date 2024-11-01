@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Teacher Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminteacher.index') }}">Teachers</a></li>
        <li class="breadcrumb-item active">Teacher Details</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4">
            <!-- Profile Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-user-circle me-1"></i>
                        Profile Information
                    </div>
                    @if($teacher->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $teacher->getPhotoUrlteacher() }}" 
                             alt="{{ $teacher->full_name }}"
                             class="rounded-circle mb-3" 
                             width="150" height="150"
                             style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    </div>
                    <h4>{{ $teacher->full_name }}</h4>
                    <p class="text-muted">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Teacher
                    </p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <a href="mailto:{{ $teacher->email }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Email
                        </a>
                        <a href="tel:{{ $teacher->phone }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                    </div>

                    <div class="border-top pt-4">
                        <div class="row text-center">
                            <div class="col">
                                <h5>{{ $teacher->teachingSubjects->count() }}</h5>
                                <small class="text-muted">Subjects</small>
                            </div>
                            <div class="col">
                                <h5>{{ $teacher->marks->count() }}</h5>
                                <small class="text-muted">Marks Given</small>
                            </div>
                            <div class="col">
                                <h5>{{ $teacher->created_at->diffInMonths() }}</h5>
                                <small class="text-muted">Months Active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('Adminteacher.edit', $teacher) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Teacher
                        </button>
                        <button class="btn btn-{{ $teacher->status ? 'danger' : 'success' }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#statusModal">
                            <i class="fas fa-{{ $teacher->status ? 'ban' : 'check' }} me-2"></i>
                            {{ $teacher->status ? 'Deactivate' : 'Activate' }} Teacher
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <!-- Detailed Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->first_name }} {{ $teacher->last_name }} 
                            {{ $teacher->family_name }} {{ $teacher->family_name2 }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <a href="tel:{{ $teacher->phone }}">{{ $teacher->phone }}</a>
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
                            {{ $teacher->dob->format('F j, Y') }} ({{ $teacher->age }} years old)
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Joined Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $teacher->created_at->format('F j, Y') }}
                            <small class="text-muted">({{ $teacher->created_at->diffForHumans() }})</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teaching Subjects -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-book me-1"></i>
                        Teaching Subjects
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignSubjectModal">
                        <i class="fas fa-plus me-1"></i>Assign Subject
                    </button>
                </div>
                <div class="card-body">
                    @if($teacher->teachingSubjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Level</th>
                                        <th>Students</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teacher->teachingSubjects as $subject)
                                        <tr>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->level->name }}</td>
                                            <td>{{ $subject->students->count() }} students</td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#removeSubjectModal{{ $subject->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted mb-3">
                                <i class="fas fa-book-open fa-3x"></i>
                            </div>
                            <h6>No Subjects Assigned Yet</h6>
                            <p class="text-muted">Click the "Assign Subject" button to add subjects.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Recent Activity
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($teacher->marks()->latest()->take(5)->get() as $mark)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="text-muted small">{{ $mark->created_at->diffForHumans() }}</div>
                                    <div>Added mark for <strong>{{ $mark->student->full_name }}</strong></div>
                                    <div class="text-muted">Subject: {{ $mark->subject->name }}</div>
                                </div>
                            </div>
                        @endforeach
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
            <div class="modal-body text-center">
                <img src="{{ $teacher->photo_url }}" 
                     alt="{{ $teacher->full_name }}"
                     class="rounded-circle mb-3" 
                     width="100" height="100"
                     style="object-fit: cover;">
                <h5>Delete Teacher Account</h5>
                <p>Are you sure you want to delete {{ $teacher->full_name }}'s account?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('Adminteacher.destroy', $teacher) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Teacher
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $teacher->status ? 'Deactivate' : 'Activate' }} Teacher Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to {{ $teacher->status ? 'deactivate' : 'activate' }} 
                   {{ $teacher->full_name }}'s account?</p>
                @if($teacher->status)
                    <p class="text-danger">This will temporarily suspend the teacher's access to the system.</p>
                @else
                    <p class="text-success">This will restore the teacher's access to the system.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('teachers.toggle-status', $teacher) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $teacher->status ? 'danger' : 'success' }}">
                        <i class="fas fa-{{ $teacher->status ? 'ban' : 'check' }} me-1"></i>
                        {{ $teacher->status ? 'Deactivate' : 'Activate' }} Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    
    .timeline-item {
        padding: 15px 0;
        border-left: 2px solid #e9ecef;
        margin-left: 20px;
        position: relative;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 20px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #007bff;
        border: 2px solid #fff;
    }
    
    .timeline-content {
        margin-left: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Photo preview functionality
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#photoPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photoInput").change(function() {
            readURL(this);
        });

        // Activity timeline animation
        $('.timeline-item').each(function(index) {
            $(this).delay(200 * index).animate({
                opacity: 1,
                left: 0
            }, 500);
        });

        // Charts initialization (if you want to add statistics)
        if($('#marksChart').length > 0) {
            var ctx = document.getElementById('marksChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($marksData->pluck('month')),
                    datasets: [{
                        label: 'Marks Given',
                        data: @json($marksData->pluck('count')),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }
    });

    // Status toggle confirmation
    $('.toggle-status').click(function(e) {
        e.preventDefault();
        const statusText = $(this).data('status') ? 'deactivate' : 'activate';
        if(confirm(`Are you sure you want to ${statusText} this teacher?`)) {
            $(this).closest('form').submit();
        }
    });
</script>
@endpush

<!-- Assign Subject Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('teachers.assign-subject', $teacher) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Subject</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">Choose a subject...</option>
                            @foreach($availableSubjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->name }} ({{ $subject->level->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Assign Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('teachers.update-photo', $teacher) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body text-center">
                    <img id="photoPreview" src="{{ $teacher->photo_url }}" 
                         class="rounded-circle mb-3" 
                         width="150" height="150"
                         style="object-fit: cover;">
                    <div class="mb-3">
                        <label class="form-label">Choose New Photo</label>
                        <input type="file" class="form-control" id="photoInput" name="photo" 
                               accept="image/*" required>
                    </div>
                    <small class="text-muted">Recommended size: 300x300 pixels</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Update Photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- In your layout file head -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- At the end of your layout file body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@push('styles')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    
    .timeline-item {
        padding: 15px 0;
        border-left: 2px solid #e9ecef;
        margin-left: 20px;
        position: relative;
        opacity: 0;
        left: -20px;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 20px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #007bff;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .timeline-content {
        margin-left: 20px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .profile-photo {
        position: relative;
        display: inline-block;
    }

    .profile-photo .change-photo {
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(0,0,0,0.5);
        color: white;
        padding: 5px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-photo:hover .change-photo {
        transform: scale(1.1);
    }

    .stats-card {
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    .activity-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .activity-indicator.online {
        background-color: #28a745;
    }

    .activity-indicator.offline {
        background-color: #dc3545;
    }
</style>
@endpush
@endsection