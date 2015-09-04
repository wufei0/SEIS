<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('P', 'mm', array(279.4,215.9), true, 'UTF-8', false);

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
   $datemodulo=$datereturnday%10;
   if($datemodulo==1) {
        $datereturnday=$datereturnday."st";
   }else if($datemodulo==2){
        $datereturnday=$datereturnday."nd";
   }
   else if($datemodulo==3){
        $datereturnday=$datereturnday."rd";
   }else{
        $datereturnday=$datereturnday."th";
   }
   //=================setting the date in oridinal=================//
   $datereturnmonth=date('F', strtotime($row['PropertyReturn_Date']));
   $datereturnyear=date('Y', strtotime($row['PropertyReturn_Date']));
    $divheader='LGU Form No. 12
                      <div align="center">
                            <b>
                                <label style="font-size: x-large">PROPERTY RETURN SLIP</label>
                            </b>
                      </div>
                      Name of Local Government Unit: <u>Provincial Government of La Union</u><br>';

                      $statusdisposal="";
                      $statusrepair="";
                      $statusreturned="";
                      $statusother="";
                      if($row['PropertyReturn_Status']=='Disposal'){$statusdisposal='x';}
                      else if($row['PropertyReturn_Status']=='Repair'){$statusrepair='x';}
                      else if($row['PropertyReturn_Status']=='Returned to Stock'){$statusreturned='x';}
                      else if($row['PropertyReturn_Status']=='Other'){$statusother='x';}
       $divheader.='Purpose: (<b>'.$statusdisposal.'</b>)Disposal&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusrepair.'</b>)Repair&nbsp;&nbsp;&nbsp;&nbsp;
       (<b>'.$statusreturned.'</b>)Returned to Stock&nbsp;&nbsp;&nbsp;&nbsp;(<b>'.$statusother.'</b>)Other
    ';
$pdf->writeHTML($divheader, true, false, false, false, '');
$savename="PARREPORT_".$_GET['id'];
$pdf->Output($savename, 'I');