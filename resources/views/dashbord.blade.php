<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .navbar .nav-link {
        color: white !important;
    }
    .navbar-brand{
        color: white !important;
    }
  

</style>
<body class="bg-light">

<!-- ✅ HEADER / NAVBAR -->
<nav class="navbar navbar-expand-lg" style="background-color: #143752;">
    <div class="container-fluid">
        
        <!-- Logo / Title -->
        <a class="navbar-brand" href="#">Ticket Management System</a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"  href="{{ url('add-ticket') }}">Add Ticket</a>
                </li>

                @if(Session::get('role') == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('view-users') }}">View Users</a>
                </li>
                @endif

                 @if(Session::get('role') == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('tickets-view') }}">View Tickets</a>
                </li>
                @endif


                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ url('logout') }}">Logout</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- ✅ DASHBOARD CONTENT -->
<div class="container mt-5">

    <div class="card shadow p-5 text-center">
        <h1 class="mb-3" style =  "color: #533fab"; >Welcome to Dashboard {{Session::get('user_name') }}</h1>
        <p class="text-muted" style = "color: #533fab"; >Current Status Of Tickets </p>
    </div>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #e69e7a"; >Total Tickets</h5>
                    <h3>{{ $total }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #dce30b";>Status - Open</h5>
                    <h3>{{ $open }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #3bccad";> Status - In Progress</h5>
                    <h3>{{ $inProgress }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #438a0e";>Status - Closed</h5>
                    <h3>{{ $closed }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #1a708f";>Priority - Low</h5>
                    <h3>{{ $low }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #263999";>Priority - Medium</h5>
                    <h3>{{ $medium }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 style =  "color: #a82037";>Priority - High</h5>
                    <h3>{{ $high }}</h3>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>