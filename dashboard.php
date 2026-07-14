
<?php

require_once 'config/session.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'includes/header.php';
?>
<div class="main-wrapper">
    <?php include 'includes/sidebar.php'; ?>
        <div class="content-area">
        <?php include 'includes/navbar.php'; ?>
        <div id="content-area">
            <?php

            $allowed_pages = [
                'modules/dashboard/home.php',
                'modules/customers/index.php',
                'modules/customers/view.php',
                'modules/customers/edit.php',
                'modules/customers/create.php',
                'modules/leads/index.php',
                'modules/leads/view.php',
                'modules/leads/edit.php',
                'modules/leads/create.php',
                'modules/tasks/index.php',
                'modules/tasks/create.php',
                'modules/tasks/view.php',
                'modules/tasks/edit.php',
                'modules/invoices/index.php',
                'modules/invoices/create.php',
                'modules/invoices/view.php',
                'modules/invoices/edit.php',
                'modules/followups/index.php',
                'modules/followups/create.php',
                'modules/followups/edit.php',
                'modules/followups/view.php',
                'modules/activity/index.php',



            ];
            $page = urldecode($_GET['page'] ?? '');
            $page_path = strtok($page, '?');
            if (in_array($page_path, $allowed_pages)) {
                include $page_path;
            } else {
                include 'modules/dashboard/home.php';
            }
            ?>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>