<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All Tickets</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
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
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
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
                    <a class="nav-link"  href="{{ url('add-ticket') }}">Add Tickets</a>
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
        <h3 class="mb-4 text-center">List Of All Tickets</h3>

        <table id="ticketTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->discription }}</td>
                    <td>
                        <span class="badge bg-info">{{ $ticket->status }}</span>
                    </td>
                    <td>
                        <span class="badge bg-warning">{{ $ticket->priority }}</span>
                    </td>
                    <td>{{ $ticket->create_at }}</td>
                    <td>
                        <!-- <button class="btn btn-sm btn-primary editBtn" data-id="{{ $ticket->id }}" >Edit</button> -->
                         <a href="{{ url('ticket-edit/'.$ticket->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $ticket->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#ticketTable').DataTable();
    });

    $(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    if (confirm("Are you sure you want to delete this ticket?")) {

        $.ajax({
            url: "/ticket-delete/" + id,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {
                if (response.success) {
                    alert("Ticket deleted successfully");

                    // remove row without reload
                    location.reload(); 
                }
            },

            error: function () {
                alert("Something went wrong");
            }
        });
    }
});

// for update 

</script>

</body>
</html>