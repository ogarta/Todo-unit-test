<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'category_id' => 1,
            'user_id' => 1,
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return ['user_id' => $user->id];
        });
    }

    public function forProject(Project $project)
    {
        return $this->state(function (array $attributes) use ($project) {
            return ['project_id' => $project->id];
        });
    }

    public function forParent(Todo $parent)
    {
        return $this->state(function (array $attributes) use ($parent) {
            return ['parent_id' => $parent->id];
        });
    }
}
