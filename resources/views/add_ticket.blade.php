<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Ticket</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
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

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Add Ticket</h3>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

      <form id="ticketForm">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control">
                <small class="text-danger" id="titleError"></small>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="discription" class="form-control"></textarea>
                <small class="text-danger" id="descriptionError"></small>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Closed">Closed</option>
                </select>
                <small class="text-danger" id="statusError"></small>
            </div>

            <!-- Priority -->
            <div class="mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-control">
                    <option value="">Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <!-- Created At -->
            <!-- <div class="mb-3">
                <label class="form-label">Created At</label>
                <input type="datetime-local" name="created_at" class="form-control">
            </div> -->

            <div id="successMsg"></div>

            <button type="submit" class="btn btn-primary w-100">Create Ticket</button>
        </form>

    </div>
</div>

</body>

<script>
    $(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ticketForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = form.find('button[type="submit"]');

        // clear old messages
        $('#successMsg').html('');
        $('#titleError').text('');
        $('#discriptionError').text('');
        $('#statusError').text('');

        btn.prop('disabled', true);

        $.ajax({
            url: "/tickets-store",
            method: "POST",
            data: form.serialize(),

            success: function (response) {

                if (response.success) {

                    $('#successMsg').html(
                        '<div class="alert alert-success">Ticket Created Successfully</div>'
                    );
                   window.location.href = "/dashboard";

                    form[0].reset();
                }
            },

            error: function (xhr) {

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.title) {
                        $('#titleError').text(errors.title[0]);
                    }

                    if (errors.description) {
                        $('#discriptionError').text(errors.description[0]);
                    }

                    if (errors.status) {
                        $('#statusError').text(errors.status[0]);
                    }
                } else {
                    $('#successMsg').html(
                        '<div class="alert alert-danger">Something went wrong</div>'
                    );
                }
            },

            complete: function () {
                btn.prop('disabled', false);
            }
        });
    });

});
</script>

</html>