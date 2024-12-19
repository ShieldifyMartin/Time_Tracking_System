<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Workload;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class WorkloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_workloads()
    {
        $response = $this->withoutMiddleware()->get('/workloads');
        $response->assertStatus(200);
    }

    public function test_store_workload()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $employee = Employee::factory()->create();
        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        // Cast employee_id and project_id as strings
        $response = $this->withoutMiddleware()->post('/workloads', [
            'employee_id' => (string) $employee->id,
            'project_id' => (string) $project->id,
            'date' => '2024-01-01',
            'hours_worked' => 8,
            'description' => 'Worked on project',
        ]);

        $response->assertRedirect('/workloads');
        $this->assertDatabaseHas('workloads', ['hours_worked' => 8]);
    }

    public function test_update_workload()
    {
        $user = User::factory()->create();
        Auth::login($user);

        // Ensure the project has 'created_by' field set when created
        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        // Create a workload and associate it with the project
        $workload = Workload::factory()->create([
            'created_by' => $user->id,
            'project_id' => $project->id,
        ]);

        // Update the workload
        $response = $this->withoutMiddleware()->put('/workloads/' . $workload->id, [
            'hours_worked' => 10,
            'description' => 'Updated workload',
        ]);

        // Assert the response is a redirect
        $response->assertRedirect('/workloads');
        
        // Assert the workload is updated in the database
        $this->assertDatabaseHas('workloads', ['hours_worked' => 10]);
    }

    public function test_delete_workload()
    {
        $user = User::factory()->create();
        Auth::login($user);

        // Create a project and set the 'created_by' field
        $project = Project::factory()->create([
            'created_by' => $user->id, // Set the created_by field
        ]);

        // Create a workload and associate it with the project
        $workload = Workload::factory()->create([
            'created_by' => $user->id,
            'project_id' => $project->id, // Associate the workload with the project
        ]);

        // Perform the delete operation
        $response = $this->withoutMiddleware()->delete('/workloads/' . $workload->id);
        
        // Check if the response redirects correctly
        $response->assertRedirect('/workloads');
        
        // Assert that the workload is removed from the database
        $this->assertDatabaseMissing('workloads', ['id' => $workload->id]);
    }

    public function test_find_workload_by_id()
    {
        $user = User::factory()->create();  // Create a user
        Auth::login($user);

        // Ensure the project has 'created_by' field set when created
        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        // Create a workload associated with the created project
        $workload = Workload::factory()->create([
            'created_by' => $user->id,
            'project_id' => $project->id,
        ]);

        $response = $this->withoutMiddleware()->get('/workloads/' . $workload->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['hours_worked' => $workload->hours_worked]);
    }
}