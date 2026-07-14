<?php
require_once __DIR__ . '/../../config/database.php';
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM customers"))['total'];
$active_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM customers WHERE status='active'"))['total'];
$inactive_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM customers WHERE status='inactive'"))['total'];
$total_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads"
        )
    )['total'];

$total_tasks =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM tasks"
        )
    )['total'];

$completed_tasks =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM tasks WHERE status='completed'"
        )
    )['total'];

$pending_tasks =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM tasks WHERE status='pending'"
        )
    )['total'];
$new_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads WHERE status='new'"
        )
    )['total'];

$contacted_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads WHERE status='contacted'"
        )
    )['total'];

$qualified_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads WHERE status='qualified'"
        )
    )['total'];

$won_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads WHERE status='won'"
        )
    )['total'];

$lost_leads =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total FROM leads WHERE status='lost'"
        )
    )['total'];
$total_revenue =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COALESCE(SUM(amount),0) as total FROM payments"
        )
    )['total'];

$today_revenue =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COALESCE(SUM(amount),0) as total
FROM payments
WHERE payment_date = CURDATE()"
        )
    )['total'];

$month_revenue =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COALESCE(SUM(amount),0) as total
FROM payments
WHERE MONTH(payment_date)=MONTH(CURDATE())
AND YEAR(payment_date)=YEAR(CURDATE())"
        )
    )['total'];

$paid_invoices =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total
FROM invoices
WHERE status='paid'"
        )
    )['total'];

$pending_invoices_count =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total
FROM invoices
WHERE status='pending'"
        )
    )['total'];

$overdue_invoices =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) as total
FROM invoices
WHERE status='overdue'"
        )
    )['total'];
$monthly_revenue = [];

for ($i = 1; $i <= 12; $i++) {
    $result =
        mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "
    SELECT COALESCE(SUM(amount),0) as total
    FROM payments
    WHERE MONTH(payment_date)=$i
    AND YEAR(payment_date)=YEAR(CURDATE())
    "
            )
        );

    $monthly_revenue[] = (float) $result['total'];
}

$revenue_data = json_encode($monthly_revenue);
$today_followups =

    mysqli_fetch_assoc(

        mysqli_query(

            $conn,

            "SELECT COUNT(*) total

FROM lead_followups

WHERE followup_date = CURDATE()

AND status='pending'"

        )

    )['total'];
$overdue_followups =

    mysqli_fetch_assoc(

        mysqli_query(

            $conn,

            "SELECT COUNT(*) total

FROM lead_followups

WHERE followup_date < CURDATE()

AND status='pending'"

        )

    )['total'];
$upcoming_followups =

    mysqli_fetch_assoc(

        mysqli_query(

            $conn,

            "SELECT COUNT(*) total

FROM lead_followups

WHERE followup_date > CURDATE()

AND status='pending'"

        )

    )['total'];
$completed_followups =

    mysqli_fetch_assoc(

        mysqli_query(

            $conn,

            "SELECT COUNT(*) total

FROM lead_followups

WHERE status='completed'"

        )

    )['total'];

?>

<div class="container-fluid mt-4">
    <div class="row g-4">
             <div class="col-lg-3 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                <h6>Total Customers</h6>
                <h2> <?= $total_customers; ?> </h2>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-success"> Active Customers</h6>
                    <h2><?= $active_customers; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-danger"> Inactive Customers </h6>
                    <h2> <?= $inactive_customers; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-primary">Total Leads</h6>
                    <h2><?= $total_leads; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">

    <div class="row g-4 mt-1">

        <div class="col-lg-4 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-warning">
                        Pending Tasks
                    </h6>
                    <h2><?= $pending_tasks; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-success">
                        Completed Tasks
                    </h6>
                    <h2><?= $completed_tasks; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h6 class="text-info">
                        Total Tasks
                    </h6>
                    <h2><?= $total_tasks; ?></h2>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container-fluid mt-4">

    <div class="row g-4"  >

        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header">

                    <h5 class="mb-0">
                        Lead Pipeline Overview
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="leadStatusChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow border-0">

                <div class="card-header">

                    <h5 class="mb-0">
                        Revenue Trend
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="revenueChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="container-fluid mt-4">
<div class="row g-4 mt-3">
    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-primary">Today's Followups</h6>
                <h2><?= $today_followups; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-danger">Overdue Followups</h6>
                <h2><?= $overdue_followups; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-warning">Upcoming Followups </h6>
                <h2><?= $upcoming_followups; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">

        <div class="card shadow border-0">

            <div class="card-body">

                <h6 class="text-success">

                    Completed

                </h6>

                <h2>

                    <?= $completed_followups; ?>

                </h2>

            </div>

        </div>

    </div>

</div>
</div>
<div class="container-fluid mt-4">

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-success">
                        Total Revenue
                    </h6>

                    <h2>
                        ₹<?= number_format($total_revenue, 2); ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-primary">
                        Today's Revenue
                    </h6>

                    <h2>
                        ₹<?= number_format($today_revenue, 2); ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-info">
                        This Month Revenue
                    </h6>

                    <h2>
                        ₹<?= number_format($month_revenue, 2); ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4 mt-1">

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-success">
                        Paid Invoices
                    </h6>

                    <h2>
                        <?= $paid_invoices; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-warning">
                        Pending Invoices
                    </h6>

                    <h2>
                        <?= $pending_invoices_count; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-danger">
                        Overdue Invoices
                    </h6>

                    <h2>
                        <?= $overdue_invoices; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- recent customers -->
<?php
$recent_sql = "SELECT customer_name,company_name,email, status FROM customers ORDER BY id DESC LIMIT 5 ";
$recent_result = mysqli_query($conn, $recent_sql);
?>
<div class="container-fluid mt-4">
<div class="card shadow-sm mt-4">
     <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0"> <i class="bi bi-clock-history"></i> Recent Customers </h5>
          <button class="btn btn-sm btn-primary" onclick="loadPage('modules/customers/index.php')"> View All </button> 
        </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($recent_result)) {
                                    ?>
                                    <tr>
                                        <td> <?= htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?= htmlspecialchars($row['company_name']); ?> </td>
                                        <td> <?= htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 'active') {
                                                ?>
                                                <span class="badge bg-success"> Active </span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="badge bg-danger"> Inactive </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- recent leads -->
<?php
$recent_leads_sql = "SELECT lead_name, company_name,source,status FROM leads ORDER BY id DESC LIMIT 5";
$recent_leads_result = mysqli_query($conn, $recent_leads_sql);
?>
<div class="container-fluid mt-4">
<div class="card shadow-sm mt-4">
     <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0"> <i class="bi bi-clock-history"></i> Recent Leads </h5>
          <button class="btn btn-sm btn-primary" onclick="loadPage('modules/leads/index.php')"> View All </button> 
        </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>

                                <tr>

                                    <th>Lead Name</th>
                                    <th>Company</th>
                                    <th>Source</th>
                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                while (
                                    $row =
                                    mysqli_fetch_assoc(
                                        $recent_leads_result
                                    )
                                ) {

                                    ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($row['lead_name']); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($row['company_name']); ?>
                                        </td>

                                        <td>
                                            <?= ucfirst($row['source']); ?>
                                        </td>

                                        <td>

                                            <?php

                                            switch ($row['status']) {
                                                case 'new':
                                                    echo '<span class="badge bg-primary">New</span>';
                                                    break;

                                                case 'contacted':
                                                    echo '<span class="badge bg-info">Contacted</span>';
                                                    break;

                                                case 'qualified':
                                                    echo '<span class="badge bg-success">Qualified</span>';
                                                    break;

                                                case 'proposal_sent':
                                                    echo '<span class="badge bg-warning text-dark">Proposal Sent</span>';
                                                    break;

                                                case 'won':
                                                    echo '<span class="badge bg-success">Won</span>';
                                                    break;

                                                case 'lost':
                                                    echo '<span class="badge bg-danger">Lost</span>';
                                                    break;
                                            }

                                            ?>

                                        </td>

                                    </tr>

                                    <?php

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>
</div>
<?php

$recent_payments_sql = "
SELECT
p.*,
i.invoice_number
FROM payments p
LEFT JOIN invoices i
ON i.id = p.invoice_id
ORDER BY p.id DESC
LIMIT 5
";

$recent_payments_result =
    mysqli_query(
        $conn,
        $recent_payments_sql
    );

?>
<div class="container-fluid mt-4">
<div class="card shadow-sm mt-4">
     <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="mb-0"> <i class="bi bi-clock-history"></i> Recent Payments </h5>
          <button class="btn btn-sm btn-primary" onclick="loadPage('modules/payments/index.php')"> View All </button> 
        </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>

                                <tr>

                                    <th>Invoice No</th>
                                    <th>Payment Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Transaction ID</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                if (mysqli_num_rows($recent_payments_result) > 0) {

                                    while (
                                        $row =
                                        mysqli_fetch_assoc(
                                            $recent_payments_result
                                        )
                                    ) {

                                        ?>

                                        <tr>

                                            <td>

                                                <?= htmlspecialchars($row['invoice_number']); ?>

                                            </td>

                                            <td>

                                                <?= $row['payment_date']; ?>

                                            </td>

                                            <td>

                                                ₹<?= number_format($row['amount'], 2); ?>

                                            </td>

                                            <td>

                                                <?= ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $row['payment_method']
                                                    )
                                                ); ?>

                                            </td>

                                            <td>

                                                <?= htmlspecialchars(
                                                    $row['transaction_id']
                                                ); ?>

                                            </td>

                                        </tr>

                                        <?php

                                    }

                                } else {

                                    ?>

                                    <tr>

                                        <td colspan="5" class="text-center">

                                            No Payments Found

                                        </td>

                                    </tr>

                                    <?php

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

 </div>
<?php

$activity_sql = "
SELECT
    activity_logs.*,
    users.name AS user_name
FROM activity_logs
LEFT JOIN users
ON users.id = activity_logs.user_id
ORDER BY activity_logs.id DESC
LIMIT 5
";

$activity_result = mysqli_query($conn,$activity_sql);

?>
<div class="container-fluid mt-4">
<div class="card shadow-sm mt-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i>
            Recent Activities
        </h5>

        <button class="btn btn-sm btn-primary"
            onclick="loadPage('modules/activity/index.php')">
            View All
        </button>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>User</th>

                        <th>Module</th>

                        <th>Action</th>

                        <th>Description</th>

                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                if(mysqli_num_rows($activity_result)>0)
                {
                    while($row=mysqli_fetch_assoc($activity_result))
                    {
                ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($row['user_name'] ?? 'Unknown'); ?>

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            <?= htmlspecialchars($row['module']); ?>

                        </span>

                    </td>

                    <td>

                        <?php

                        if(strtolower($row['action'])=='created')
                        {
                            echo '<span class="badge bg-success">Created</span>';
                        }
                        elseif(strtolower($row['action'])=='updated')
                        {
                            echo '<span class="badge bg-warning text-dark">Updated</span>';
                        }
                        elseif(strtolower($row['action'])=='deleted')
                        {
                            echo '<span class="badge bg-danger">Deleted</span>';
                        }
                        else
                        {
                            echo '<span class="badge bg-secondary">'
                                . htmlspecialchars($row['action']) .
                                '</span>';
                        }

                        ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($row['description']); ?>

                    </td>

                    <td>

                        <?= date('d M Y h:i A',strtotime($row['created_at'])); ?>

                    </td>

                </tr>

                <?php
                    }
                }
                else
                {
                ?>

                <tr>

                    <td colspan="5" class="text-center">

                        No Activity Found

                    </td>

                </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>
<script>
    setTimeout(function () {
        const canvas = document.getElementById('leadStatusChart');
        if (!canvas) {
            console.log('Chart canvas not found');
            return;
        }
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: [
                    'New',
                    'Contacted',
                    'Qualified',
                    'Won',
                    'Lost'
                ],

                datasets: [{

                    label: 'Leads',

                    data: [
                        <?= $new_leads; ?>,
                        <?= $contacted_leads; ?>,
                        <?= $qualified_leads; ?>,
                        <?= $won_leads; ?>,
                        <?= $lost_leads; ?>
                    ],

                    tension: 0.4,
                    fill: true,
                    borderWidth: 3

                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {
                        display: true
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        });

    }, 300);

</script>
<script>
    setTimeout(function () {
        const revenueCanvas = document.getElementById('revenueChart');
        if (!revenueCanvas) {
            console.log('Revenue Chart Canvas Not Found');
            return;
        }
        const revenueCtx = revenueCanvas.getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',

            data: {

                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],

                datasets: [{

                    label: 'Revenue',

                    data: <?= json_encode($monthly_revenue); ?>,

                    borderWidth: 1

                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {
                        display: true
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true

                    }

                }

            }

        });

    }, 500);

</script>