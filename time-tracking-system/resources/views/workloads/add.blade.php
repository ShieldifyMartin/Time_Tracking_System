@extends('layouts.app')

@section('title', 'Add Workload')

@section('content')
<div class="form-container">
    <h1>Add New Workload</h1>
    <form action="{{ url('workloads') }}" method="POST">
        @csrf
        <label for="employee_id">Employee:</label>
        <select id="employee_id" name="employee_id" required>
            <option value="" disabled selected>Select an Employee</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
            @endforeach
        </select>

        <label for="project_id">Project:</label>
        <select id="project_id" name="project_id" required>
            <option value="" disabled selected>Select a Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="hours_worked">Hours Worked:</label>
        <input type="number" id="hours_worked" name="hours_worked" min="1" max="24" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Add Workload</button>
    </form>
</div>
@endsection