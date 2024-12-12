<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function list()
    {
        $employees = $this->employeeService->list();
        return view('employees.list', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'hired_since' => 'required|date|before_or_equal:today',
            'salary' => 'required|numeric|min:0',
            'working_hours_per_day' => 'required|integer|min:1|max:24',
            'total_hours_worked' => 'required|integer|min:0',
            'job_title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $id = $this->employeeService->store($data);
        return redirect('/employees')->with('success', 'Employee created successfully');
    }

    public function findById($id)
    {
        $employee = $this->employeeService->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:employees,email,' . $id,
            'hired_since' => 'sometimes|date|before_or_equal:today',
            'salary' => 'sometimes|numeric|min:0',
            'working_hours_per_day' => 'sometimes|integer|min:1|max:24',
            'total_hours_worked' => 'sometimes|integer|min:0',
            'job_title' => 'sometimes|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $this->employeeService->update($id, $data);
        return redirect('/employees')->with('success', 'Employee updated successfully');
    }

    public function delete($id)
    {
        $result = $this->employeeService->delete($id);

        if (!$result) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return redirect('/employees')->with('success', 'Employee deleted successfully');
    }

    public function allEmployees()
    {
        $employees = $this->employeeService->list();
        return view('employees.all', compact('employees'));
    }

    public function getCreateView()
    {
        return view('employees.add');
    }

    public function getEditView($id)
    {
        $employee = $this->employeeService->findById($id);
        return view('employees.edit', compact('employee'));
    }
}