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
         case 'printPropertyPARovermodal':
                printData($_POST['printpar_id']);
                break;

         case 'printPropertyReturnovermodal':
                printData($_POST['printpropertyreturn_id']);
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
             case 'printPropertyPARovermodal':
                $sql='SELECT Property_Acknowledgement.*, M_Personnel.* FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                WHERE Par_Id='.$id.'';

                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                     echo "
                        <div style='height:430px;overflow:auto;' id='normantry'>
                            <table border='1px' style='width: 100%;'>
                                <tr>
                                    <td colspan='7'>&nbsp;Revised January 1992</td>
                                    <td colspan='2'>&nbsp;Appendix 27 <br>&nbsp;<b>GSO No.</b>: ".$row['Par_GSOno']."</td>
                                </tr>
                                <tr>
                                    <td colspan='9' style='text-align: center'>Republic of the Philippines<br><b>PROPERTY ACKNOWLEDGEMENT RECEIPT</b><br>Province of La Union</td>
                                </tr>
                                <tr>
                                    <td colspan='4'>&nbsp;Office/Agency: <u><b>Provincial Government of La Union</b></u></td>
                                    <td colspan='3'>&nbsp;Address: <u><b>Provincial Capitol, City of San Fernando</u></b></td>
                                    <td colspan='2'>&nbsp;Date: February 4,2015</td>
                                </tr>
                                <tr>
                                    <td colspan='9'>
                                    <div align='center'>
                                    <br>
                                    I acknowledge to have received from <u><b>EMELDA P. PASCUAL</b></u><br>
                                    of <u><b>PGSO</b></u>, the following property/ies which will be used in <u><b>BRGY. LIAOC NORTE, NAGUILIAN</b></u> and for which I am accountable.</td>
                                    </div>
                                </tr>
                                <tr style='text-align: center'>
                                    <td>Qty.</td>
                                    <td>Unit</td>
                                    <td>NAME AND DESCRIPTION</td>
                                    <td>DATE ACQUIRED</td>
                                    <td>INVENTORY TAG</td>
                                    <td>PROPERTY NUMBER</td>
                                    <td>UNIT VALUE</td>
                                    <td>TOTAL ACQUISITION COST</td>
                                    <td>REMARKS</td>
                                </tr>    ";


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }



                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $rows)
                                    {
                                       echo "<tr><td></td><td></td><td>".$rows['Property_Number']."</td><td></td><td>".$rows['Property_InventoryTag']."</td><td>".$rows['Property_Number']."</td><td></td><td></td><td></td></tr>";
                                    }


                             echo "
                              <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>&nbsp;Note: ".$row['Par_Note']."</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                 <tr align='center'>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>TOTAL<b/></td>
                                    <td></td>
                                    <td><b>43,740.00</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan='9'>&nbsp;Remarks: &nbsp;".$row['Par_Remarks']."</td>
                                </tr>
                                <tr>
                                    <td colspan='5'>
                                        &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                                        <div align='center'>
                                        <u><b><font style='text-transform: uppercase;'>".$row['Personnel_Fname']." ".$row['Personnel_Mname']." ".$row['Personnel_Lname']."</font></b></u><br>
                                        Barangay captain
                                        </div>
                                    </td>
                                    <td colspan='4'>
                                        &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                                        <div align='center'>
                                          <u><b><font style='text-transform: uppercase;'>".$row['Personnel_Fname']." ".$row['Personnel_Mname']." ".$row['Personnel_Lname']."</font></b></u><br>
                                        PGSO
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>";
                        break;












                        case 'printPropertyReturnovermodal';
                           echo "
                            <div style='height:430px;overflow:auto;'>
                            LGU Form No. 12
                           <div align='center'><b><label style='font-size: x-large'>PROPERTY RETURN SLIP</label></b></div>
                     Name of Local Government Unit: <u>Provincial Government of La Union</u><br>
                     Purpose: (x)Disposal&nbsp;&nbsp;&nbsp;&nbsp;()Repair&nbsp;&nbsp;&nbsp;&nbsp;()Returned to Stock&nbsp;&nbsp;&nbsp;&nbsp;()Other

<table border='1px' style='width: 100%;'>
<tr>
                                    <td colspan='8'>&nbsp;</td></tr>
<tr align='center'>
<td style='width:5%'>QTY.</td>
<td style='width:5%'>UNIT</td>
<td style='width:25%'>DESCRIPTION</td>
<td style='width:15%'>Property Number</td>

<td style='width:10%'>Date Acquired</td>
<td style='width:20%'>Name of End-User</td>
<td style='width:10%'>Unit Value</td>
<td style='width:10%'>Total Value</td></tr>





<tr><td>1</td><td>pc</td><td>15 -12</td><td></td><td></td><td>Mario R. Quiloy</td><td></td><td></td></tr>
<tr><td>1</td><td>pc</td><td>15 -12</td><td></td><td></td><td>Mario R. Quiloy</td><td></td><td></td></tr>
<tr><td>1</td><td>pc</td><td>15 -12</td><td></td><td></td><td>Mario R. Quiloy</td><td></td><td></td></tr>
<tr><td>1</td><td>pc</td><td>15 -12</td><td></td><td></td><td>Mario R. Quiloy</td><td></td><td></td></tr>
   <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
     <tr>
                                    <td></td>
                                    <td></td>
                                    <td>&nbsp;Note: Note Sample</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                 <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> <tr align='center'>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Sub-Total</b></td>
                                    <td></td>
                                    <td><b>15,253.00</b></td>
                                </tr>

<tr><td colspan='8' align='center'><b>CERTIFICATION</b></td></tr>

<tr><td colspan='4'>&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this 23rd day of February,<br>&nbsp;2012.<br>
&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br><br>

 <div align='center'>
                                        <u><b>MARIO R. QUILLOY</b></u><br>
                                       Security Guard
                                        </div>

 <br>&nbsp;the items/articles described above.<br><br><br>

 <div align='center'>
                                        <u><b>ALEXANDER FRANCISCO R. ORTEGA</b></u><br>
                                       Chief - Security Services Division
                                        </div>  <br><br>

</td>
<td colspan='4'>&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this 23rd day of February,<br>&nbsp;2012.<br>
&nbsp;RECEIVED from <u><b>Security Services Division</b></u><br><br><br>

 <div align='center'>
                                        <u><b>MARIO R. QUILLOY</b></u><br>
                                       Security Guard
                                        </div>

 <br>&nbsp;the items/articles described above.<br><br><br>

 <div align='center'>
                                        <u><b>ALEXANDER FRANCISCO R. ORTEGA</b></u><br>
                                       Chief - Security Services Division
                                        </div>  <br><br>

</td>
</tr>
</table>
                          </div> ";

                          break;
        }
        mysqli_close($conn);
    }


