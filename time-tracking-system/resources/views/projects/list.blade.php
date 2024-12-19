@extends('layouts.app')

@section('title', 'Projects List')

@section('content')
<div>
    <h1>Projects</h1>

    @if(Auth::user())
        <a class="nav-link active w-auto px-3 py-2 btn btn-primary" href="{{ route('projects.add') }}">Add Project</a>
    @endif

    @if(isset($projects) && count($projects) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Workloads</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->start_date->format('Y-m-d') }}</td>
                        <td>{{ $project->end_date->format('Y-m-d') }}</td>
                        <td>{{ $project->status }}</td>
                        <td>{{ $project->workloads->count() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if(Auth::user() && (Auth::user()->id === $project->created_by || Auth::user()->role === 'admin'))
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('projects.delete', $project->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No projects found.</p>
    @endif
</div>
@endsection