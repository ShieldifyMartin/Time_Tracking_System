@extends('layouts.app')

@section('title', 'Employees List')

@section('content')
<div>
    <h1>Employees</h1>
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
                        <td>{{ $employee->earnedSalary }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No employees found.</p>
    @endif
</div>
@endsection