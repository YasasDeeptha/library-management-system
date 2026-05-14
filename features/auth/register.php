<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">

    <link rel="stylesheet" href="/library-management-system/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/library-management-system/assets/css/style.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container" style="max-width: 500px;">

    <div class="card border-0 shadow-sm rounded-4 p-4">

        <div class="text-center mb-4">
            <h4 class="fw-bold mb-1">Staff Registration</h4>
        </div>

        <div class="alert alert-danger d-none" id="message"></div>

        <form id="registerForm">

            <div class="mb-3">
                <label class="form-label small fw-medium">
                    Username
                </label>

                <input type="text"
                       class="form-control"
                       id="username"
                       name="username"
                       required>
            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-medium">
                        First Name
                    </label>

                    <input type="text"
                           class="form-control"
                           id="firstname"
                           name="firstname"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-medium">
                        Last Name
                    </label>

                    <input type="text"
                           class="form-control"
                           id="lastname"
                           name="lastname"
                           required>
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label small fw-medium">
                    Email Address
                </label>

                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-medium">
                    Password
                </label>

                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       required>
            </div>

            <button type="submit"
                    class="btn btn-primary w-100 fw-bold py-2">
                Register
            </button>

        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <a href="/library-management-system/index.php"
               class="text-decoration-none fw-semibold">
                Back to Login
            </a>
        </div>

    </div>

</div>

<script src="/library-management-system/assets/js/main.js"></script>

</body>
</html>