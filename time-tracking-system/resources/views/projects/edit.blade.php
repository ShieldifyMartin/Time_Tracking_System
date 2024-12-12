@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="form-container">
        <h1>Edit Project</h1>
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Don't forget to include the method for PUT request -->
            
            <label for="name">Project Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="planned" {{ old('status', $project->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit">Edit Project</button>
        </form>
    </div>
@endsection