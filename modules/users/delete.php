<?php
require_once __DIR__.'/../../includes/auth.php';

requireRole(['admin']);
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/session.php';
$id =(int)($_GET['id'] ?? 0);
/*
|--------------------------------------------------------------------------
| User Exists?
|--------------------------------------------------------------------------
*/
$sql = "SELECT * FROM users WHERE id=?";
$stmt =mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$result =mysqli_stmt_get_result($stmt);
$user =mysqli_fetch_assoc($result);
if(!$user){
    exit(
    'User Not Found'
    );
}
/*
|--------------------------------------------------------------------------
| Don't Delete Yourself
|--------------------------------------------------------------------------
*/
if($id == $_SESSION['user_id'])
{
    exit('You cannot delete your own account');
}

/*
|--------------------------------------------------------------------------
| Only Admin Can Delete
|--------------------------------------------------------------------------
*/

if($_SESSION['role'] != 'admin')
{
    exit('Access Denied');
}

/*
|--------------------------------------------------------------------------
| Delete Profile Image
|--------------------------------------------------------------------------
*/

if(!empty($user['profile_image']) && file_exists($user['profile_image']))
{
    unlink(    $user['profile_image']    );
}

/*
|--------------------------------------------------------------------------
| Delete User
|--------------------------------------------------------------------------
*/

$delete_sql = "DELETE FROM users WHERE id=?";
$delete_stmt =mysqli_prepare($conn,$delete_sql);
mysqli_stmt_bind_param($delete_stmt,"i",$id);
if(mysqli_stmt_execute($delete_stmt))
{
    echo 'User Deleted Successfully';
}
else
{
    echo    'Failed To Delete User';
}
?>