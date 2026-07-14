    <?php

    require_once __DIR__ . '/../config/database.php';


function logActivity($user_id, $module, $action, $reference_id = null, $description = '')
{
    global $conn;

    if (!$conn) {
        return;
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    $user_id = (int)$user_id;
    $module = mysqli_real_escape_string($conn, $module);
    $action = mysqli_real_escape_string($conn, $action);

    if ($reference_id === null) {
        $reference_id = "NULL";
    } else {
        $reference_id = (int)$reference_id;
    }

    $description = mysqli_real_escape_string($conn, $description);
    $ip = mysqli_real_escape_string($conn, $ip);

    $sql = "INSERT INTO activity_logs
    (user_id,module,action,reference_id,description,ip_address)
    VALUES
    ($user_id,'$module','$action',$reference_id,'$description','$ip')";

    mysqli_query($conn,$sql);
}
?>