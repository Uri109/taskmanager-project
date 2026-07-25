<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_projects(): void
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    public function test_user_can_create_project_and_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/projects', ['title' => 'Launch', 'description' => 'Ship it', 'color' => '#7357ee'])->assertRedirect();
        $project = Project::first();
        $this->actingAs($user)->post("/projects/{$project->id}/tasks", ['title' => 'Publish page', 'status' => 'todo', 'priority' => 'high'])->assertRedirect("/projects/{$project->id}");
        $this->assertDatabaseHas('tasks', ['project_id' => $project->id, 'title' => 'Publish page']);
    }

    public function test_validation_rejects_empty_title_and_invalid_status(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(['title' => 'Valid', 'color' => '#7357ee']);
        $this->actingAs($user)->from('/projects/create')->post('/projects', ['title' => '', 'color' => '#7357ee'])->assertSessionHasErrors('title');
        $this->actingAs($user)->post("/projects/{$project->id}/tasks", ['title' => 'Task', 'status' => 'blocked', 'priority' => 'low'])->assertSessionHasErrors('status');
    }

    public function test_user_cannot_access_another_users_project_or_task(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $project = $owner->projects()->create(['title' => 'Private', 'color' => '#7357ee']);
        $task = $project->tasks()->create(['title' => 'Secret', 'status' => 'todo', 'priority' => 'medium']);
        $this->actingAs($intruder)->get("/projects/{$project->id}")->assertForbidden();
        $this->actingAs($intruder)->get("/projects/{$project->id}/tasks/{$task->id}")->assertForbidden();
    }

    public function test_changing_task_to_done_sets_timestamp_and_alert(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(['title' => 'Launch', 'color' => '#7357ee']);
        $task = $project->tasks()->create(['title' => 'Finish', 'status' => 'in_progress', 'priority' => 'medium']);
        $this->actingAs($user)->put("/projects/{$project->id}/tasks/{$task->id}", ['title' => 'Finish', 'status' => 'done', 'priority' => 'medium'])
            ->assertRedirect("/projects/{$project->id}")->assertSessionHas('completed');
        $this->assertNotNull($task->fresh()->completed_at);
    }

    public function test_tasks_can_be_filtered_by_status(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(['title' => 'Launch', 'color' => '#7357ee']);
        $project->tasks()->createMany([['title' => 'Visible done', 'status' => 'done', 'priority' => 'low'], ['title' => 'Hidden todo', 'status' => 'todo', 'priority' => 'low']]);
        $this->actingAs($user)->get("/projects/{$project->id}?status=done")->assertOk()->assertSee('Visible done')->assertDontSee('Hidden todo');
    }
}
