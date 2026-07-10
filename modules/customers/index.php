<?php

require_once __DIR__ . '/../../config/database.php';

$limit = 10;

$page_no = isset($_GET['p'])
? (int)$_GET['p']
: 1;

$offset =
($page_no - 1) * $limit;

$count_sql =
"SELECT COUNT(*) as total
FROM customers";

$count_result =
mysqli_query($conn,$count_sql);

$total_records =
mysqli_fetch_assoc($count_result)['total'];

$total_pages =
ceil($total_records / $limit);

$sql = "
SELECT
id,
customer_code,
customer_name,
company_name,
email,
phone,
status
FROM customers
ORDER BY id DESC
LIMIT $offset,$limit
";

$result = mysqli_query($conn,$sql);

?>
<div class="card shadow border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Customers
        </h4>
          <div class="position-relative me-3">
                <input type="text" id="customerSearch" class="form-control "placeholder="Search Customer...">
            </div>
    

        <button
            class="btn btn-primary"
            onclick="loadPage('modules/customers/create.php')">

            <i class="bi bi-plus-circle"></i>
            Add Customer

        </button>

    </div>
    
<!-- customer table -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="customerTable">
                <thead>
                    <tr>        
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
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

                        <td>
                            <?= htmlspecialchars($row['customer_code']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['customer_name']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['company_name']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['email']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['phone']); ?>
                        </td>

                        <td>

                            <?php
                            if($row['status'] == 'active')
                            {
                            ?>

                            <span class="badge bg-success customer-status">
                                Active
                            </span>

                            <?php
                            }
                            else
                            {
                            ?>

                            <span class="badge bg-danger customer-status">
                                Inactive
                            </span>

                            <?php
                            }
                            ?>

                        </td>

                        <td>
 <button class="btn btn-info btn-sm" onclick="loadPage('modules/customers/view.php?id=<?= $row['id']; ?>')">  <i class="bi bi-eye"></i></button>
<button class="btn btn-warning btn-sm" onclick="loadPage('modules/customers/edit.php?id=<?= $row['id']; ?>')"><i class="bi bi-pencil-square"></i></button>
<button class="btn btn-danger btn-sm" onclick="deleteCustomer(<?= $row['id']; ?>)"><i class="bi bi-trash"></i></button>
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
                            colspan="8"
                            class="text-center">

                            No Customers Found

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>
<nav class="mt-3">

<ul class="pagination justify-content-end">
<?php for($i=1; $i<=$total_pages; $i++) { ?>
<li class="page-item <?= ($i==$page_no)?'active':''; ?>">
<a class="page-link" href="#" onclick="loadPage('modules/customers/index.php?p=<?= $i; ?>')">
<?= $i; ?>

</a>

</li>

<?php } ?>

</ul>

</nav>
        </div>

    </div>

</div>