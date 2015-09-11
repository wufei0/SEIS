<?php
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF('L', 'mm', array(215.9,279.4), true, 'UTF-8', false);

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
   $monthdisplay=convertmonth($_GET['month']);
   $tbl = '';
   $tbl='<table><tr><td align="center"><b>PROVINCIAL GENERAL SERVICES OFFICE</b></td></tr>
   <tr><td align="center">Supply and Property Division</td></tr>
   <tr><td align="center">SUMMARY OF NEWLY ACQUIRED EQUIPMENT</td></tr>
   <tr><td align="center"><i>As of '.$monthdisplay.' - '.$_GET['year'].'</i></td></tr></table><br><br>';

   $tbl.='<table border="1px">
   <tr align="center">
                                <td><b>ITEM NO.</b></td>
                                <td><b>PARTICULARS</b></td>
                                <td><b>QTY</b></td>
                                <td><b>UNIT</b></td>
                                <td><b>UNIT COST</b></td>
                                <td><b>TOTAL COST</b></td>
                                <td><b>GSO NO.</b></td>
                                <td><b>DATE ACQUIRED</b></td>
                                <td><b>OFFICE</b></td>
                                <td><b>END USER</b></td>
                                <td><b>REMARKS</b></td>
                                </tr>';

$sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                            INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id';
                            $resultset=  mysqli_query($conn, $sql);
                            $num=1;
                            foreach($resultset as $rows)
                            {
                                $dateofproperty=$rows['Acquisition_Date'];
                                list($year, $month, $day) = explode('-', $dateofproperty);
                                if(($year==$_GET['year']) && ($month==$_GET['month'])){
                                    $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                    INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                    INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                    $resultSet=  mysqli_query($conn, $sql);
                                    $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                    $dateacquired=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                    $acquiredcost='Php '. number_format($rows['Acquisition_Cost'], 2);
                                    $tbl.='
                                    <tr  align="center">
                                    <td style="width:2%">'.$num.'</td>
                                    <td>'.$rows['Property_Description'].'</td>
                                    <td>1</td>
                                    <td>Equipment</td>
                                    <td>'.$acquiredcost.'</td>
                                    <td>'.$acquiredcost.'</td>
                                    <td>'.$row['Par_GSOno'].'</td>
                                    <td>'.$dateacquired.'</td>
                                    <td>'.$row['Division_Name'].'</td>
                                    <td>'.$row['Personnel_Fname'].' '.$row['Personnel_Mname'][0].'. '.$row['Personnel_Lname'].'</td>
                                    <td>'.$row['Par_Remarks'].'</td>
                                    </tr>';
                                    $num++;
                                    }
                            }
                            $monthdisplay=convertmonth($_GET['month']);
                            if($num==1){
                                   $tbl.='<tr><td colspan="12" align="center">NO RECORDS FOR THE DATE OF '.$monthdisplay.' - '.$_GET['year'].'</td></tr>';
                            }
  $tbl.='</table>';



































   $pdf->writeHTML($tbl, true, false, false, false, '');
   $savename="Filnemanes";
   $pdf->Output($savename, 'I');

 function convertmonth($month){
        if($month=='01'){
            $monthdisplay="JANUARY";
        }
        else if($month=='02'){
            $monthdisplay="FEBRUARY";
        }
        else if($month=='03'){
            $monthdisplay="MARCH";
        }
        else if($month=='04'){
            $monthdisplay="APRIL";
        }
        else if($month=='05'){
            $monthdisplay="MAY";
        }
        else if($month=='06'){
            $monthdisplay="JUNE";
        }
        else if($month=='07'){
            $monthdisplay="JULY";
        }
        else if($month=='08'){
            $monthdisplay="AUGUST";
        }
        else if($month=='09'){
            $monthdisplay="SEPTEMBER";
        }
        else if($month=='10'){
            $monthdisplay="OCTOBER";
        }
        else if($month=='11'){
            $monthdisplay="NOVEMBER";
        }
        else if($month=='12'){
            $monthdisplay="DECEMBER";
        }
        return $monthdisplay;
 }