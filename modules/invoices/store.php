<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';

$invoice_number =
trim($_POST['invoice_number'] ?? '');

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

$created_by =
$_SESSION['user_id'] ?? 0;

/*
|--------------------------------------------------------------------------
| Calculate Grand Total
|--------------------------------------------------------------------------
*/

$tax_amount =
($subtotal * $tax) / 100;

$amount =
($subtotal + $tax_amount) - $discount;

/*
|--------------------------------------------------------------------------
| Company Details
|--------------------------------------------------------------------------
*/

$company_name = 'CRM PROJECT';

$company_gst = '27XXXXXXXXXXZ5';

/*
|--------------------------------------------------------------------------
| Insert Invoice
|--------------------------------------------------------------------------
*/

$sql = "
INSERT INTO invoices
(
invoice_number,
customer_id,
invoice_date,
due_date,
subtotal,
tax,
discount,
amount,
status,
notes,
created_by,
company_name,
company_gst
)
VALUES
(
?,?,?,?,?,?,?,?,?,?,?,?,?
)
";

$stmt =
mysqli_prepare($conn,$sql);
$invoice_id = mysqli_insert_id($conn);
logActivity(
    $_SESSION['user_id'],
    'Invoice',
    'Created',
    $invoice_id,
    'New invoice created: ' . $invoice_number
);
mysqli_stmt_bind_param(
$stmt,
"sissdddsssiss",
$invoice_number,
$customer_id,
$invoice_date,
$due_date,
$subtotal,
$tax,
$discount,
$amount,
$status,
$notes,
$created_by,
$company_name,
$company_gst
);

if(mysqli_stmt_execute($stmt))
{
?>

<script>

alert(
'Invoice Created Successfully'
);

window.location =
'/dashboard.php?page=modules/invoices/index.php';

</script>

<?php
}
else
{
echo mysqli_error($conn);
}
?>
