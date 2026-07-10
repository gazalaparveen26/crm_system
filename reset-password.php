<?php

$token = $_GET['token'];

?>

<!DOCTYPE html>
<html>
<head>

    <title>Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center min-vh-100 align-items-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="text-center mb-4">

                        Reset Password

                    </h3>

                    <form
                        method="POST"
                        action="auth/reset-password-process.php">

                        <input
                            type="hidden"
                            name="token"
                            value="<?= $token ?>">

                        <div class="mb-3">

                            <label>New Password</label>
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
                            class="btn btn-success w-100">

                            Update Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<script src="assets/js/auth.js"></script>
</body>
</html>