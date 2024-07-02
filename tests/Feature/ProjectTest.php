<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProjectTest extends TestCase
{

    public function test_project_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('project.index'));

        $response->assertStatus(200);
    }

    public function test_project_pagination()
    {
        $user = User::factory()->create();
        Project::factory(['user_id' => $user->id])->count(20)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('project.index') . '?page=2');

        $response->assertViewHas('projects', function ($projects) {
            return $projects->currentPage() === 2;
        });
    }
}
