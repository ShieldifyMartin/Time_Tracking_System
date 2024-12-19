<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_projects()
    {
        // Bypass middleware if needed
        $this->withoutMiddleware();

        $response = $this->get('/projects');
        $response->assertStatus(200);
    }

    public function test_store_project()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        Auth::login($user);

        // Simulate posting a new project
        $response = $this->post('/projects', [
            'name' => 'New Project',
            'start_date' => '2024-01-01',
            'status' => 'planned',
        ]);

        // Assert that the response is a redirect and project is in the database
        $response->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
    }

    public function test_update_project()
    {
        // Create the user and the project
        $user = User::factory()->create();
        Auth::login($user);
        
        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        // Send the PUT request to update the project, excluding 'created_by'
        $response = $this->put('/projects/' . $project->id, [
            'name' => 'Updated Project Name',
            'status' => 'active',
        ]);

        // Assert the response is a redirect to the projects index
        $response->assertRedirect('/projects');

        // Assert that the 'name' and 'status' are updated in the database
        $this->assertDatabaseHas('projects', ['name' => 'Updated Project Name']);
        $this->assertDatabaseHas('projects', ['status' => 'active']);

        // Ensure 'created_by' remains unchanged and is set to the correct user ID
        $this->assertDatabaseHas('projects', ['created_by' => $user->id]);
    }

    public function test_delete_project()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a project with 'created_by' set to the authenticated user's ID
        $project = Project::factory()->create(['created_by' => $user->id]);

        // Make a request to delete the project
        $response = $this->delete('/projects/' . $project->id);

        // Assert that the response redirects to the projects list
        $response->assertRedirect('/projects');

        // Assert that the project is deleted from the database
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_find_project_by_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a project with 'created_by' set to the authenticated user's ID
        $project = Project::factory()->create(['created_by' => $user->id]);

        // Make a request to find the project by its ID
        $response = $this->get('/projects/' . $project->id);

        // Assert that the response is successful and contains the project data
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $project->name]);
    }

}