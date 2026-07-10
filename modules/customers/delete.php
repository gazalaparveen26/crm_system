<?php

require_once '../../config/database.php';
require_once '../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
$id = (int) ($_GET['id'] ?? 0);
$sql = "DELETE FROM customers WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
logActivity(
    $_SESSION['user_id'],
    'Customer',
    'Deleted',
    $_GET['id'],
    'Customer deleted'
);
mysqli_stmt_bind_param($stmt, "i", $id);
if(mysqli_stmt_execute($stmt))
{


    echo "success";
}
else
{
    echo "error";
}