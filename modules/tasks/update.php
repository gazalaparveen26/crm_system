<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';

$id = (int)$_POST['id'];

$task_title = trim($_POST['task_title']);
$description = trim($_POST['description']);
$priority = $_POST['priority'];
$status = $_POST['status'];
$start_date = $_POST['start_date'];
$due_date = $_POST['due_date'];

$sql = "
UPDATE tasks
SET
task_title = ?,
description = ?,
priority = ?,
status = ?,
start_date = ?,
due_date = ?
WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);
logActivity(
    $_SESSION['user_id'],
    'Task',
    'Updated',
    $_POST['id'],
    'Task updated'
);

mysqli_stmt_bind_param(
$stmt,
"ssssssi",
$task_title,
$description,
$priority,
$status,
$start_date,
$due_date,
$id
);

if(mysqli_stmt_execute($stmt))
{
    header(
    "Location: /dashboard.php?page=modules/tasks/index.php"
    );
    exit;
}
else
{
    echo mysqli_error($conn);
}
?>
