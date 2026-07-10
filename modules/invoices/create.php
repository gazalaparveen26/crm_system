<?php

require_once __DIR__ . '/../../config/database.php';

$invoice_number =
'INV-' . date('Ymd') . '-' . rand(100,999);

$customers =
mysqli_query(
$conn,
"SELECT id, customer_name
FROM customers
ORDER BY customer_name ASC"
);

?>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">
Create Invoice
</h4>

</div>

<div class="card-body">

<form
action="modules/invoices/store.php"
method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Invoice Number
</label>

<input
type="text"
name="invoice_number"
class="form-control"
value="<?= $invoice_number; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Customer
</label>

<select
name="customer_id"
class="form-select"
required>

<option value="">
Select Customer
</option>

<?php
while($customer =
mysqli_fetch_assoc($customers))
{
?>

<option
value="<?= $customer['id']; ?>">

<?= htmlspecialchars(
$customer['customer_name']
); ?>

</option>

<?php
}
?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Invoice Date
</label>

<input
type="date"
name="invoice_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Due Date
</label>

<input
type="date"
name="due_date"
class="form-control">

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
Subtotal
</label>

<input
type="number"
step="0.01"
id="subtotal"
name="subtotal"
class="form-control"
oninput="calculateTotal()"
required>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
Tax (%)
</label>

<input
type="number"
step="0.01"
id="tax"
name="tax"
class="form-control"
value="18"
oninput="calculateTotal()">

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
Discount
</label>

<input
type="number"
step="0.01"
id="discount"
name="discount"
class="form-control"
value="0"
oninput="calculateTotal()">

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
Grand Total
</label>

<input
type="number"
step="0.01"
id="amount"
name="amount"
class="form-control bg-light"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-select">

<option value="pending">
Pending
</option>

<option value="paid">
Paid
</option>

<option value="partial">
Partial
</option>

<option value="overdue">
Overdue
</option>

</select>

</div>

<div class="col-12 mb-3">

<label class="form-label">
Notes
</label>

<textarea
name="notes"
class="form-control"
rows="4"></textarea>

</div>

</div>

<button
type="submit"
class="btn btn-success">

Save Invoice

</button>

<button
type="button"
class="btn btn-secondary"
onclick="loadPage('modules/invoices/index.php')">

Cancel

</button>

</form>

</div>

</div>

<script>

function calculateTotal()
{
let subtotal =
parseFloat(
document.getElementById('subtotal').value
) || 0;

let tax =
parseFloat(
document.getElementById('tax').value
) || 0;

let discount =
parseFloat(
document.getElementById('discount').value
) || 0;

let taxAmount =
(subtotal * tax) / 100;

let grandTotal =
subtotal + taxAmount - discount;

document.getElementById('amount').value =
grandTotal.toFixed(2);
}

</script>
