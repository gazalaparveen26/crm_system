<?php
require_once __DIR__.'/../../includes/auth.php';

requireRole(['admin']);
require_once __DIR__ . '/../../config/database.php';
$id = (int)($_GET['id'] ?? 0);
if($id == 0 && isset($_GET['page']))
{
    parse_str( parse_url($_GET['page'], PHP_URL_QUERY), $params
    );
    $id = (int)($params['id'] ?? 0);
}
$sql = "SELECT * FROM users WHERE id=? ";
$stmt =mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$result =mysqli_stmt_get_result($stmt);
$user =mysqli_fetch_assoc($result);
if(!$user)
{
    die('User Not Found');
}
?>
<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">
        <h4 class="mb-0"> Edit User </h4>
        <button class="btn btn-secondary" onclick="loadPage('modules/users/index.php')"> Back </button>
    </div>
    <div class="card-body">
        <form action="modules/users/update.php"  method="POST"  enctype="multipart/form-data">
            <input type="hidden" name="id"   value="<?= $user['id']; ?>">
            <input  type="hidden"  name="old_image" value="<?= $user['profile_image']; ?>">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <?php
                    if(!empty($user['profile_image']))
                    {
                    ?>
                    <img src="<?= $user['profile_image']; ?>" class="img-fluid rounded-circle border"
                    style="width:150px;height:150px;object-fit:cover;">
                    <?php
                    }
                    else
                    {
                    ?>
                    <img src="https://via.placeholder.com/150" class="img-fluid rounded-circle border">
                    <?php
                    }
                    ?>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input  type="text"  name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> Email</label>
                            <input  type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">  Phone   </label>
                            <input type="text" name="phone"  class="form-control"  value="<?= htmlspecialchars($user['phone']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">   New Password </label>
                            <input   type="password" name="password"  class="form-control"><small class="text-muted">Leave blank to keep current password </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>  Admin </option>
                                <option  value="manager" <?= $user['role']=='manager'?'selected':''; ?>>Manager</option>
                                <option value="staff" <?= $user['role']=='staff'?'selected':''; ?>>  Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">  Status  </label>
                            <select name="status" class="form-select">
                                <option value="active" <?= $user['status']=='active'?'selected':''; ?>> Active </option>
                                <option value="inactive" <?= $user['status']=='inactive'?'selected':''; ?>> Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Update User </button>
        </form>
    </div>
</div>
