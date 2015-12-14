<?php
require_once('tcpdf/tcpdf.php');  // Call class TCPDF to generate Report
$pdf = new TCPDF('L', 'mm', array(215.9,330.2), true, 'UTF-8', false);// Page Setup(setting u the size)

// ---------------------------------------------------------
$pdf->SetPrintHeader(false);// To remove header of the page
$pdf->SetPrintFooter(false);// To remove footer of the page
$pdf->SetFont('Helvetica', '',9);//Font and size to use
$pdf->AddPage();//If everything is set, Create Page

include("../connection.php");
global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
$conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
if (mysqli_connect_error())
{
    echo "Connection Error";
    die();
}
   $monthdisplay=convertmonth($_GET['month']); //call method convertmonth() to convert number date to Word date
   $tbl ='';//variable that holds the content of the table and will display after
   $tbl='<table><tr><td align="center"><b>PROVINCIAL GOVERNMENT OF LA UNION</b></td></tr>
   <tr><td align="center">Aguila Road, San Fernando City, La Union</td></tr></table><br><br>';//header of the report, initialize content to tbl

    $tbl.='<table><tr><td align="center"><b>PROPERTY, PLANT AND EQUIPMENT SCHEDULE</b></td></tr>
   <tr><td align="center"><i>As of '.$monthdisplay.' - '.$_GET['year'].'</i></td></tr></table><br><br>';//header of the report, initialize content to tbl

   $tbl.='<table><tr><td align="center"><b>PPE Account</b></td><td align="center"><b>Account Code</b></td><td align="center"><b>Book</b></td></tr>
   <tr><td align="center">Motor Vehicles</td><td align="center">241</td><td align="center">General Fund</td></tr>
   </table><br><br>'; //header of the report, initialize content to tbl

   $tbl.='<table border="1px">
   <tr align="center">
   <td style="width:4%"><b>ITEM NO.</b></td>
   <td style="width:10%"><br><br><b>ARTICLES</b></td>
   <td style="width:10%"><br><br><b>PARTICULARS</b></td>
   <td style="width:5%"><br><br><b>QTY</b></td>
   <td style="width:5%"><br><br><b>UNIT</b></td>
   <td style="width:10%"><br><br><b>UNIT COST</b></td>
   <td style="width:10%"><br><br><b>TOTAL COST</b></td>
   <td style="width:9%"><br><br><b>GSO NO.</b></td>
   <td style="width:9%"><b><br>DATE ACQUIRED</b></td>
   <td style="width:10%"><br><br><b>OFFICE</b></td>
   <td style="width:9%"><br><br><b>END USER</b></td>
   <td style="width:9%"><br><br><b>REMARKS</b></td>
   </tr>';

   $sql='SELECT Property_Acknowledgement_Subset.*, Property.*,M_Classification.*,M_Type.* FROM Property_Acknowledgement_Subset
   INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
   INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
   INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id';
   $resultset=  mysqli_query($conn, $sql);
   $num=1;
   foreach($resultset as $rows)
   {
        $dateofproperty=$rows['Acquisition_Date'];   //initialize date from the database to explode month
        list($year, $month, $day) = explode('-', $dateofproperty);   //use to explode to date and save to three variables
        if(($year==$_GET['year']) && ($month==$_GET['month'])){ //check if year and month from database is equal to user input
            //if true, then get data and initialize to variable tbl
            $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
            INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
            INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where
            Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
            $resultSet=  mysqli_query($conn, $sql);
            $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
            $dateacquired=date('F d, Y', strtotime($rows['Acquisition_Date']));
            $acquiredcost=number_format($rows['Acquisition_Cost'], 2);
            $tbl.='
            <tr  align="center">
            <td>'.$num.'</td>
            <td>'.$rows['Property_Description'].'</td>
            <td>'.$rows['Type_Name'].'</td>
            <td>1</td>
            <td>'.$rows['Property_Unit'].'</td>
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
   $monthdisplay=convertmonth($_GET['month']); // call method to convert number month to word month
   if($num==1){//this will display if there is no record found
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