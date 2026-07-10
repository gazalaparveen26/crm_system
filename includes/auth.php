<?php

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

function requireRole($roles)
{
    if(!isset($_SESSION['user_id']))
    {
        ?>
        <script>
        alert('Please Login');
        window.location='login.php';
        </script>
        <?php
        exit;
    }

    if(!in_array($_SESSION['role'], $roles))
    {
        ?>
        <script>
        alert('Access Denied');

        if(typeof loadPage === 'function')
        {
            loadPage('modules/dashboard/index.php');
        }
        else
        {
            window.location='dashboard.php';
        }
        </script>
        <?php
        exit;
    }
}