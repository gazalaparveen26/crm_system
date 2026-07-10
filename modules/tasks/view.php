<?php

require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if($id == 0 && isset($_GET['page']))
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
<div class="card-header bg-primary text-white">

    <h4 class="mb-0">
        View Task
    </h4>

</div>

<div class="card-body">

    <div class="row">

        <div class="col-md-6 mb-3">
            <strong>Task Title:</strong><br>
            <?= htmlspecialchars($task['task_title']); ?>
        </div>

        <div class="col-md-3 mb-3">
            <strong>Priority:</strong><br>
            <?= ucfirst($task['priority']); ?>
        </div>

        <div class="col-md-3 mb-3">
            <strong>Status:</strong><br>
            <?= ucfirst(str_replace('_',' ',$task['status'])); ?>
        </div>

        <div class="col-md-6 mb-3">
            <strong>Start Date:</strong><br>
            <?= $task['start_date']; ?>
        </div>

        <div class="col-md-6 mb-3">
            <strong>Due Date:</strong><br>
            <?= $task['due_date']; ?>
        </div>

        <div class="col-12 mb-3">
            <strong>Description:</strong><br>
            <?= nl2br(htmlspecialchars($task['description'])); ?>
        </div>

    </div>

    <button
    class="btn btn-secondary"
    onclick="loadPage('modules/tasks/index.php')">

        Back

    </button>

</div>

</div>
