<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('L', 'mm', array(215.9,279.4), true, 'UTF-8', false);

// ---------------------------------------------------------
$pdf->AddPage();
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetFont('Helvetica', '',10);

include("../connection.php");
global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
$conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
if (mysqli_connect_error())
{
    echo "Connection Error";
    die();
}
   $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
   INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
   INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id WHERE Par_Id='.$_GET['id'].'';
   $resultSet=  mysqli_query($conn, $sql);
   $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
   $sql='SELECT M_AccountableOfficer.AccountableOfficer_Name,M_Division.Division_Name,M_Department.Department_Name FROM M_AccountableOfficer
   INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
   INNER JOIN M_Department ON M_Department.Department_Id=M_Division.fkDepartment_Id
   WHERE M_AccountableOfficer.AccountableOfficer_Section="PARA"';
   $resultSet=  mysqli_query($conn, $sql);
   $accountablerows=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
   $datepar=date('F d, Y', strtotime($row['Par_Date']));

   $tbl_header = '<table border="1px">';
   $tbl_footer = '</table>';
   $tbl = '';
   $tbl='<tr>
           <td colspan="7">&nbsp;Revised January 1992</td>
           <td colspan="2">&nbsp;Appendix 27 <br>&nbsp;<b>GSO No.</b>: '.$row["Par_GSOno"].'</td>
         </tr>
         <tr>
           <td colspan="9" style="text-align: center">Republic of the Philippines<br><b>PROPERTY ACKNOWLEDGEMENT RECEIPT</b><br>Province of La Union</td>
         </tr>
         <tr>
           <td colspan="4">&nbsp;Office/Agency: <u><b>Provincial Government of La Union</b></u></td>
           <td colspan="3">&nbsp;Address: <u><b>Provincial Capitol, City of San Fernando</u></b></td>
           <td colspan="2">&nbsp;Date: '.$datepar.'</td>
         </tr>
         <tr>
           <td colspan="9"><div align="center"><br>I acknowledge to have received from <u><b><font style="text-transform: uppercase;">'.$accountablerows["AccountableOfficer_Name"].'</font></b></u><br>of <u><b><font style="text-transform: uppercase;">'.$accountablerows["Department_Name"].'</font></b></u>, the following property/ies which will be used in <u><b><font style="text-transform: uppercase;">'.$row["Division_Name"].'</font></b></u> and for which I am accountable.</div></td>
         </tr>
         <tr style="text-align: center">
           <td>Qty.</td>
           <td>Unit</td>
           <td>NAME AND DESCRIPTION</td>
           <td>DATE ACQUIRED</td>
           <td>INVENTORY TAG</td>
           <td>PROPERTY NUMBER</td>
           <td>UNIT VALUE</td>
           <td>TOTAL ACQUISITION COST</td>
           <td>REMARKS</td>
         </tr>';

         $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
         INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
         WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
         $resultset=  mysqli_query($conn, $sql);
         $cost=0;
         foreach($resultset as $rows)
         {
            $unitvalue='Php '. number_format($rows['Acquisition_Cost'], 2);
            $tbl .= '<tr>
            <td></td>
            <td></td>
            <td>&nbsp;'.$rows['Property_Description'].'</td>
            <td>&nbsp;'.$rows['Acquisition_Date'].'</td>
            <td>&nbsp;'.$rows['Property_InventoryTag'].'</td>
            <td>&nbsp;'.$rows['Property_Number'].'</td>
            <td>&nbsp;'.$unitvalue.'</td>
            <td></td>
            <td>&nbsp;'.$rows['Property_Remarks'].'</td>
            </tr>';
            $cost=$cost+$rows['Acquisition_Cost'];
            $sql='SELECT Property_Serial.Serialno FROM Property_Serial
            WHERE fkProperty_Id='.$rows['Property_Id'].'';
            $resultset=  mysqli_query($conn, $sql);
            foreach($resultset as $serialrows)
            {
                $tbl .= ' <tr>
                <td></td>
                <td></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Serial No:</b> '.$serialrows['Serialno'].'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>';
            }
         }
         $totalcost='Php '. number_format($cost, 2);
         $tbl .= '
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
            <td>&nbsp;Note: '.$row['Par_Note'].'</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr>
            <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         </tr>
         <tr align="center">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>TOTAL</b></td>
            <td></td>
            <td><b>'.$totalcost.'</b></td>
            <td></td>
         </tr>
         <tr>
            <td colspan="9">&nbsp;Remarks: &nbsp;'.$row['Par_Remarks'].'</td>
         </tr>
         <tr>
            <td colspan="5">
                &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                <div align="center">
                    <u><b><font style="text-transform: uppercase;">'.$row['Personnel_Fname'].' '.$row['Personnel_Mname'][0].'. '.$row['Personnel_Lname'].'</font></b></u><br>'.$row['Personnel_Position'].'<br>
                </div>
            </td>
            <td colspan="4">
                &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                <div align="center">
                    <u><b><font style="text-transform: uppercase;">'.$accountablerows['AccountableOfficer_Name'].'</font></b></u><br>'.$accountablerows['Department_Name'].'<br>
                </div>
            </td>
         </tr>';
$pdf->writeHTML($tbl_header . $tbl . $tbl_footer, true, false, false, false, '');
$savename="PARREPORT_".$_GET['id'];
$pdf->Output($savename, 'I');