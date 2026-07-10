<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';

$id =
(int)($_POST['id'] ?? 0);

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
| Get Invoice ID
|--------------------------------------------------------------------------
*/

$get_sql = "
SELECT invoice_id
FROM payments
WHERE id = ?
";

$get_stmt =
mysqli_prepare($conn,$get_sql);

mysqli_stmt_bind_param(
$get_stmt,
"i",
$id
);

mysqli_stmt_execute($get_stmt);

$get_result =
mysqli_stmt_get_result($get_stmt);

$payment =
mysqli_fetch_assoc($get_result);

if(!$payment)
{
    die('Payment Not Found');
}

$invoice_id =
$payment['invoice_id'];

/*
|--------------------------------------------------------------------------
| Update Payment
|--------------------------------------------------------------------------
*/

$sql = "
UPDATE payments
SET
payment_date=?,
amount=?,
payment_method=?,
transaction_id=?,
remarks=?
WHERE id=?
";

$stmt =
mysqli_prepare($conn,$sql);
logActivity(
    $_SESSION['user_id'],
    'Payment',
    'Updated',
    $_POST['id'],
    'Payment updated'
);

mysqli_stmt_bind_param(
$stmt,
"sdsssi",
$payment_date,
$amount,
$payment_method,
$transaction_id,
$remarks,
$id
);

if(mysqli_stmt_execute($stmt))
{

/*
|--------------------------------------------------------------------------
| Invoice Amount
|--------------------------------------------------------------------------
*/

$invoice_sql = "
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

$paid_sql = "
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
| Status Update
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
'Payment  Updated Successfully'
);

window.location =
'/dashboard.php?page=modules/payments/index.php?id=<?=$id?>';

</script>

<?php

}
else
{

echo mysqli_error($conn);

}
?>
