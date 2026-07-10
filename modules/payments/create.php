<?php

require_once __DIR__ . '/../../config/database.php';

$invoices =
    mysqli_query(
        $conn,
        "
SELECT
id,
invoice_number,
amount,
status
FROM invoices
WHERE status IN ('pending','partial')
ORDER BY id DESC
"
    );

?>

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">
            Add Payment
        </h4>

    </div>

    <div class="card-body">

        <form action="modules/payments/store.php" method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Invoice
                    </label>

                    <select name="invoice_id" class="form-select" required>

                        <option value="">
                            Select Invoice
                        </option>

                        <?php

                        while (
                            $invoice =
                            mysqli_fetch_assoc($invoices)
                        ) {

                            ?>

                            <option value="<?= $invoice['id']; ?>">

                                <?= htmlspecialchars($invoice['invoice_number']); ?>

                                (
                                ₹<?= number_format($invoice['amount'], 2); ?>
                                )

                            </option>

                            <?php

                        }

                        ?>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Payment Date
                    </label>

                    <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Amount
                    </label>

                    <input type="number" step="0.01" name="amount" class="form-control" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Payment Method
                    </label>

                    <select name="payment_method" class="form-select">

                        <option value="cash">
                            Cash
                        </option>

                        <option value="upi">
                            UPI
                        </option>

                        <option value="bank_transfer">
                            Bank Transfer
                        </option>

                        <option value="card">
                            Card
                        </option>

                        <option value="other">
                            Other
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Transaction ID
                    </label>

                    <input type="text" name="transaction_id" class="form-control">

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Remarks
                    </label>

                    <textarea name="remarks" rows="4" class="form-control"></textarea>

                </div>

            </div>

            <button type="submit" class="btn btn-success">

                Save Payment

            </button>

            <button type="button" class="btn btn-secondary" onclick="loadPage('modules/payments/index.php')">

                Cancel

            </button>

        </form>

    </div>

</div>