<?php

require_once '../../config/database.php';
require_once '../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    exit('Invalid Request');
}

$id = (int)$_POST['id'];

$customer_name = trim($_POST['customer_name']);
$company_name = trim($_POST['company_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$alternate_phone = trim($_POST['alternate_phone']);
$website = trim($_POST['website']);
$gst_number = trim($_POST['gst_number']);
$address = trim($_POST['address']);
$city = trim($_POST['city']);
$state = trim($_POST['state']);
$country = trim($_POST['country']);
$postal_code = trim($_POST['postal_code']);
$customer_type = trim($_POST['customer_type']);
$status = trim($_POST['status']);
$notes = trim($_POST['notes']);

$sql = "
UPDATE customers
SET
customer_name = ?,
company_name = ?,
email = ?,
phone = ?,
alternate_phone = ?,
website = ?,
gst_number = ?,
address = ?,
city = ?,
state = ?,
country = ?,
postal_code = ?,
customer_type = ?,
status = ?,
notes = ?
WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);
logActivity(
    $_SESSION['user_id'],
    'Customer',
    'Updated',
    $_POST['id'],
    'Customer updated'
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssssssssi",
    $customer_name,
    $company_name,
    $email,
    $phone,
    $alternate_phone,
    $website,
    $gst_number,
    $address,
    $city,
    $state,
    $country,
    $postal_code,
    $customer_type,
    $status,
    $notes,
    $id
);

if(mysqli_stmt_execute($stmt))
{
    header(
        "Location: ../../dashboard.php?page=modules/customers/index.php"
    );
    exit;
}
else
{
    echo mysqli_error($conn);
}