@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('My Students')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item active">{{__('Students')}}</li>
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
                            <th>{{__('Student')}}</th>
                            <th>{{__('Marks Count')}}</th>
                            <th>{{__('Average Score')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject->level->students as $student)
                        <tr>
                            <td>{{ $student->full_name }}</td>


                            <td>
                                @if($student->studentMarks)

                                {{ $student->studentMarks->score }}
                            @else 
                            {{__('Not yet')}}
                            @endif
                            </td>
                            <td>
                                @if($student->average_score)
                                    <span class="badge bg-{{ $student->average_score >= 12 ? 'success' : 'danger' }}">
                                        {{ number_format($student->average_score, 1) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{__('No marks')}}</span>
                                @endif
                            </td>
                            <td>{!! $student->status_badge !!}</td>
                            <td>
                                @if(!$student->studentMarks)
                                <button class="btn btn-sm btn-primary add-mark-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addMarkModal"
                                        data-student-id="{{ $student->id }}"
                                        data-student-name="{{ $student->full_name }}">
                                    <i class="fas fa-plus"></i> {{__('Add Mark')}}
                                </button>
                                @endif
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

@push('scripts')
<script>
$(document).ready(function() {
    // Handle Add Mark Modal
    $('.add-mark-btn').click(function() {
        const studentId = $(this).data('student-id');
        const studentName = $(this).data('student-name');
        
        $('#studentId').val(studentId);
        $('#studentName').text(studentName);
        $('#addMarkForm').attr('action', `/teacher/marks/${studentId}/store`);
    });
});
</script>
@endpush
@endsection