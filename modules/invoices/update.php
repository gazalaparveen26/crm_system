<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
$id =
(int)($_POST['id'] ?? 0);

$customer_id =
(int)($_POST['customer_id'] ?? 0);

$invoice_date =
$_POST['invoice_date'] ?? '';

$due_date =
!empty($_POST['due_date'])
? $_POST['due_date']
: null;

$subtotal =
(float)($_POST['subtotal'] ?? 0);

$tax =
(float)($_POST['tax'] ?? 0);

$discount =
(float)($_POST['discount'] ?? 0);

$status =
$_POST['status'] ?? 'pending';

$notes =
trim($_POST['notes'] ?? '');

/*
|--------------------------------------------------------------------------
| Calculate Total
|--------------------------------------------------------------------------
*/

$tax_amount =
($subtotal * $tax) / 100;

$amount =
($subtotal + $tax_amount) - $discount;

/*
|--------------------------------------------------------------------------
| Update Query
|--------------------------------------------------------------------------
*/

$sql = "
UPDATE invoices
SET
customer_id = ?,
invoice_date = ?,
due_date = ?,
subtotal = ?,
tax = ?,
discount = ?,
amount = ?,
status = ?,
notes = ?
WHERE id = ?
";

$stmt =
mysqli_prepare($conn,$sql);
logActivity(
    $_SESSION['user_id'],
    'Invoice',
    'Updated',
    $_POST['id'],
    'Invoice updated'
);

mysqli_stmt_bind_param(
$stmt,
"issddddssi",
$customer_id,
$invoice_date,
$due_date,
$subtotal,
$tax,
$discount,
$amount,
$status,
$notes,
$id
);

if(mysqli_stmt_execute($stmt))
{
?>

<script>

alert(
'Invoice Updated Successfully'
);

window.location =
'/dashboard.php?page=modules/invoices/view.php?id=<?=$id?>';

</script>

<?php
}
else
{
echo mysqli_error($conn);
}
?>
