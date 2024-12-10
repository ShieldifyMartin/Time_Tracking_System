<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function list()
    {
        $projects = $this->projectService->list();
        return view('projects.list', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string|in:planned,active,completed,cancelled',
        ]);

        $project = $this->projectService->store($data);

        return response()->json(['id' => $project->toArray()['id'], 'message' => 'Project created successfully'], 201);
    }

    public function findById($id)
    {
        $project = $this->projectService->findById($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json($project->toArray());
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|string|in:planned,active,completed,cancelled',
        ]);

        $updatedData = $this->projectService->update($id, $data);

        if (!$updatedData) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json(['message' => 'Project updated successfully']);
    }

    public function delete($id)
    {
        $deleted = $this->projectService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function getWorkloads($id)
    {
        $workloads = $this->projectService->getWorkloads($id);

        if (!$workloads) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json(array_map(fn($workload) => $workload->toArray(), array_filter($workloads)));
    }
}
