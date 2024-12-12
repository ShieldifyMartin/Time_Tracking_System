@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4 fw-bold">Welcome to the Management System</h1>
    <p class="lead mt-3 mb-5">Your one-stop solution for managing the working process effortlessly.</p>

    <!-- Quick Login Button -->
    <button class="btn btn-primary mb-4" id="login-btn">Quick Login</button>

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
                    <a href="{{ route('employees.list') }}" class="btn btn-primary w-100">Go to Employees</a>
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
                    <a href="{{ route('projects.list') }}" class="btn btn-success w-100">Go to Projects</a>
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
                    <a href="{{ route('workloads.list') }}" class="btn btn-warning w-100">Go to Workloads</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginBtn = document.getElementById('login-btn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function() {
                var loginModal = document.getElementById('loginModal');
                if (loginModal) {
                    var myModal = new bootstrap.Modal(loginModal);
                    myModal.show();
                } else {
                    console.error("Modal with id 'loginModal' not found");
                }
            });
        } else {
            console.error("Button with id 'login-btn' not found");
        }
    });
</script>