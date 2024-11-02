<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Level Name</th>
                <th>Description</th>
                <th>Subjects</th>
                <th>Students</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($levels as $level)
                <tr>
                    <td>{{ $level->name }}</td>
                    <td>{{ $level->description }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ $level->subjects->count() }} Subjects
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $level->students->count() }} Students
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('Adminlevel.show', $level) }}" 
                               class="btn btn-sm btn-info text-white"
                               title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editLevelModal{{ $level->id }}"
                                    title="Edit Level">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteLevelModal{{ $level->id }}"
                                    title="Delete Level">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>No levels found
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $levels->links() }}
</div>
