@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center py-5">
    @auth
        <h1 class="display-4 fw-bold">Welcome {{ Auth::user()->name }} to the Management System</h1>
    @endauth
    @guest
        <h1 class="display-4 fw-bold">Welcome to the Management System</h1>
    @endguest

    <!-- Check if user is an admin and display message -->
    @if(Auth::user() && Auth::user()->role === 'admin')
        <p class="lead text-success">You have full access as an admin.</p>
    @endif

    <p class="lead mt-3 mb-5">Your one-stop solution for managing the working process effortlessly.</p>

    <!-- Auth links - Conditional display based on authentication -->
    @guest
        <a href="{{ route('login') }}" class="btn btn-primary mb-4">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary mb-4">Register</a>
    @endguest

    @auth
        <a href="{{ route('logout') }}" class="btn btn-danger mb-4" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endauth

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Employee Card -->
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-tie fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Employees</h5>
                    <p class="card-text">Access employee records, manage salaries, and monitor working hours seamlessly.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('employees.list') }}" class="btn btn-secondary w-100">Go to Employees</a>
                </div>
            </div>
        </div>

        <!-- Project Card -->
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-tasks fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Projects</h5>
                    <p class="card-text">Keep track of your projects with details like timelines, workloads, and status updates.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('projects.list') }}" class="btn btn-secondary w-100">Go to Projects</a>
                </div>
            </div>
        </div>

        <!-- Workload Card -->
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-clipboard-list fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Workloads</h5>
                    <p class="card-text">Assign and review workloads, ensuring efficient resource management across teams.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('workloads.list') }}" class="btn btn-secondary w-100">Go to Workloads</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Showcase Charts Section - Auth only functionality -->
    @if(Auth::user())
        <div class="card-body text-center mt-5">
            <h5 class="card-title mb-3">Go to Charts</h5>
            <div class="d-flex justify-content-center align-items-center">
                <p class="card-text mb-0 me-3">Showcase in-depth chart for employees and projects working hours and analysis.</p>
                <a href="{{ route('chart') }}" class="btn btn-primary px-5 py-2">Go to Charts</a>
            </div>
        </div>
    @endif

    <!-- Generate Report Section - Admin only functionality -->
    @if(Auth::user() && Auth::user()->role === 'admin')
        <div class="card-body text-center mt-5">
            <h5 class="card-title mb-3">Generate Reports</h5>
            <div class="d-flex justify-content-center align-items-center">
                <p class="card-text mb-0 me-3">Create in-depth reports for employees and projects, including detailed workload data.</p>
                <a href="{{ route('reports.generate') }}" class="btn btn-primary px-5 py-2">Generate Report</a>
            </div>
        </div>
    @endif
</div>
@endsection