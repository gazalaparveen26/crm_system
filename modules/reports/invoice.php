
<?php

require_once __DIR__ . '/../../config/database.php';

$status =
$_GET['status'] ?? '';

$where = '';

if(!empty($status))
{
    $where =
    " WHERE i.status='$status' ";
}

$total_invoices =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM invoices"
)
)['total'];

$paid_invoices =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM invoices WHERE status='paid'"
)
)['total'];

$pending_invoices =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM invoices WHERE status='pending'"
)
)['total'];

$overdue_invoices =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM invoices WHERE status='overdue'"
)
)['total'];

$sql = "
SELECT
i.*,
c.customer_name
FROM invoices i
LEFT JOIN customers c
ON c.id=i.customer_id
$where
ORDER BY i.id DESC
";

$result =
mysqli_query($conn,$sql);

?>

<div class="container-fluid">

<div class="row mb-4">

<div class="col-12">
<div class="d-flex justify-content-between align-items-center mb-3">

    <h3>
        Invoice Report
    </h3>

    <button
    class="btn btn-secondary"
    onclick="loadPage('modules/reports/index.php')">

        Back

    </button>

</div>

</div>

</div>

<div class="row g-3 mb-4">

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6>Total Invoices</h6>

<h2><?= $total_invoices; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-success">
Paid
</h6>

<h2><?= $paid_invoices; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-warning">
Pending
</h6>

<h2><?= $pending_invoices; ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-danger">
Overdue
</h6>

<h2><?= $overdue_invoices; ?></h2>

</div>

</div>

</div>

</div>

<div class="card shadow border-0 mb-4">

<div class="card-body">

<form
onsubmit="event.preventDefault(); filterInvoiceReport();">

<div class="row">

<div class="col-md-4">

<label>Status</label>

<select name="status" class="form-select">
<option value="">All Status</option>
<option value="pending">Pending</option>
<option value="paid">Paid</option>
<option value="partial">Partial</option>
<option value="overdue">Overdue</option>
</select>
</div>
<div class="col-md-4 d-flex align-items-end">
<button type="submit" class="btn btn-primary">Filter</button>
</div>

</div>

</form>

</div>

</div>

<div class="card shadow border-0">

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th>Invoice No</th>
<th>Customer</th>
<th>Date</th>
<th>Amount</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

while(
$row =
mysqli_fetch_assoc($result)
)
{

?>

<tr>

<td>
<?= htmlspecialchars($row['invoice_number']); ?>
</td>

<td>
<?= htmlspecialchars($row['customer_name']); ?>
</td>

<td>
<?= $row['invoice_date']; ?>
</td>

<td>
₹<?= number_format($row['amount'],2); ?>
</td>

<td>
<?= ucfirst($row['status']); ?>
</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>

