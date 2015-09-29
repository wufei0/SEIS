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
   $tbl = '<table align="center" style="width: 100%;"><tr><td align="center"><b>INVENTORY OF EQUIPMENT</b></td></tr>
                          <tr><td align="center">(Insert: "Supplies" or "Equipment" but not both)</td></tr>
                          <tr><td align="center"><b><i>Made as of December 31, 2013</i></b></td></tr></table><br><br>';

   $tbl.='
   <table align="center" style="width: 100%;">
                          <tr align="center">
                          <td align="right">For which</td>
                          <td><u><b>DR. MARK S. TOMBOC</b></u></td>
                          <td><u><b>OIC-CHIEF HOSPITAL</b></u></td>
                          <td><u><b>BLDH</b></u></td>
                          <td rowspan="2">, <b><i>accountable having assumed such accountability on December 31, 2012</i></b></td>
                          </tr>
                          <tr align="center"><td></td><td>(Name of Accountable Officer)</td><td>(Official Desgination)</td><td>(Bureau or Office)</td><td></td></tr>

   </table><br><br>
   ';

    $tbl.='<table border="1px" style="width: 100%;">
    <tr align="center">
                                            <td rowspan="2"><b>Article</b></td>
                                            <td rowspan="2"><b>Description</b></td>
                                            <td rowspan="2"><b>Date Acquired</b></td>
                                            <td rowspan="2"><b>Inventory Tag #</b></td>
                                            <td rowspan="2"><b>Property Number</b></td>
                                            <td rowspan="2"><b>Qty Unit</b></td>
                                            <td rowspan="2"><b>Unit Value</b></td>
                                            <td colspan="2"><b>BALANCE PER STOCK CARD</b></td>
                                            <td colspan="2"><b>ON HAND PER COUNT</b></td>
                                            <td rowspan="2"><b>REMARKS</b></td></tr>
                                            <tr align="center">

                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                </tr>

    ';
$sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id';
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
                                        $acquiredcost='Php '. number_format($rows['Acquisition_Cost'], 2);
                                          $tbl.='
                                          <tr  align="center">
                                              <td>Not Working</td>
                                              <td>'.$rows['Property_Description'].'</td>
                                              <td>'.$datepar.'</td>
                                              <td>'.$rows['Property_InventoryTag'].'</td>
                                              <td>'.$rows['Property_Number'].'</td>
                                              <td>1</td><td>'.$acquiredcost.'</td><td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                          </tr>';
                                          $num++;
                                }
                              //  $monthdisplay=convertmonth($_POST['inventory_month']);
                              if($num==1){
                              //   $tbl.='<tr><td colspan="12" align="center">NO RECORDS FOR THE DATE OF '.$monthdisplay.' - '.$_POST['inventory_year'].'</td><tr>';
                 }
    $tbl.='</table>';
$pdf->writeHTML($tbl, true, false, false, false, '');
$savename="PARREPORT_";
$pdf->Output($savename, 'I');