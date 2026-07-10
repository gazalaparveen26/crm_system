<?php

require_once __DIR__ . '/../../config/database.php';

$id =
(int)($_GET['id'] ?? 0);

if($id <= 0)
{
?>

<script>

alert('Invalid Followup ID');

loadPage(
'modules/followups/index.php'
);

</script>

<?php
exit;
}

$sql = "

UPDATE lead_followups

SET status='completed'

WHERE id=?

";

$stmt =
mysqli_prepare(
$conn,
$sql
);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

if(
mysqli_stmt_execute($stmt)
)
{
?>

<script>

alert(
'Followup Marked Completed'
);

loadPage(
'modules/followups/index.php'
);

</script>

<?php
}
else
{
?>

<script>

alert(
'Error Completing Followup'
);

loadPage(
'modules/followups/index.php'
);

</script>

<?php
}
?>