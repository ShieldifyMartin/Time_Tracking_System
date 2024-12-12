<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fs-3" href="{{ url('/') }}">Time Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('employees.list') }}">Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('projects.list') }}">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('workloads.list') }}">Workloads</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
