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
$sql = "SELECT * FROM leads WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$lead = mysqli_fetch_assoc($result);

if(!$lead)
{
    die("Lead Not Found");
}

if($lead['converted_customer_id'])
{
    die("Lead Already Converted");
}

$customer_code =
'CUST-' .
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
customer_name,
company_name,
email,
phone,
status,
notes,
created_by
)
VALUES
(
?,?,?,?,?,?,?,?
)
";

$stmt = mysqli_prepare($conn, $sql);

$customer_status = 'active';

mysqli_stmt_bind_param(
$stmt,
"sssssssi",
$customer_code,
$lead['lead_name'],
$lead['company_name'],
$lead['email'],
$lead['phone'],
$customer_status,
$lead['remarks'],
$lead['created_by']
);

if(mysqli_stmt_execute($stmt))
{
    $customer_id = mysqli_insert_id($conn);

    $update_sql = "
    UPDATE leads
    SET
    converted_customer_id = ?,
    status = 'won'
    WHERE id = ?
    ";

    $update_stmt = mysqli_prepare($conn, $update_sql);

    mysqli_stmt_bind_param(
    $update_stmt,
    "ii",
    $customer_id,
    $id
    );

    mysqli_stmt_execute($update_stmt);

    header(
    "Location: /dashboard.php?page=modules/customers/index.php"
    );

    exit;
}
else
{
    echo mysqli_error($conn);
}
?>
