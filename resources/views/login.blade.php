<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Management System - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            width: 400px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        .login-card h3 {
            font-weight: 700;
            color: #333;
        }
        .login-card .form-control {
            border-radius: 10px;
            padding: 10px;
        }
        .login-card .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }
        .error-text {
            font-size: 0.875rem;
        }
        .logo {
            display: block;
            margin: 0 auto 1rem auto;
            width: 80px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- Logo -->
    <!-- <img src="https://via.placeholder.com/80?text=TMS" alt="TMS Logo" class="logo"> -->

    <h3 class="text-center mb-4">Ticket Management System</h3>

    <!-- Error Message -->
    <div id="errorMsg"></div>

    <!-- Login Form -->
    <form id="loginForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name">
            <small class="text-danger error-text" id="nameError"></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password">
            <small class="text-danger error-text" id="passwordError"></small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <br>
    <a href="{{ url('register') }}" >Register Yourself </a>

</div>

<script>
$(document).ready(function () {

    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#loginForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = form.find('button[type="submit"]');

        btn.prop('disabled', true).text('Logging in...');

        $('#errorMsg').html('');
        $('#nameError').text('');
        $('#passwordError').text('');

        $.ajax({
            url: "/login",
            method: "POST",
            data: form.serialize(),

            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect;
                }
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) $('#nameError').text(errors.name[0]);
                    if (errors.password) $('#passwordError').text(errors.password[0]);
                } else if (xhr.status === 401) {
                    $('#errorMsg').html('<div class="alert alert-danger">Invalid credentials</div>');
                } else {
                    $('#errorMsg').html('<div class="alert alert-danger">Server error, try again</div>');
                }
            },

            complete: function () {
                btn.prop('disabled', false).text('Login');
            }
        });
    });

});
</script>

</body>
</html>