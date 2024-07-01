<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    private User $user;
    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->user = $user;
    }

    public function test_todo_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/todo');

        $response->assertOk();
    }

    public function test_todo_can_be_created(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/todo', [
                'title' => 'Test Todo',
                'category_id' => 1,
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('todos', [
            'title' => 'Test Todo',
            'category_id' => 1,
        ]);

        $response->assertRedirect('/');
    }


    public function test_todo_can_be_updated(): void
    {
        $todo = Todo::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->patch("/todo/{$todo->id}", [
                'title' => 'Updated Todo',
                'category_id' => 2,
                'priority' => 1,
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('todos', [
            'title' => 'Updated Todo',
            'category_id' => 2,
        ]);

        $response->assertRedirect('/');
    }

    public function test_todo_can_be_deleted(): void
    {
        $todo = Todo::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->delete("/todo/{$todo->id}");

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('todos', [
            'title' => 'Test Todo',
            'category_id' => 1,
        ]);

        $response->assertRedirect('/');
    }

    
}
