<?php

require_once '../../config/database.php';
require_once '../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
$lead_id =
$_POST['lead_id'];

$date =
$_POST['followup_date'];

$time =
$_POST['followup_time'];

$notes =
$_POST['notes'];

$sql =
"INSERT INTO lead_followups
(
lead_id,
followup_date,
followup_time,
notes,
created_by
)
VALUES
(?,?,?,?,?)";

$stmt =
mysqli_prepare(
$conn,
$sql
);
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
"isssi",
$lead_id,
$date,
$time,
$notes,
$_SESSION['user_id']
);

mysqli_stmt_execute($stmt);

?>

<script>
alert('Followup Added');
window.location ='/dashboard.php?page=modules/followups/index.php';
</script>