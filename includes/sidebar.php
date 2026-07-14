<div class="sidebar" id="sidebar">
    <div class="logo">
        <h4>CRM PRO</h4>
    </div>

    <ul class="nav flex-column">

        <li>
            <a href="#" onclick="loadPage('modules/dashboard/home.php')"><i class="bi bi-grid"></i>       Dashboard</a>
        </li>

        <li>
            <a href="#" onclick="loadPage('modules/customers/index.php')"> <i class="bi bi-people"></i> Customers</a>
        </li>
        <li>
            <a href="#" onclick="loadPage('modules/leads/index.php')"><i class="bi bi-bullseye"></i> Leads</a>
        </li>
        <li>
            <a href="#" onclick="loadPage('modules/tasks/index.php')"> <i  class="bi bi-check2-square"></i> Tasks</a>
        </li>
        <li class="nav-item">
            <a href="#"  onclick="loadPage('modules/invoices/index.php')">
        <i class="bi bi-receipt"></i> Invoices    </a>
</li>
        <li class="nav-item">
            <a href="#"  onclick="loadPage('modules/payments/index.php')">
        <i class="bi bi-receipt"></i> Payments    </a>
</li>
       <?php

if(
$_SESSION['role']=='admin'
||
$_SESSION['role']=='manager'
)
{
?>

<li class="nav-item">
<a href="#"
onclick="loadPage('modules/reports/index.php')">
 <i class="bi bi-graph-up"></i>
Reports
</a>
</li>

<?php
}
?>

     <?php if($_SESSION['role'] == 'admin') { ?>
<li class="nav-item">
    <a   href="#"  onclick="loadPage('modules/users/index.php')">
        <i class="bi bi-people"></i>        Users    </a>
</li>
<?php } ?>
<li class="nav-item">
    <a href="#" onclick="loadPage('modules/followups/index.php')">
       <i class="bi bi-calendar-check"></i> Followups </a>
</li>

 <li class="nav-item"><a href="#" onclick="loadPage('modules/activity/index.php')"><i class="bi bi-clock-history"></i>Activity Logs</a></li>
    
        <li class="nav-item"><a href="#" onclick="loadPage('modules/notifications/index.php')"><i class="bi bi-bell"></i> Notifications </a> </li>
        <li class="nav-item"><a href="#" onclick="loadPage('modules/settings/index.php')"> <i class="bi bi-gear"></i>Settings</a></li>

    </ul>

</div>