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

$sql =
"SELECT * FROM leads WHERE id = ?";

$stmt =
mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result =
mysqli_stmt_get_result($stmt);

$lead =
mysqli_fetch_assoc($result);

if(!$lead)
{
    die("Lead Not Found");
}

?>

<div class="card shadow border-0">

    <div class="card-header d-flex justify-content-between">

        <h4>Lead Details</h4>

        <button
        class="btn btn-secondary"
        onclick="loadPage('modules/leads/index.php')">

            Back

        </button>

    </div>

    <div class="card-body">

        <table class="table">

            <tr>
                <th>Lead Code</th>
                <td><?= htmlspecialchars($lead['lead_code']); ?></td>
            </tr>

            <tr>
                <th>Lead Name</th>
                <td><?= htmlspecialchars($lead['lead_name']); ?></td>
            </tr>

            <tr>
                <th>Company</th>
                <td><?= htmlspecialchars($lead['company_name']); ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($lead['email']); ?></td>
            </tr>

            <tr>
                <th>Phone</th>
                <td><?= htmlspecialchars($lead['phone']); ?></td>
            </tr>

            <tr>
                <th>Source</th>
                <td><?= htmlspecialchars($lead['source']); ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td><?= htmlspecialchars($lead['status']); ?></td>
            </tr>

            <tr>
                <th>Estimated Value</th>
                <td><?= htmlspecialchars($lead['estimated_value']); ?></td>
            </tr>

            <tr>
                <th>Follow Up Date</th>
                <td><?= htmlspecialchars($lead['followup_date']); ?></td>
            </tr>

            <tr>
                <th>Remarks</th>
                <td><?= htmlspecialchars($lead['remarks']); ?></td>
            </tr>

        </table>

    </div>

</div>