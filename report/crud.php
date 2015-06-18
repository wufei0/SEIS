<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("../connection.php");
    include("../security.php");
 $path = $_SERVER['HTTP_REFERER'];
    if (substr($path,-1)=='?')
    {
        $path=substr($path,0, -1);
    }
    $file=substr($path,0, -4);
    define('FileReferer',strtoupper(substr(strrchr($file, "/"), 1)));
    if (!isset($_POST['module']))
    {
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
        case 'searchPARReport':
            if (isset($_POST['searchText']))
            {
                $searchString=($_POST['searchText']);
            }
            else
            {
                $searchString='';
            }
            searchText($searchString);
            break;
        case 'paginationPARReport':
                pagination();
                break;

        case 'searchPropertyReturnReport':
            if (isset($_POST['searchText']))
            {
                $searchString=($_POST['searchText']);
            }
            else
            {
                $searchString='';
            }
            searchText($searchString);
            break;

        case 'paginationPropertyReturnReport':
            pagination();
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
                $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id
                WHERE Par_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                $sql='SELECT M_AccountableOfficer.AccountableOfficer_Name,M_Division.Division_Name,M_Department.Department_Name FROM M_AccountableOfficer
                INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                INNER JOIN M_Department ON M_Department.Department_Id=M_Division.fkDepartment_Id
                WHERE M_AccountableOfficer.AccountableOfficer_Section="PARA"';
                $resultSet=  mysqli_query($conn, $sql);
                $accountablerows=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                $datepar=date('F d, Y', strtotime($row['Par_Date']));
                     echo "
                        <div style='height:430px;overflow:auto;'>
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
                                    <td colspan='2'>&nbsp;Date: ".$datepar."</td>
                                </tr>
                                <tr>
                                    <td colspan='9'><div align='center'><br>I acknowledge to have received from <u><b><font style='text-transform: uppercase;'>".$accountablerows['AccountableOfficer_Name']."</font></b></u><br>of <u><b><font style='text-transform: uppercase;'>".$accountablerows['Department_Name']."</font></b></u>, the following property/ies which will be used in <u><b><font style='text-transform: uppercase;'>".$row['Division_Name']."</font></b></u> and for which I am accountable.</td></div>
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
                                </tr>";
                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                $cost=0;
                                foreach($resultset as $rows)
                                {
                                    $unitvalue='Php '. number_format($rows['Acquisition_Cost'], 2);
                                    echo "<tr><td></td><td></td><td>&nbsp;".$rows['Property_Description']."</b></td><td>&nbsp;".$rows['Acquisition_Date']."</td><td>&nbsp;".$rows['Property_InventoryTag']."</td><td>&nbsp;".$rows['Property_Number']."</td><td>&nbsp;".$unitvalue."</td><td></td><td>&nbsp;".$rows['Property_Remarks']."</td></tr>";
                                    $cost=$cost+$rows['Acquisition_Cost'];
                                    $sql='SELECT Property_Serial.Serialno FROM Property_Serial
                                    WHERE fkProperty_Id='.$rows['Property_Id'].'';
                                    $resultset=  mysqli_query($conn, $sql);
                                    foreach($resultset as $serialrows)
                                    {
                                        echo "<tr><td></td><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Serial No:</b> ".$serialrows['Serialno']."</td><td></td><td></td><td></td><td></td><td></td><td></td>";
                                    }
                                }
                                $totalcost='Php '. number_format($cost, 2);
                                echo "
                                <tr>
                                    <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td></td><td></td><td>&nbsp;Note: ".$row['Par_Note']."</td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                </tr>
                                <tr align='center'>
                                    <td>&nbsp;</td><td></td><td></td><td></td><td></td><td><b>TOTAL<b/></td><td></td><td><b>".$totalcost."</b></td><td></td>
                                </tr>
                                <tr>
                                    <td colspan='9'>&nbsp;Remarks: &nbsp;".$row['Par_Remarks']."</td>
                                </tr>
                                <tr>
                                    <td colspan='5'>
                                        &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                                        <div align='center'>
                                            <u><b><font style='text-transform: uppercase;'>".$row['Personnel_Fname']." ".$row['Personnel_Mname'][0].". ".$row['Personnel_Lname']."</font></b></u><br>".$row['Personnel_Position']."
                                        </div>
                                    </td>
                                    <td colspan='4'>
                                    &nbsp;NAME & SIGNATURE<br>&nbsp;POSITION<br>
                                    <div align='center'>
                                        <u><b><font style='text-transform: uppercase;'>".$accountablerows['AccountableOfficer_Name']."</font></b></u><br>".$accountablerows['Department_Name']."
                                    </div>
                                </td>
                                </tr>
                            </table>
                        </div>";
                        break;
            case 'printPropertyReturnovermodal';
                $sql='SELECT * FROM Property_Return WHERE PropertyReturn_Id='.$id.'';
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
                echo "<div style='height:430px;overflow:auto;'>LGU Form No. 12
                      <div align='center'><b><label style='font-size: x-large'>PROPERTY RETURN SLIP</label></b></div>
                      Name of Local Government Unit: <u>Provincial Government of La Union</u><br>";
                      $statusdisposal="";
                      $statusrepair="";
                      $statusreturned="";
                      $statusother="";
                      if($row['PropertyReturn_Status']=='Disposal'){$statusdisposal='x';}
                      else if($row['PropertyReturn_Status']=='Repair'){$statusrepair='x';}
                      else if($row['PropertyReturn_Status']=='Returned to Stock'){$statusreturned='x';}
                      else if($row['PropertyReturn_Status']=='Other'){$statusother='x';}
                      echo "Purpose: (<b>".$statusdisposal."</b>)Disposal&nbsp;&nbsp;&nbsp;&nbsp;(<b>".$statusrepair."</b>)Repair&nbsp;&nbsp;&nbsp;&nbsp;(<b>".$statusreturned."</b>)Returned to Stock&nbsp;&nbsp;&nbsp;&nbsp;(<b>".$statusother."</b>)Other
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
                                <td style='width:10%'>Total Value</td>
                            </tr>";
                            $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.*,Property_Acknowledgement_Subset.fkProperty_Id,Property_Acknowledgement.Par_Id,M_Personnel.*
                            FROM Property_Return_Subset
                            INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                            INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                            INNER JOIN M_Personnel on M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                            INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                            WHERE Property_Return_Subset.fkPropertyReturn_Id='.$row['PropertyReturn_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                $cost=0;
                                foreach($resultset as $rows)
                                {
                                    $unitvalue='Php '. number_format($rows['Acquisition_Cost'], 2);
                                    echo "<tr><td></td><td></td><td>&nbsp;".$rows['Property_Description']."</b></td><td>&nbsp;".$rows['Property_Number']."</td><td>&nbsp;".$rows['Acquisition_Date']."</td><td>&nbsp;".$rows['Personnel_Lname']."</td><td>&nbsp;".$unitvalue."</td><td></td></tr>";
                                    $cost=$cost+$rows['Acquisition_Cost'];
                                }
                                 $totalcost='Php '. number_format($cost,2);
                            echo "<tr>
                                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr>
                                <td></td><td></td><td>&nbsp;Note: Note Sample</td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr align='center'>
                                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td><b>TOTAL</b></td><td></td><td><b>".$totalcost."</b></td>
                            </tr>
                            <tr>
                                <td colspan='8' align='center'><b>CERTIFICATION</b></td>
                            </tr>
                            <tr>
                                <td colspan='4'>&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this ".$datereturnday." day of ".$datereturnmonth.",<br>&nbsp;".$datereturnyear.".<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br><br>
                                    <div align='center'><u><b>MARIO R. QUILLOY</b></u><br>Security Guard</div>
                                    <br>&nbsp;the items/articles described above.<br><br><br>
                                    <div align='center'><u><b>ALEXANDER FRANCISCO R. ORTEGA</b></u><br>Chief - Security Services Division</div><br><br>
                                </td>
                                <td colspan='4'>&nbsp;&nbsp;&nbsp;I HEREBY CERTIFY that I have this ".$datereturnday." day of ".$datereturnmonth.",<br>&nbsp;".$datereturnyear.".<br>&nbsp;RETURNED to the <u><b>Provincial General Services Office</b></u><br><br><br>
                                    <div align='center'><u><b><font style='text-transform: uppercase;'>".$accountablerows1['AccountableOfficer_Name']."</font></b></u><br>".$accountablerows1['AccountableOfficer_Position']."</div>
                                    <br>&nbsp;the items/articles described above.<br><br><br>
                                    <div align='center'>
                                    <u><b><font style='text-transform: uppercase;'>".$accountablerows2['AccountableOfficer_Name']."</font></b></u><br>".$accountablerows2['Department_Name']."</div><br><br>
                                </td>
                            </tr>
                    </table>
                </div> ";
                break;
        }
        mysqli_close($conn);
    }
        function searchText($stringToSearch)
    {
        if(!systemPrivilege('P_Create',$_SESSION['GROUPNAME'],FileReferer))
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
            case 'searchPARReport':
                $sql='SELECT Property_Acknowledgement.*, M_Personnel.*, M_Division.*
                FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON Property_Acknowledgement.fkPersonnel_Id=M_Personnel.Personnel_Id
                INNER JOIN M_Division ON Property_Acknowledgement.fkDivision_Id=M_Division.Division_Id
                WHERE Property_Acknowledgement.Par_Date LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Type LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Remarks LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_GSOno LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Note LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Fname LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Mname LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Lname LIKE "%'.$stringToSearch.'%"
                OR M_Division.Division_Name LIKE "%'.$stringToSearch.'%"
                ORDER BY Property_Acknowledgement.Par_Id LIMIT 0,10';
                $sqlcount='SELECT Property_Acknowledgement.*, M_Personnel.*, M_Division.*
                FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON Property_Acknowledgement.fkPersonnel_Id=M_Personnel.Personnel_Id
                INNER JOIN M_Division ON Property_Acknowledgement.fkDivision_Id=M_Division.Division_Id
                WHERE Property_Acknowledgement.Par_Date LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Type LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Remarks LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_GSOno LIKE "%'.$stringToSearch.'%"
                OR Property_Acknowledgement.Par_Note LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Fname LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Mname LIKE "%'.$stringToSearch.'%"
                OR M_Personnel.Personnel_Lname LIKE "%'.$stringToSearch.'%"
                OR M_Division.Division_Name LIKE "%'.$stringToSearch.'%"
                ORDER BY Property_Acknowledgement.Par_Id';
                $resultSet= mysqli_query($conn, $sql);
                $resultCount= mysqli_query($conn, $sqlcount);
                $numOfRow=mysqli_num_rows($resultCount);
                $rowsperpage = 10;
                $totalpages = ceil($numOfRow / $rowsperpage);
                $num=1;

                echo '
                <div class="panel-body bodyul" style="overflow: auto">
                <table class="table table-hover fixed"  id="search_table">
                        <tr>
                                  <td style="width:12%;"><b>GSO Number</b></td>
                                  <td style="width:12%;"><b>Date</b></td>
                                  <td style="width:12%;"><b>Office</b></td>
                                  <td style="width:12%;"><b>Recepient</b></td>
                                  <td style="width:12%;"><b>Type</b></td>
                                  <td style="width:12%;"><b>Note</b></td>
                                  <td style="width:12%;"><b>Remarks</b></td>
                                  <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';

                foreach ($resultSet as $row)
                {
                    echo "
                    <tr>
                            <td style='word-break: break-all'>".$row['Par_GSOno']."</td>
                            <td style='word-break: break-all'>".$row['Par_Date']."</td>
                            <td style='word-break: break-all'>".$row['Division_Name']."</td>
                            <td style='word-break: break-all'>".$row['Personnel_Fname']."</td>
                            <td style='word-break: break-all'>".$row['Par_Type']."</td>
                            <td style='word-break: break-all'>".$row['Par_Note']."</td>
                            <td style='word-break: break-all'>".$row['Par_Remarks']."</td>
                            <td colspan='3'  style='text-align: center'><a onclick='printPARovermodal(".$row['Par_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                    </tr>";
                }
                echo '</table>
                      </div>
                      <div class="panel-footer footer-size">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="searchStatus" class="panel-footer"></div>
                                </div>
                                <div class="col-md-8">
                                    <nav>
                                               <ul class="rev-pagination pagination" id="change_button">';
                                                         changepagination(1,$totalpages,$stringToSearch);
                                          echo '</ul>
                                    </nav>
                                </div>
                            </div>
                      </div>';
                      echo 'ajaxseparator';
                      echo "".$numOfRow."";
                      break;

            case 'searchPropertyReturnReport':
                    $sql='SELECT * FROM Property_Return
                    WHERE PropertyReturn_Note LIKE "%'.$stringToSearch.'%"
                    OR PropertyReturn_Date LIKE "%'.$stringToSearch.'%"
                    OR PropertyReturn_Status LIKE "%'.$stringToSearch.'%"
                    ORDER BY PropertyReturn_Id LIMIT 0,10';

                    $sqlcount='SELECT * FROM Property_Return
                    WHERE PropertyReturn_Note LIKE "%'.$stringToSearch.'%"
                    OR PropertyReturn_Date LIKE "%'.$stringToSearch.'%"
                    OR PropertyReturn_Status LIKE "%'.$stringToSearch.'%"
                    ORDER BY PropertyReturn_Id';
                    $resultSet= mysqli_query($conn, $sql);
                    $resultCount= mysqli_query($conn, $sqlcount);
                    $numOfRow=mysqli_num_rows($resultCount);
                    $rowsperpage = 10;
                    $totalpages = ceil($numOfRow / $rowsperpage);
                    $num=1;

                    echo '
                    <div class="panel-body bodyul" style="overflow: auto">
                    <table class="table table-hover fixed"  id="search_table">
                            <tr>
                                     <td style="width:30%;"><b>Property Return Note</b></td>
                                           <td style="width:30%;"><b>Property Return Date</b></td>
                                           <td style="width:30%;"><b>Property Return Status</b></td>
                                      <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                            </tr>';

                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr>
                                 <td style='word-break: break-all'>".$row['PropertyReturn_Note']."</td>
                                          <td style='word-break: break-all'>".$row['PropertyReturn_Date']."</td>
                                          <td style='word-break: break-all'>".$row['PropertyReturn_Status']."</td>
                                          <td  style='text-align: center' colspan='3'><a onclick='printPropertyReturnovermodal(".$row['PropertyReturn_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                                  </tr>";
                    }
                    echo '</table>
                          </div>
                          <div class="panel-footer footer-size">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="searchStatus" class="panel-footer"></div>
                                    </div>
                                    <div class="col-md-8">
                                        <nav>
                                                   <ul class="rev-pagination pagination" id="change_button">';
                                                             changepagination(1,$totalpages,$stringToSearch);
                                              echo '</ul>
                                        </nav>
                                    </div>
                                </div>
                          </div>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;
        }
        mysqli_close($conn);
    }

    function Pagination()
    {
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
        switch ($_POST['module'])
        {
            case 'paginationPARReport':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql='SELECT Property_Acknowledgement.*, M_Personnel.*, M_Division.*
                    FROM Property_Acknowledgement
                    INNER JOIN M_Personnel ON Property_Acknowledgement.fkPersonnel_Id=M_Personnel.Personnel_Id
                    INNER JOIN M_Division ON Property_Acknowledgement.fkDivision_Id=M_Division.Division_Id
                    WHERE Property_Acknowledgement.Par_Date LIKE "%'.$stringToSearch.'%"
                    OR Property_Acknowledgement.Par_Type LIKE "%'.$stringToSearch.'%"
                    OR Property_Acknowledgement.Par_Remarks LIKE "%'.$stringToSearch.'%"
                    OR Property_Acknowledgement.Par_GSOno LIKE "%'.$stringToSearch.'%"
                    OR Property_Acknowledgement.Par_Note LIKE "%'.$stringToSearch.'%"
                    OR M_Personnel.Personnel_Fname LIKE "%'.$stringToSearch.'%"
                    OR M_Personnel.Personnel_Mname LIKE "%'.$stringToSearch.'%"
                    OR M_Personnel.Personnel_Lname LIKE "%'.$stringToSearch.'%"
                    OR M_Division.Division_Name LIKE "%'.$stringToSearch.'%"
                    ORDER BY Property_Acknowledgement.Par_Id LIMIT  '.$offset.','.$rowsperpage.'';
                    $result = mysqli_query($conn, $sql);
                    echo '<table class="table table-hover"  id="search_table">
                                  <tr>
                            <td style="width:12%;"><b>GSO Number</b></td>
                                  <td style="width:12%;"><b>Date</b></td>
                                  <td style="width:12%;"><b>Office</b></td>
                                  <td style="width:12%;"><b>Recepient</b></td>
                                  <td style="width:12%;"><b>Type</b></td>
                                  <td style="width:12%;"><b>Note</b></td>
                                  <td style="width:12%;"><b>Remarks</b></td>
                                  <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                    </tr>';
                    foreach ($result as $row)
                            {
                              echo "<tr>
                                    <td style='word-break: break-all'>".$row['Par_GSOno']."</td>
                            <td style='word-break: break-all'>".$row['Par_Date']."</td>
                            <td style='word-break: break-all'>".$row['Division_Name']."</td>
                            <td style='word-break: break-all'>".$row['Personnel_Fname']."</td>
                            <td style='word-break: break-all'>".$row['Par_Type']."</td>
                            <td style='word-break: break-all'>".$row['Par_Note']."</td>
                            <td style='word-break: break-all'>".$row['Par_Remarks']."</td>
                            <td colspan='3'  style='text-align: center'><a onclick='printPARovermodal(".$row['Par_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                                    </tr>";
                              }
                            echo ' </table>';
                            echo 'ajaxseparator';
                            changepagination( $_POST['page_id'],$_POST['total_pages'],$_POST['search_string']);
                            echo 'ajaxseparator';
                            echo "".$startPage."";
                            echo 'ajaxseparator';
                            echo "".$endPage."";
                            break;

             case 'paginationPropertyReturnReport':
                        $rowsperpage=10;
                        $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                        $stringToSearch =$_POST['search_string'];

                        $sql='SELECT * FROM Property_Return
                        WHERE PropertyReturn_Note LIKE "%'.$stringToSearch.'%"
                        OR PropertyReturn_Date LIKE "%'.$stringToSearch.'%"
                        OR PropertyReturn_Status LIKE "%'.$stringToSearch.'%"
                        ORDER BY PropertyReturn_Id LIMIT '.$offset.','.$rowsperpage.'';

                        $result = mysqli_query($conn, $sql);
                        echo '<table class="table table-hover"  id="search_table">
                                  <tr>
                                              <td style="width:30%;"><b>Property Return Note</b></td>
                                       <td style="width:30%;"><b>Property Return Date</b></td>
                                       <td style="width:30%;"><b>Property Return Status</b></td>
                                  <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                                  </tr>';
                            foreach ($result as $row)
                            {
                                  echo "<tr>
                                      <td style='word-break: break-all'>".$row['PropertyReturn_Note']."</td>
                                      <td style='word-break: break-all'>".$row['PropertyReturn_Date']."</td>
                                      <td style='word-break: break-all'>".$row['PropertyReturn_Status']."</td>
                                      <td  style='text-align: center' colspan='3'><a onclick='printPropertyReturnovermodal(".$row['PropertyReturn_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                                  </tr>";
                             }
                            echo ' </table>';
                            echo 'ajaxseparator';
                            changepagination( $_POST['page_id'],$_POST['total_pages'],$_POST['search_string']);
                            echo 'ajaxseparator';
                            echo "".$startPage."";
                            echo 'ajaxseparator';
                            echo "".$endPage."";
                            break;
                    }
                    mysqli_close($conn);
      }

    function changepagination($currentPage,$totalpages, $stringToSearch){
                        if($totalpages>=9){
                            $startPage = $currentPage - 4;
                            $endPage = $currentPage + 4;
                            $indicate="higher";
                        }else{
                            $startPage=1;
                            $endPage=$totalpages;
                            $indicate="lower";
                        }
                        if ($startPage <= 0 && $indicate=="higher") {
                            $startPage = 1;
                            $num1=$currentPage - 4;
                            $endPage=abs($num1)+$endPage+1;
                            if($endPage>$totalpages){
                                   $endPage=$totalpages;
                            }
                        }
                        if ($endPage > $totalpages && $indicate=="higher"){
                            $num2=$totalpages-$endPage;
                            $startPage=abs(abs($num2)-$startPage);
                            $endPage = $totalpages;
                        }
                        if ($startPage > 1 && $indicate=="higher")
                        {
                            $pagePrevious=$currentPage-1;
                            echo "<li><a href='#!' onclick=paginationButton('". $pagePrevious."','".$stringToSearch."','".$totalpages."');><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
                        }
                        for($num=$startPage; $num<=$endPage; $num++){
                            echo "<li id='".$num."'><a  href='#!' onclick=paginationButton('".$num."','".$stringToSearch."','".$totalpages."');>".$num."</a></li>";
                        };
                        if ($endPage < $totalpages && $indicate=="higher"){
                            $pageNext=$currentPage+1;
                            echo "<li><a href='#!' onclick=paginationButton('".$pageNext."','".$stringToSearch."','".$totalpages."');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                        }
      	 }

