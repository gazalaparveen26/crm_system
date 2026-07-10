<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
$invoice_id =
(int)($_POST['invoice_id'] ?? 0);

$payment_date =
$_POST['payment_date'] ?? '';

$amount =
(float)($_POST['amount'] ?? 0);

$payment_method =
$_POST['payment_method'] ?? 'cash';

$transaction_id =
trim($_POST['transaction_id'] ?? '');

$remarks =
trim($_POST['remarks'] ?? '');

/*
|--------------------------------------------------------------------------
| Save Payment
|--------------------------------------------------------------------------
*/

$sql = "
INSERT INTO payments
(
invoice_id,
payment_date,
amount,
payment_method,
transaction_id,
remarks
)
VALUES
(
?,?,?,?,?,?
)
";

$stmt =
mysqli_prepare($conn,$sql);
$customer_id = mysqli_insert_id($conn);
logActivity(
    $_SESSION['user_id'],
    'Payment',
    'Created',
    $customer_id,
    'New payment created: ' . $customer_name
);
mysqli_stmt_bind_param(
$stmt,
"isdsss",
$invoice_id,
$payment_date,
$amount,
$payment_method,
$transaction_id,
$remarks
);

if(mysqli_stmt_execute($stmt))
{

/*
|--------------------------------------------------------------------------
| Invoice Total
|--------------------------------------------------------------------------
*/

$invoice_sql =
"
SELECT amount
FROM invoices
WHERE id = $invoice_id
";

$invoice_result =
mysqli_query(
$conn,
$invoice_sql
);

$invoice =
mysqli_fetch_assoc(
$invoice_result
);

$invoice_total =
(float)$invoice['amount'];

/*
|--------------------------------------------------------------------------
| Total Paid
|--------------------------------------------------------------------------
*/

$paid_sql =
"
SELECT
SUM(amount) as total_paid
FROM payments
WHERE invoice_id = $invoice_id
";

$paid_result =
mysqli_query(
$conn,
$paid_sql
);

$total_paid =
(float)
mysqli_fetch_assoc(
$paid_result
)['total_paid'];

/*
|--------------------------------------------------------------------------
| Update Status
|--------------------------------------------------------------------------
*/

if($total_paid <= 0)
{
$status = 'pending';
}
elseif($total_paid < $invoice_total)
{
$status = 'partial';
}
else
{
$status = 'paid';
}

mysqli_query(
$conn,
"
UPDATE invoices
SET status='$status'
WHERE id=$invoice_id
"
);

?>

<script>

alert(
'Payment Added Successfully'
);

window.location ='/dashboard.php?page=modules/payments/index.php';

</script>
<?php

}
else
{

echo mysqli_error($conn);

}
?>
