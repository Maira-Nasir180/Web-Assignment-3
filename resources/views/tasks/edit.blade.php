@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0 text-secondary">Edit Task</h1>
                <a href="{{ route('home', ['status' => $listStatus]) }}" class="btn btn-outline-secondary btn-sm">Back to list</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('tasks.update', $task) }}" method="post" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="list_status" value="{{ $listStatus }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                                   class="form-control @error('title') is-invalid @enderror" required maxlength="255">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date"
                                       value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                                       class="form-control @error('due_date') is-invalid @enderror" required>
                                @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="priority" class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
                                    <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                                    <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                                </select>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" @selected(old('status', $task->status) === 'pending')>Pending</option>
                                    <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Task</button>
                            <a href="{{ route('home', ['status' => $listStatus]) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
