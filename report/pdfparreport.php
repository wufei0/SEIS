<?php
//============================================================+
// File name   : example_021.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 021 for TCPDF class
//               WriteHTML text flow
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML text flow.
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 021');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

$tbl_header = '
<table id="gallerytab" width="600" cellspacing="2" cellpadding="1" border="1px">
<tr>
        <th><font face="Arial, Helvetica, sans-serif">Products Title</font></th>
        <th><font face="Arial, Helvetica, sans-serif">Product Specs</font></th>
        <th><font face="Arial, Helvetica, sans-serif">Product Price</font></th>
      </tr>';
$tbl_footer = '</table>';
$tbl = '';
    include("../connection.php");
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
        $sql='SELECT * FROM Property_Return';
        $resultSet=  mysqli_query($conn, $sql);

while ($row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC)) {
$tbl .= '
    <tr>
        <td>'.$row["PropertyReturn_Note"].'</td>
        <td>'.$row["PropertyReturn_Date"].'</td>
        <td>'.$row["PropertyReturn_Status"].'</td>
    </tr>
';
}
// output the HTML content
$pdf->writeHTML($tbl_header . $tbl . $tbl_footer, true, false, false, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_021.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+