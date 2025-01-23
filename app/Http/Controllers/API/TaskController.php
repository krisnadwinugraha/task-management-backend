<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    // In TaskController@index
    public function index(Request $request)
    {
        $query = Task::query();

        // Search by title or description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        // Apply date range filter
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('due_date', [$request->start_date, $request->end_date]);
        }

        // Eager load relationships if needed
        $query->with(['assignedUser', 'creator', 'comments']);

        // Paginate results
        $tasks = $query->paginate(10);

        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,on_hold',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create([
            ...$validated,
            'created_by' => $request->user()->id,
        ]);

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task->load(['assignedUser', 'creator', 'comments']));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed,on_hold',
            'priority' => 'sometimes|required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable',
        ]);

        // Add custom activity log description for specific changes
        if (isset($validated['status']) && $validated['status'] !== $task->status) {
            activity()
                ->performedOn($task)
                ->withProperties(['status_change' => [
                    'from' => $task->status,
                    'to' => $validated['status']
                ]])
                ->log("Task status changed from {$task->status} to {$validated['status']}");
        }

        if (isset($validated['assigned_to']) && $validated['assigned_to'] !== $task->assigned_to) {
            $newAssignee = User::find($validated['assigned_to']);
            activity()
                ->performedOn($task)
                ->withProperties(['assignment_change' => [
                    'from' => $task->assigned_to,
                    'to' => $validated['assigned_to']
                ]])
                ->log("Task reassigned to {$newAssignee->name}");
        }

        $task->update($validated);

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
