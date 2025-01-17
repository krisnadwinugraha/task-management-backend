<?php
// app/Models/Task.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use LogsActivity, HasFactory;

    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'description',
                'status',
                'priority',
                'assigned_to',
                'due_date'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Task was created',
                'updated' => 'Task was updated',
                'deleted' => 'Task was deleted',
                default => $eventName
            });
    }

    // Add this method to get formatted changes
    public function getFormattedChanges(): array
    {
        $activity = $this->activities()->latest()->first();

        if (!$activity) {
            return [];
        }

        $changes = [];
        foreach ($activity->changes['attributes'] ?? [] as $field => $newValue) {
            $oldValue = $activity->changes['old'][$field] ?? null;
            if ($oldValue !== $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }

        return $changes;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'task_categories', 'task_id', 'category_id');
    }

    // Assigned user relation (assumes `assigned_to` is a foreign key in `tasks` table referring to `users` table)
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Creator relation (assumes `created_by` is a foreign key in `tasks` table referring to `users` table)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Comments relation (assumes `task_id` is a foreign key in `task_comments` table referring to `tasks` table)
    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id');
    }
}
