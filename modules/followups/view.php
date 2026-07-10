<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)$_GET['id'];

$sql = "

SELECT

f.*,

l.lead_name

FROM lead_followups f

LEFT JOIN leads l
ON l.id = f.lead_id

WHERE f.id = ?

";

$stmt =
mysqli_prepare(
$conn,
$sql
);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result =
mysqli_stmt_get_result($stmt);

$followup =
mysqli_fetch_assoc($result);

if(!$followup)
{
?>

<div class="alert alert-danger">

Followup Not Found

</div>

<?php
exit;
}

?>

<div class="card shadow border-0">

<div class="card-header d-flex justify-content-between align-items-center">

<h4 class="mb-0">

View Followup

</h4>

<button
class="btn btn-secondary"
onclick="loadPage('modules/followups/index.php')">

Back

</button>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold">

Lead

</label>

<div>

<?= htmlspecialchars($followup['lead_name']); ?>

</div>

</div>

<div class="col-md-3 mb-3">

<label class="fw-bold">

Followup Date

</label>

<div>

<?= date(
'd M Y',
strtotime($followup['followup_date'])
); ?>

</div>

</div>

<div class="col-md-3 mb-3">

<label class="fw-bold">

Followup Time

</label>

<div>

<?= $followup['followup_time']; ?>

</div>

</div>

<div class="col-md-12 mb-3">

<label class="fw-bold">

Notes

</label>

<div class="border rounded p-3">

<?= nl2br(
htmlspecialchars($followup['notes'])
); ?>

</div>

</div>

<div class="col-md-4">

<label class="fw-bold">

Status

</label>

<div>

<?php

if($followup['status']=='completed')
{
?>

<span class="badge bg-success">

Completed

</span>

<?php
}
elseif(
$followup['followup_date']
<
date('Y-m-d')
)
{
?>

<span class="badge bg-danger">

Overdue

</span>

<?php
}
else
{
?>

<span class="badge bg-warning text-dark">

Pending

</span>

<?php
}
?>

</div>

</div>

<div class="col-md-4">

<label class="fw-bold">

Created At

</label>

<div>

<?= date(
'd M Y h:i A',
strtotime($followup['created_at'])
); ?>

</div>

</div>

</div>

</div>

</div>