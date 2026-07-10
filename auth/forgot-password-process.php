<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);

    $sql = "SELECT id FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        $token = bin2hex(
            random_bytes(32)
        );

        $expiresAt = date(
            'Y-m-d H:i:s',
            strtotime('+1 hour')
        );

        $insert = "
            INSERT INTO password_resets
            (user_id, token, expires_at)
            VALUES (?, ?, ?)
        ";

        $stmt = mysqli_prepare(
            $conn,
            $insert
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iss",
            $user['id'],
            $token,
            $expiresAt
        );

        mysqli_stmt_execute($stmt);

        echo "<h3>Reset Link</h3>";

        echo "
        <a href='../reset-password.php?token=$token'>
            Click Here To Reset Password
        </a>";
    }
    else {

        echo "Email Not Found";

    }
}