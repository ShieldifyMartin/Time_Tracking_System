<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\ProjectService;
use App\Services\WorkloadService;
use App\Models\Employee;
use App\Models\Project;

class WorkloadController extends Controller
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

    /**
     * Display a listing of workloads.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $workloads = $this->workloadService->list();
        return view('workloads.list', compact('workloads'));
    }

    /**
     * Store a newly created workload in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|string',
            'project_id' => 'required|string',
            'date' => 'required|date',
            'hours_worked' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $data['created_by'] = Auth::id();

        $id = $this->workloadService->store($data);
        return redirect('/workloads')->with('success', 'Workload created successfully');
    }

    /**
     * Display the specified workload.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function findById($id)
    {
        $workload = $this->workloadService->findById($id);

        if (!$workload) {
            return response()->json(['error' => 'Workload not found'], 404);
        }

        return response()->json($workload);
    }

    /**
     * Update the specified workload in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->authorizeWorkloadAction($id);
        $data = $request->validate([
            'employee_id' => 'sometimes|string',
            'project_id' => 'sometimes|string',
            'date' => 'sometimes|date',
            'hours_worked' => 'sometimes|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $updated = $this->workloadService->update($id, $data);

        if (!$updated) {
            return response()->json(['error' => 'Workload not found'], 404);
        }

        return redirect('/workloads')->with('success', 'Workload updated successfully');
    }

    /**
     * Remove the specified workload from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->authorizeWorkloadAction($id);
        $deleted = $this->workloadService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Workload not found'], 404);
        }

        return redirect('/workloads')->with('success', 'Workload deleted successfully');
    }

    // Load view functions
    public function getCreateView()
    {
        $employees = $this->employeeService->list();
        $projects = $this->projectService->list();

        return view('workloads.add', compact('employees', 'projects'));
    }

    public function getEditView($id)
    {
        $this->authorizeWorkloadAction($id);
        $employees = $this->employeeService->list();
        $projects = $this->projectService->list();
        $workload = $this->workloadService->findById($id);
        return view('workloads.edit', compact('employees', 'projects', 'workload'));
    }

    // Internal authorization method
    private function authorizeWorkloadAction($id)
    {
        $workload = $this->workloadService->findById($id);

        if (!$workload || ($workload->created_by !== Auth::id() && Auth::user()->role !== 'admin')) {
            return redirect('/')->with('error', 'Unauthorized action.');
        }
    }
}