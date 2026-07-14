<?php

require_once __DIR__.'/../../config/database.php';

$limit = 10;

$page_no = isset($_GET['p']) ? (int)$_GET['p'] : 1;

$offset = ($page_no - 1) * $limit;

$count_sql = "SELECT COUNT(*) total FROM activity_logs";

$count_result = mysqli_query($conn,$count_sql);

$total_records = mysqli_fetch_assoc($count_result)['total'];

$total_pages = ceil($total_records / $limit);

$sql = "
SELECT
activity_logs.*,
users.name AS user_name
FROM activity_logs
LEFT JOIN users
ON users.id = activity_logs.user_id
ORDER BY activity_logs.id DESC
LIMIT $offset,$limit
";

$result = mysqli_query($conn,$sql);

?>


<div class="card shadow border-0">

    <div class="card-header">
        
        <div class="row align-items-center">
<div class="col-md-2">



<h4 class="mb-0">

Activity Logs

</h4>

</div>

<!-- <div class="col-md-2">

<input

type="text"

id="activitySearch"

class="form-control"

placeholder="Search Activity...">

</div> -->

<div class="col-md-2">

<select

id="activityModuleFilter"

class="form-select">

<option value="">All Modules</option>

<option value="customer">Customer</option>

<option value="lead">Lead</option>

<option value="followup">Followup</option>

<option value="task">Task</option>

<option value="invoice">Invoice</option>

<option value="payment">Payment</option>

<option value="user">User</option>

</select>

</div>

<div class="col-md-2">

<select

id="activityActionFilter"

class="form-select">

<option value="">All Actions</option>

<option value="created">Created</option>

<option value="updated">Updated</option>

<option value="deleted">Deleted</option>

<option value="login">Login</option>

<option value="logout">Logout</option>

</select>

</div>

<div class="col-md-3 text-end">

<button

class="btn btn-secondary"

onclick="resetActivityFilters()">

<i class="bi bi-arrow-clockwise"></i>

Reset

</button>

</div>

</div>

</div>

    <div class="card-body">

        <div class="table-responsive">

        <table class="table table-hover align-middle" id="activityTable">

                <thead>
                   <tr>

<th>ID</th>

<th>User</th>

<th>Module</th>

<th>Action</th>

<th>Description</th>

<th>IP</th>

<th>Date</th>

<th>View</th>

</tr>
                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td data-module="<?= strtolower($row['module']); ?>"><?= $row['module'] ?></td>
                        <td data-action="<?= strtolower($row['action']); ?>">
                            <span class="badge bg-primary">
                                <?= $row['action'] ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= $row['ip_address'] ?></td>
                        <td><?= $row['created_at'] ?></td>

<td>

<button
class="btn btn-info btn-sm"
onclick="loadPage('modules/activity/view.php?id=<?= $row['id']; ?>')">

<i class="bi bi-eye"></i>

</button>

</td>

                    </tr>

                <?php } ?>

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
onclick="loadPage('modules/activity/index.php?p=<?= $i; ?>')">

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
