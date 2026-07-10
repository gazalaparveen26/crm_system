<?php
require_once __DIR__.'/../../includes/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/../../config/database.php';
$id = (int)($_GET['id'] ?? 0);
if($id == 0 && isset($_GET['page']))
{
    parse_str(parse_url($_GET['page'], PHP_URL_QUERY), $params );
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
    die("User Not Found");
}
?>
<div class="card shadow border-0">
    <div class="card-header d-flex justify-content-between">
        <h4>  User Details  </h4>
        <button class="btn btn-secondary" onclick="loadPage('modules/users/index.php')"> Back</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <?php
                if(!empty($user['profile_image']))
                {
                ?>
                <img src="<?= $user['profile_image']; ?>" class="img-fluid rounded-circle border" style="width:150px;height:150px;object-fit:cover;">
                <?php
                }
                else
                {
                ?>
                <img  src="https://via.placeholder.com/150" class="img-fluid rounded-circle border">
                <?php
                }
                ?>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">   Name  </th>
                        <td> <?= htmlspecialchars($user['name']); ?>  </td>
                    </tr>
                    <tr>
                        <th>Email  </th>
                        <td> <?= htmlspecialchars($user['email']); ?> </td>
                    </tr>
                    <tr>
                        <th>
                            Phone
                        </th>
                        <td>
                            <?= htmlspecialchars($user['phone']); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Role
                        </th>
                        <td>
                            <?= ucfirst($user['role']); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Status
                        </th>
                        <td>

                            <?php

                            if($user['status']=='active')
                            {
                                echo '<span class="badge bg-success">Active</span>';
                            }
                            else
                            {
                                echo '<span class="badge bg-danger">Inactive</span>';
                            }

                            ?>

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Last Login
                        </th>
                        <td>
                            <?= $user['last_login']; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Email Verified
                        </th>
                        <td>

                            <?php

                            if($user['email_verified'])
                            {
                                echo '<span class="badge bg-success">Verified</span>';
                            }
                            else
                            {
                                echo '<span class="badge bg-warning text-dark">Not Verified</span>';
                            }

                            ?>

                        </td>
                    </tr>

                    <tr>
                        <th>
                            Created At
                        </th>
                        <td>
                            <?= $user['created_at']; ?>
                        </td>
                    </tr>

                </table>

                <button
                class="btn btn-warning"
                onclick="loadPage('modules/users/edit.php?id=<?= $user['id']; ?>')">

                    Edit User

                </button>

            </div>

        </div>

    </div>

</div>

