<?php

require_once __DIR__.'/../../config/database.php';

$limit = 10;

$page_no = isset($_GET['p']) ? (int)$_GET['p'] : 1;

$offset = ($page_no-1) * $limit;

$count_sql = "SELECT COUNT(*) total FROM notifications";

$count_result = mysqli_query($conn,$count_sql);

$total_records = mysqli_fetch_assoc($count_result)['total'];

$total_pages = ceil($total_records/$limit);

$sql = "

SELECT

notifications.*,

users.name

FROM notifications

LEFT JOIN users

ON users.id = notifications.user_id

ORDER BY notifications.id DESC

LIMIT $offset,$limit

";

$result = mysqli_query($conn,$sql);

?>
<div class="card-body">

<div class="table-responsive">

<table
class="table table-hover align-middle"
id="notificationTable">

<thead class="table-light">

<tr>

<th>ID</th>

<th>User</th>

<th>Type</th>

<th>Title</th>

<th>Status</th>

<th>Date</th>

<th width="180">

Action

</th>

</tr>

</thead>
<tbody>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?= $row['id']; ?>

</td>

<td>

<?= htmlspecialchars($row['name']); ?>

</td>

<td data-type="<?= strtolower($row['type']); ?>">

<?php

switch($row['type'])
{

case 'lead':

echo '<span class="badge bg-primary">Lead</span>';

break;

case 'customer':

echo '<span class="badge bg-success">Customer</span>';

break;

case 'followup':

echo '<span class="badge bg-warning text-dark">Followup</span>';

break;

case 'invoice':

echo '<span class="badge bg-danger">Invoice</span>';

break;

case 'payment':

echo '<span class="badge bg-info">Payment</span>';

break;

case 'task':

echo '<span class="badge bg-secondary">Task</span>';

break;

default:

echo '<span class="badge bg-dark">System</span>';

}

?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['title']); ?>

</strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['message']); ?>

</small>

</td>

<td data-status="<?= $row['is_read']; ?>">

<?php

if($row['is_read']==0)
{

?>

<span class="badge bg-danger">

Unread

</span>

<?php

}

else

{

?>

<span class="badge bg-success">

Read

</span>

<?php

}

?>

</td>

<td>

<?= date('d M Y h:i A',strtotime($row['created_at'])); ?>

</td>

<td>

<button

class="btn btn-info btn-sm"

onclick="loadPage('modules/notifications/view.php?id=<?= $row['id']; ?>')">

<i class="bi bi-eye"></i>

</button>

<?php

if($row['is_read']==0)

{

?>

<button

class="btn btn-success btn-sm"

onclick="markNotificationRead(<?= $row['id']; ?>)">

<i class="bi bi-check-circle"></i>

</button>

<?php

}

?>

<button

class="btn btn-danger btn-sm"

onclick="deleteNotification(<?= $row['id']; ?>)">

<i class="bi bi-trash"></i>

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

<td colspan="7" class="text-center">

No Notifications Found

</td>

</tr>

<?php

}

?>

</tbody>
</table>

<nav class="mt-3">

<ul class="pagination justify-content-end">

<?php

for($i=1;$i<=$total_pages;$i++)

{

?>

<li class="page-item <?= ($i==$page_no)?'active':''; ?>">

<a

class="page-link"

href="#"

onclick="loadPage('modules/notifications/index.php?p=<?= $i; ?>')">

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

</div>