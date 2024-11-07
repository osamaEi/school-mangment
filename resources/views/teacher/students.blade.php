@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">My Students</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Students</li>
    </ol>

    <!-- Students by Subject -->
    @foreach($subjects as $subject)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ $subject->name }} - {{ $subject->level->name }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Marks Count</th>
                            <th>Average Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject->level->students as $student)
                        <tr>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->marks_count }}</td>
                            <td>
                                @if($student->average_score)
                                    <span class="badge bg-{{ $student->average_score >= 70 ? 'success' : ($student->average_score >= 50 ? 'warning' : 'danger') }}">
                                        {{ number_format($student->average_score, 1) }}%
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No marks</span>
                                @endif
                            </td>
                            <td>{!! $student->status_badge !!}</td>
                            <td>
                                <button class="btn btn-sm btn-primary add-mark-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addMarkModal"
                                        data-student-id="{{ $student->id }}"
                                        data-student-name="{{ $student->full_name }}"
                                        data-subject-id="{{ $subject->id }}">
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
    @endforeach
</div>

<!-- Add Mark Modal -->
@include('teacher.partials.add-mark-modal')
@endsection