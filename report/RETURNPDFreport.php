<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('P', 'mm', array(279.4,215.9), true, 'UTF-8', false);

// ---------------------------------------------------------
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetFont('Helvetica', '',10);
$pdf->AddPage();

include("../connection.php");
global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
$conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
if (mysqli_connect_error())
{
    echo "Connection Error";
    die();
}
   $sql='SELECT * FROM Property_Return WHERE PropertyReturn_Id='.$_GET['id'].'';
   $resultSet=  mysqli_query($conn, $sql);
   $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
   $sql='SELECT M_AccountableOfficer.*,M_Division.Division_Name,M_Department.Department_Name FROM M_AccountableOfficer
   INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
   INNER JOIN M_Department ON M_Department.Department_Id=M_Division.fkDepartment_Id
   WHERE M_AccountableOfficer.AccountableOfficer_Section="PRSR"';
   $resultSet=  mysqli_query($conn, $sql);
   $accountablerows1=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
   $sql='SELECT M_AccountableOfficer.*,M_Division.Division_Name,M_Department.Department_Name FROM M_AccountableOfficer
   INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
   INNER JOIN M_Department ON M_Department.Department_Id=M_Division.fkDepartment_Id
   WHERE M_AccountableOfficer.AccountableOfficer_Section="PRSA"';
   $resultSet=  mysqli_query($conn, $sql);
   $accountablerows2=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
   $datereturnday=date('d', strtotime($row['PropertyReturn_Date']));
   //=================setting the date in oridinal=================//
   if($datereturnday==1) {
        $datereturnday=$datereturnday."st";
   }else if($datereturnday==2){
        $datereturnday=$datereturnday."nd";
   }
   else if($datereturnday==3){
        $datereturnday=$datereturnday."rd";
   }else{
        $datereturnday=$datereturnday."th";
   }
   //=================setting the date in oridinal=================//
   $datereturnmonth=date('F', strtotime($row['PropertyReturn_Date']));
   $datereturnyear=date('Y', strtotime($row['PropertyReturn_Date']));
   $divreturn='<div>LGU Form No. 12<div align="center"><b><label style="font-size: x-large">PROPERTY RETURN SLIP</label><br></b></div>';
   $statusdisposal="";
   $statusrepair="";
   $statusreturned="";
   $statusother="";
   if($row['PropertyReturn_Status']=='Disposal'){$statusdisposal='x';}
   else if($row['PropertyReturn_Status']=='Repair'){$statusrepair='x';}
   else if($row['PropertyReturn_Status']=='Returned to Stock'){$statusreturned='x';}
   else if($row['PropertyReturn_Status']=='Other'){$statusother='x';}
   $divreturn.='Name of Local Government Unit: <u>Provincial Government of La Union</u><br>Purpose: (<b>'.$statusdisposal.'</b>)
   Disposal&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusrepair.'</b>)Repair&nbsp;&nbsp;&nbsp;&nbsp;
   (<b>'.$statusreturned.'</b>)Returned to Stock&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusother.'</b>)Other</div>
   <table border="1px" style="width: 100%;">
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr align="center">
            <td style="width:5%">QTY.</td>
            <td style="width:5%">UNIT</td>
            <td style="width:25%">DESCRIPTION</td>
            <td style="width:15%">Property Number</td>
            <td style="width:10%">Date Acquired</td>
            <td style="width:20%">Name of End-User</td>
            <td style="width:10%">Unit Value</td>
            <td style="width:10%">Total Value</td>
        </tr>';

            $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.*,Property_Acknowledgement_Subset.fkProperty_Id,Property_Acknowledgement.Par_Id,M_Personnel.*
            FROM Property_Return_Subset
            INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
            INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
            INNER JOIN M_Personnel on M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
            INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
            WHERE Property_Return_Subset.fkPropertyReturn_Id='.$row['PropertyReturn_Id'].'';
            $resultset=  mysqli_query($conn, $sql);
            $cost=0;
            $returnsignatureposition='';
            foreach($resultset as $rows)
            {
                $unitvalue='Php '. number_format($rows['Acquisition_Cost'], 2);
                $divreturn.='<tr>
                <td></td>
                <td></td>
                <td>&nbsp;'.$rows['Property_Description'].'</td>
                <td>&nbsp;'.$rows['Property_Number'].'</td>
                <td>&nbsp;'.$rows['Acquisition_Date'].'</td>
                <td>&nbsp;'.$rows['Personnel_Lname'].', '.$rows['Personnel_Fname'].' '.$rows['Personnel_Mname'].'</td>
                <td>&nbsp;'.$unitvalue.'</td>
                <td></td>
                </tr>';
                $cost=$cost+$rows['Acquisition_Cost'];
                $returnsignature=$rows['Personnel_Fname'].' '.$rows['Personnel_Mname'][0].'. '.$rows['Personnel_Lname'];
                $returnsignatureposition=$rows['Personnel_Position'];
                $sqlchieofficer='SELECT * from M_Division where Division_Id='.$rows['fkDivision_Id'].'';
                $resultSet=  mysqli_query($conn, $sqlchieofficer);
                $rowchiefofficer=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
            }
            $totalcost='Php '. number_format($cost,2);
            $divreturn.='<tr>
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
                <td></td><td></td><td>&nbsp;Note: '.$row['PropertyReturn_Note'].'</td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr align="center">
                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td><b>TOTAL</b></td><td></td><td><b>'.$totalcost.'</b></td>
            </tr>
            <tr>
                <td colspan="8" align="center"><b>CERTIFICATION</b></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this '.$datereturnday.' day of '.$datereturnmonth.',<br>&nbsp;'.$datereturnyear.'.<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br><br>
                  <div align="center"><u><b><font style="text-transform: uppercase;">'.$returnsignature.'</font></b></u><br>'.$returnsignatureposition.'</div>
                  <br>&nbsp;the items/articles described above.<br><br><br>
                  <div align="center"><u><b><font style="text-transform: uppercase;">'.$rowchiefofficer["Chief_Officer"].'</font></b></u><br>'.$rowchiefofficer["Division_Name"].'</div><br><br>
                </td>
                <td colspan="4">&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this '.$datereturnday.' day of '.$datereturnmonth.',<br>&nbsp;'.$datereturnyear.'<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br><br>
                    <div align="center"><u><b><font style="text-transform: uppercase;">'.$accountablerows1["AccountableOfficer_Name"].'</font></b></u><br>'.$accountablerows1["AccountableOfficer_Position"].'</div>
                    <br>&nbsp;the items/articles described above.<br><br><br>
                    <div align="center">
                    <u><b><font style="text-transform: uppercase;">'.$accountablerows2["AccountableOfficer_Name"].'</font></b></u><br>'.$accountablerows2["Department_Name"].'</div><br><br>
                </td>
            </tr>
        </table>';
$pdf->writeHTML($divreturn, true, false, false, false, '');
$savename="PARREPORT_".$_GET['id'];
$pdf->Output($savename, 'I');