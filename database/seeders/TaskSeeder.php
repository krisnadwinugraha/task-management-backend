<?php
namespace Database\Seeders;

use App\Models\Task;
use App\Models\Category;
use App\Models\TaskComment;
use App\Models\TaskAttachment;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Create 50 tasks
        Task::factory(50)->create()->each(function ($task) {
            // Add 1-5 comments to each task
            TaskComment::factory(rand(1, 5))->create([
                'task_id' => $task->id
            ]);

            // Add 0-3 attachments to each task
            if (rand(0, 1)) {
                TaskAttachment::factory(rand(1, 3))->create([
                    'task_id' => $task->id
                ]);
            }

            // Attach 1-3 random categories to each task
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $task->categories()->attach($categories);
        });
    }
}