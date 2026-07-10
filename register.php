<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-5 col-md-7">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        CRM Registration
                    </h2>

                    <form action="auth/register-process.php" method="POST">

                        <div class="mb-3">
                            <label>Name</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required>
                        </div>

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
        class="form-control"
        onkeyup="checkPasswordStrength('password','strength')">

    <button
        type="button"
        class="btn btn-outline-secondary"
        onclick="togglePassword('password')">

        👁

    </button>

</div>

<small id="strength"></small>

                            <small id="strength"></small>

                        </div>

                        <div class="mb-3">

                            <label>Confirm Password</label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    class="form-control"
                                    required>

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('confirm_password')">

                                    👁

                                </button>

                            </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Register

                        </button>
 <p class="mt-3">
                            already have an account?
                            <a href="login.php">Login here</a>
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