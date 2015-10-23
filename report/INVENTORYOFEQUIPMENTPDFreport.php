<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('L', 'mm', array(215.9,330.2), true, 'UTF-8', false);

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

  $sql='SELECT M_Personnel.*, M_Division.Division_Name FROM M_Personnel
  INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
  WHERE M_Personnel.Personnel_Id='.$_GET['id'].'';
  $resultSet=  mysqli_query($conn, $sql);
  $rowPersonnel=mysqli_fetch_array($resultSet,MYSQL_ASSOC);

   $tbl = '<table align="center" style="width: 100%;"><tr><td align="center"><b>INVENTORY OF EQUIPMENT</b></td></tr>
                          <tr><td align="center">(Insert: "Supplies" or "Equipment" but not both)</td></tr>
                          <tr><td align="center"><b><i>Made as of December 31, 2013</i></b></td></tr></table><br><br>';

   $tbl.='
   <table align="center"  style="width: 100%;">
                          <tr align="center">
                          <td align="right" style="width:10%;">For which</td>
                          <td style="width:20%;"><u><b><font style="text-transform: uppercase;">'.$rowPersonnel['Personnel_Fname'].' '.$rowPersonnel['Personnel_Mname'][0].'. '.$rowPersonnel['Personnel_Lname'].'</font></b></u></td>
                          <td style="width:25%;"><u><b>'.$rowPersonnel['Personnel_Position'].'</b></u></td>
                          <td style="width:25%;"><u><b>'.$rowPersonnel['Division_Name'].'</b></u></td>
                          <td rowspan="2" style="width:20%;">, <b><i>accountable having assumed such accountability on December 31, 2012</i></b></td>
                          </tr>

                          <tr align="center"><td></td><td>(Name of Accountable Officer)</td><td>(Official Desgination)</td><td>(Bureau or Office)</td><td></td></tr>

   </table><br><br>
   ';

    $tbl.='<table border="1px" style="width: 100%;">
    <tr align="center" style="text-align: center;font-size: 9px;font-weight:bold;">
                                            <td rowspan="2" style="width:9%;"><b>Article</b></td>
                                            <td rowspan="2" style="width:9%;"><b>Description</b></td>
                                            <td rowspan="2" style="width:9%;"><b>Date Acquired</b></td>
                                            <td rowspan="2" style="width:9%;"><b>Inventory Tag #</b></td>
                                            <td rowspan="2" style="width:9%;"><b>Property Number</b></td>
                                            <td rowspan="2" style="width:5%;"><b>Qty Unit</b></td>
                                            <td rowspan="2" style="width:10%;"><b>Unit Value</b></td>
                                            <td colspan="2" style="width:15%;"><b>BALANCE PER STOCK CARD</b></td>
                                            <td colspan="2" style="width:15%;"><b>ON HAND PER COUNT</b></td>
                                            <td rowspan="2" style="width:10%;"><b>REMARKS</b></td></tr>
                                            <tr align="center">

                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                </tr>

    ';
$sql='SELECT Property_Acknowledgement_Subset.*, Property.*,M_Classification.*,M_Type.* FROM Property_Acknowledgement_Subset
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                    INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
                                    INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id';
                                $resultset=  mysqli_query($conn, $sql);
                                $num=1;
                                foreach($resultset as $rows)
                                {
                                    $dateofproperty=$rows['Acquisition_Date'];
                                    //list($year, $month, $day) = explode('-', $dateofproperty);
                            $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                        INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                        INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                        $resultSet=  mysqli_query($conn, $sql);
                                        $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                        $datepar=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                        $acquiredcost=number_format($rows['Acquisition_Cost'], 2);
                                          $tbl.='
                                          <tr  align="center" style="text-align: center;font-size: 9px;">
                                              <td>'.$rows['Type_Name'].'</td>
                                              <td>'.$rows['Property_Description'].'</td>
                                              <td>'.$datepar.'</td>
                                              <td>'.$rows['Property_InventoryTag'].'</td>
                                              <td>'.$rows['Property_Number'].'</td>
                                              <td>1</td>
                                              <td>'.$acquiredcost.'</td>
                                              <td>1</td>
                                              <td>'.$acquiredcost.'</td>
                                              <td>1</td>
                                              <td>'.$acquiredcost.'</td>
                                              <td>'.$rows['Property_Remarks'].'</td>
                                          </tr>';
                                          $num++;
                                }
                              //  $monthdisplay=convertmonth($_POST['inventory_month']);
                              if($num==1){
                              //   $tbl.='<tr><td colspan="12" align="center">NO RECORDS FOR THE DATE OF '.$monthdisplay.' - '.$_POST['inventory_year'].'</td><tr>';
                 }
    $tbl.='</table>';

           $preparer_name="";
                    $checker_name="";
                    $noter_name="";
                    $certifier_name="";
                    $attester_name="";
                    $approver_name="";

                    $preparer_position="";
                    $checker_position="";
                    $noter_position="";
                    $certifier_position="";
                    $attester_position="";
                    $approver_position="";

                        $sql='SELECT M_AccountableOfficer.*,M_Division.Division_Name,M_Department.Department_Name FROM M_AccountableOfficer
                        INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                        INNER JOIN M_Department ON M_Department.Department_Id=M_Division.fkDepartment_Id';
                        $resultSet=  mysqli_query($conn, $sql);
                       foreach($resultSet as $rows)
                       {
                         if($rows['AccountableOfficer_Section']=='IOEP'){
                           $preparer_name=$rows['AccountableOfficer_Name'];
                           $preparer_position=$rows['AccountableOfficer_Position'];
                         }
                          if($rows['AccountableOfficer_Section']=='IOECH'){
                            $checker_name=$rows['AccountableOfficer_Name'];
                           $checker_position=$rows['AccountableOfficer_Position'];

                         }
                          if($rows['AccountableOfficer_Section']=='IOEN'){
                            $noter_name=$rows['AccountableOfficer_Name'];
                           $noter_position=$rows['AccountableOfficer_Position'];

                         }
                          if($rows['AccountableOfficer_Section']=='IOECE'){
                            $certifier_name=$rows['AccountableOfficer_Name'];
                           $certifier_position=$rows['AccountableOfficer_Position'];

                         }
                          if($rows['AccountableOfficer_Section']=='IOEAT'){
                            $attester_name=$rows['AccountableOfficer_Name'];
                           $attester_position=$rows['AccountableOfficer_Position'];

                         }
                          if($rows['AccountableOfficer_Section']=='IOEAP'){
                            $approver_name=$rows['AccountableOfficer_Name'];
                           $approver_position=$rows['AccountableOfficer_Position'];

                         }
                       }


                    $tbl.='<br><br><table  style="width: 100%;">
                    <tr><td>Conducted by:</td><td>Prepared by:<br><br><b>'.$preparer_name.'</b><br>'.$preparer_position.'<br><br></td>
                    <td>Checked by: <br><br><b>'.$checker_name.'</b><br>'.$checker_position.'<br><br></td>
                    <td>Noted by: <br><br><b>'.$noter_name.'</b><br>'.$noter_position.'<br><br></td>
                    <td>Certified Correct:</td></tr>
                    <tr><td></td><td colspan="2" align ="center">Attested by:</td><td colspan="2">Approved by</td></tr>
                    </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
$savename="PARREPORT_";
$pdf->Output($savename, 'I');