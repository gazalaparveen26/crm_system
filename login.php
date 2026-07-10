<?php
require_once 'config/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center min-vh-100 align-items-center">

        <div class="col-lg-4 col-md-6 col-sm-10">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        CRM Login
                    </h2>

                    <form action="auth/login-process.php" method="POST">
                        <div class="mb-3">
                           <input
    type="hidden"
    name="csrf_token"
    value="<?= $_SESSION['csrf_token']; ?>">
                        <div class="mb-3">
                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
<div class="input-group">

    <input
        type="password"
        id="password"
        name="password"
        class="form-control">

    <button
        type="button"
        class="btn btn-outline-secondary"
        onclick="togglePassword('password')">

        👁

    </button>
    </div>  
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Login

                        </button>
                        <p class="mt-3">
                            Not registered?
                            <a href="register.php">Create an
                                account</a>
                        </p>
                        <p>
                            <a href="forgot-password.php">Forgot
                                password?</a>
                        </p>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<script src="assets/js/auth.js"></script>
</body>
</html>