<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

$sql = "
SELECT *
FROM payments
WHERE id = ?
";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result =
mysqli_stmt_get_result($stmt);

$payment =
mysqli_fetch_assoc($result);

if(!$payment)
{
    die('Payment Not Found');
}

?>

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h4 class="mb-0">
Edit Payment
</h4>

</div>

<div class="card-body">

<form
action="modules/payments/update.php"
method="POST">

<input
type="hidden"
name="id"
value="<?= $payment['id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Payment Date
</label>

<input
type="date"
name="payment_date"
class="form-control"
value="<?= $payment['payment_date']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Amount
</label>

<input
type="number"
step="0.01"
name="amount"
class="form-control"
value="<?= $payment['amount']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Payment Method
</label>

<select
name="payment_method"
class="form-select">

<option value="cash"
<?= $payment['payment_method']=='cash' ? 'selected' : ''; ?>>
Cash
</option>

<option value="upi"
<?= $payment['payment_method']=='upi' ? 'selected' : ''; ?>>
UPI
</option>

<option value="bank_transfer"
<?= $payment['payment_method']=='bank_transfer' ? 'selected' : ''; ?>>
Bank Transfer
</option>

<option value="card"
<?= $payment['payment_method']=='card' ? 'selected' : ''; ?>>
Card
</option>

<option value="other"
<?= $payment['payment_method']=='other' ? 'selected' : ''; ?>>
Other
</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Transaction ID
</label>

<input
type="text"
name="transaction_id"
class="form-control"
value="<?= htmlspecialchars($payment['transaction_id']); ?>">

</div>

<div class="col-12 mb-3">

<label class="form-label">
Remarks
</label>

<textarea
name="remarks"
rows="4"
class="form-control"><?= htmlspecialchars($payment['remarks']); ?></textarea>

</div>

</div>

<button
type="submit"
class="btn btn-success">

Update Payment

</button>

<button
type="button"
class="btn btn-secondary"
onclick="loadPage('modules/payments/index.php')">

Cancel

</button>

</form>

</div>

</div>
