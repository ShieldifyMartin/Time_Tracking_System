@extends('layouts.app')

@section('title', 'Edit Workload')

@section('content')
<div class="form-container">
    <h1>Edit Workload</h1>
    <form action="{{ route('workloads.update', $workload->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="employee_id">Employee:</label>
        <select id="employee_id" name="employee_id" required>
            <option value="" disabled>Select an Employee</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" 
                    {{ old('employee_id', $workload->employee_id) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </option>
            @endforeach
        </select>

        <label for="project_id">Project:</label>
        <select id="project_id" name="project_id" required>
            <option value="" disabled>Select a Project</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" 
                    {{ old('project_id', $workload->project_id) == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="{{ old('date', $workload->date->format('Y-m-d')) }}" required>

        <label for="hours_worked">Hours Worked:</label>
        <input type="number" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $workload->hours_worked) }}" min="1" max="24" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required>{{ old('description', $workload->description) }}</textarea>

        <button type="submit">Edit Workload</button>
    </form>
</div>
@endsection