<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("../connection.php");
    include("../security.php");
    if (!isset($_POST['module']))
    {
        die();
    }

    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
    if (mysqli_connect_error())
    {
        echo "Connection Error";
        die();
    }

    switch ($_POST['module'])
    {

         case 'printPARovermodal':
                printData($_POST['printpar_id']);
                break;

    }


      function printData($id)
    {
        if(!systemPrivilege('P_Create',$_SESSION['GROUPNAME'],$_POST['form']))
        {
            echo 'Insufficient Group Privilege. Please contact your Administrator.';
            die();
        }
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
        switch ($_POST['module'])
        {

                case 'printPARovermodal':
                    $sql='SELECT * FROM Property_Acknowledgement WHERE Par_Id='.$id.'';
                        $resultSet=  mysqli_query($conn, $sql);
                        $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                        echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo "<table class='table table-bordered'>
                                <tr>
                                    <td>GSO Number:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>Date Acquired:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>GSO Number:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>Office:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>Recipient:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                                <tr>
                                    <td>Remarks:</td>
                                    <td>".$row['Par_Date']."</td>
                                </tr>
                               </table>";
                               echo "</div>";
                               echo "</div>";
                break;
        }
        mysqli_close($conn);
    }


