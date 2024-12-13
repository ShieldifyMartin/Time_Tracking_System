<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Middleware\ProjectCreator;

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
            'status' => 'sometimes|string|in:planned,active,completed,on_hold,cancelled',
        ]);
        $data['created_by'] = Auth::id();

        $project = $this->projectService->store($data);
        return redirect('/projects')->with('success', 'Project created successfully');
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
        $this->authorizeProjectAction($id);
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|string|in:planned,active,completed,on_hold,cancelled',
        ]);


        $updatedData = $this->projectService->update($id, $data);

        if (!$updatedData) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return redirect('/projects')->with('success', 'Project updated successfully');
    }

    public function delete($id)
    {
        $this->authorizeProjectAction($id);
        $deleted = $this->projectService->delete($id);

        if (!$deleted) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return redirect('/projects')->with('success', 'Project deleted successfully');
    }

    public function getWorkloads($id)
    {
        $workloads = $this->projectService->getWorkloads($id);

        if (!$workloads) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json(array_map(fn($workload) => $workload->toArray(), array_filter($workloads)));
    }

    public function getCreateView()
    {
        return view('projects.add');
    }

    public function getEditView($id)
    {
        $this->authorizeProjectAction($id);
        $project = $this->projectService->findById($id);
        return view('projects.edit', compact('project'));
    }

    // Internal authorization method
    private function authorizeProjectAction($id)
    {
        $project = $this->projectService->findById($id);

        if (!$project || ($project->created_by !== Auth::id() && Auth::user()->role !== 'admin')) {
            return redirect('/')->with('error', 'Unauthorized action.');
        }
    }
}
