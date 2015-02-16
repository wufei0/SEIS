<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        
    }
    
    if (!isset($_SESSION['LOGGED']))
    {
        $_SESSION['LOGGED']='';
    }
    
    
    if ($_SESSION['LOGGED']!='' )
    {
        $DB_USER = $_SESSION['USERNAME'];
        $DB_PASS = $_SESSION['PASSWORD'];
        $_SESSION['LOGGED']=true;
    }
    else
    {
        $DB_USER = 'root';
        $DB_PASS = 'launi0n@dmin';
        $_SESSION['LOGGED']='';
    }
    
    
        $DB_HOST = '10.10.5.11';
        $BD_TABLE = 'SEIS'; 

?>