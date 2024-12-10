<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fs-3" href="{{ url('/') }}">Time Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active px-3 py-2" href="{{ route('employees.add') }}">Add Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('employees.list') }}">Employee Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active px-3 py-2" href="{{ route('projects.add') }}">Add Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('projects.list') }}">Project Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active px-3 py-2" href="{{ route('workloads.add') }}">Add Workload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('workloads.list') }}">Workload Listing</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
