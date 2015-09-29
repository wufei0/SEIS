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
        //START PAR REPORT---------------------------------------------
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
        //END PAR REPORT---------------------------------------------

        //START RETURN REPORT---------------------------------------------
        case 'printPropertyReturnovermodal':
            printData($_POST['printpropertyreturn_id']);
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
        //END RETURN REPORT---------------------------------------------

        //START INVENTORY REPORT---------------------------------------------
        case 'searchInventoryEquipment':
           printsearchmodal();
            break;

        case 'searchPersonnel':
            searchModal();
            break;

        case 'selectPersonnel':
            searchModal();
            break;
        //END INVENTORY REPORT---------------------------------------------

        //START SUMMARY REPORT---------------------------------------------
        case 'searchSummaryEquipment':
            printsearchmodal();
            break;
        //END SUMMARY REPORT---------------------------------------------

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
            case 'printPropertyReturnovermodal':
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
                                <td colspan='8'>&nbsp;</td>
                            </tr>
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
                            $returnsignatureposition='';
                            foreach($resultset as $rows)
                            {
                                    $unitvalue='Php '. number_format($rows['Acquisition_Cost'], 2);
                                    echo "<tr><td></td><td></td><td>&nbsp;".$rows['Property_Description']."</b></td><td>&nbsp;".$rows['Property_Number']."</td><td>&nbsp;".$rows['Acquisition_Date']."</td><td>&nbsp;".$rows['Personnel_Lname'].", ".$rows['Personnel_Fname']." ".$rows['Personnel_Mname']."</td><td>&nbsp;".$unitvalue."</td><td></td></tr>";
                                    $cost=$cost+$rows['Acquisition_Cost'];
                                    $returnsignature=$rows['Personnel_Fname'].' '.$rows['Personnel_Mname'][0].'. '.$rows['Personnel_Lname'];
                                    $returnsignatureposition=$rows['Personnel_Position'];
                                    $sqlchieofficer='SELECT * from M_Division where Division_Id='.$rows['fkDivision_Id'].'';
                                    $resultSet=  mysqli_query($conn, $sqlchieofficer);
                                    $rowchiefofficer=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
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
                                    <div align='center'><u><b><font style='text-transform: uppercase;'>".$returnsignature."</font></b></u><br>".$returnsignatureposition."</div>
                                    <br>&nbsp;the items/articles described above.<br><br><br>
                                    <div align='center'><u><b><font style='text-transform: uppercase;'>".$rowchiefofficer['Chief_Officer']."</font></b></u><br>".$rowchiefofficer['Division_Name']."</div><br><br>
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

                echo '<div class="panel-body bodyul" style="overflow: auto">
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
                                    <td colspan='3'  style='text-align: center'><a onclick='printPAR(".$row['Par_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                            </tr>";
                        }
                echo '</table></div>
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
                                 <td  style='text-align: center' colspan='3'><a onclick='printPropertyReturn(".$row['PropertyReturn_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
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

    function printsearchmodal()
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
             case 'searchSummaryEquipment':
                    echo "<table class='table table-bordered table-hover'  id='search_table'>
                            <tr align='center'>
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
                            </tr>";
                            $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                            INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id';
                            $resultset=  mysqli_query($conn, $sql);
                            $num=1;
                            foreach($resultset as $rows)
                            {
                                $dateofproperty=$rows['Acquisition_Date'];
                                list($year, $month, $day) = explode('-', $dateofproperty);
                                if(($year==$_POST['summary_year']) && ($month==$_POST['summary_month'])){
                                    $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                    INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                    INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                    $resultSet=  mysqli_query($conn, $sql);
                                    $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                    $dateacquired=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                    $acquiredcost='Php '. number_format($rows['Acquisition_Cost'], 2);
                                    echo "
                                    <tr  align='center'><td>".$num."</td><td>".$rows['Property_Description']."</td><td>1</td><td>Equipment</td><td>".$acquiredcost."</td>
                                        <td>".$acquiredcost."</td><td>".$row['Par_GSOno']."</td><td>".$dateacquired."</td>
                                        <td>".$row['Division_Name']."</td>
                                        <td>".$row['Personnel_Fname']." ".$row['Personnel_Mname'][0].". ".$row['Personnel_Lname']."</td>
                                        <td>".$row['Par_Remarks']."</td>
                                    </tr>";
                                    $num++;
                                    }
                            }
                            $monthdisplay=convertmonth($_POST['summary_month']);
                            if($num==1){
                                    echo "<tr><td colspan='12' align='center'>NO RECORDS FOR THE DATE OF ".$monthdisplay." - ".$_POST['summary_year']."</td><tr>";
                            }
                    echo "</table>";
                    echo 'ajaxseparator';
                    echo "
                    <table align='center' style='width: 100%;'>
                          <tr><td align='center'><b>PROVINCIAL GENERAL SERVICES OFFICE</b></td></tr>
                          <tr><td align='center'>Supply and Property Division</td></tr>
                          <tr><td align='center'>SUMMARY OF NEWLY ACQUIRED EQUIPMENT</td></tr>
                          <tr><td align='center'>PROVINCIAL GENERAL SERVICES OFFICE</td></tr>
                          <tr><td align='center'><i>As of ".$monthdisplay." - ".$_POST['summary_year']."</i></td></tr>
                    </table><br>";
                    break;

               case 'searchInventoryEquipment':
                                  echo " <table width='100%' class='table table-bordered table-hover'  id='search_table'>
                                    <tr align='center'>
                                                <td rowspan='2'><b>Article</b></td>
                                                <td rowspan='2'><b>Description</b></td>
                                                <td rowspan='2'><b>Date Acquired</b></td>
                                                <td rowspan='2'><b>Inventory Tag #</b></td>
                                                <td rowspan='2'><b>Property Number</b></td>
                                                <td rowspan='2'><b>Qty Unit</b></td>
                                                <td rowspan='2'><b>Unit Value</b></td>
                                                <td colspan='2'><b>BALANCE PER STOCK CARD</b></td>
                                                <td colspan='2'><b>ON HAND PER COUNT</b></td>
                                                <td rowspan='2'><b>REMARKS</b></td>
                                    </tr>
                                    <tr align='center'>
                                                <td><b>Qty</b></td>
                                                <td><b>Value</b></td>
                                                <td><b>Qty</b></td>
                                                <td><b>Value</b></td>
                                    </tr>";
                                $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id';
                                $resultset=  mysqli_query($conn, $sql);
                                $num=1;
                                foreach($resultset as $rows)
                                {
                                    $dateofproperty=$rows['Acquisition_Date'];
                                    list($year, $month, $day) = explode('-', $dateofproperty);
                               $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                        INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                        INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                        $resultSet=  mysqli_query($conn, $sql);
                                        $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                        $datepar=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                        $acquiredcost='Php '. number_format($rows['Acquisition_Cost'], 2);
                                          echo "
                                       <tr  align='center'>
                                              <td>Not Working</td>
                                              <td>".$rows['Property_Description']."</td>
                                              <td>".$datepar."</td>
                                              <td>".$rows['Property_InventoryTag']."</td>
                                              <td>".$rows['Property_Number']."</td>
                                              <td>1</td><td>".$acquiredcost."</td><td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                          </tr>
                                          ";
                                          $num++;


                                }

                    echo "</table>";

































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

                    echo 'ajaxseparator';
                    echo "
                    <table align='center' style='width: 100%;'>
                          <tr><td align='center'><b>INVENTORY OF EQUIPMENT</b></td></tr>
                          <tr><td align='center'>(Insert: \"Supplies\" or \"Equipment\" but not both)</td></tr>
                          <tr><td align='center'><b><i>Made as of December 31, 2013</i></b></td></tr>
                    </table><br>";
                    echo "
                    <table align='center' style='width: 100%;'>
                          <tr align='center'><td>For which</td><td><u><b>DR. MARK S. TOMBOC</b></u></td><td><u><b>OIC-CHIEF HOSPITAL</b></u></td><td><u><b>BLDH</b></u></td><td>, <b><i>accountable having assumed such accountability on December 31, 2012</i></b></td></tr>
                          <tr align='center'><td></td><td>(Name of Accountable Officer)</td><td>(Official Desgination)</td><td>(Bureau or Office)</td></tr>
                    </table><br>";
                     echo 'ajaxseparator';
                    echo "<br><table  style='width: 100%;'>
                    <tr><td>Conducted by:</td><td>Prepared by:<br><br><b>".$preparer_name."</b><br>".$preparer_position."<br><br></td>
                    <td>Checked by: <br><br><b>".$checker_name."</b><br>".$checker_position."<br><br></td>
                    <td>Noted by: <br><br><b>".$noter_name."</b><br>".$noter_position."<br><br></td>
                    <td>Certified Correct:</td></tr>
                    <tr><td></td><td colspan='2' align ='center'><br><br>Attested by:</td><td colspan='2'><br><br>Approved by</td></tr>
                    </table>";
                    break;
        }
        mysqli_close($conn);
    }

    function searchModal()
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

                //---------------Start Personnel Modal---------------
                case 'searchPersonnel':
                    $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                    INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
                    where M_Personnel.Personnel_Fname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Lname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Transdate LIKE "%'.$_POST['search_string'].'%" OR M_Division.Division_Name LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedPersonnel(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
                                  <td>".$row['Personnel_Fname']."</td>
                                  <td>".$row['Personnel_Mname']."</td>
                                  <td>".$row['Personnel_Lname']."</td>
                                  <td>".$row['Division_Name']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;

               case 'selectPersonnel':
                      $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                      INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPersonnel(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
                                    <td>".$row['Personnel_Fname']."</td>
                                    <td>".$row['Personnel_Mname']."</td>
                                    <td>".$row['Personnel_Lname']."</td>
                                    <td>".$row['Division_Name']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;
        }
        mysqli_close($conn);
    }
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

