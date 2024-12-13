@extends('layouts.app')

@section('title', 'Employees List')

@section('content')
<div>
    <h1>Employees</h1>

    @if(Auth::user() && Auth::user()->role === 'admin')
        <a class="nav-link active w-auto px-3 py-2 btn btn-primary" href="{{ route('employees.add') }}">Add Employee</a>
    @endif

    @if(isset($employees) && count($employees) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Hired Since</th>
                    <th>Salary</th>
                    <th>Working Hours Per Day</th>
                    <th>Total Hours Worked</th>
                    <th>Job Title</th>
                    <th>Notes</th>
                    <th>Active</th>
                    <th>Earned Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->hired_since->format('Y-m-d') }}</td>
                        <td>${{ number_format($employee->salary, 2) }}</td>
                        <td>{{ $employee->working_hours_per_day }}</td>
                        <td>{{ $employee->total_hours_worked }}</td>
                        <td>{{ $employee->job_title }}</td>
                        <td>{{ $employee->notes }}</td>
                        <td>{{ $employee->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            {{ is_numeric($employee->earnedSalary) ? '$' . number_format($employee->earnedSalary, 2) : $employee->earnedSalary }}
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if(Auth::user() && Auth::user()->role === 'admin')
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('employees.delete', $employee->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No employees found.</p>
    @endif
</div>
@endsection