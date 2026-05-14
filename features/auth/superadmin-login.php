<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Super Admin Login | LMS</title>
        <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">

        <link rel="stylesheet"
            href="/library-management-system/assets/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="/library-management-system/assets/css/style.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container" style="max-width: 420px;">

        <div class="card border-0 shadow-sm rounded-4 p-4">

            
            <div class="text-center mb-4">

                <div class="mb-3">

                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm"
                         style="width:72px;height:72px;font-size:28px;font-weight:700;">

                        LMS

                    </div>

                </div>

                <h2 class="fw-bold mb-1">
                    Super Admin Login
                </h2>

                <p class="text-muted mb-0">
                    Library Management System
                </p>

            </div>

          
            <div class="alert alert-danger d-none"
                 id="message"></div>

       
            <form id="loginForm">

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Username
                    </label>

                    <input type="text"
                           class="form-control py-2"
                           id="username"
                           name="username"
                           placeholder="Enter admin username">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <input type="password"
                           class="form-control py-2"
                           id="password"
                           name="password"
                           placeholder="Enter password">

                </div>

                <button type="submit"
                        class="btn btn-primary w-100 fw-bold py-2 rounded-3">

                    Sign In

                </button>

                

            </form>

            <div class="text-center mt-3">
                <a href="/library-management-system/features/auth/login.php"
                    class="btn btn-outline-dark w-100 fw-semibold py-2">
                    Back to Login
                </a>
            </div>

         
            <div class="text-center mt-4 pt-3 border-top">

                <small class="text-muted">
                    Authorized access only
                </small>

            </div>

        </div>

    </div>

    <script src="/library-management-system/assets/js/main.js"></script>

</body>

</html>