<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../includes/activity.php';
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    exit('Invalid Request');
}

$lead_name =trim($_POST['lead_name']);
$company_name =trim($_POST['company_name']);
$email =trim($_POST['email']);
$phone =trim($_POST['phone']);
$source =trim($_POST['source']);
$status =trim($_POST['status']);
$estimated_value =$_POST['estimated_value'];
$followup_date =$_POST['followup_date'];
$remarks =trim($_POST['remarks']);
$lead_code ='LEAD-' .str_pad(rand(1,99999),5,'0',STR_PAD_LEFT);
$sql = "INSERT INTO leads(lead_code,lead_name,company_name,email,phone,source,status,estimated_value,followup_date,remarks,created_by)VALUES(?,?,?,?,?,?,?,?,?,?,?)";

$stmt =mysqli_prepare($conn,$sql);
$lead_id = mysqli_insert_id($conn);
logActivity(
    $_SESSION['user_id'],
    'Lead',
    'Created',
    $lead_id,
    'New lead created: ' . $lead_name
);

mysqli_stmt_bind_param(
$stmt,
"ssssssssssi",
$lead_code,
$lead_name,
$company_name,
$email,
$phone,
$source,
$status,
$estimated_value,
$followup_date,
$remarks,
$_SESSION['user_id']
);

if(
mysqli_stmt_execute($stmt)
)
{
?>

<script>

alert(
'Lead Added Successfully'
);

window.location =
'/dashboard.php?page=modules/leads/index.php';

</script>

<?php
}
else
{
    echo mysqli_error($conn);
}