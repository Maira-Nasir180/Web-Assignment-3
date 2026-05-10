<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filter = $request->query('status', 'all');
        if (! in_array($filter, ['all', 'pending', 'completed'], true)) {
            $filter = 'all';
        }

        $query = Task::query()
            ->orderBy('due_date')
            ->orderByDesc('id');

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'completed') {
            $query->where('status', 'completed');
        }

        $tasks = $query->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'filter' => $filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $listStatus = $request->query('status', 'all');

        return view('tasks.create', ['listStatus' => $listStatus]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:high,medium,low'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        Task::create($validated);

        return redirect()
            ->route('home', ['status' => $this->listStatus($request)])
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task): View
    {
        $listStatus = $request->query('status', 'all');

        return view('tasks.edit', [
            'task' => $task,
            'listStatus' => $listStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:high,medium,low'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        $task->update($validated);

        return redirect()
            ->route('home', ['status' => $this->listStatus($request)])
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('home', ['status' => $this->listStatus($request)])
            ->with('success', 'Task deleted successfully.');
    }

    public function complete(Request $request, Task $task): RedirectResponse
    {
        $task->update(['status' => 'completed']);

        return redirect()
            ->route('home', ['status' => $this->listStatus($request)])
            ->with('success', 'Task marked as completed.');
    }

    private function listStatus(Request $request): string
    {
        $status = $request->input('list_status', $request->query('status', 'all'));

        return in_array($status, ['all', 'pending', 'completed'], true) ? $status : 'all';
    }
}
