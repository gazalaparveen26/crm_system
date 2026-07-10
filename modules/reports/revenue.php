
<?php

require_once __DIR__ . '/../../config/database.php';

$from =
$_GET['from'] ?? '';

$to =
$_GET['to'] ?? '';

$where = '';

if(!empty($from) && !empty($to))
{
    $where =
    " WHERE p.payment_date BETWEEN '$from' AND '$to' ";
}

$total_revenue =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COALESCE(SUM(amount),0) total
FROM payments"
)
)['total'];

$today_revenue =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT COALESCE(SUM(amount),0) total
FROM payments
WHERE payment_date = CURDATE()
"
)
)['total'];

$month_revenue =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"
SELECT COALESCE(SUM(amount),0) total
FROM payments
WHERE MONTH(payment_date)=MONTH(CURDATE())
AND YEAR(payment_date)=YEAR(CURDATE())
"
)
)['total'];

$sql = "
SELECT
p.*,
i.invoice_number
FROM payments p
LEFT JOIN invoices i
ON i.id=p.invoice_id
$where
ORDER BY p.id DESC
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

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-success">
Total Revenue
</h6>

<h2>
₹<?= number_format($total_revenue,2); ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-primary">
Today's Revenue
</h6>

<h2>
₹<?= number_format($today_revenue,2); ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-info">
This Month Revenue
</h6>

<h2>
₹<?= number_format($month_revenue,2); ?>
</h2>

</div>

</div>

</div>

</div>

<div class="card shadow border-0 mb-4">

<div class="card-body">

<form
onsubmit="event.preventDefault(); filterRevenueReport();">

<div class="row">

<div class="col-md-4">

<label>
From Date
</label>

<input
type="date"
name="from"
class="form-control"
value="<?= $from; ?>">

</div>

<div class="col-md-4">

<label>
To Date
</label>

<input
type="date"
name="to"
class="form-control"
value="<?= $to; ?>">

</div>

<div class="col-md-4 d-flex align-items-end">

<button
type="submit"
class="btn btn-primary">

Filter

</button>

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

<th>ID</th>
<th>Invoice</th>
<th>Date</th>
<th>Amount</th>
<th>Method</th>

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
<?= $row['id']; ?>
</td>

<td>
<?= htmlspecialchars($row['invoice_number']); ?>
</td>

<td>
<?= $row['payment_date']; ?>
</td>

<td>
₹<?= number_format($row['amount'],2); ?>
</td>

<td>
<?= ucwords(
str_replace(
'_',
' ',
$row['payment_method']
)
); ?>
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
