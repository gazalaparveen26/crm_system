<?php
require_once '../../config/database.php';

$leads =
mysqli_query(
$conn,
"SELECT id,lead_name
 FROM leads
 ORDER BY lead_name"
);
?>

<div class="container-fluid">

<h3>Add Followup</h3>

<form action="modules/followups/store.php"
      method="POST">

<div class="mb-3">

<label>Lead</label>

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

<option value="<?= $row['id']; ?>">

<?= htmlspecialchars(
$row['lead_name']
); ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>Date</label>

<input
type="date"
name="followup_date"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Time</label>

<input
type="time"
name="followup_time"
class="form-control">

</div>

<div class="mb-3">

<label>Notes</label>

<textarea
name="notes"
class="form-control"></textarea>

</div>

<button
class="btn btn-primary">

Save Followup

</button>

</form>

</div>