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
        $commentTemplates = [
            // Status Updates
            "I've started working on this. Will update the team by end of day.",
            "Making good progress here. Already completed the initial phase.",
            "Had to pause this due to some blockers with the API integration. @{name} can you help?",
            "Just pushed the changes to staging. Please review when you have a chance.",

            // Technical Comments
            "Found the root cause - there was a race condition in the authentication flow. Working on a fix.",
            "The database queries are now optimized. Seeing a 40% improvement in response time.",
            "We might need to refactor this part to make it more scalable. Current implementation won't handle high load.",
            "Added unit tests and documentation. Coverage is now at 85%.",

            // Questions & Clarifications
            "Quick question - should we support mobile view for this feature?",
            "Can someone clarify the expected behavior when the user is offline?",
            "Not sure about the best approach here. Would appreciate some input from the team.",
            "Do we have any existing components we can reuse for this?",

            // Feedback & Reviews
            "Code looks good overall, but we should add error handling for edge cases.",
            "UI feels a bit cluttered. Maybe we can simplify the layout?",
            "Great work on the optimization! Much smoother now.",
            "Found a minor bug in error handling - it's not catching network timeouts.",

            // Task Management
            "Moving this to QA. Please test on your end.",
            "Need to prioritize this - it's blocking several other tasks.",
            "Should we break this down into smaller subtasks?",
            "Estimating this will take about 3-4 days to complete."
        ];

        // Randomly decide whether to mention a user
        if ($this->faker->boolean(30)) {
            $firstName = $this->faker->firstName;
            $selectedComment = str_replace('{name}', $firstName, $this->faker->randomElement($commentTemplates));
        } else {
            $selectedComment = $this->faker->randomElement($commentTemplates);
        }

        return [
            'content' => $selectedComment,
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}
