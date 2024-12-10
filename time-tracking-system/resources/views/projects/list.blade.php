@extends('layouts.app')

@section('title', 'Projects List')

@section('content')
<div>
    <h1>Projects</h1>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No projects found.</p>
    @endif
</div>
@endsection