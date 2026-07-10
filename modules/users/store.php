```php
<?php

require_once __DIR__ . '/../../config/database.php';

$name =
trim($_POST['name'] ?? '');

$email =
trim($_POST['email'] ?? '');

$phone =
trim($_POST['phone'] ?? '');

$password =
$_POST['password'] ?? '';

$role =
$_POST['role'] ?? 'staff';

$status =
$_POST['status'] ?? 'active';

/*
|--------------------------------------------------------------------------
| Duplicate Email Check
|--------------------------------------------------------------------------
*/

$check_sql =
"
SELECT id
FROM users
WHERE email=?
";

$check_stmt =
mysqli_prepare(
$conn,
$check_sql
);

mysqli_stmt_bind_param(
$check_stmt,
"s",
$email
);

mysqli_stmt_execute(
$check_stmt
);

$check_result =
mysqli_stmt_get_result(
$check_stmt
);

if(
mysqli_num_rows(
$check_result
) > 0
)
{
?>

<script>

alert(
'Email already exists'
);

window.location =
'/dashboard.php?page=modules/users/create.php';

</script>

<?php

exit;

}

/*
|--------------------------------------------------------------------------
| Password Hash
|--------------------------------------------------------------------------
*/

$hashed_password =
password_hash(
$password,
PASSWORD_DEFAULT
);

/*
|--------------------------------------------------------------------------
| Profile Image Upload
|--------------------------------------------------------------------------
*/

$profile_image = null;

if(
isset(
$_FILES['profile_image']
)
&&
$_FILES['profile_image']['error']
==
0
)
{

$upload_dir =
'uploads/users/';

if(
!is_dir(
$upload_dir
)
)
{
mkdir(
$upload_dir,
0777,
true
);
}

$file_name =
time()
.
'_'
.
basename(
$_FILES['profile_image']['name']
);

$target_file =
$upload_dir
.
$file_name;

move_uploaded_file(
$_FILES['profile_image']['tmp_name'],
$target_file
);

$profile_image =
$target_file;

}

/*
|--------------------------------------------------------------------------
| Insert User
|--------------------------------------------------------------------------
*/

$sql =
"
INSERT INTO users
(
name,
email,
phone,
password,
role,
profile_image,
status
)
VALUES
(
?,?,?,?,?,?,?
)
";

$stmt =
mysqli_prepare(
$conn,
$sql
);

mysqli_stmt_bind_param(
$stmt,
"sssssss",
$name,
$email,
$phone,
$hashed_password,
$role,
$profile_image,
$status
);

if(
mysqli_stmt_execute(
$stmt
)
)
{
?>

<script>

alert(
'User Created Successfully'
);

window.location =
'/dashboard.php?page=modules/users/index.php';

</script>

<?php

}
else
{

echo
mysqli_error(
$conn
);

}
?>
```
