<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Services\WorkloadService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected $employeeService;
    protected $workloadService;
    protected $projectService;

    public function __construct(EmployeeService $employeeService, WorkloadService $workloadService, ProjectService $projectService)
    {
        $this->employeeService = $employeeService;
        $this->workloadService = $workloadService;
        $this->projectService = $projectService;
    }

    public function index()
    {
        // Fetch all employees and projects
        $employees = $this->employeeService->list();
        $projects = $this->projectService->list();

        // Fetch workloads for the past month for each employee
        $workloadsLast30Days = $this->workloadService->getWorkloadsForLastMonth();

        // Pass the data to the view
        return view('charts.index', compact('employees', 'workloadsLast30Days', 'projects'));
    }
}