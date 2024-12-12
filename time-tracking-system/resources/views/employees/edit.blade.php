@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="form-container">
        <h1>Edit Employee</h1>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}" required>

            <label for="hired_since">Hired Since:</label>
            <input type="date" id="hired_since" name="hired_since" value="{{ old('hired_since', $employee->hired_since->format('Y-m-d')) }}" required>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" required>

            <label for="working_hours_per_day">Working Hours Per Day:</label>
            <input type="number" id="working_hours_per_day" name="working_hours_per_day" min="1" max="24" value="{{ old('working_hours_per_day', $employee->working_hours_per_day) }}" required>

            <label for="total_hours_worked">Total Hours Worked:</label>
            <input type="number" id="total_hours_worked" name="total_hours_worked" value="{{ old('total_hours_worked', $employee->total_hours_worked) }}" required>

            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $employee->job_title) }}" required>

            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" rows="4">{{ old('notes', $employee->notes) }}</textarea>

            <label for="is_active">Is Active:</label>
            <select id="is_active" name="is_active" required>
                <option value="1" {{ old('is_active', $employee->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_active', $employee->is_active) == 0 ? 'selected' : '' }}>No</option>
            </select>

            <button type="submit">Update Employee</button>
        </form>
    </div>
@endsection