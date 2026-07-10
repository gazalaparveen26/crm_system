<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $token = trim($_POST['token']);

    $password = $_POST['password'];

    $confirmPassword = $_POST['confirm_password'];

    // Password Match Check
    if ($password !== $confirmPassword) {

        die("Passwords do not match");

    }

    // Token Verify
    $sql = "
        SELECT *
        FROM password_resets
        WHERE token = ?
        AND expires_at > NOW()
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $token
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $reset = mysqli_fetch_assoc($result);

        // Password Hash
        $hashedPassword = password_hash(
            $password,
            PASSWORD_BCRYPT
        );

        // Update User Password
        $update = "
            UPDATE users
            SET password = ?
            WHERE id = ?
        ";

        $stmt = mysqli_prepare(
            $conn,
            $update
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $hashedPassword,
            $reset['user_id']
        );

        mysqli_stmt_execute($stmt);

        // Delete Used Token
        $delete = "
            DELETE FROM password_resets
            WHERE token = ?
        ";

        $stmt = mysqli_prepare(
            $conn,
            $delete
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $token
        );

        mysqli_stmt_execute($stmt);

        header(
            "Location: ../login.php?reset=success"
        );

        exit;

    } else {

        die("Invalid or Expired Token");

    }

}