<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

use Dompdf\Dompdf;

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

$html = '

<html>

<head>

<style>

body{
font-family: DejaVu Sans;
font-size:14px;
color:#333;
}

.header{
width:100%;
margin-bottom:20px;
}

.title{
font-size:24px;
font-weight:bold;
}

.right{
float:right;
text-align:right;
}

.clear{
clear:both;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table,
th,
td{
border:1px solid #ccc;
}

th{
background:#f5f5f5;
padding:10px;
}

td{
padding:10px;
}

.total{
background:#e9f3ff;
font-weight:bold;
}

</style>

</head>

<body>

<div class="header">

<div>

<div class="title">
'.$invoice['company_name'].'
</div>

GST :
'.$invoice['company_gst'].'

</div>

<div class="right">

Invoice :
'.$invoice['invoice_number'].'<br>

Date :
'.$invoice['invoice_date'].'

</div>

<div class="clear"></div>

</div>

<hr>

<h3>Customer Details</h3>

<strong>Name:</strong>
'.$invoice['customer_name'].'<br>

<strong>Email:</strong>
'.$invoice['email'].'<br>

<strong>Phone:</strong>
'.$invoice['phone'].'<br>

<strong>Due Date:</strong>
'.$invoice['due_date'].'<br>

<strong>Status:</strong>
'.ucfirst($invoice['status']).'

<table>

<tr>

<th>Description</th>
<th>Amount</th>

</tr>

<tr>

<td>Subtotal</td>

<td>
Rs. '.number_format($invoice['subtotal'],2).'
</td>

</tr>

<tr>

<td>
Tax ('.$invoice['tax'].'%)
</td>

<td>
Rs. '.number_format($tax_amount,2).'
</td>

</tr>

<tr>

<td>Discount</td>

<td>
Rs. '.number_format($invoice['discount'],2).'
</td>

</tr>

<tr class="total">

<td>
Grand Total
</td>

<td>
Rs. '.number_format($invoice['amount'],2).'
</td>

</tr>

</table>

<br><br>

<strong>Notes</strong><br>

'.$invoice['notes'].'

</body>

</html>
';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper(
'A4',
'portrait'
);

$dompdf->render();

$dompdf->stream(
$invoice['invoice_number'].'.pdf',
[
'Attachment' => true
]
);
