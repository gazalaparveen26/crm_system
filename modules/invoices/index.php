<?php

require_once __DIR__ . '/../../config/database.php';

$limit = 10;

$page_no = isset($_GET['p'])
? (int)$_GET['p']
: 1;

$offset = ($page_no - 1) * $limit;

/*
|--------------------------------------------------------------------------
| Total Records
|--------------------------------------------------------------------------
*/

$count_sql = "
SELECT COUNT(*) as total
FROM invoices
";

$count_result =
mysqli_query($conn,$count_sql);

$total_records =
mysqli_fetch_assoc($count_result)['total'];

$total_pages =
ceil($total_records / $limit);

/*
|--------------------------------------------------------------------------
| Invoice List
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
i.*,
c.customer_name
FROM invoices i
LEFT JOIN customers c
ON c.id = i.customer_id
ORDER BY i.id DESC
LIMIT $offset,$limit
";

$result =
mysqli_query($conn,$sql);

?>
<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Invoices</h4>
        <div class="d-flex gap-2">
            <input type="text" id="invoiceSearch" class="form-control rounded-pill" placeholder="Search Lead...">
        </div>
        <button class="btn btn-primary" onclick="loadPage('modules/invoices/create.php')">
            <i class="bi bi-plus-circle"></i> Create Invoice</button>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table
            class="table table-hover align-middle"
            id="invoiceTable">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Invoice Date</th>
                        <th>Amount</th>
                        <th>Status</th>
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
                    mysqli_fetch_assoc($result))
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
                            <?= htmlspecialchars($row['customer_name']); ?>
                        </td>

                        <td>
                            <?= $row['invoice_date']; ?>
                        </td>

                        <td>
                            ₹<?= number_format($row['amount'],2); ?>
                        </td>

                        <td>

                        <?php

                        switch($row['status'])
                        {

                            case 'pending':
                                echo '<span class="badge bg-warning text-dark">Pending</span>';
                                break;

                            case 'paid':
                                echo '<span class="badge bg-success">Paid</span>';
                                break;

                            case 'partial':
                                echo '<span class="badge bg-info">Partial</span>';
                                break;

                            case 'overdue':
                                echo '<span class="badge bg-danger">Overdue</span>';
                                break;

                        }

                        ?>

                        </td>

                        <td>

                            <button
                            class="btn btn-info btn-sm"
                            onclick="loadPage('modules/invoices/view.php?id=<?= $row['id']; ?>')">

                                View

                            </button>

                            <button
                            class="btn btn-warning btn-sm"
                            onclick="loadPage('modules/invoices/edit.php?id=<?= $row['id']; ?>')">

                                Edit

                            </button>

                            <button
                            class="btn btn-danger btn-sm"
                            onclick="deleteInvoice(<?= $row['id']; ?>)">

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

                        <td colspan="7" class="text-center">

                            No Invoices Found

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

            for($i=1;$i<=$total_pages;$i++)
            {

            ?>

                <li class="page-item <?= $i==$page_no ? 'active' : ''; ?>">

                    <a
                    href="#"
                    class="page-link"
                    onclick="loadPage('modules/invoices/index.php?p=<?= $i; ?>')">

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