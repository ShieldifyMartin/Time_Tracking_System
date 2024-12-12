<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Services\ProjectService;
use App\Services\WorkloadService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $employeeService;
    protected $projectService;
    protected $workloadService;

    // Inject the services
    public function __construct(EmployeeService $employeeService, ProjectService $projectService, WorkloadService $workloadService)
    {
        $this->employeeService = $employeeService;
        $this->projectService = $projectService;
        $this->workloadService = $workloadService;
    }

    // Generate report for employees and projects and return as a PDF.
    public function generateReport()
    {
        // Fetch all employees and projects using the services
        $employees = $this->employeeService->list();
        $projects = $this->projectService->list();

        \Log::info('Fetched employees:', $employees->toArray());
        
        $reportData = [];

        // Fetch work data for employees
        foreach ($employees as $employee) {
            \Log::info('Processing employee:', ['name' => $employee->name]);
            $workData = $this->workloadService->findByEmployeeId($employee->id);
            $reportData[] = [
                'employee' => $employee->name,
                'work_data' => $workData,
            ];
        }

        // Fetch work data for projects
        foreach ($projects as $project) {
            $projectWorkData = $this->workloadService->findByProjectId($project->id);
            $reportData[] = [
                'project' => $project->name,
                'work_data' => $projectWorkData,
            ];
        }

        // Generate the HTML content for the report
        $reportHtml = "<h1>Management Report</h1>";

        $reportHtml .= "<h2>Employees</h2>";
        foreach ($reportData as $data) {
            if (isset($data['employee'])) {
                $reportHtml .= "<h3>Employee: " . $data['employee'] . "</h3>";
                $reportHtml .= "<ul>";
                foreach ($data['work_data'] as $work) {
                    $reportHtml .= "<li>" . $work->description . " - Hours: " . $work->hours . "</li>";
                }
                $reportHtml .= "</ul>";
            }
        }

        $reportHtml .= "<h2>Projects</h2>";
        foreach ($reportData as $data) {
            if (isset($data['project'])) {
                $reportHtml .= "<h3>Project: " . $data['project'] . "</h3>";
                $reportHtml .= "<ul>";
                foreach ($data['work_data'] as $work) {
                    $reportHtml .= "<li>" . $work->description . " - Hours: " . $work->hours . "</li>";
                }
                $reportHtml .= "</ul>";
            }
        }

        // Generate the PDF using the HTML content
        $pdf = \PDF::loadHTML($reportHtml);
        $fileName = 'management_report_' . Carbon::now()->format('Y_m_d_H_i_s') . '.pdf';

        // Return the PDF as a response for download
        return $pdf->download($fileName);
    }
}