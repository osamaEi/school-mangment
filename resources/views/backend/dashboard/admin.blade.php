{{-- resources/views/backend/dashboard/index.blade.php --}}
@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{__('Dashboard')}}</h1>
        <button class="btn btn-primary btn-sm" onclick="window.print()">
            <i class="fas fa-print me-2"></i>{{__('Print Report')}}
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{__('Students')}}</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $counts['students'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('Teachers')}}</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $counts['teachers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Levels Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{__('Levels')}}</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $counts['levels'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{__('Subjects')}}</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $counts['subjects'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Level Stats -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Level Statistics')}}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('Level')}}</th>
                                    <th>{{__('Students')}}</th>
                                    <th>{{__('Subjects')}}</th>
                                    <th>{{__('Progress')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($levelStats as $stat)
                                <tr>
                                    <td>{{ $stat['name'] }}</td>
                                    <td>{{ $stat['students'] }}</td>
                                    <td>{{ $stat['subjects'] }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $percentage = $counts['students'] ? 
                                                    ($stat['students'] / $counts['students'] * 100) : 0;
                                            @endphp
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $percentage }}%"
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('Recent Activity')}}</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($recentActivity as $activity)
                            <div class="timeline-item">
                                <div class="timeline-icon bg-{{ $activity['color'] }}">
                                    <i class="fas fa-{{ $activity['icon'] }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-0">{{ $activity['name'] }}</h6>
                                    <small class="text-muted">{{ $activity['type'] }} • {{ $activity['date'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: transform .2s;
}

.card:hover {
    transform: translateY(-5px);
}

.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}

.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}

.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}

.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}

.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    padding: 10px 0;
    position: relative;
    display: flex;
    align-items: center;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 15px;
}

.progress {
    height: 20px;
    border-radius: 10px;
}

.progress-bar {
    background-color: #4e73df;
    border-radius: 10px;
}

@media print {
    .btn-print {
        display: none;
    }
}
</style>
@endpush
@endsection
