<?php

require_once '../config/database.php';

$token = $_POST['token'];

$password = $_POST['password'];

$sql = "
SELECT *
FROM password_resets
WHERE token = ?
AND expires_at > NOW()
";

$stmt = mysqli_prepare(
    $conn,
    $sql
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $token
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {

    $reset = mysqli_fetch_assoc($result);

    $hashedPassword = password_hash(
        $password,
        PASSWORD_BCRYPT
    );

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

    echo "Password Updated Successfully";
}
else {

    echo "Invalid Or Expired Token";

}