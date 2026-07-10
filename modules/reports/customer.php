
<?php

require_once __DIR__ . '/../../config/database.php';

$total_customers =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total FROM customers"
)
)['total'];

$active_customers =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM customers
WHERE status='active'"
)
)['total'];

$inactive_customers =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) total
FROM customers
WHERE status='inactive'"
)
)['total'];

$total_revenue =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT COALESCE(SUM(amount),0) total
FROM invoices
"
)
)['total'];

$sql = "
SELECT

c.id,
c.customer_name,
c.company_name,

COUNT(i.id) total_invoices,

COALESCE(
SUM(i.amount),
0
) total_amount

FROM customers c

LEFT JOIN invoices i
ON i.customer_id = c.id

GROUP BY c.id

ORDER BY total_amount DESC
";

$result =
mysqli_query($conn,$sql);

?>

<div class="container-fluid">

<div class="row mb-4">

<div class="col-12">
<div class="d-flex justify-content-between align-items-center mb-3">

    <h3>
        Customer Report
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

<h6>
Total Customers
</h6>

<h2>
<?= $total_customers; ?>
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-success">
Active Customers
</h6>

<h2>
<?= $active_customers; ?>
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-danger">
Inactive Customers
</h6>

<h2>
<?= $inactive_customers; ?>
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-primary">
Total Revenue
</h6>

<h2>
₹<?= number_format($total_revenue,2); ?>
</h2>

</div>

</div>

</div>

</div>

<div class="card shadow border-0">

<div class="card-header">

<h5 class="mb-0">
Top Customers
</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th>#</th>
<th>Customer</th>
<th>Company</th>
<th>Total Invoices</th>
<th>Total Revenue</th>

</tr>

</thead>

<tbody>

<?php

$sr = 1;

while(
$row =
mysqli_fetch_assoc($result)
)
{

?>

<tr>

<td>
<?= $sr++; ?>
</td>

<td>
<?= htmlspecialchars($row['customer_name']); ?>
</td>

<td>
<?= htmlspecialchars($row['company_name']); ?>
</td>

<td>
<?= $row['total_invoices']; ?>
</td>

<td>
₹<?= number_format($row['total_amount'],2); ?>
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