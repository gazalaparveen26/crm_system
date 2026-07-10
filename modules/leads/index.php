<?php
require_once __DIR__ . '/../../config/database.php';
$limit = 10;
$page_no = isset($_GET['p']) ? (int) $_GET['p'] : 1;
$offset = ($page_no - 1) * $limit;
$count_sql = "SELECT COUNT(*) as total FROM leads";
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);
$sql = "SELECT id,lead_code,lead_name,company_name,email,phone,source, status FROM leads ORDER BY id DESC LIMIT $offset,$limit";
$result = mysqli_query($conn, $sql);
?>
<div class="card shadow border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0"> Leads </h4>
        <div class="position-relative me-3">
            <input type="text" id="leadSearch" class="form-control " placeholder="Search Lead...">
        </div>
        <button class="btn btn-primary" onclick="loadPage('modules/leads/create.php')">
            <i class="bi bi-plus-circle"></i> Add Lead </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="leadTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['lead_code']); ?></td>
                                <td><?= htmlspecialchars($row['lead_name']); ?></td>
                                <td><?= htmlspecialchars($row['company_name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['phone']); ?></td>
                                <td><?= htmlspecialchars($row['source']); ?></td>
                                <td>
                                    <?php
                                    switch ($row['status']) {
                                        case 'new':
                                            echo '<span class="badge bg-primary lead-status">New</span>';
                                            break;
                                        case 'contacted':
                                            echo '<span class="badge bg-info lead-status">Contacted</span>';
                                            break;
                                        case 'qualified':
                                            echo '<span class="badge bg-success lead-status">Qualified</span>';
                                            break;
                                        case 'proposal_sent':
                                            echo '<span class="badge bg-warning text-dark">Proposal Sent</span>';
                                            break;
                                        case 'won':
                                            echo '<span class="badge bg-success lead-status">Won</span>';
                                            break;
                                        case 'lost':
                                            echo '<span class="badge bg-danger lead-status">Lost</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm"
                                        onclick="loadPage('modules/leads/view.php?id=<?= $row['id']; ?>')"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-warning btn-sm"
                                        onclick="loadPage('modules/leads/edit.php?id=<?= $row['id']; ?>')"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteLead(<?= $row['id']; ?>)">
                                        <i class="bi bi-trash"></i></button>
                                    <button class="btn btn-success btn-sm"
                                        onclick="loadPage('modules/leads/convert.php?id=<?= $row['id']; ?>')"><i class="fa fa-exchange"></i></button>

                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="9" class="text-center">No Leads Found
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <nav class="mt-3">
                <ul class="pagination justify-content-end">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= $i == $page_no ? 'active' : ''; ?>">
                            <a class="page-link" href="#" onclick="loadPage('modules/leads/index.php?p=<?= $i; ?>')">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>