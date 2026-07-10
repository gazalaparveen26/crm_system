<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Email already exists check
    $checkQuery = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        die("Email already registered");
    }

    // Password Hash
    $hashedPassword = password_hash(
        $password,
        PASSWORD_BCRYPT
    );

    // Insert User
    $insertQuery = "
        INSERT INTO users
        (name, email, password)
        VALUES (?, ?, ?)
    ";

    $stmt = mysqli_prepare($conn, $insertQuery);

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $name,
        $email,
        $hashedPassword
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../login.php");
        exit;

    } else {

        echo "Registration Failed";

    }
}