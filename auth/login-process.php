<?php

require_once '../config/database.php';
require_once '../config/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // CSRF Check
    if (
        !isset($_POST['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {

        die("Invalid Request");

    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user =
            mysqli_fetch_assoc($result);

        // Account Lock Check
        if (
            !empty($user['locked_until']) &&
            strtotime($user['locked_until']) > time()
        ) {

            die(
                "Account Locked. Try Again After 15 Minutes."
            );

        }

        // Password Check
        if (
            password_verify(   $password, $user['password']) ) {

            // Reset Failed Attempts
            $reset_sql =  "UPDATE users  SET failed_attempts = 0,  locked_until = NULL WHERE id = ?";
            $reset_stmt =  mysqli_prepare($conn,  $reset_sql);
            mysqli_stmt_bind_param( $reset_stmt, "i", $user['id'] );
            mysqli_stmt_execute(  $reset_stmt);
            session_regenerate_id(true);
            $_SESSION['user_id'] =$user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] =$user['email'];
            $_SESSION['role'] =$user['role'];
            header( "Location: ../dashboard.php" );
            exit;
        } else {
            // Increase Failed Attempts
            $attempts = $user['failed_attempts'] + 1;
            $update_sql = " UPDATE users SET failed_attempts = ? WHERE id = ? ";
            $update_stmt =mysqli_prepare(   $conn, $update_sql );
            mysqli_stmt_bind_param( $update_stmt,   "ii", $attempts, $user['id'] );
            mysqli_stmt_execute( $update_stmt );
            // Lock Account After 5 Attempts
            if ($attempts >= 5) {
                $lock_time = date("Y-m-d H:i:s", strtotime("+15 minutes"));
                $lock_sql = "  UPDATE users SET locked_until = ?  WHERE id = ? ";
                $lock_stmt =   mysqli_prepare(  $conn, $lock_sql);
                mysqli_stmt_bind_param($lock_stmt, "si",$lock_time,$user['id'] );
                mysqli_stmt_execute($lock_stmt);
                die( "Account Locked For 15 Minutes" );
            }
        echo "<script>alert('Invalid Password. Attempt: " . $attempts . "');
        window.location.href = '../login.php';</script>";
            
        }

    } else {

        
  echo "<script>alert('User Not Found');
  window.location.href = '../login.php';</script>";
    }

}