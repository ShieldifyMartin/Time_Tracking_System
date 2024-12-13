@extends('layouts.app')

@section('title', 'Employee Workload Charts')

@section('content')
<div class="container">
    <h1>Employee Workload Charts</h1>

    <div class="row">
        @foreach($employees as $employee)
            <div class="col-md-4 border">
                <h3 class="text-center">{{ $employee->first_name }} {{ $employee->last_name }}</h3>

                <!-- Chart 1: Total hours worked this month -->
                <div id="chartContainer{{$employee->id}}_1" style="height: 170px; width: 80%;"></div>

                <!-- Chart 2: Hours worked per project -->
                <div id="chartContainer{{$employee->id}}_2" style="height: 170px; width: 80%;"></div>

                <!-- Chart 3: Hours worked per day this month -->
                <div id="chartContainer{{$employee->id}}_3" style="height: 170px; width: 80%;"></div>

                <!-- Chart 4: Hours worked by week -->
                <div id="chartContainer{{$employee->id}}_4" style="height: 170px; width: 80%;"></div>
            </div>
        @endforeach
    </div>
</div>

<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    window.onload = function () {
        var employees = @json($employees);
        var workloadsLast30Days = @json($workloadsLast30Days);
        var projects = @json($projects);

        // Loop through each employee and render the charts
        employees.forEach(function(employee) {
            console.log("Processing Employee:", employee);
            var employeeWorkloads = workloadsLast30Days.filter(function(workload) {
                return workload.employee_id === employee.id;
            });
            console.log("Workloads for Employee " + employee.id + ":", employeeWorkloads);

            // Chart 1: Total hours worked this month
            var totalHoursWorked = employeeWorkloads.reduce(function(sum, workload) {
                return sum + workload.hours_worked;
            }, 0);

            var chart1 = new CanvasJS.Chart("chartContainer" + employee.id + "_1", {
                title: { text: "Total Hours Worked (This Month)" },
                data: [{ type: "column", dataPoints: [{ label: "Hours", y: totalHoursWorked }] }]
            });
            chart1.render();

            // Chart 2: Hours worked per project
            var projectHours = {};
            employeeWorkloads.forEach(function(workload) {
                projectHours[workload.project_id] = (projectHours[workload.project_id] || 0) + workload.hours_worked;
            });

            var dataPoints2 = Object.keys(projectHours).map(function(projectId) {
                var project = projects.find(function(project) { return project.id == projectId });
                var projectName = project ? project.name : 'Unknown Project';
                return { label: projectName, y: projectHours[projectId] };
            });

            var chart2 = new CanvasJS.Chart("chartContainer" + employee.id + "_2", {
                title: { text: "Hours Worked per Project" },
                data: [{ type: "pie", dataPoints: dataPoints2 }]
            });
            chart2.render();

            // Chart 3: Hours worked per day
            var dayHours = {};
            employeeWorkloads.forEach(function(workload) {
                var day = workload.date.split(' ')[0]; // Extract just the date part (YYYY-MM-DD)
                dayHours[day] = (dayHours[day] || 0) + workload.hours_worked;
            });

            var dataPoints3 = Object.keys(dayHours).map(function(day) {
                return { label: day, y: dayHours[day] };
            });

            var chart3 = new CanvasJS.Chart("chartContainer" + employee.id + "_3", {
                title: { text: "Hours Worked per Day" },
                data: [{ type: "line", dataPoints: dataPoints3 }]
            });
            chart3.render();

            // Chart 4: Hours worked by week
            var weekHours = {};
            employeeWorkloads.forEach(function(workload) {
                var week = moment(workload.date).isoWeek();
                weekHours[week] = (weekHours[week] || 0) + workload.hours_worked;
            });

            var dataPoints4 = Object.keys(weekHours).map(function(week) {
                return { label: 'Week ' + week, y: weekHours[week] };
            });

            var chart4 = new CanvasJS.Chart("chartContainer" + employee.id + "_4", {
                title: { text: "Hours Worked by Week" },
                data: [{ type: "column", dataPoints: dataPoints4 }]
            });
            chart4.render();
        });
    }
</script>
@endsection