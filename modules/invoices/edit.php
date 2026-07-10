
<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if($id == 0 && isset($_GET['page']))
{
    parse_str(
        parse_url($_GET['page'], PHP_URL_QUERY),
        $params
    );

    $id = (int)($params['id'] ?? 0);
}

$sql = "
SELECT *
FROM invoices
WHERE id=?
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

$invoice =
mysqli_fetch_assoc($result);

if(!$invoice)
{
    die('Invoice Not Found');
}

$customers =
mysqli_query(
$conn,
"SELECT id, customer_name
FROM customers
ORDER BY customer_name ASC"
);

?>

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h4 class="mb-0">
Edit Invoice
</h4>

</div>

<div class="card-body">

<form
action="modules/invoices/update.php"
method="POST">

<input
type="hidden"
name="id"
value="<?= $invoice['id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Invoice Number
</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($invoice['invoice_number']); ?>"
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

<?php

while(
$customer =
mysqli_fetch_assoc($customers)
)
{

?>

<option
value="<?= $customer['id']; ?>"
<?= $customer['id']==$invoice['customer_id'] ? 'selected' : ''; ?>>

<?= htmlspecialchars($customer['customer_name']); ?>

</option>

<?php
}
?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>
Invoice Date
</label>

<input
type="date"
name="invoice_date"
class="form-control"
value="<?= $invoice['invoice_date']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>
Due Date
</label>

<input
type="date"
name="due_date"
class="form-control"
value="<?= $invoice['due_date']; ?>">

</div>

<div class="col-md-3 mb-3">

<label>
Subtotal
</label>

<input
type="number"
step="0.01"
id="subtotal"
name="subtotal"
class="form-control"
value="<?= $invoice['subtotal']; ?>"
oninput="calculateTotal()">

</div>

<div class="col-md-3 mb-3">

<label>
Tax %
</label>

<input
type="number"
step="0.01"
id="tax"
name="tax"
class="form-control"
value="<?= $invoice['tax']; ?>"
oninput="calculateTotal()">

</div>

<div class="col-md-3 mb-3">

<label>
Discount
</label>

<input
type="number"
step="0.01"
id="discount"
name="discount"
class="form-control"
value="<?= $invoice['discount']; ?>"
oninput="calculateTotal()">

</div>

<div class="col-md-3 mb-3">

<label>
Grand Total
</label>

<input
type="number"
step="0.01"
id="amount"
class="form-control bg-light"
value="<?= $invoice['amount']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>
Status
</label>

<select
name="status"
class="form-select">

<option value="pending" <?= $invoice['status']=='pending' ? 'selected' : ''; ?>>
Pending
</option>

<option value="paid" <?= $invoice['status']=='paid' ? 'selected' : ''; ?>>
Paid
</option>

<option value="partial" <?= $invoice['status']=='partial' ? 'selected' : ''; ?>>
Partial
</option>

<option value="overdue" <?= $invoice['status']=='overdue' ? 'selected' : ''; ?>>
Overdue
</option>

</select>

</div>

<div class="col-12 mb-3">

<label>
Notes
</label>

<textarea
name="notes"
class="form-control"
rows="4"><?= htmlspecialchars($invoice['notes']); ?></textarea>

</div>

</div>

<button
type="submit"
class="btn btn-success">

Update Invoice

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
subtotal * tax / 100;

let grandTotal =
subtotal + taxAmount - discount;

document.getElementById('amount').value =
grandTotal.toFixed(2);
}

</script>
