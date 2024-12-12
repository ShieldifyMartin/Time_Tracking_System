@extends('layouts.app')

@section('title', 'Add Project')

@section('content')
    <div class="form-container">
        <h1>Add New Project</h1>
        <form action="{{ url('projects') }}" method="POST">
            @csrf
            <label for="name">Project Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="planned">Planned</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="on_hold">On Hold</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <button type="submit">Add Project</button>
        </form>
    </div>
</body>
</html>
@endsection