<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ActivityController extends Controller
{
    use AuthorizesRequests;

    public function taskActivities()
    {
        $activities = Activity::where('subject_type', Task::class)
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
