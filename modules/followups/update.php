<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';  

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    exit('Invalid Request');
}

$id =
(int)$_POST['id'];

$lead_id =
(int)$_POST['lead_id'];

$followup_date =
trim($_POST['followup_date']);

$followup_time =
trim($_POST['followup_time']);

$notes =
trim($_POST['notes']);

$status =
trim($_POST['status']);

$sql = "

UPDATE lead_followups

SET

lead_id = ?,
followup_date = ?,
followup_time = ?,
notes = ?,
status = ?

WHERE id = ?

";

$stmt =
mysqli_prepare(
$conn,
$sql
);
logActivity(
    $_SESSION['user_id'],
    'Payment',
    'Updated',
    $_POST['id'],
    'Payment updated'
);
mysqli_stmt_bind_param(
$stmt,
"issssi",
$lead_id,
$followup_date,
$followup_time,
$notes,
$status,
$id
);

if(mysqli_stmt_execute($stmt))
{
?>

<script>
alert('Followup Updated Successfully');
window.location ='/dashboard.php?page=modules/followups/index.php';
</script>

<?php
}
else
{
?>

<script>

alert('Error Updating Followup');

history.back();

</script>

<?php
}
?>