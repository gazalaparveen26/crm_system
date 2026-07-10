<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';

$id = (int)($_GET['id'] ?? 0);

$sql =
"DELETE FROM payments WHERE id=?";

$stmt =
mysqli_prepare($conn,$sql);
logActivity(
    $_SESSION['user_id'],
    'Payment',
    'Deleted',
    $_GET['id'],
    'Payment deleted'
);
mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

if(mysqli_stmt_execute($stmt))
{


    echo "success";
}
else
{
    echo "error";
}