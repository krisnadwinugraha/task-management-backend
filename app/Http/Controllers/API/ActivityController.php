<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function taskActivities(Task $task)
    {
        $this->authorize('view', $task);

        $activities = Activity::where('subject_type', Task::class)
            ->where('subject_id', $task->id)
            ->with('causer')
            ->latest()
            ->paginate(15);

        return response()->json([
            'activities' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'changes' => [
                        'before' => $activity->changes['old'] ?? [],
                        'after' => $activity->changes['attributes'] ?? []
                    ],
                    'causer' => $activity->causer ? [
                        'id' => $activity->causer->id,
                        'name' => $activity->causer->name
                    ] : null,
                    'created_at' => $activity->created_at
                ];
            })
        ]);
    }
}