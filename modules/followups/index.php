<?php
require_once __DIR__ . '/../../config/database.php';
$limit = 10;
$page_no = isset($_GET['p']) ? (int) $_GET['p'] : 1;
$offset = ($page_no - 1) * $limit;
$count_sql = "SELECT COUNT(*) as total FROM lead_followups ";
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);
$sql = "SELECT  f.id,f.followup_date,f.followup_time,f.notes,f.status,l.lead_name FROM lead_followups f LEFT JOIN leads l ON l.id = f.lead_id ORDER BY f.followup_date ASC LIMIT $offset,$limit";
$result = mysqli_query($conn, $sql);
?>
<tbody>
    <div class="card shadow border-0">
        <!-- ================= Header ================= -->
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h4 class="mb-0"> Followups</h4>
                </div>
            <!-- select by name -->
                <div class="col-md-2">
                    <input type="text" id="followupSearch" class="form-control" placeholder="Search Followup...">
                </div>
                <!-- select by date  -->
                <div class="col-md-2">
                   <select id="followupDateFilter" class="form-select" onchange="filterFollowups()">
                        <option value="">All Dates </option>
                        <option value="today">  Today</option>
                        <option value="week">This Week</option>
                        <option value="month"> This Month</option>
                    </select>
                </div>
                <!-- select by status -->
                <div class="col-md-2">
                   <select id="followupStatusFilter" class="form-select" onchange="filterFollowups()">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-secondary me-2" onclick="resetFollowupFilters()"> <i class="bi bi-arrow-clockwise"></i>Reset </button>
                    <button class="btn btn-primary" onclick="loadPage('modules/followups/create.php')"> <i class="bi bi-plus-circle"></i>  Add Followup</button>
                </div>
            </div>
        </div>
        <!-- ================= Body ================ -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="followupTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Lead</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th width="240"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td>  <?= htmlspecialchars($row['lead_name']); ?> </td>
                                    <td data-date="<?= $row['followup_date']; ?>">
                                        <?= date('d M Y',  strtotime($row['followup_date'])); ?>
                                    </td>
                                    <td> <?= date('h:i A', strtotime($row['followup_time'])); ?></td>
                                    <td data-status="<?php
                                    if ($row['status'] == 'completed') {
                                        echo 'completed';
                                    } elseif ($row['followup_date'] < date('Y-m-d')) {
                                        echo 'overdue';
                                    } else {
                                        echo 'pending';
                                    }
                                    ?>">
                                        <?php
                                        if ($row['status'] == 'completed') {
                                            ?>
                                            <span class="badge bg-success">Completed</span>
                                            <?php
                                        } elseif ($row['followup_date'] < date('Y-m-d')) {
                                            ?>
                                            <span class="badge bg-danger">Overdue </span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="badge bg-warning text-dark"> Pending  </span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    </td>
                                    <td> <span title="<?= htmlspecialchars($row['notes']); ?>">  <?= htmlspecialchars( strlen($row['notes']) > 50  ? substr($row['notes'], 0, 50) . '...'  :   $row['notes']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="loadPage('modules/followups/view.php?id=<?= $row['id']; ?>')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" onclick="loadPage('modules/followups/edit.php?id=<?= $row['id']; ?>')"> <i class="bi bi-pencil-square"></i>  </button>
                                        <?php
                                        if ($row['status'] == 'pending') {
                                            ?>
                                            <button class="btn btn-success btn-sm" onclick="completeFollowup(<?= $row['id']; ?>)"> <i class="bi bi-check-circle"></i></button>
                                            <?php
                                        }
                                        ?>
                                        <button class="btn btn-danger btn-sm" onclick="deleteFollowup(<?= $row['id']; ?>)"><i class="bi bi-trash"></i> </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" class="text-center"> No Followups Found</td></tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav class="mt-3">
                    <ul class="pagination justify-content-end">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            ?>
                            <li class="page-item <?= ($i == $page_no) ? 'active' : ''; ?>">
                                <a class="page-link" href="#"
                                    onclick="loadPage('modules/followups/index.php?p=<?= $i; ?>')">
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
