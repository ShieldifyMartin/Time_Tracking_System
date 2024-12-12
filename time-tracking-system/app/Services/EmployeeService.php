<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    // Retrieve all employees from the database
    public function list()
    {
        return Employee::all();
    }

    // Retrieve a specific employee by ID
    public function findById($id)
    {
        return Employee::find($id);
    }

    // Create a new employee record
    public function store(array $data)
    {
        $employee = Employee::create($data);
        return $employee->id;
    }

    // Find the employee by ID and update the record
    public function update($id, array $data)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return false;
        }

        $employee->update($data);
        return true;
    }

    // Find the employee by ID and delete the record
    public function delete($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return false;
        }

        $employee->delete();
        return true;
    }
}
