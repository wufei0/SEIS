<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        
    }
    
    if (!isset($_SESSION['LOGGED']))
    {
        $_SESSION['LOGGED']='';
    }
    if ((!isset($_SESSION['GROUPNAME'])))
    {
        $_SESSION['GROUPNAME']='';
    }
    
    
    if ($_SESSION['LOGGED']!='' )
    {
        $DB_USER = $_SESSION['USERNAME'];
        $DB_PASS = $_SESSION['PASSWORD'];
        $_SESSION['LOGGED']=true;
    }
    else
    {
        $DB_USER = 'guest';
        $DB_PASS = 'I am guest account.';
        $_SESSION['LOGGED']='';
    }
    
    
        $DB_HOST = '10.10.5.11';
        $BD_TABLE = 'SEIS'; 

?>