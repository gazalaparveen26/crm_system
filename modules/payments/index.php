<?php

require_once __DIR__ . '/../../config/database.php';

$limit = 10;

$page_no =
isset($_GET['p'])
? (int)$_GET['p']
: 1;

$offset =
($page_no - 1) * $limit;

/*
|--------------------------------------------------------------------------
| Total Records
|--------------------------------------------------------------------------
*/

$count_sql = "
SELECT COUNT(*) as total
FROM payments
";

$count_result =
mysqli_query($conn,$count_sql);

$total_records =
mysqli_fetch_assoc($count_result)['total'];

$total_pages =
ceil($total_records / $limit);

/*
|--------------------------------------------------------------------------
| Payment List
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
p.*,
i.invoice_number,
i.status
FROM payments p
LEFT JOIN invoices i
ON i.id = p.invoice_id
ORDER BY p.id DESC
LIMIT $offset,$limit
";

$result =
mysqli_query($conn,$sql);

?>

<div class="card shadow border-0">

<div class="card-header d-flex justify-content-between align-items-center">

<h4 class="mb-0">
Payments
</h4>

<div class="d-flex gap-2">

<input
type="text"
id="paymentSearch"
class="form-control rounded-pill"
placeholder="Search Payment...">

</div>

<button
class="btn btn-primary"
onclick="loadPage('modules/payments/create.php')">

<i class="bi bi-plus-circle"></i>

Add Payment

</button>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle" id="paymentTable">

<thead>

<tr>

<th>ID</th>
<th>Invoice No</th>
<th>Date</th>
<th>Amount</th>
<th>Invoice Status</th>
<th>Method</th>
<th width="220">
Action
</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result) > 0)
{

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
<?= ucfirst($row['status']); ?>
</td>

<td>

<?=
ucwords(
str_replace(
'_',
' ',
$row['payment_method']
)
);
?>

</td>

<td>

<button
class="btn btn-info btn-sm"
onclick="loadPage('modules/payments/view.php?id=<?= $row['id']; ?>')">

View

</button>

<button
class="btn btn-warning btn-sm"
onclick="loadPage('modules/payments/edit.php?id=<?= $row['id']; ?>')">

Edit

</button>

<button
class="btn btn-danger btn-sm"
onclick="deletePayment(<?= $row['id']; ?>)">

Delete

</button>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="6" class="text-center">

No Payments Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<nav class="mt-3">

<ul class="pagination justify-content-end">

<?php

for(
$i=1;
$i<=$total_pages;
$i++
)
{

?>

<li class="page-item <?= $i==$page_no ? 'active' : ''; ?>">

<a
href="#"
class="page-link"
onclick="loadPage('modules/payments/index.php?p=<?= $i; ?>')">

<?= $i; ?>

</a>

</li>

<?php

}

?>

</ul>

</nav>

</div>

</div>

<script>

document
.getElementById('paymentSearch')
.addEventListener(
'keyup',
function()
{

let value =
this.value.toLowerCase();

document
.querySelectorAll(
'#paymentTable tbody tr'
)
.forEach(function(row)
{

row.style.display =
row.innerText
.toLowerCase()
.includes(value)
? ''
: 'none';

});

});

</script>
