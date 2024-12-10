@extends('layouts.app')

@section('title', 'Add Workload')

@section('content')
<div class="form-container">
        <h1>Add New Workload</h1>
        <form action="{{ url('workloads') }}" method="POST">
            @csrf
            <label for="employee_id">Employee ID:</label>
            <input type="number" id="employee_id" name="employee_id" required>

            <label for="project_id">Project ID:</label>
            <input type="number" id="project_id" name="project_id" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="hours_worked">Hours Worked:</label>
            <input type="number" id="hours_worked" name="hours_worked" min="1" max="24" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit">Add Workload</button>
        </form>
    </div>
</body>
</html>
@endsection