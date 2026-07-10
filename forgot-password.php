<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">

    <div class="row justify-content-center min-vh-100 align-items-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="text-center mb-4">
                        Forgot Password
                    </h3>

                    <form method="POST"
                          action="auth/forgot-password-process.php">

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Send Reset Link

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>