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
SELECT *
FROM customers
WHERE id = ?
";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result =
mysqli_stmt_get_result($stmt);

$customer =
mysqli_fetch_assoc($result);

if(!$customer)
{
    die("Customer Not Found");
}

?>


<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">
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

$sql = "SELECT * FROM customers WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$customer = mysqli_fetch_assoc($result);

if(!$customer)
{
    die("Customer Not Found");
}

?>

<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">

    <h4 class="mb-0">
        Edit Customer
    </h4>
   <button class="btn btn-secondary" onclick="loadPage('modules/customers/index.php')">Back</button>
</div>

<div class="card-body">

    <form
        action="modules/customers/update.php"
        method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $customer['id']; ?>">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Customer Name *
                </label>

                <input
                    type="text"
                    name="customer_name"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['customer_name']); ?>"
                    required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Company Name
                </label>

                <input
                    type="text"
                    name="company_name"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['company_name']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['email']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['phone']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Alternate Phone
                </label>

                <input
                    type="text"
                    name="alternate_phone"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['alternate_phone']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Website
                </label>

                <input
                    type="text"
                    name="website"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['website']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    GST Number
                </label>

                <input
                    type="text"
                    name="gst_number"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['gst_number']); ?>">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Customer Type
                </label>

                <select
                    name="customer_type"
                    class="form-select">

                    <option
                        value="individual"
                        <?= $customer['customer_type']=='individual' ? 'selected' : ''; ?>>
                        Individual
                    </option>

                    <option
                        value="business"
                        <?= $customer['customer_type']=='business' ? 'selected' : ''; ?>>
                        Business
                    </option>

                </select>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select">

                    <option
                        value="active"
                        <?= $customer['status']=='active' ? 'selected' : ''; ?>>
                        Active
                    </option>

                    <option
                        value="inactive"
                        <?= $customer['status']=='inactive' ? 'selected' : ''; ?>>
                        Inactive
                    </option>

                </select>

            </div>

            <div class="col-12 mb-3">

                <label class="form-label">
                    Address
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    rows="3"><?= htmlspecialchars($customer['address']); ?></textarea>

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    City
                </label>

                <input
                    type="text"
                    name="city"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['city']); ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    State
                </label>

                <input
                    type="text"
                    name="state"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['state']); ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    Country
                </label>

                <input
                    type="text"
                    name="country"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['country']); ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">
                    Postal Code
                </label>

                <input
                    type="text"
                    name="postal_code"
                    class="form-control"
                    value="<?= htmlspecialchars($customer['postal_code']); ?>">

            </div>

            <div class="col-12 mb-3">

                <label class="form-label">
                    Notes
                </label>

                <textarea
                    name="notes"
                    class="form-control"
                    rows="4"><?= htmlspecialchars($customer['notes']); ?></textarea>

            </div>

        </div>

        <button
            type="submit"
            class="btn btn-success">

            Update Customer

        </button>

        <button
            type="button"
            class="btn btn-secondary"
            onclick="loadPage('modules/customers/index.php')">

            Cancel

        </button>

    </form>

</div>


</div>
