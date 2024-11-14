@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('Teacher Dashboard')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
    </ol>

    <!-- Basic Info Card -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-circle me-1"></i>
                    {{__('Teacher Profile')}}
                </div>
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->getPhotoUrlteacher() }}" 
                         class="rounded-circle mb-3" 
                         width="150" height="150">
                    <h5>{{ Auth::user()->full_name }}</h5>
                    <p class="text-muted">
                        {{__('Teaching')}} {{ $subjects_count }} Subjects')}}
                    </p>
                </div>
            </div>
        </div>

        <!-- Subjects List -->
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-book me-1"></i>
                    {{__('My Subjects')}}
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($subjects as $subject)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $subject->name }}</h6>
                                        <small class="text-muted">Level: {{ $subject->level->name }}</small>
                                    </div>
                                    <a href="{{route('teacher.subject.show',$subject->id)}}" class="btn btn-sm btn-primary">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Marks -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-star me-1"></i>
            {{__('Recent Marks Given')}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('Student')}}</th>
                            <th>{{__('Subject')}}</th>
                            <th>{{__('Mark')}}</th>
                            <th>{{__('Date')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_marks as $mark)
                            <tr>
                                <td>{{ $mark->student->full_name }}</td>
                                <td>{{ $mark->subject->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $mark->score >= 70 ? 'success' : ($mark->score >= 50 ? 'warning' : 'danger') }}">
                                        {{ $mark->score }}%
                                    </span>
                                </td>
                                <td>{{ $mark->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('teacher.showStudents')}}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-plus-circle me-2"></i>{{__('Add Mark')}}
                    </a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{route('teacher.showStudents')}}" class="btn btn-info w-100 mb-2 text-white">
                        <i class="fas fa-users me-2"></i>{{__('View Students')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    margin-bottom: 1.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection
