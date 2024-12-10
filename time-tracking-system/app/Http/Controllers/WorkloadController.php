<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WorkloadService;

class WorkloadController extends Controller
{
    protected $workloadService;

    public function __construct(WorkloadService $workloadService)
    {
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

        $id = $this->workloadService->store($data);
        return response()->json(['id' => $id, 'message' => 'Workload created successfully'], 201);
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

        return response()->json(['message' => 'Workload updated successfully']);
    }

    /**
     * Remove the specified workload from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $deleted = $this->workloadService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Workload not found'], 404);
        }

        return response()->json(['message' => 'Workload deleted successfully']);
    }
}