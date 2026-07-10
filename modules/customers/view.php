
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
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$result =mysqli_stmt_get_result($stmt);
$customer =mysqli_fetch_assoc($result);
if(!$customer)
{
    die("Customer Not Found");
}
?>
<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">
        <h4>Customer Details</h4>
        <button class="btn btn-secondary" onclick="loadPage('modules/customers/index.php')">Back</button>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Customer Code</th>
                <td>
                    <?= htmlspecialchars( $customer['customer_code']); ?>
                </td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>
                    <?= htmlspecialchars($customer['customer_name']); ?>
                </td>
            </tr>

            <tr>

                <th>
                    Company
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['company_name']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    Email
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['email']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    Phone
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['phone']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    Address
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['address']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    City
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['city']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    State
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['state']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    Country
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['country']
                    ); ?>
                </td>

            </tr>

            <tr>

                <th>
                    Status
                </th>

                <td>
                    <?= htmlspecialchars(
                    $customer['status']
                    ); ?>
                </td>

            </tr>

        </table>

    </div>

</div>