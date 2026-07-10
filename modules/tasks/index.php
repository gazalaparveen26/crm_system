<?php

require_once __DIR__ . '/../../config/database.php';
$limit = 10;

$page_no = isset($_GET['p'])
? (int)$_GET['p']
: 1;

$offset = ($page_no - 1) * $limit;
$count_sql =
"SELECT COUNT(*) as total
FROM tasks";

$count_result =
mysqli_query($conn,$count_sql);

$total_records =
mysqli_fetch_assoc($count_result)['total'];

$total_pages =
ceil($total_records / $limit);
$sql = "
SELECT
id,
task_title,
priority,
status,
start_date,
due_date
FROM tasks
ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

?>

<div class="card shadow border-0">


<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="mb-0">
        Tasks
    </h4>
<div class="position-relative me-3">
    <input
    type="text"
    id="taskSearch"
    class="form-control rounded-pill"
    placeholder="Search Task...">
</div>
    <button
    class="btn btn-primary"
    onclick="loadPage('modules/tasks/create.php')">

        <i class="bi bi-plus-circle"></i>
        Add Task

    </button>

</div>

<div class="card-body">

    <div class="table-responsive">

        <table class="table table-hover align-middle" id="taskTable">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Due Date</th>
                    <th width="220">Action</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if(mysqli_num_rows($result) > 0)
            {

                while($row = mysqli_fetch_assoc($result))
                {

            ?>

                <tr>

                    <td>
                        <?= $row['id']; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['task_title']); ?>
                    </td>

                    <td>
                        <?= ucfirst($row['priority']); ?>
                    </td>

                    <td>
                        <?= ucfirst(str_replace('_',' ',$row['status'])); ?>
                    </td>

                    <td>
                        <?= $row['start_date']; ?>
                    </td>

                    <td>
                        <?= $row['due_date']; ?>
                    </td>

                    <td>

                   <button class="btn btn-info btn-sm" onclick="loadPage('modules/tasks/view.php?id=<?= $row['id']; ?>')">View</button>
<button class="btn btn-warning btn-sm" onclick="loadPage('modules/tasks/edit.php?id=<?= $row['id']; ?>')">Edit</button>
<button class="btn btn-danger btn-sm" onclick="deleteTask(<?= $row['id']; ?>)">Delete</button>
                    </td>

                </tr>

            <?php

                }

            }
            else
            {

            ?>

                <tr>

                    <td
                    colspan="7"
                    class="text-center">

                        No Tasks Found

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>
<nav class="mt-3">

<ul class="pagination justify-content-end">
<?php for($i=1; $i<=$total_pages; $i++) { ?>
<li class="page-item <?= ($i==$page_no)?'active':''; ?>">
<a class="page-link" href="#" onclick="loadPage('modules/tasks/index.php?p=<?= $i; ?>')">
<?= $i; ?>
</a>
</li>
<?php } ?>
</ul>
</nav>
    </div>

</div>
</div>
