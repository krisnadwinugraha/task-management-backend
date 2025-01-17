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

        $taskTemplates = [
            [
                'titles' => [
                    'Update client dashboard UI',
                    'Fix payment gateway integration',
                    'Implement email notification system',
                    'Optimize database queries',
                    'Set up automated testing pipeline',
                    'Create API documentation',
                    'Debug user authentication issues',
                    'Add export to PDF feature',
                    'Implement data backup system',
                    'Review and refactor legacy code'
                ],
                'descriptions' => [
                    'Need to redesign the client dashboard to improve user experience. Focus on making key metrics more visible and adding responsive charts.',
                    'Several users reported issues with payment processing. Need to investigate logs and fix the integration with the payment provider.',
                    'Design and implement a robust email notification system for user activities and system alerts. Include templating system for easy customization.',
                    'System is running slow during peak hours. Analyze and optimize database queries to improve performance.',
                    'Set up automated testing environment with CI/CD pipeline to ensure code quality and reduce deployment issues.',
                    'Create comprehensive API documentation including endpoints, request/response formats, and example usage.',
                    'Multiple users reported being logged out unexpectedly. Debug session management and fix authentication issues.',
                    'Add functionality to export reports and data to PDF format. Ensure proper formatting and styling.',
                    'Implement automated daily backup system for all critical data. Include verification and restoration testing.',
                    'Review and refactor outdated code modules to improve maintainability and reduce technical debt.'
                ]
            ]
        ];

        $randomTemplate = $this->faker->randomElement($taskTemplates);
        $randomTitleIndex = $this->faker->numberBetween(0, count($randomTemplate['titles']) - 1);

        return [
            'title' => $randomTemplate['titles'][$randomTitleIndex],
            'description' => $randomTemplate['descriptions'][$randomTitleIndex],
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'on_hold']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'assigned_to' => $this->faker->randomElement($users),
            'created_by' => $this->faker->randomElement($users),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }
}
