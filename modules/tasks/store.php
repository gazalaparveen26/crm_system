<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';  
$task_title = trim($_POST['task_title']);
$description = trim($_POST['description']);
$priority = $_POST['priority'];
$status = $_POST['status'];
$start_date = $_POST['start_date'];
$due_date = $_POST['due_date'];

$sql = "
INSERT INTO tasks
(
task_title,
description,
priority,
status,
start_date,
due_date
)
VALUES
(
?,?,?,?,?,?
)
";

$stmt = mysqli_prepare($conn,$sql);
$task_id = mysqli_insert_id($conn);
logActivity(
    $_SESSION['user_id'],
    'Task',
    'Created',
    $task_id,
    'New task created: ' . $task_title  
);
mysqli_stmt_bind_param(
$stmt,
"ssssss",
$task_title,
$description,
$priority,
$status,
$start_date,
$due_date
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
