<?php
require_once __DIR__.'/../../config/database.php';
require_once __DIR__.'/../../config/session.php';
require_once __DIR__.'/../../includes/activity.php';
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    exit('Invalid Request');
}

$id = (int)$_POST['id'];

$lead_name = trim($_POST['lead_name']);
$company_name = trim($_POST['company_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$source = trim($_POST['source']);
$status = trim($_POST['status']);
$estimated_value = $_POST['estimated_value'];
$followup_date = $_POST['followup_date'];
$remarks = trim($_POST['remarks']);

$sql = "UPDATE leads SET lead_name = ?, company_name = ?, email = ?,phone = ?,source = ?,status = ?,estimated_value = ?,followup_date = ?,remarks = ?,updated_at = NOW() WHERE id = ?";
$stmt = mysqli_prepare($conn,$sql);

$stmt = mysqli_prepare($conn,$sql);

logActivity(
    $_SESSION['user_id'],
    'Lead',
    'Updated',
    $_POST['id'],
    'Lead updated'
);

mysqli_stmt_bind_param($stmt,"sssssssssi",$lead_name,$company_name,$email,$phone,$source,$status,$estimated_value,$followup_date,$remarks,$id);
if(mysqli_stmt_execute($stmt))
{
?>
<script>
alert('Lead Updated Successfully');
window.location ='/dashboard.php?page=modules/leads/index.php';
</script>
<?php
}
else
{
    echo mysqli_error($conn);
}
?>
