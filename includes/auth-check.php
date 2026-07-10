<?php

session_start();

function requireRole($roles)
{
    if(!isset($_SESSION['role']))
    {
        die('Please Login');
    }

    if(!in_array($_SESSION['role'],$roles))
    {
        die('Access Denied');
    }
}