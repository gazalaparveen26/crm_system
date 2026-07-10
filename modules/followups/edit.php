<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)$_GET['id'];

$sql = "

SELECT *

FROM lead_followups

WHERE id = ?

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

$leads =
mysqli_query(
$conn,
"SELECT
id,
lead_name
FROM leads
ORDER BY lead_name"
);

?>

<div class="card shadow border-0">

<div class="card-header d-flex justify-content-between align-items-center">

<h4 class="mb-0">

Edit Followup

</h4>

<button
class="btn btn-secondary"
onclick="loadPage('modules/followups/index.php')">

Back

</button>

</div>

<div class="card-body">

<form
action="modules/followups/update.php"
method="POST">

<input
type="hidden"
name="id"
value="<?= $followup['id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Lead

</label>

<select
name="lead_id"
class="form-control"
required>

<?php

while(
$row =
mysqli_fetch_assoc($leads)
)
{

?>

<option

value="<?= $row['id']; ?>"

<?= ($row['id']==$followup['lead_id']) ? 'selected' : ''; ?>

>

<?= htmlspecialchars($row['lead_name']); ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Followup Date

</label>

<input
type="date"
name="followup_date"
class="form-control"
value="<?= $followup['followup_date']; ?>"
required>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Followup Time

</label>

<input
type="time"
name="followup_time"
class="form-control"
value="<?= $followup['followup_time']; ?>">

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Notes

</label>

<textarea
name="notes"
rows="4"
class="form-control"><?= htmlspecialchars($followup['notes']); ?></textarea>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-control">

<option
value="pending"
<?= ($followup['status']=='pending') ? 'selected' : ''; ?>>

Pending

</option>

<option
value="completed"
<?= ($followup['status']=='completed') ? 'selected' : ''; ?>>

Completed

</option>

</select>

</div>

</div>

<button
type="submit"
class="btn btn-primary">

Update Followup

</button>

</form>

</div>

</div>