<?php

namespace Database\Factories;

use App\Models\TaskAttachment;
use App\Models\Task; 
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskAttachmentFactory extends Factory
{
    public function definition()
    {
        return [
            'filename' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'path' => 'attachments/' . $this->faker->uuid() . '.file',
            'mime_type' => $this->faker->mimeType(),
            'size' => $this->faker->numberBetween(1000, 5000000),
            'task_id' => Task::factory(),
        ];
    }
}