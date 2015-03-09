<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include("../connection.php");
    include("../security.php");

    if (!isset($_POST['module']))
    {
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
            case 'selectClassification':
                $sql='SELECT * FROM M_Classification';
                $resultSet= mysqli_query($conn, $sql);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedClassification(\"".$row['Classification_Name']."\",\"".$row['Classification_Id']."\");'>
                        <td>".$row['Classification_Name']."</td>
                        <td>".$row['Classification_Description']."</td>
                    </tr>";
                }
                echo ' </table> ';
                break;

            case 'searchClassification':
                $sql='SELECT * FROM M_Classification where Classification_Name LIKE "%'.$_POST['search_string'].'%" OR Classification_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                $resultSet= mysqli_query($conn, $sql);
                $numOfRow=mysqli_num_rows($resultSet);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                 <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedClassification(\"".$row['Classification_Name']."\",\"".$row['Classification_Id']."\");'>
                        <td>".$row['Classification_Name']."</td>
                        <td>".$row['Classification_Description']."</td>
                    </tr>";
                }
                echo '</table>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

            case 'selectBrand':
                $sql='SELECT * FROM M_Brand';
                $resultSet= mysqli_query($conn, $sql);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                 <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedBrand(\"".$row['Brand_Name']."\",\"".$row['Brand_Id']."\");'>
                        <td>".$row['Brand_Name']."</td>
                        <td>".$row['Brand_Description']."</td>
                    </tr>";
                }
                echo ' </table> ';
                break;

            case 'searchBrand':
                $sql='SELECT * FROM M_Brand where Brand_Name LIKE "%'.$_POST['search_string'].'%" OR Brand_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                $resultSet= mysqli_query($conn, $sql);
                $numOfRow=mysqli_num_rows($resultSet);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                 <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedBrand(\"".$row['Brand_Name']."\",\"".$row['Brand_Id']."\");'>
                        <td>".$row['Brand_Name']."</td>
                        <td>".$row['Brand_Description']."</td>
                    </tr>";
                }
                echo '</table>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

            case 'selectDivision':
                $sql='SELECT * FROM M_Division';
                $resultSet= mysqli_query($conn, $sql);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                 <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedDivision(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                        <td>".$row['Division_Name']."</td>
                        <td>".$row['Division_Description']."</td>
                    </tr>";
                }
                echo ' </table> ';
                break;

            case 'searchDivision':
                $sql='SELECT * FROM M_Division where Division_Name LIKE "%'.$_POST['search_string'].'%" OR Division_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                $resultSet= mysqli_query($conn, $sql);
                $numOfRow=mysqli_num_rows($resultSet);
                echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                 <tr><th>Property Number</th><th>Description</th></tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr onclick='selectedDivision(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                        <td>".$row['Division_Name']."</td>
                        <td>".$row['Division_Description']."</td>
                    </tr>";
                }
                echo '</table>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

            case 'addEquipment':
                if((strlen($_POST['equipment_number']))==0 || (strlen($_POST['equipment_description']))==0 || (strlen($_POST['equipment_acquisitiondate']))==0 || (strlen($_POST['equipment_acquisitioncost']))==0 || (strlen($_POST['equipment_serial']))==0 || (strlen($_POST['equipment_model']))==0 || (strlen($_POST['equipment_brand']))=='Select Brand' || (strlen($_POST['equipment_tag']))==0 || (strlen($_POST['equipment_classification']) )=='Select Classification' || (strlen($_POST['equipment_division']))=='Select Division' || (strlen($_POST['equipment_status']))==0)
                {
                    echo "Cannot save blank Equipment Information";
                    die();
                }
                if(verify_duplicate('equipment'))
                {
                    echo "Equipment already exist.";
                    die();
                }
                createData();
                break;

            case 'searchEquipment':
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

            case 'viewEquipment':
                viewData($_POST['equipment_id']);
                break;

            case 'editEquipment':
                viewEditData($_POST['equipment_id']);
                break;

            case 'updateDepartment':
                if((strlen($_POST['department_name']))==0)
                {
                      echo "Cannot Save blank Department";
                      die();
                }
                updateData();
                break;

    }

    function verify_duplicate($moduleName)
    {
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

    if (mysqli_connect_error())
    {
        echo "Connection Error";
        die();
    }
	$verify_duplicate=false;
    switch ($moduleName)
    {
        case 'equipment':
            $sql="SELECT Property_Number FROM Property WHERE Property_Number='".$_POST['equipment_number']."'";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
              $verify_duplicate=true;
            }

            break;

    }
    mysqli_close($conn);
    if ($verify_duplicate==true)
   {
     return true;
   }
   else
   {
     return false;
   }
}

function createData()
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
        case 'addEquipment':
            $sql="INSERT INTO Property(Property_Number,Property_Description,Acquisition_Date,Acquisition_Cost,Property_Model,fkBrand_Id,
            Property_InventoryTag,fkClassification_Id,fkDivision_Id,Status,Location)
            values('".$_POST['equipment_number']."','".$_POST['equipment_description']."','".$_POST['equipment_acquisitiondate']."','".$_POST['equipment_acquisitioncost']."','".$_POST['equipment_model']."',
            '".$_POST['brand_id']."','".$_POST['equipment_tag']."','".$_POST['classification_id']."','".$_POST['division_id']."',
            '".$_POST['equipment_status']."','".$_POST['equipment_location']."')";
            $resultset=mysqli_query($conn,$sql);

            if ($resultset)
            {
                echo 'Equipment added successfully';
            }
            else
            {
                echo mysqli_error($conn);
            }
             break;
    }
 mysqli_close($conn);
}

function searchText($stringToSearch)
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

        case 'searchEquipment':

            $sql='SELECT Property_Id,Property_Number,Property_Description,Acquisition_Date,Acquisition_Cost,Property_Model,fkBrand_Id,
            Property_InventoryTag,fkClassification_Id,fkDivision_Id,Status,Location FROM Property WHERE Property_Number
            LIKE "%'.$stringToSearch.'%" OR Property_Description LIKE "%'.$stringToSearch.'%" ORDER BY Property_Number LIMIT 0,10';

            $sqlcount='SELECT Property_Id,Property_Number,Property_Description,Acquisition_Date,Acquisition_Cost,Property_Model,fkBrand_Id,
            Property_InventoryTag,fkClassification_Id,fkDivision_Id,Status,Location FROM Property WHERE Property_Number
            LIKE "%'.$stringToSearch.'%" OR Property_Description LIKE "%'.$stringToSearch.'%" ORDER BY Property_Number';
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
                            <td class="equipNumberWidth"><b>Equipment Number</b></td>
                            <td class="equipDescWidth"><b>Equipment Description</b></td>
                            <td class="equipModelWidth"><b>Model</b></td>
                            <td class="equipStatusWidth"><b>Status</b></td>
                            <td class="equipLocationWidth"><b>Location</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                    </tr>
                    ';

            foreach ($resultSet as $row)
            {
                echo "
                <tr>
                        <td>".$row['Property_Number']."</td>
                        <td>".$row['Property_Description']."</td>
                        <td>".$row['Property_Model']."</td>
                        <td>".$row['Status']."</td>
                        <td>".$row['Location']."</td>
                        <td align='right'><a href='#!'><span onclick='viewEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td align='right'><a href='#!'><span onclick='editEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td align='right'><a href='#!'><span onclick='deleteEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                </tr>
           ";
            }
            echo ' </table>
                  </div>
                    <div class="panel-footer footer-size">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="searchStatus" class="panel-footer">

                                </div>
                            </div>
                            <div class="col-md-8">
                        <nav>
                    <ul class="rev-pagination pagination" id="change_button">';
                                                       changepagination(1,$totalpages,$stringToSearch);
                                                              echo '
                                                      </ul>
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

  function viewData($id)
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

        case 'viewEquipment':
            $sql='SELECT * FROM Property WHERE ';
            $sql=$sql.' Property_Id='.$id.' ';
            $resultSet=  mysqli_query($conn, $sql);
            $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);

             echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>Property Number:</td>
                        <td class='desc-width'><input readonly='readonly type='text' class='form-control' value='".$row['Property_Number']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Property_Description']."'></td>
                    </tr>
                     <tr>
                        <td>Acquisition Date:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Acquisition_Date']."'></td>
                    </tr>
                     <tr>
                        <td>Acquisition Cost:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Acquisition_Cost']."'></td>
                    </tr>
                     <tr>
                        <td>Model:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_Model']."'></td>
                    </tr>
                     <tr>
                        <td>Brand:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['fkBrand_Id']."'></td>
                    </tr>
                     <tr>
                        <td>Inventory Tag:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_InventoryTag']."'></td>
                    </tr>
                     <tr>
                        <td>Classification:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['fkClassification_Id']."'></td>
                    </tr>
                     <tr>
                        <td>Division:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['fkDivision_Id']."'></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Status']."'></td>
                    </tr>
                    <tr>
                        <td>Location:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Location']."'></td>
                    </tr>

                </table>";
                echo "</div>";
                echo "</div>";
                break;
    }

    //mysqli_free_result($row);
    mysqli_close($conn);
}


function viewEditData($id)
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

        case 'editEquipment':
            $sql='SELECT * FROM Property WHERE ';
            $sql=$sql.' Property_Id='.$id.' ';
            $resultSet=  mysqli_query($conn, $sql);
            $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);

            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<table>
                    <tr>
                        <td>Department:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department' type='text' class='form-control' value='".$row['Property_Number']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Property_Description']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Acquisition_Date']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Acquisition_Cost']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Property_Model']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['fkBrand_Id']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Property_InventoryTag']."'></td>
                    </tr><tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['fkClassification_Id']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['fkDivision_Id']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Status']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Location']."'></td>
                    </tr>

                </table>";
            echo "</div>";
            echo "</div>";

            break;
    }

   // mysqli_free_result($row);
    mysqli_close($conn);
}

function deleteData()
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

        case 'deleteDepartment':

            $sql='DELETE FROM Property WHERE Department_Id = '.$_POST['department_id'].' ';
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Delete Successful';
            }
            else
            {

                echo mysqli_error($conn);
//                echo '<br>';
//                echo $sql;
            }
            break;

    }

    mysqli_close($conn);
}

function updateData()
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

        case 'updateDepartment':
            $sql="SELECT Department_Name FROM M_Department WHERE Department_Name='".$_POST['department_name']."' AND Department_Id!='".$_POST['department_id']."'";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
              echo "Duplicate Department Name detected";
            }else{
                $sql='UPDATE M_Department SET Department_Name ="'.$_POST['department_name'].'", Description="'.$_POST['department_desc'].'" ';
                $sql=$sql.' WHERE Department_Id = '.$_POST['department_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);

                if ($resultSet)
                {
                    echo 'Update Successful';
                }
                else
                {

                    echo mysqli_error($conn);
//                    echo '<br>';
//                    echo $sql;
                }
            }
            break;

    }

    mysqli_close($conn);
}

?>