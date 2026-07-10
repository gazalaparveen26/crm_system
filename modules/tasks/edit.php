<?php

require_once __DIR__ . '/../../config/database.php';

$id = 0;

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];
}
elseif(isset($_GET['page']))
{
    parse_str(
        parse_url($_GET['page'], PHP_URL_QUERY),
        $params
    );

    $id = (int)($params['id'] ?? 0);
}
$sql = "SELECT * FROM tasks WHERE id = ?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$task = mysqli_fetch_assoc($result);

if(!$task)
{
    die("Task Not Found");
}

?>

<div class="card shadow border-0">


<div class="card-header bg-warning">

    <h4 class="mb-0">
        Edit Task
    </h4>

</div>

<div class="card-body">

    <form
    action="modules/tasks/update.php"
    method="POST">

        <input
        type="hidden"
        name="id"
        value="<?= $task['id']; ?>">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Task Title
                </label>

                <input
                type="text"
                name="task_title"
                class="form-control"
                value="<?= htmlspecialchars($task['task_title']); ?>"
                required>

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    Priority
                </label>

                <select
                name="priority"
                class="form-select">

                    <option value="low"
                    <?= $task['priority']=='low'?'selected':''; ?>>
                    Low
                    </option>

                    <option value="medium"
                    <?= $task['priority']=='medium'?'selected':''; ?>>
                    Medium
                    </option>

                    <option value="high"
                    <?= $task['priority']=='high'?'selected':''; ?>>
                    High
                    </option>

                    <option value="urgent"
                    <?= $task['priority']=='urgent'?'selected':''; ?>>
                    Urgent
                    </option>

                </select>

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    Status
                </label>

                <select
                name="status"
                class="form-select">

                    <option value="pending"
                    <?= $task['status']=='pending'?'selected':''; ?>>
                    Pending
                    </option>

                    <option value="in_progress"
                    <?= $task['status']=='in_progress'?'selected':''; ?>>
                    In Progress
                    </option>

                    <option value="completed"
                    <?= $task['status']=='completed'?'selected':''; ?>>
                    Completed
                    </option>

                    <option value="cancelled"
                    <?= $task['status']=='cancelled'?'selected':''; ?>>
                    Cancelled
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Start Date
                </label>

                <input
                type="date"
                name="start_date"
                class="form-control"
                value="<?= $task['start_date']; ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Due Date
                </label>

                <input
                type="date"
                name="due_date"
                class="form-control"
                value="<?= $task['due_date']; ?>">

            </div>

            <div class="col-12 mb-3">

                <label class="form-label">
                    Description
                </label>

                <textarea
                name="description"
                class="form-control"
                rows="4"><?= htmlspecialchars($task['description']); ?></textarea>

            </div>

        </div>

        <button
        type="submit"
        class="btn btn-success">
            Update Task
        </button>

        <button
        type="button"
        class="btn btn-secondary"
        onclick="loadPage('modules/tasks/index.php')">
            Cancel
        </button>

    </form>

</div>
</div>
