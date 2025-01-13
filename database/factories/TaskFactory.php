<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;
    
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'on_hold']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'assigned_to' => $this->faker->randomElement($users),
            'created_by' => $this->faker->randomElement($users),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }
}