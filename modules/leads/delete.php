<?php

require_once '../../config/database.php';
require_once '../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
$id = (int)($_GET['id'] ?? 0);
$sql = "DELETE FROM leads WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
logActivity(
    $_SESSION['user_id'],
    'Lead',
    'Deleted',
    $_GET['id'],
    'Lead deleted'
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