<?php

namespace App\Services;

use App\Models\Workload;

class WorkloadService
{
    // List all workloads
    public function list()
    {
        return Workload::all();
    }

    // Create a new workload
    public function store(array $data)
    {
        return Workload::create($data);
    }

    // Find workload by ID
    public function findById($id)
    {
        return Workload::find($id);
    }

    // Update workload by ID
    public function update($id, array $data)
    {
        $workload = Workload::find($id);
        if (!$workload) return null;
        $workload->update($data);
        return $workload;
    }

    // Delete workload by ID
    public function delete($id)
    {
        $workload = Workload::find($id);
        if (!$workload) return false;
        $workload->delete();
        return true;
    }
}