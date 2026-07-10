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

$sql = "
SELECT
i.*,
c.customer_name,
c.company_name,
c.email,
c.phone
FROM invoices i
LEFT JOIN customers c
ON c.id=i.customer_id
WHERE i.id=?
";

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

$invoice =
mysqli_fetch_assoc($result);

if(!$invoice)
{
    die("Invoice Not Found");
}
?>

<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">
        <h4>
            Invoice Details
        </h4>
  <button class="btn btn-secondary" onclick="loadPage('modules/invoices/index.php')">Back</button>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <strong>
                    Invoice Number
                </strong>

                <br>

                <?= htmlspecialchars($invoice['invoice_number']); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Customer
                </strong>

                <br>

                <?= htmlspecialchars($invoice['customer_name']); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Company
                </strong>

                <br>

                <?= htmlspecialchars($invoice['company_name']); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Email
                </strong>

                <br>

                <?= htmlspecialchars($invoice['email']); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Phone
                </strong>

                <br>

                <?= htmlspecialchars($invoice['phone']); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Invoice Date
                </strong>

                <br>

                <?= $invoice['invoice_date']; ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Due Date
                </strong>

                <br>

                <?= $invoice['due_date']; ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Amount
                </strong>

                <br>

                ₹<?= number_format($invoice['amount'],2); ?>

            </div>

            <div class="col-md-6 mb-3">

                <strong>
                    Status
                </strong>

                <br>

                <?= ucfirst($invoice['status']); ?>

            </div>

            <div class="col-12">

                <strong>
                    Notes
                </strong>

                <br>

                <?= nl2br(htmlspecialchars($invoice['notes'])); ?>

            </div>

        </div>

        <hr>
<a
href="#"
class="btn btn-primary"
onclick="loadPage('modules/invoices/preview.php?id=<?= $invoice['id']; ?>')">

Preview Invoice

</a>

    </div>

</div>