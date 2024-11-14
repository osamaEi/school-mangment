@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    @include('backend.levels.partials._header')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{__('All Levels')}}</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLevelModal">
                <i class="fas fa-plus me-2"></i>{{__('Add New Level')}}
            </button>
        </div>

        <div class="card-body">
            @include('backend.levels.partials._alerts')
            @include('backend.levels.partials._table')
        </div>
    </div>
</div>

<!-- Modals -->
@include('backend.levels.modals.create')
@foreach($levels as $level)
    @include('backend.levels.modals.edit', ['level' => $level])
    @include('backend.levels.modals.delete', ['level' => $level])
@endforeach
@endsection

@push('styles')
    @include('backend.levels.styles')
@endpush

@push('scripts')
    @include('backend.levels.scripts')
@endpush