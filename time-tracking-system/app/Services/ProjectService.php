<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Workload;

class ProjectService
{
    // Retrieve all projects
    public function list()
    {
        return Project::all();
    }

    // Create a new project
    public function store(array $data)
    {
        return Project::create($data);
    }

    // Retrieve a specific project by ID
    public function findById($id)
    {
        return Project::find($id);
    }

    // Find the project and update its details
    public function update($id, array $data)
    {
        $project = Project::find($id);

        if (!$project) {
            return null;
        }

        $project->update($data);
        return $project;
    }

    // Find the project and delete it along with associated workloads
    public function delete($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return false;
        }

        // Delete related workloads
        Workload::where('project_id', $id)->delete();

        // Delete the project
        $project->delete();
        return true;
    }

    // Get workloads associated with the project
    public function getWorkloads($id)
    {
        $project = Project::find($id);
        return $project ? $project->workloads : null;
    }
}