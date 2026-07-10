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
p.*,
i.invoice_number,
i.status
FROM payments p
LEFT JOIN invoices i
ON i.id = p.invoice_id
WHERE p.id = ?
";

$stmt =
mysqli_prepare($conn,$sql);

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

<div class="card-header d-flex justify-content-between">

<h4>
Payment Details
</h4>

<button
class="btn btn-secondary"
onclick="loadPage('modules/payments/index.php')">

Back

</button>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<strong>
Invoice Number
</strong>

<br>

<?= htmlspecialchars($payment['invoice_number']); ?>

</div>

<div class="col-md-6 mb-3">

<strong>
Payment Date
</strong>

<br>

<?= $payment['payment_date']; ?>

</div>

<div class="col-md-6 mb-3">

<strong>
Amount
</strong>

<br>

₹<?= number_format($payment['amount'],2); ?>

</div>
<div class="col-md-6 mb-3">

<strong>
Invoice Status
</strong>

<br>

<?= ucfirst($payment['status']); ?>

</div>
<div class="col-md-6 mb-3">

<strong>
Payment Method
</strong>

<br>

<?= ucwords(str_replace('_',' ',$payment['payment_method'])); ?>

</div>

<div class="col-md-6 mb-3">

<strong>
Transaction ID
</strong>

<br>

<?= htmlspecialchars($payment['transaction_id']); ?>

</div>

<div class="col-12 mb-3">

<strong>
Remarks
</strong>

<br>

<?= nl2br(htmlspecialchars($payment['remarks'])); ?>

</div>

</div>

</div>

</div>
