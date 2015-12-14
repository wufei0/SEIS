<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('P', 'mm', array(279.4,215.9), true, 'UTF-8', false); //set size of the page
// ----------------------------------------------
$pdf->SetPrintHeader(false);//remove header
$pdf->SetPrintFooter(false);//remove footer
$pdf->SetFont('Helvetica', '',10);//set fonstyle and size
$pdf->AddPage();//if page setup is set, can now create a page

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
   //Select Accountable Officer for the Signature
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
   //set the report if it is for disposal, repair, returned stock or other as to saved to database
   if($row['PropertyReturn_Status']=='Disposal'){$statusdisposal='x';}
   else if($row['PropertyReturn_Status']=='Repair'){$statusrepair='x';}
   else if($row['PropertyReturn_Status']=='Returned to Stock'){$statusreturned='x';}
   else if($row['PropertyReturn_Status']=='Other'){$statusother='x';}

   //header
   $divreturn.='Name of Local Government Unit: <u><b>Provincial Government of La Union</b></u><br>Purpose: (<b>'.$statusdisposal.'</b>)
   Disposal&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusrepair.'</b>)Repair&nbsp;&nbsp;&nbsp;&nbsp;
   (<b>'.$statusreturned.'</b>)Returned to Stock&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusother.'</b>)Other</div>
   <table border="1px" style="width: 100%;font-size: 9px;">
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr align="center" style="text-align: center;font-weight:bold;">
            <td style="width:5%"><br><br>QTY.</td>
            <td style="width:5%"><br><br>UNIT</td>
            <td style="width:20%"><br><br>DESCRIPTION</td>
            <td style="width:15%">PROPERTY NUMBER</td>
            <td style="width:10%">DATE ACQUIRED</td>
            <td style="width:25%"><br><br>NAME OF END-USER</td>
            <td style="width:10%">UNIT VALUE</td>
            <td style="width:10%">TOTAL VALUE</td>
        </tr>';

            $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.*,Property_Acknowledgement_Subset.fkProperty_Id,Property_Acknowledgement.Par_Id,M_Personnel.* ,M_Division.Division_Id
            FROM Property_Return_Subset
            INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
            INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
            INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
            INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
            INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
            WHERE Property_Return_Subset.fkPropertyReturn_Id='.$row['PropertyReturn_Id'].'';
            $resultset=  mysqli_query($conn, $sql);
            $cost=0;
            $returnsignatureposition='';
            foreach($resultset as $rows)
            {
                $unitvalue=number_format($rows['Acquisition_Cost'], 2);
                $divreturn.='<tr align="center" style="text-align: center;">
                <td style="height:12px;">1</td>
                <td>&nbsp;'.$rows['Property_Unit'].'</td>
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
                $sqlchieofficer='SELECT M_ChiefOfficer.*,M_Personnel.*,M_Division.* from M_ChiefOfficer
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_ChiefOfficer.fkPersonnel_Id
                INNER JOIN M_Division ON M_Division.Division_Id=M_ChiefOfficer.fkDivision_Id
                where M_ChiefOfficer.fkDivision_Id='.$rows['Division_Id'].'';
                $resultSet=mysqli_query($conn, $sqlchieofficer);
                $rowchiefofficer=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
            }
            $totalcost=number_format($cost,2);
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
                <td></td><td></td><td colspan="3">&nbsp;<b>Note:</b> '.$row['PropertyReturn_Note'].'</td><td></td><td align="center"><b>TOTAL</b></td><td align="center"><b>'.$totalcost.'</b></td>
            </tr>
            <tr>
                <td colspan="8" align="center"><b>CERTIFICATION</b></td>
            </tr>
            <tr>
                <td width="50%">&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this '.$datereturnday.' day of '.$datereturnmonth.',<br>&nbsp;'.$datereturnyear.'.<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br>
                  <div align="center"><u><b><font style="text-transform: uppercase;">'.$returnsignature.'</font></b></u><br>'.$returnsignatureposition.'</div>
                  <br>&nbsp;the items/articles described above.<br><br>
                  <div align="center"><u><b><font style="text-transform: uppercase;">'.$rowchiefofficer["Personnel_Fname"].' '.$rowchiefofficer["Personnel_Mname"][0].'. '.$rowchiefofficer["Personnel_Lname"].'</font></b></u><br>'.$rowchiefofficer["Division_Name"].'</div><br>
                </td>
                <td width="50%">&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this '.$datereturnday.' day of '.$datereturnmonth.',<br>&nbsp;'.$datereturnyear.'<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br>
                    <div align="center"><u><b><font style="text-transform: uppercase;">'.$accountablerows1["AccountableOfficer_Name"].'</font></b></u><br>'.$accountablerows1["AccountableOfficer_Position"].'</div>
                    <br>&nbsp;the items/articles described above.<br><br>
                    <div align="center">
                    <u><b><font style="text-transform: uppercase;">'.$accountablerows2["AccountableOfficer_Name"].'</font></b></u><br>'.$accountablerows2["Department_Name"].'</div><br>
                </td>
            </tr>
        </table>';
$pdf->writeHTML($divreturn, true, false, false, false, '');
$savename="PARREPORT_".$_GET['id'];
$pdf->Output($savename, 'I');