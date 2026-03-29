<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Management System - Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="background: linear-gradient(135deg, #667eea, #764ba2); height: 100vh; display: flex; align-items: center; justify-content: center;">



<div style="background: #fff; border-radius: 15px; padding: 2rem; width: 400px; box-shadow: 0 8px 30px rgba(0,0,0,0.2);">

    <!-- Logo -->
    <img src="https://via.placeholder.com/80?text=TMS" alt="TMS Logo" style="display:block; margin:0 auto 1rem auto; width:80px;">

    <h3 style="text-align:center; font-weight:700; color:#204969; margin-bottom:1.5rem;">Register</h3>

    <!-- Error Message -->
    <div id="errorMsg"></div>

    <!-- Registration Form -->
    <form id="registerForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="mb-3">
            <label style="font-weight:600;" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" style="border-radius:10px; padding:10px;">
            <small id="nameError" style="color:red; font-size:0.875rem;"></small>
        </div>

        <div class="mb-3">
            <label style="font-weight:600;" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" style="border-radius:10px; padding:10px;">
            <small id="passwordError" style="color:red; font-size:0.875rem;"></small>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; padding:10px; font-weight:600;">Register</button>
    </form>

</div>

<script>
$(document).ready(function () {

    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#registerForm').submit(function(e) {
        e.preventDefault();

        let form = $(this);
        let btn = form.find('button[type="submit"]');

        btn.prop('disabled', true).text('Registering...');

        $('#errorMsg').html('');
        $('#nameError').text('');
        $('#passwordError').text('');

        $.ajax({
            url: "/register-store",
            method: "POST",
            data: form.serialize(),

            success: function(response) {
                if(response.success) {
                     $('#successMsg').html(
                        '<div class="alert alert-success">User Registered Sucessfully</div>'
                    );

                    window.location.href = "/"; // redirect to login/dashboard
                }
            },

            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if(errors.name) $('#nameError').text(errors.name[0]);
                    if(errors.password) $('#passwordError').text(errors.password[0]);
                } else {
                    $('#errorMsg').html('<div class="alert alert-danger"try again</div>');
                }
            },

            complete: function() {
                btn.prop('disabled', false).text('Register');
            }
        });
    });

});
</script>

</body>
</html>