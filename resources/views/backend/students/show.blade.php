@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminstudent.index') }}">Students</a></li>
        <li class="breadcrumb-item active">Student Details</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Student Profile Card -->
        <div class="col-12 col-md-4 col-lg-4"> 
            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-user-graduate me-1"></i>
                        Student Profile
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                               {{ $student->status ? 'checked' : '' }}
                               data-student-id="{{ $student->id }}">
                        <label class="form-check-label">
                            <span class="badge bg-{{ $student->status ? 'success' : 'danger' }}">
                                {{ $student->status ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $student->getPhotoUrlstudent() }}" 
                             class="rounded-circle mb-3" 
                             width="150" height="150"
                             style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0"
                                data-bs-toggle="modal" 
                                data-bs-target="#uploadPhotoModal">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h4>{{ $student->full_name }}</h4>
                    <p class="text-muted mb-4">
                        <i class="fas fa-id-card me-2"></i>Student ID: {{ $student->id }}
                    </p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <a href="mailto:{{ $student->email }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-envelope me-1"></i>Email
                        </a>
                        <a href="tel:{{ $student->phone }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                        <a href="{{ route('Adminstudent.edit', $student) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                    </div>

                    <div class="border-top pt-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center mb-3">
                                    <div class="fw-bold h4 mb-0">{{ $student->studentMarks->count() }}</div>
                                    <div class="small text-muted">Marks</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center mb-3">
                                    <div class="fw-bold h4 mb-0">{{ number_format($averageScore, 1) }}%</div>
                                    <div class="small text-muted">Average</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center mb-3">
                                    <div class="fw-bold h4 mb-0">{{ $student->studentLevels->count() }}</div>
                                    <div class="small text-muted">Levels</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-address-card me-1"></i>
                    Contact Information
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="small text-muted">Email</div>
                            <div>{{ $student->email }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">Phone</div>
                            <div>{{ $student->phone }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">Country</div>
                            <div>{{ $student->country }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">Date of Birth</div>
                            <div>{{ $student->dob }} ({{ $student->age }} years)</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">Joined Date</div>
                            <div>{{ $student->created_at }}</div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="col-12 col-md-8 col-lg-8">
            
            <!-- Current Level Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-graduation-cap me-1"></i>
                        Current Level
                    </div>
                    <button class="btn btn-sm btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#changeLevelModal">
                        <i class="fas fa-exchange-alt me-1"></i>Change Level
                    </button>
                </div>
                <div class="card-body">
                    @if($currentLevel = $student->currentLevel())
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-1">{{ $currentLevel->name }}</h5>
                                <p class="text-muted mb-0">
                                    Enrolled: {{ $currentLevel->pivot->enrolled_at }}
                                </p>
                            </div>
                       
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted mb-3">
                                <i class="fas fa-exclamation-circle fa-3x"></i>
                            </div>
                            <h6>No Active Level</h6>
                            <p class="text-muted">This student is not currently enrolled in any level.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Academic Performance Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Academic Performance
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" height="200"></canvas>
                </div>
            </div>

            <!-- Recent Marks Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-star me-1"></i>
                    Recent Marks
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Score</th>
                                    <th>Teacher</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marks as $mark)
                                    <tr>
                                        <td>{{ $mark->subject->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $mark->score >= 70 ? 'success' : ($mark->score >= 50 ? 'warning' : 'danger') }}">
                                                {{ $mark->score }}%
                                            </span>
                                        </td>
                                        <td>{{ $mark->teacher->full_name }}</td>
                                        <td>{{ $mark->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="text-muted">No marks recorded yet</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $marks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Level Modal -->
<div class="modal fade" id="changeLevelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Student Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Adminstudent.change-level', $student) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select New Level</label>
                        <select name="level_id" class="form-select" required>
                            <option value="">Choose a level...</option>
                            @foreach(App\Models\Level::all() as $level)
                                <option value="{{ $level->id }}"
                                    {{ $student->currentLevel()?->id == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($student->currentLevel())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This will mark the current level ({{ $student->currentLevel()->name }}) as completed.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Change Level
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadPhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Adminstudent.update-photo', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body text-center">
                    <img id="photoPreview" 
                         src="{{ $student->photo ? Storage::url($student->photo) : asset('images/default-user.png') }}" 
                         class="rounded-circle mb-3" 
                         width="150" height="150"
                         style="object-fit: cover;">
                    <div class="mb-3">
                        <label class="form-label">Choose New Photo</label>
                        <input type="file" class="form-control" name="photo" 
                               accept="image/*" required 
                               onchange="previewImage(this)">
                        <div class="form-text">Maximum file size: 2MB</div>
                    </div>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- At the end of your layout file body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialize performance chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const marksData = @json($student->studentMarks()
        ->with('subject')
        ->latest()
        ->take(10)
        ->get()
        ->reverse()
        ->map(fn($mark) => [
            'date' => $mark->created_at->format('M d'),
            'score' => $mark->score,
            'subject' => $mark->subject->name
        ]));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: marksData.map(mark => `${mark.subject} (${mark.date})`),
            datasets: [{
                label: 'Score',
                data: marksData.map(mark => mark.score),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Score: ${context.raw}%`;
                        }
                    }
                }
            }
        }
    });

    // Handle status toggle
    $('.form-check-input').change(function() {
        const studentId = $(this).data('student-id');
        const isActive = this.checked;
        const statusBadge = $(this).siblings('label').find('.badge');

        $.ajax({
            url: `/admin/students/${studentId}/toggle-status`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                statusBadge
                    .removeClass('bg-success bg-danger')
                    .addClass(isActive ? 'bg-success' : 'bg-danger')
                    .text(isActive ? 'Active' : 'Inactive');
                
                toastr.success('Status updated successfully');
            },
            error: function() {
                toastr.error('Failed to update status');
                $(this).prop('checked', !isActive);
            }
        });
    });
});

// Photo preview function
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            $('#photoPreview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
@endpush
@endsection