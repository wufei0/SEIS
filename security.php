<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//
//include("../../connection.php");
//global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
//
//$conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
//if (mysqli_connect_error())
//{
//    echo "Connection Error";
//    die();
//}
      

function privilege($dml,$group,$flag,$module)
{
    
    switch ($dml)
    {
        case 'P_Read':
            $lang='P_Read';
            break;
        case 'P_Create':
            break;
        case 'P_Update':
            break;
        case 'P_Delete':
            break;
    }
    
    $sql='SELECT '.$dml.' FROM M_PrivilegeUser';
}