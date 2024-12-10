@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')
    <div class="form-container">
        <h1>Add New Employee</h1>
        <form action="{{ url('employees') }}" method="POST">
            @csrf
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="hired_since">Hired Since:</label>
            <input type="date" id="hired_since" name="hired_since" required>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required>

            <label for="working_hours_per_day">Working Hours Per Day:</label>
            <input type="number" id="working_hours_per_day" name="working_hours_per_day" min="1" max="24" required>

            <label for="total_hours_worked">Total Hours Worked:</label>
            <input type="number" id="total_hours_worked" name="total_hours_worked" required>

            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" required>

            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" rows="4"></textarea>

            <label for="is_active">Is Active:</label>
            <select id="is_active" name="is_active" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>

            <button type="submit">Add Employee</button>
        </form>
    </div>
@endsection