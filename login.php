<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


    if (!isset($_POST['module']))
    {
        die();
    }
    
    include("connection.php");
    
    switch ($_POST['module'])
    {
        
        case 'renderLogin':
            echo "<form onsubmit='return logMeIn();'>";
            echo "<div class='row'>";
                echo "<div class='col-md-12'><table>
                
                    <tr>
                        <td>Username:</td>
                        <td style='width:100%; padding:0 0 5px 10px;'><input id='txtusername' type='text' class='form-control'></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td style='width:100%; padding:0 0 5px 10px;'><input id='txtpassword' type='password' class='form-control' ></td>
                    </tr>
                   

                </table>";
                echo "</div>";
                echo "</div>";
//                    <table style='float:right;'>
//                    <tr>
//                                    <td> <button type='submit' class='btn btn-primary form-control' >Login</button> </td>
//                                    <td> <button type='button' class='btn btn-danger form-control' data-dismiss='modal'>Close</button> </td>
//                            
//                    </tr>
//                    </table>
                   
            break;
        
        case 'logMeIn':
            global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
            $username=$_POST['username'];
            $password=$_POST['password'];
            
            $conn=mysqli_connect($DB_HOST,$username,$password,$BD_TABLE);
            if (mysqli_connect_error())
            {
                $_SESSION['LOGGED']=false;
                echo 'false';
                die();
            }
            else
            {
                echo 'true';
                $_SESSION['LOGGED']=true;
                $_SESSION['USERNAME']=$username;
                $_SESSION['PASSWORD']=$password;
                
            }
            
            
            break;
            
        case 'logMeOut':
            session_destroy();
            break;
        
        
    }