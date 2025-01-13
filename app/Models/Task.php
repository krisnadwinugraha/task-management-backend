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
}
