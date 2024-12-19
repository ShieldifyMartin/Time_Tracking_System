<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Services\ProjectService;
use App\Services\WorkloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $employeeService;
    protected $projectService;
    protected $workloadService;

    public function __construct(EmployeeService $employeeService, ProjectService $projectService, WorkloadService $workloadService)
    {
        $this->employeeService = $employeeService;
        $this->projectService = $projectService;
        $this->workloadService = $workloadService;
    }

    public function generateReport()
    {
        // Internal authorization method
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized action.');
        }

        $reportHtml = "<h1>Management Report</h1>";
    
        // Fetch and add employee data to the report
        $employees = $this->employeeService->list();
        \Log::info('Fetched employees:', $employees->toArray());
        $reportHtml .= "<h2>Employees</h2>";
        foreach ($employees as $employee) {
            $workData = $this->workloadService->findByEmployeeId($employee->id);
            
            // Add detailed employee information
            $reportHtml .= "<h3>Employee: " . $employee->first_name . " " . $employee->last_name . "</h3>";
            $reportHtml .= "<ul>";
            $reportHtml .= "<li><strong>Email:</strong> " . $employee->email . "</li>";
            $reportHtml .= "<li><strong>Hired Since:</strong> " . $employee->hired_since . "</li>";
            $reportHtml .= "<li><strong>Salary:</strong> $" . number_format($employee->salary, 2) . "</li>";
            $reportHtml .= "<li><strong>Working Hours Per Day:</strong> " . $employee->working_hours_per_day . " hours</li>";
            $reportHtml .= "<li><strong>Total Hours Worked:</strong> " . $employee->total_hours_worked . " hours</li>";
            $reportHtml .= "<li><strong>Job Title:</strong> " . $employee->job_title . "</li>";
            $reportHtml .= "<li><strong>Notes:</strong> " . $employee->notes . "</li>";
            $reportHtml .= "<li><strong>Active Status:</strong> " . ($employee->is_active ? 'Active' : 'Inactive') . "</li>";
            
            // Full workload data
            $reportHtml .= "<h4>Workload Data</h4><ul>";
            foreach ($workData as $work) {
                $reportHtml .= "<li><strong>Project:</strong> " . $work->project->name . " - <strong>Description:</strong> " . $work->description . " - <strong>Date:</strong> " . $work->date . " - <strong>Hours Worked:</strong> " . $work->hours_worked . "</li>";
            }
            $reportHtml .= "</ul>";
            $reportHtml .= "</ul>";
        }
    
        // Fetch and add project data to the report
        $projects = $this->projectService->list();
        $reportHtml .= "<h2>Projects</h2>";
        foreach ($projects as $project) {
            $workData = $this->workloadService->findByProjectId($project->id);
            \Log::info('Workload for project ' . $project->id, $workData->toArray());
            $reportHtml .= "<h3>Project: " . $project->name . "</h3>";
            $reportHtml .= "<ul>";
            $reportHtml .= "<li><strong>Description:</strong> " . $project->description . "</li>";
            $reportHtml .= "<li><strong>Start Date:</strong> " . $project->start_date . "</li>";
            $reportHtml .= "<li><strong>End Date:</strong> " . $project->end_date . "</li>";
            $reportHtml .= "<li><strong>Status:</strong> " . $project->status . "</li>";
    
            // Full workload data for the project
            $reportHtml .= "<h4>Workload Data</h4><ul>";
            foreach ($workData as $work) {
                $reportHtml .= "<li><strong>Employee:</strong> " . $work->employee->first_name . " " . $work->employee->last_name . " - <strong>Description:</strong> " . $work->description . " - <strong>Date:</strong> " . $work->date . " - <strong>Hours Worked:</strong> " . $work->hours_worked . "</li>";
            }
            $reportHtml .= "</ul>";
            $reportHtml .= "</ul>";
        }
    
        // Generate the PDF from the HTML content
        $pdf = \PDF::loadHTML($reportHtml);
        $fileName = 'management_report_' . Carbon::now()->format('Y_m_d_H_i_s') . '.pdf';
    
        // Return the PDF as a response for download
        return $pdf->download($fileName);
    }
}    