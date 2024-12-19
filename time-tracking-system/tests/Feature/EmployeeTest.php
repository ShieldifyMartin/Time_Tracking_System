<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected $employeeService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of EmployeeService
        $mockEmployeeService = \Mockery::mock('App\Services\EmployeeService');

        // Bind the mock service to the service container
        $this->app->instance('App\Services\EmployeeService', $mockEmployeeService);

        // Optionally, set up default behaviors for the mock (if needed)
        $this->employeeService = $mockEmployeeService;
    }

    // Test the list method
    public function testListEmployees()
    {
        $employees = Employee::factory()->count(3)->create();

        // Mock the list method to return the employees
        $this->employeeService->shouldReceive('list')->once()->andReturn($employees);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->get(route('employees.list'));

        $response->assertStatus(200);
        $response->assertViewIs('employees.list');
        $response->assertViewHas('employees', $employees);
    }

    // Test store method
    public function testStoreEmployee()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'hired_since' => '2023-01-01',
            'salary' => 50000,
            'working_hours_per_day' => 8,
            'total_hours_worked' => 2000,
            'job_title' => 'Developer',
            'notes' => 'Good performance',
            'is_active' => true,
        ];

        $this->employeeService->shouldReceive('store')->once()->andReturn(1);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->post(route('employees.store'), $data);

        $response->assertRedirect(route('employees.list'));
        $response->assertSessionHas('success', 'Employee created successfully');
    }

    // Test findById method
    public function testFindEmployeeById()
    {
        $employee = Employee::factory()->create();

        $this->employeeService->shouldReceive('findById')
            ->once()
            ->with($employee->id)
            ->andReturn($employee);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->get(route('employees.show', ['id' => $employee->id]));

        $response->assertStatus(200);
        $response->assertJson($employee->toArray());
    }

    // Test update method
    public function testUpdateEmployee()
    {
        $employee = Employee::factory()->create();
        $data = [
            'first_name' => 'Updated Name',
            'last_name' => 'Doe',
            'email' => 'updated.doe@example.com',
        ];

        // Create an admin user and act as that user
        $admin = User::factory()->create([
            'role' => 'admin', // Ensure role is 'admin'
        ]);

        // Simulate admin login without middleware
        $this->actingAs($admin);

        // Mock the service method to return a successful update
        $this->employeeService->shouldReceive('update')->once()->andReturn(true);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->put(route('employees.update', ['id' => $employee->id]), $data);

        // Check the response
        $response->assertRedirect(route('employees.list'));
        $response->assertSessionHas('success', 'Employee updated successfully');
    }

    // Test delete employee
    public function testDeleteEmployee()
    {
        $employee = Employee::factory()->create();

        $this->employeeService->shouldReceive('delete')->once()->andReturn(true);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->delete(route('employees.delete', ['id' => $employee->id]));

        $response->assertRedirect(route('employees.list'));
        $response->assertSessionHas('success', 'Employee deleted successfully');
    }

    // Test edit employee view
    public function testEditEmployeeView()
    {
        $employee = Employee::factory()->create();

        // Create an admin user and act as that user
        $admin = User::factory()->create([
            'role' => 'admin', // Ensure role is 'admin'
        ]);

        // Simulate admin login without middleware
        $this->actingAs($admin);

        // Mock the findById method to return the created employee
        $this->employeeService->shouldReceive('findById')
            ->once()
            ->with($employee->id)
            ->andReturn($employee);

        // Disable middleware for this test
        $response = $this->withoutMiddleware()->get(route('employees.edit', ['id' => $employee->id]));

        // Check the response
        $response->assertStatus(200);
        $response->assertViewIs('employees.edit');
        $response->assertViewHas('employee', $employee);
    }
}