<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/database.php';
require_once '../../config/session.php';
require_once '../../includes/activity.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid Request');
}

$customer_name = trim($_POST['customer_name']);
$company_name = trim($_POST['company_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$alternate_phone = trim($_POST['alternate_phone']);
$website = trim($_POST['website']);
$gst_number = trim($_POST['gst_number']);

$customer_type = trim($_POST['customer_type']);
$status = trim($_POST['status']);

$address = trim($_POST['address']);
$city = trim($_POST['city']);
$state = trim($_POST['state']);
$country = trim($_POST['country']);
$postal_code = trim($_POST['postal_code']);

$notes = trim($_POST['notes']);

$customer_code =
'CUS-' .
str_pad(
rand(1,99999),
5,
'0',
STR_PAD_LEFT
);

$sql = "
INSERT INTO customers
(
customer_code,
company_name,
customer_name,
email,
phone,
alternate_phone,
website,
gst_number,
address,
city,
state,
country,
postal_code,
customer_type,
status,
notes,
created_by
)
VALUES
(
?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
)
";

$stmt = mysqli_prepare($conn,$sql);
$customer_id = mysqli_insert_id($conn);
logActivity(
    $_SESSION['user_id'],
    'Customer',
    'Created',
    $customer_id,
    'New customer created: ' . $customer_name
);

mysqli_stmt_bind_param(
$stmt,
"ssssssssssssssssi",

$customer_code,
$company_name,
$customer_name,
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
$_SESSION['user_id']
);

if(mysqli_stmt_execute($stmt))
{
    echo "<script>alert('Customer Saved Successfully');</script>";
    header("Location: ../../dashboard.php?page=modules/customers/index.php");
}
else
{
    echo mysqli_error($conn);
}