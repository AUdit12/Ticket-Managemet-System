<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Ticket</title>

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
                    <a class="nav-link"  href="{{ url('dashboard') }}">Home</a>
                </li>

                 <li class="nav-item">
                    <a class="nav-link"  href="{{ url('tickets-view') }}">View Ticket</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ url('logout') }}">Logout</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card shadow p-4">

        <h3 class="mb-4 text-center">Edit Ticket</h3>

        <form method="POST" action="{{ url('ticket-update/'.$ticket->id) }}">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $ticket->title }}">
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label>Description</label>
                <textarea name="discription" class="form-control">{{ $ticket->discription }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                    <option {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Priority -->
            <div class="mb-3">
                <label>Priority</label>
                <select name="priority" class="form-control">
                    <option {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                    <option {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Update Ticket</button>
        </form>

    </div>
</div>

</body>
</html>