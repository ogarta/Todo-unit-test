<?php

namespace Tests\Feature;

use App\Enums\CategoriesEnum;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Tests\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_update_subtask()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'user_id' => $user->id
        ]);

        $task = Todo::factory()->forUser($user)->forProject($project)->create([
            'title' => 'Task 1',
            'category_id' => 1,
            'description' => 'Description 1',
        ]);
        
        $subtask = Todo::factory()->forUser($user)->forProject($project)->forParent($task)->create([
            'title' => 'Subtask 1',
            'category_id' => 1,
            'description' => 'Description 1',
        ]);

        $response = $this->actingAs($user)->put(route('subtask.update', $subtask->id), [
            'subtaskUpdate' => [
                'title' => 'Subtask 1 Updated',
                'category_id' => 1,
            ],
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('todos', [
            'title' => 'Subtask 1 Updated',
        ]);

    }
}
