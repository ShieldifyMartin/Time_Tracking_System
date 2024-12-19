<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Workload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\PDF;
use App\Services\EmployeeService;
use App\Services\ProjectService;
use App\Services\WorkloadService;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_report()
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
            'date' => now()->format('Y-m-d'),
            'description' => 'Worked on the project',
            'created_by' => $user->id 
        ]);

        // Mock the services to return the necessary data
        $employeeService = \Mockery::mock(EmployeeService::class);
        $employeeService->shouldReceive('list')->andReturn(collect([$employee]));
        
        $projectService = \Mockery::mock(ProjectService::class);
        $projectService->shouldReceive('list')->andReturn(collect([$project]));
        
        $workloadService = \Mockery::mock(WorkloadService::class);
        $workloadService->shouldReceive('findByEmployeeId')->andReturn(collect([$workload]));
        $workloadService->shouldReceive('findByProjectId')->andReturn(collect([$workload]));

        // Bind the mocked services to the container
        $this->app->instance(EmployeeService::class, $employeeService);
        $this->app->instance(ProjectService::class, $projectService);
        $this->app->instance(WorkloadService::class, $workloadService);

        // Act: Make the request to generate the report, disable middleware
        $response = $this->withoutMiddleware()->get(route('reports.generate')); // Correct route name
        
        // Assert: Check if the response is a PDF download
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename=management_report_' . now()->format('Y_m_d_H_i_s') . '.pdf');
    }
}