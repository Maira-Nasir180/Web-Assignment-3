@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <h1 class="h3 mb-0 text-secondary">My Tasks</h1>
        <a href="{{ route('tasks.create', ['status' => $filter]) }}" class="btn btn-primary">Add Task</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="btn-group flex-wrap" role="group" aria-label="Filter by status">
                <a href="{{ route('home', ['status' => 'all']) }}"
                   class="btn btn-outline-primary {{ $filter === 'all' ? 'active' : '' }}">All</a>
                <a href="{{ route('home', ['status' => 'pending']) }}"
                   class="btn btn-outline-primary {{ $filter === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('home', ['status' => 'completed']) }}"
                   class="btn btn-outline-primary {{ $filter === 'completed' ? 'active' : '' }}">Completed</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end" style="min-width: 220px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td class="fw-medium">{{ $task->title }}</td>
                            <td class="text-secondary small">{{ $task->description ? \Illuminate\Support\Str::limit($task->description, 80) : '—' }}</td>
                            <td>{{ $task->due_date->format('M j, Y') }}</td>
                            <td>
                                @php
                                    $priorityBadge = match ($task->priority) {
                                        'high' => 'bg-danger',
                                        'medium' => 'bg-warning text-dark',
                                        'low' => 'bg-secondary',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $priorityBadge }}">{{ ucfirst($task->priority) }}</span>
                            </td>
                            <td>
                                @if($task->status === 'completed')
                                    <span class="badge bg-success rounded-pill">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex flex-wrap justify-content-end gap-1">
                                    <a href="{{ route('tasks.edit', ['task' => $task, 'status' => $filter]) }}"
                                       class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @if($task->isPending())
                                        <form action="{{ route('tasks.complete', $task) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="list_status" value="{{ $filter }}">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Mark Complete</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('tasks.destroy', $task) }}" method="post"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="list_status" value="{{ $filter }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-5">No tasks found for this filter.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
