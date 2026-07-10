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
SELECT
i.*,
c.customer_name,
c.company_name,
c.email,
c.phone,
c.address
FROM invoices i
LEFT JOIN customers c
ON c.id = i.customer_id
WHERE i.id = ?
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

$tax_amount =
($invoice['subtotal'] * $invoice['tax']) / 100;

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="mb-0">
<?= htmlspecialchars($invoice['company_name']); ?>
</h2>

<p class="mb-0">
GST :
<?= htmlspecialchars($invoice['company_gst']); ?>
</p>

</div>

<div class="text-end">

<h4>
Invoice
</h4>

<p class="mb-0">
<?= $invoice['invoice_number']; ?>
</p>

</div>

</div>

<hr>

<div class="row">

<div class="col-md-6">

<h5>Customer Details</h5>

<p>

<strong>Name:</strong>

<?= htmlspecialchars($invoice['customer_name']); ?>

<br>

<strong>Company:</strong>

<?= htmlspecialchars($invoice['company_name']); ?>

<br>

<strong>Email:</strong>

<?= htmlspecialchars($invoice['email']); ?>

<br>

<strong>Phone:</strong>

<?= htmlspecialchars($invoice['phone']); ?>

</p>

</div>

<div class="col-md-6 text-end">

<p>

<strong>Invoice Date:</strong>

<?= $invoice['invoice_date']; ?>

<br>

<strong>Due Date:</strong>

<?= $invoice['due_date']; ?>

<br>

<strong>Status:</strong>

<?= ucfirst($invoice['status']); ?>

</p>

</div>

</div>

<table class="table table-bordered mt-4">

<thead>

<tr>

<th>Description</th>
<th class="text-end">Amount</th>

</tr>

</thead>

<tbody>

<tr>

<td>Subtotal</td>

<td class="text-end">
Rs. <?= number_format($invoice['subtotal'],2); ?>
</td>

</tr>

<tr>

<td>
Tax (<?= $invoice['tax']; ?>%)
</td>

<td class="text-end">
Rs. <?= number_format($tax_amount,2); ?>
</td>

</tr>

<tr>

<td>Discount</td>

<td class="text-end">
Rs. <?= number_format($invoice['discount'],2); ?>
</td>

</tr>

<tr class="table-primary">

<td>
<strong>Grand Total</strong>
</td>

<td class="text-end">

<strong>
Rs. <?= number_format($invoice['amount'],2); ?>
</strong>

</td>

</tr>

</tbody>

</table>

<?php if(!empty($invoice['notes'])) { ?>

<div class="mt-4">

<h5>Notes</h5>

<p>
<?= nl2br(htmlspecialchars($invoice['notes'])); ?>
</p>

</div>

<?php } ?>

<hr>

<div class="d-flex gap-2">

<a
href="modules/invoices/pdf.php?id=<?= $invoice['id']; ?>"
class="btn btn-danger"
target="_blank">

Download PDF

</a>



<button
class="btn btn-warning"
onclick="loadPage('modules/invoices/edit.php?id=<?= $invoice['id']; ?>')">

Edit

</button>

<button
class="btn btn-secondary"
onclick="loadPage('modules/invoices/view.php')">

Back

</button>

</div>

</div>

</div>

</div>
