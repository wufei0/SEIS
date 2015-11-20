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
        //START INVENTORY PER PERSONNEL REPORT---------------------------------------------
        case 'searchInventoryEquipment':
           printsearchmodal();
            break;

        case 'searchPersonnel':
            searchModal();
            break;

        case 'selectPersonnel':
            searchModal();
            break;
        //END INVENTORY PER PERSONNEL REPORT---------------------------------------------
        //START INVENTORY PER PERSONNEL REPORT---------------------------------------------
        case 'searchInventoryEquipmentOffice':
           printsearchmodal();
            break;

        case 'searchOffice':
            searchModal();
            break;

        case 'selectOffice':
            searchModal();
            break;
        //END INVENTORY PER PERSONNEL REPORT---------------------------------------------
        //START SUMMARY REPORT---------------------------------------------
        case 'searchSummaryEquipment':
            printsearchmodal();
            break;
        //END SUMMARY REPORT---------------------------------------------
              //START SCHEDULE REPORT---------------------------------------------
        case 'selectPPEAccount':
            searchmodal();
            break;

        case 'searchPPEAccount';
            searchModal();
            break;
        //START SCHEDULE REPORT---------------------------------------------
        //START SUMMARY SCHEDULE REPORT---------------------------------------------
        case 'searchEquipmentSchedule':
            printsearchmodal();
            break;
        //END SUMMARY SCHEDULE REPORT---------------------------------------------
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

                echo '<div class="panel-body bodyul" style="overflow: auto;height: 330px">
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
                        <div class="col-md-12">
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
                    <div class="panel-body bodyul" style="overflow: auto;height: 330px">
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
                                    <div class="col-md-12">
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
                                    <td colspan='3'  style='text-align: center'><a onclick='printPAR(".$row['Par_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
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
                                            <td  style='text-align: center' colspan='3'><a onclick='printPropertyReturn(".$row['PropertyReturn_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
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
                                $sql='SELECT Property_Acknowledgement_Subset.*,Property_Acknowledgement.*,M_Personnel.*, Property.*,M_Classification.*,M_Type.*
                                    FROM Property_Acknowledgement_Subset
                                    INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                                    INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                    INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
                                    INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id
                                    where Property_Acknowledgement.fkPersonnel_Id='.$_POST['personnel_id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                $num=1;
                                foreach($resultset as $row)
                                {
                                    $dateofproperty=$row['Acquisition_Date'];
                                    list($year, $month, $day) = explode('-', $dateofproperty);
                                        $datepar=date('F d, Y', strtotime($row['Acquisition_Date']));
                                        $acquiredcost=number_format($row['Acquisition_Cost'], 2);
                                          echo "
                                    <tr  align='center'>
                                        <td>".$row['Type_Name']."</td>
                                        <td>".$row['Property_Description']."</td>
                                        <td>".$datepar."</td>
                                        <td>".$row['Property_InventoryTag']."</td>
                                        <td>".$row['Property_Number']."</td>
                                        <td>1</td><td>".$acquiredcost."</td><td>1</td>
                                        <td>".$acquiredcost."</td>
                                        <td>1</td>
                                        <td>".$acquiredcost."</td>
                                        <td>".$row['Property_Remarks']."</td>
                                        </tr>
                                          ";
                                          $num++;


                                }

                    echo "</table>";
                    break;

                            case 'searchInventoryEquipmentOffice':
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
                                $sql='SELECT Property_Acknowledgement_Subset.*,Property_Acknowledgement.*, Property.*,M_Classification.*,M_Type.*
                                    FROM Property_Acknowledgement_Subset
                                    INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                    INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
                                    INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id
                                    where Property_Acknowledgement.fkDivision_Id='.$_POST['office_id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                $num=1;
                                foreach($resultset as $row)
                                {
                                    $dateofproperty=$row['Acquisition_Date'];
                                    list($year, $month, $day) = explode('-', $dateofproperty);
                                        $datepar=date('F d, Y', strtotime($row['Acquisition_Date']));
                                        $acquiredcost=number_format($row['Acquisition_Cost'], 2);
                                          echo "
                                    <tr  align='center'>
                                        <td>".$row['Type_Name']."</td>
                                        <td>".$row['Property_Description']."</td>
                                        <td>".$datepar."</td>
                                        <td>".$row['Property_InventoryTag']."</td>
                                        <td>".$row['Property_Number']."</td>
                                        <td>1</td><td>".$acquiredcost."</td><td>1</td>
                                        <td>".$acquiredcost."</td>
                                        <td>1</td>
                                        <td>".$acquiredcost."</td>
                                        <td>".$row['Property_Remarks']."</td>
                                        </tr>
                                          ";
                                          $num++;


                                }

                    echo "</table>";
                    break;

        case 'searchSummaryEquipment':
                    echo "<table class='table table-bordered table-hover'  id='search_table'>
                            <tr align='center'>
                                <td><b>ITEM NO.</b></td>
                                <td><b>ARTICLES</b></td>
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
                            $sql='SELECT Property_Acknowledgement_Subset.*, Property.*,M_Classification.*,M_Type.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
                                INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id';
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
                                    $acquiredcost=number_format($rows['Acquisition_Cost'], 2);
                                    echo "
                                    <tr  align='center'><td>".$num."</td><td>".$rows['Property_Description']."</td>
                                    <td>".$rows['Type_Name']."</td>
                                    <td>1</td>
                                    <td>".$rows['Property_EstLife']."</td>
                                    <td>".$acquiredcost."</td>
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
                    break;

                     case 'searchEquipmentSchedule':
                    echo "<table class='table table-bordered table-hover'  id='search_table'>
                            <tr align='center'>
                                <td><b>Property Number</b></td>
                                <td><b>Description</b></td>
                                <td><b>Acq. Date</b></td>
                                <td><b>Est. life</b></td>
                                <td><b>Resp. Center</b></td>
                                <td><b>Acquisition Cost</b></td>
                                <td><b>Acc. Depreciation</b></td>
                                <td><b>Net Book Values</b></td>
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
                                    $sql='
                                    SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_Id,Property.*,Property.Property_Id,M_Personnel.*,M_Division.Division_Name
                                    FROM Property_Acknowledgement
                                    INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                    INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                    INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Idwhere Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
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
          case 'searchOffice':
                    $sql='SELECT * FROM M_Division
                    where Division_Name "%'.$_POST['search_string'].'%"
                    OR Division_Description LIKE "%'.$_POST['search_string'].'%"
                    OR Chief_officer LIKE "%'.$_POST['search_string'].'%"
                    OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Division Name</th><th>Division Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedOffice(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                  <td>".$row['Division_Name']."</td>
                                  <td>".$row['Division_Description']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;

               case 'selectOffice':
                      $sql='SELECT * FROM M_Division';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Division Name</th><th>Division Description</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedOffice(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                 <td>".$row['Division_Name']."</td>
                                  <td>".$row['Division_Description']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

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

            case 'selectPPEAccount':
                      $sql='SELECT * FROM M_Type';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Type Name</th><th>Description</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPPEAccount(\"".$row['Type_Name']."\");'>
                                    <td>".$row['Type_Name']."</td>
                                    <td>".$row['Type_Description']."</td>
                                </tr>";
                            }
                            echo '</table> ';
                            break;

               case 'searchPPEAccount':
                      $sql='SELECT * FROM M_Type WHERE Type_Name LIKE "%'.$_POST['search_string'].'%" OR Type_Description LIKE "%'.$_POST['search_string'].'%"
                      ';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Type Name</th><th>Description</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPPEAccount(\"".$row['Type_Name']."\");'>
                                    <td>".$row['Type_Name']."</td>
                                    <td>".$row['Type_Description']."</td>
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

