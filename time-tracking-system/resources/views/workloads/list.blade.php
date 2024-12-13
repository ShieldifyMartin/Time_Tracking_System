@extends('layouts.app')

@section('title', 'Workloads List')

@section('content')
<div>
    <h1>Workloads</h1>
    
    <a class="nav-link active w-auto px-3 py-2 btn btn-primary" href="{{ route('workloads.add') }}">Add Workload</a>

    @if(isset($workloads) && count($workloads) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th>Hours Worked</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workloads as $workload)
                    <tr>
                        <td>{{ $workload->id }}</td>
                        <td>{{ $workload->employee->first_name }} {{ $workload->employee->last_name }}</td>
                        <td>{{ $workload->project->name }}</td>
                        <td>{{ $workload->date->format('Y-m-d') }}</td>
                        <td>{{ $workload->hours_worked }}</td>
                        <td>{{ $workload->description }}</td>
                        <td>
                            <div class="d-flex gap-2">    
                                @if(Auth::user() && (Auth::user()->id === $workload->created_by || Auth::user()->role === 'admin'))
                                    <a href="{{ route('workloads.edit', $workload->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('workloads.delete', $workload->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this workload?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No workloads found.</p>
    @endif
</div>
@endsection