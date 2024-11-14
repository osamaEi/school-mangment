@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 mb-0">{{__('Welcome')}}, {{ Auth::user()->first_name }}!</h1>
            <p class="text-muted">{{__('Your academic dashboard')}}</p>
        </div>
        <div>
            <span class="badge bg-{{ Auth::user()->status ? 'success' : 'danger' }}">
                {{ Auth::user()->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <!-- Current Level -->
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 text-uppercase">{{__('Current Level')}}</div>
                            <div class="h4 mb-0">
                                {{ $currentLevel ? $currentLevel->name : 'Not Enrolled' }}
                            </div>
                        </div>
                        <i class="fas fa-graduation-cap fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Score -->
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 text-uppercase">{{__('Average Score')}}</div>
                            <div class="h4 mb-0">{{ number_format($averageScore, 1) }}%</div>
                        </div>
                        <i class="fas fa-chart-line fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Subjects -->
        <div class="col-md-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 text-uppercase">{{__('Total Subjects')}}</div>
                            <div class="h4 mb-0">{{ $totalSubjects }}</div>
                        </div>
                        <i class="fas fa-book fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Marks -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Recent Marks')}}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('Score')}}</th>
                                    <th>{{__('Teacher')}}</th>
                                    <th>{{__('Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMarks as $mark)
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
                                        <td colspan="4" class="text-center py-3">{{__('No marks recorded yet')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Subjects -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Current Subjects')}}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($currentSubjects as $subject)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $subject->name }}</h6>
                                        @if($subject->teacher)

                                        <small class="text-muted">
                                            {{__('Teacher')}}: {{ $subject->teacher->first_name }}
                                        </small>

                                        @endif
                                    </div>
                                
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center py-3">
                                {{__('No subjects assigned')}}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this after your current subjects section -->
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
                        @forelse($subjectFiles as $file)
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
</div>

<style>
.card {
    transition: transform 0.2s ease;
    border: none;
}

.card:hover {
    transform: translateY(-5px);
}

.table td {
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.list-group-item {
    border-left: none;
    border-right: none;
}
</style>

@endsection