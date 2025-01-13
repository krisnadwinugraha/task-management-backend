<?php

namespace Database\Factories;

use App\Models\TaskComment;
use App\Models\Task; 
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskCommentFactory extends Factory
{
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}