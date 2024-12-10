@extends('layouts.app')

@section('title', 'Workloads List')

@section('content')
<div>
    <h1>Workloads</h1>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No workloads found.</p>
    @endif
</div>
@endsection