<?php
require_once __DIR__ . '/../../includes/auth.php';
requireRole(['admin']);

require_once __DIR__ . '/../../config/database.php';

$limit = 10;

$page_no = isset($_GET['p'])
    ? (int)$_GET['p']
    : 1;

$offset = ($page_no - 1) * $limit;

$count_sql = "SELECT COUNT(*) AS total FROM users";

$count_result = mysqli_query($conn, $count_sql);

$total_records = mysqli_fetch_assoc($count_result)['total'];

$total_pages = ceil($total_records / $limit);

$sql = "
SELECT *
FROM users
ORDER BY id DESC
LIMIT $offset,$limit
";

$result = mysqli_query($conn, $sql);
?>

<div class="card shadow border-0">

    <!-- ================= HEADER ================= -->

    <div class="card-header">

        <div class="row align-items-center">

            <div class="col-md-2">

                <h4 class="mb-0">
                    Users
                </h4>

            </div>

            <!-- Search -->

            <div class="col-md-3">

                <input
                    type="text"
                    id="userSearch"
                    class="form-control"
                    placeholder="Search User...">

            </div>

            <!-- Role -->

            <div class="col-md-2">

                <select
                    id="userRoleFilter"
                    class="form-select">

                    <option value="">
                        All Roles
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                    <option value="manager">
                        Manager
                    </option>

                    <option value="staff">
                        Staff
                    </option>

                </select>

            </div>

            <!-- Status -->

            <div class="col-md-2">

                <select
                    id="userStatusFilter"
                    class="form-select">

                    <option value="">
                        All Status
                    </option>

                    <option value="active">
                        Active
                    </option>

                    <option value="inactive">
                        Inactive
                    </option>

                </select>

            </div>

            <!-- Buttons -->

            <div class="col-md-3 text-end">

                <button
                    class="btn btn-secondary me-2"
                    onclick="resetUserFilters()">

                    <i class="bi bi-arrow-clockwise"></i>

                    Reset

                </button>

                <button
                    class="btn btn-primary"
                    onclick="loadPage('modules/users/create.php')">

                    <i class="bi bi-plus-circle"></i>

                    Add User

                </button>

            </div>

        </div>

    </div>

    <!-- ================= BODY ================= -->

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="table table-hover align-middle"
                id="userTable">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Profile</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Phone</th>

                        <th>Role</th>

                        <th>Status</th>

                        <th>Last Login</th>

                        <th width="220">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>
                    <?php
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
?>

<tr>

    <td>
        <?= $row['id']; ?>
    </td>

    <!-- Profile -->

    <td>

        <?php
        if(!empty($row['profile_image']))
        {
        ?>

        <img
            src="<?= htmlspecialchars($row['profile_image']); ?>"
            class="rounded-circle"
            width="40"
            height="40"
            style="object-fit:cover;">

        <?php
        }
        else
        {
        ?>

        <img
            src="https://via.placeholder.com/40"
            class="rounded-circle">

        <?php
        }
        ?>

    </td>

    <!-- Name -->

    <td>

        <?= htmlspecialchars($row['name']); ?>

    </td>

    <!-- Email -->

    <td>

        <?= htmlspecialchars($row['email']); ?>

    </td>

    <!-- Phone -->

    <td>

        <?= htmlspecialchars($row['phone']); ?>

    </td>

    <!-- Role -->

    <td data-role="<?= strtolower($row['role']); ?>">

        <?php

        if($row['role']=='admin')
        {
        ?>

        <span class="badge bg-danger">
            Admin
        </span>

        <?php
        }
        elseif($row['role']=='manager')
        {
        ?>

        <span class="badge bg-warning text-dark">
            Manager
        </span>

        <?php
        }
        else
        {
        ?>

        <span class="badge bg-info">
            Staff
        </span>

        <?php
        }
        ?>

    </td>

    <!-- Status -->

    <td data-status="<?= strtolower($row['status']); ?>">

        <?php

        if($row['status']=='active')
        {
        ?>

        <span class="badge bg-success">
            Active
        </span>

        <?php
        }
        else
        {
        ?>

        <span class="badge bg-secondary">
            Inactive
        </span>

        <?php
        }
        ?>

    </td>

    <!-- Last Login -->

    <td>

        <?=
        !empty($row['last_login'])
        ?
        date(
            'd M Y h:i A',
            strtotime($row['last_login'])
        )
        :
        '-';
        ?>

    </td>

    <!-- Action -->

    <td>

        <button
            class="btn btn-info btn-sm"
            onclick="loadPage('modules/users/view.php?id=<?= $row['id']; ?>')">

            <i class="bi bi-eye"></i>

        </button>

        <button
            class="btn btn-warning btn-sm"
            onclick="loadPage('modules/users/edit.php?id=<?= $row['id']; ?>')">

            <i class="bi bi-pencil-square"></i>

        </button>

        <button
            class="btn btn-danger btn-sm"
            onclick="deleteUser(<?= $row['id']; ?>)">

            <i class="bi bi-trash"></i>

        </button>

    </td>

</tr>

<?php
    }
}
else
{
?>

<tr>

    <td
        colspan="9"
        class="text-center">

        No Users Found

    </td>

</tr>

<?php
}
?>
                </tbody>

            </table>

            <!-- ================= Pagination ================= -->

            <nav class="mt-3">

                <ul class="pagination justify-content-end">

                    <?php
                    for($i=1;$i<=$total_pages;$i++)
                    {
                    ?>

                    <li class="page-item <?= ($i==$page_no)?'active':''; ?>">

                        <a
                            href="#"
                            class="page-link"
                            onclick="loadPage('modules/users/index.php?p=<?= $i; ?>')">

                            <?= $i; ?>

                        </a>

                    </li>

                    <?php
                    }
                    ?>

                </ul>

            </nav>

        </div>

    </div>

</div>