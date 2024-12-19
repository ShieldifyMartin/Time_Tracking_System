<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Workload;
use Illuminate\Support\Facades\Auth;
use App\Services\EmployeeService;
use App\Services\WorkloadService;
use App\Services\ProjectService;

class ChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        // Arrange: Create necessary data for the test
        $user = User::factory()->create();
        Auth::login($user);

        // Create some employees, projects, and workloads
        $employee = Employee::factory()->create();
        $project = Project::factory()->create();
        $workload = Workload::factory()->create([
            'employee_id' => $employee->id,
            'project_id' => $project->id,
            'hours_worked' => 8,
            'date' => now()->subDays(10)->format('Y-m-d'),
            'description' => 'Worked on the project'
        ]);

        // Mock the services to return the necessary data
        $employeeService = \Mockery::mock(EmployeeService::class);
        $employeeService->shouldReceive('list')->andReturn(collect([$employee]));
        
        $projectService = \Mockery::mock(ProjectService::class);
        $projectService->shouldReceive('list')->andReturn(collect([$project]));
        
        $workloadService = \Mockery::mock(WorkloadService::class);
        $workloadService->shouldReceive('getWorkloadsForLastMonth')->andReturn(collect([$workload]));

        // Bind the mocked services to the container
        $this->app->instance(EmployeeService::class, $employeeService);
        $this->app->instance(ProjectService::class, $projectService);
        $this->app->instance(WorkloadService::class, $workloadService);

        // Act: Make the request to the correct route
        $response = $this->get(route('chart')); // Correct route name

        // Assert: Check if the response contains the necessary data
        $response->assertStatus(200);
        $response->assertViewIs('charts.index');
        $response->assertViewHas('employees');
        $response->assertViewHas('workloadsLast30Days');
        $response->assertViewHas('projects');
        
        // Optionally check if specific data is passed to the view
        $response->assertViewHas('employees', function ($employees) use ($employee) {
            return $employees->contains('id', $employee->id);
        });
    }
}