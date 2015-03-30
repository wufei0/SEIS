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
            case 'selectBrand':
                searchModal();
                break;

            case 'selectClassification':
                 searchModal();
                break;

            case 'selectModel':
                 searchModal();
                break;

            case 'searchBrand':
                 searchModal();
                break;

            case 'searchClassification':
                 searchModal();
                break;

            case 'searchModel':
                 searchModal();
                break;

            case 'selectClassificationovermodal':
                 searchModal();
                break;

            case 'searchClassificationovermodal':
                 searchModal();
                break;

            case 'selectBrandovermodal':
                 searchModal();
                break;

            case 'searchBrandovermodal':
                 searchModal();
                break;

            case 'selectModelovermodal':
                 searchModal();
                break;

            case 'searchModelovermodal':
                 searchModal();
                break;

            case 'addSerialovermodal':
                 viewData($_POST['serial_id']);
                break;

            case 'addSerialToListovermodal':
                if((strlen($_POST['serial_value']))==0)
                {
                    echo "Cannot save blank Serial Number";
                    die();
                }
                createData();
                break;

            case 'addEquipment':
                if((strlen($_POST['equipment_number']))==0 || (strlen($_POST['equipment_description']))==0 || (strlen($_POST['equipment_acquisitiondate']))==0 || (strlen($_POST['equipment_acquisitioncost']))==0  || (strlen($_POST['equipment_model']))==0 || (strlen($_POST['equipment_brand']))=='Select Brand' || (strlen($_POST['equipment_tag']))==0 || (strlen($_POST['equipment_classification']) )=='Select Classification'|| (strlen($_POST['equipment_acquisition']) )==0 || (strlen($_POST['equipment_condition']) )==0 || ($_POST['equipment_serial'])=='')
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

            case 'updateEquipment':
                if((strlen($_POST['equipment_number']))==0 OR (strlen($_POST['equipment_desc']))==0 OR (strlen($_POST['equipment_acquisition']))==0 OR (strlen($_POST['equipment_acquisitiondate']))==0 OR (strlen($_POST['equipment_acquisitioncost']))==0 OR (strlen($_POST['equipment_tag']))==0 OR (strlen($_POST['equipment_model']))==0 OR (strlen($_POST['equipment_condition']))==0 OR (strlen($_POST['equipment_brand']))==0 OR (strlen($_POST['equipment_classification']))==0 )
                {
                    echo "Cannot Save blank Equipment";
                    die();
                }
                updateData();
                break;

            case 'paginationEquipment':
                pagination();
                break;

            case 'deleteEquipment':
                deleteData();
                break;

            case 'deleteSerial':
                deleteData();
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
                $sql="INSERT INTO Property(Property_Number,Property_Description,Acquisition_Date,Acquisition_Cost,fkModel_Id,fkBrand_Id,
                Property_InventoryTag,fkClassification_Id,Property_Acquisition,Property_Condition)
                values('".$_POST['equipment_number']."','".$_POST['equipment_description']."','".$_POST['equipment_acquisitiondate']."','".$_POST['equipment_acquisitioncost']."','".$_POST['model_id']."',
                '".$_POST['brand_id']."','".$_POST['equipment_tag']."','".$_POST['classification_id']."',
                '".$_POST['equipment_acquisition']."','".$_POST['equipment_condition']."')";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                    echo 'Equipment added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                $sql='SELECT LAST_INSERT_ID()';
                $recordsets=mysqli_query($conn,$sql);
                $rows=  mysqli_fetch_row($recordsets);
                $lastId= $rows[0];
                mysqli_free_result($recordsets);

                //adding of serial
                $serial_array = $_POST['serial_array'];
                $serial_desc_array = $_POST['serial_desc_array'];
                $num=0;
                if (is_array($serial_array)){
                    foreach ($serial_array as $value){
                        $sql="INSERT INTO Property_Serial(Serialno,Status_description,fkProperty_id) values('".$value."','".$serial_desc_array[$num]."','".$lastId."') ";
                        $resultset=mysqli_query($conn,$sql);
                        $num++;
                    }
                }
                 break;

            case 'addSerialToListovermodal':
               $sql="SELECT Serialno FROM Property_Serial WHERE Serialno='".$_POST['serial_value']."'";
               $rowset=mysqli_query($conn,$sql);
               if (mysqli_num_rows($rowset)>=1)
               {
                    echo "Duplicate Serial detected";
               }
               else{
                   $sql="INSERT INTO Property_Serial(Serialno,Status_description,fkProperty_id)
                   values('".$_POST['serial_value']."','".$_POST['serial_desc']."','".$_POST['property_number']."')";
                   $resultset=mysqli_query($conn,$sql);

                   $sql='SELECT * FROM Property_Serial WHERE fkProperty_id="'.$_POST['property_number'].'"';
                   $resultSet= mysqli_query($conn, $sql);
                   echo "<tr>
                              <td>".$_POST['serial_value']."</td>
                              <td>".$_POST['serial_desc']."</td>
                              <td onclick='deleteSerial(".$_POST['property_number'].")' style='width:10px;'><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                    echo 'ajaxseparator';
                    echo '<option disabled data-subtext="'.$_POST['serial_desc'].'" value="'.$_POST['serial_value'].'">'.$_POST['serial_value'].'</option>';
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
                $sql='SELECT Property.*, M_Brand.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Brand ON Property.fkBrand_Id=M_Brand.Brand_Id
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
                OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_InventoryTag LIKE "%'.$stringToSearch.'%"
                OR M_Classification.Classification_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Condition LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Acquisition LIKE "%'.$stringToSearch.'%"
                ORDER BY Property.Property_Number LIMIT 0,10';

                $sqlcount='SELECT Property.*, M_Brand.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Brand ON Property.fkBrand_Id=M_Brand.Brand_Id
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
                OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_InventoryTag LIKE "%'.$stringToSearch.'%"
                OR M_Classification.Classification_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Condition LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Acquisition LIKE "%'.$stringToSearch.'%"
                ORDER BY Property.Property_Number';
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
                                <td style="width:12%;"><b>Property No.</b></td>
                                <td style="width:12%;"><b>Description</b></td>
                                <td style="width:12%;"><b>Inventory Tag</b></td>
                                <td style="width:12%;"><b>Model</b></td>
                                <td style="width:12%;"><b>Brand</b></td>
                                <td style="width:12%;"><b>Classification</b></td>
                                <td style="width:12%;"><b>Condition</b></td>
                                <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';

                foreach ($resultSet as $row)
                {
                    echo "
                    <tr>
                            <td style='word-break: break-all'>".$row['Property_Number']."</td>
                            <td style='word-break: break-all'>".$row['Property_Description']."</td>
                            <td style='word-break: break-all'>".$row['Property_InventoryTag']."</td>
                            <td style='word-break: break-all'>".$row['Model_Name']."</td>
                            <td style='word-break: break-all'>".$row['Brand_Name']."</td>
                            <td style='word-break: break-all'>".$row['Classification_Name']."</td>
                            <td style='word-break: break-all'>".$row['Property_Condition']."</td>
                            <td align='right'><a href='#!'><span onclick='viewEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editEquipment(".$row['Property_Id'].",".$row['fkModel_Id'].",".$row['fkBrand_Id'].",".$row['fkClassification_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </tr>";
                }
                echo '</table>
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

            case 'searchModel':
                    $sql='SELECT * FROM M_Model where Model_Name LIKE "%'.$_POST['search_string'].'%" OR Model_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedModel(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                            <td>".$row['Model_Name']."</td>
                            <td>".$row['Model_Description']."</td>
                        </tr>";
                    }
                    echo '</table>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
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

            case 'selectModel':
                    $sql='SELECT * FROM M_Model';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                    <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedModel(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                            <td>".$row['Model_Name']."</td>
                            <td>".$row['Model_Description']."</td>
                        </tr>";
                    }
                    echo ' </table> ';
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

            case 'searchClassificationovermodal':
                    $sql='SELECT * FROM M_Classification where Classification_Name LIKE "%'.$_POST['search_string'].'%" OR Classification_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedClassificationovermodal(\"".$row['Classification_Name']."\",\"".$row['Classification_Id']."\");'>
                            <td>".$row['Classification_Name']."</td>
                            <td>".$row['Classification_Description']."</td>
                        </tr>";
                    }
                    echo '</table>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
                    break;

            case 'searchBrandovermodal':
                    $sql='SELECT * FROM M_Brand where Brand_Name LIKE "%'.$_POST['search_string'].'%" OR Brand_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedBrandovermodal(\"".$row['Brand_Name']."\",\"".$row['Brand_Id']."\");'>
                            <td>".$row['Brand_Name']."</td>
                            <td>".$row['Brand_Description']."</td>
                        </tr>";
                    }
                    echo '</table>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
                    break;

            case 'searchModelovermodal':
                    $sql='SELECT * FROM M_Model where Model_Name LIKE "%'.$_POST['search_string'].'%" OR Model_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedModelovermodal(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                            <td>".$row['Model_Name']."</td>
                            <td>".$row['Model_Description']."</td>
                        </tr>";
                    }
                    echo '</table>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
                    break;

            case 'selectClassificationovermodal':
                    $sql='SELECT * FROM M_Classification';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                    <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedClassificationovermodal(\"".$row['Classification_Name']."\",\"".$row['Classification_Id']."\");'>
                            <td>".$row['Classification_Name']."</td>
                            <td>".$row['Classification_Description']."</td>
                        </tr>";
                    }
                    echo ' </table> ';
                    break;

            case 'selectBrandovermodal':
                    $sql='SELECT * FROM M_Brand';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedBrandovermodal(\"".$row['Brand_Name']."\",\"".$row['Brand_Id']."\");'>
                            <td>".$row['Brand_Name']."</td>
                            <td>".$row['Brand_Description']."</td>
                        </tr>";
                    }
                    echo ' </table> ';
                    break;

            case 'selectModelovermodal':
                    $sql='SELECT * FROM M_Model';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                     <tr><th>Property Number</th><th>Description</th></tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr onclick='selectedModelovermodal(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                            <td>".$row['Model_Name']."</td>
                            <td>".$row['Model_Description']."</td>
                        </tr>";
                    }
                    echo ' </table> ';
                    break;
        }
        mysqli_close($conn);
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
                $sql='SELECT Property.*, M_Brand.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Brand ON Property.fkBrand_Id=M_Brand.Brand_Id
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkBrand_Id=M_Brand.Brand_Id
                WHERE Property.Property_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Property No.:</td>
                            <td class='desc-width'><input readonly='readonly type='text' class='form-control' value='".$row['Property_Number']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Property_Description']."'></td>
                        </tr>
                         <tr>
                            <td>Acquisition:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_Acquisition']."'></td>
                        </tr>
                         <tr>
                            <td>Acq. Date:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Acquisition_Date']."'></td>
                        </tr>
                         <tr>
                            <td>Acq. Cost:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Acquisition_Cost']."'></td>
                        </tr>
                        <tr>
                            <td>Serial:</td>
                            <td class='desc-width'>";
                                            $sql='SELECT * FROM Property_Serial WHERE fkProperty_id='.$row['Property_Id'].'';
                                            $resultset=  mysqli_query($conn, $sql);
                                            echo "<select readonly='readonly' class='form-control input-size selectpicker'>";
                                            echo "<option disabled selected='selected'>List of Serials</option>";
                                            foreach($resultset as $rows)
                                            {
                                                echo "<option disabled  data-subtext='".$rows['Status_description']."'>".$rows['Serialno']."</option>";
                                            }
                                            echo "</select>";
                        echo "</td>
                        </tr>
                        <tr>
                            <td>Tag:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_InventoryTag']."'></td>
                        </tr>
                         <tr>
                            <td>Model:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Model_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Condition:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_Condition']."'></td>
                        </tr>
                         <tr>
                            <td>Brand:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Brand_Name']."'></td>
                        </tr>
                         <tr>
                            <td>Classification:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Classification_Name']."'></td>
                        </tr>
                    </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'addSerialovermodal':
                    $sql='SELECT * FROM Property_Serial WHERE fkProperty_id='.$id.'';
                    $resultset=  mysqli_query($conn, $sql);
                    foreach($resultset as $rows)
                    {
                        echo "<tr>
                        <td>".$rows['Serialno']."</td>
                        <td>".$rows['Status_description']."</td>
                        <td onclick='deleteSerial(".$rows['Serial_id'].")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td></tr>";
                    }
                    break;
        }
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
                $sql='SELECT Property.*, M_Brand.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Brand ON Property.fkBrand_Id=M_Brand.Brand_Id
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkBrand_Id=M_Brand.Brand_Id
                WHERE Property.Property_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Property No.:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_number' type='text' class='form-control' value='".$row['Property_Number']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_description'  type='text' class='form-control' value='".$row['Property_Description']."'></td>
                        </tr>
                        <tr>
                            <td>Acquisition:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_acquisition'  type='text' class='form-control' value='".$row['Property_Acquisition']."'></td>
                        </tr>
                        <tr>
                            <td>Acq. Date:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_acquisitiondate'   type='date' class='form-control' value='".$row['Acquisition_Date']."'></td>
                        </tr>
                        <tr>
                            <td>Acq. Cost:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_acquisitioncost'  type='number' step='0.01' class='form-control' value='".$row['Acquisition_Cost']."'></td>
                        </tr>
                         <tr>
                            <td>Serial:</td>
                            <td class='desc-width'>
                            <div class='input-group' style='width:100%;'>";
                                            $sql='SELECT * FROM Property_Serial WHERE fkProperty_id="'.$row['Property_Id'].'"';
                                            $resultset=  mysqli_query($conn, $sql);
                                            echo '<select id="mymodal_equipment_serial" readonly="readonly" class="form-control input-size selectpicker">';
                                            foreach($resultset as $rows)
                                            {
                                                echo '<option disabled data-subtext="'.$rows['Status_description'].'" value="'.$rows['Serialno'].'">'.$rows['Serialno'].'</option>';
                                            }
                                            echo '</select>';
                            echo"
                                    <span class='input-group-btn'>
                                      <button class='btn btn-default' onclick='addSerialovermodal(".$row['Property_Id'].");' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                  </div><!-- /input-group -->
                            </td>
                        </tr>
                         <tr>
                            <td>Tag:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_tag'  type='text' class='form-control' value='".$row['Property_InventoryTag']."'></td>
                        </tr>
                        <tr>
                            <td>Model:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Model' id='equipment_modelovermodal' value='".$row['Model_Name']."'>
                                    <span class='input-group-btn'>
                                      <button class='btn btn-default' onclick='selectModelovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>  </tr>
                         <tr>
                            <td>Condition:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_condition'  type='text' class='form-control' value='".$row['Property_Condition']."'></td>
                        </tr>
                        <tr>
                            <td>Brand:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Brand' id='equipment_brandovermodal' value='".$row['Brand_Name']."'>
                                    <span class='input-group-btn'>
                                      <button class='btn btn-default' onclick='selectBrandovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>Classification:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Classification' id='equipment_classificationovermodal' value='".$row['Classification_Name']."'>
                                    <span class='input-group-btn'>
                                      <button class='btn btn-default' onclick='selectClassificationovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>";
                echo "</div>";
                echo "</div>";
                break;
        }
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
            case 'deleteEquipment':
                mysqli_autocommit($conn,FALSE);
                $sql='DELETE FROM Property_Serial WHERE fkProperty_id = '.$_POST['equipment_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                $sql='DELETE FROM Property WHERE Property_Id = '.$_POST['equipment_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                mysqli_commit($conn);

                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteSerial':
                $sql='DELETE FROM Property_Serial WHERE Serial_id = '.$_POST['serial_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                    echo 'ajaxseparator';
                    $sql='SELECT * FROM Property_Serial WHERE fkProperty_id='.$_POST['property_number'].'';
                    $resultset=  mysqli_query($conn, $sql);
                    foreach($resultset as $rows)
                    {
                        echo "<tr><td>".$rows['Serialno']."</td>
                        <td>".$rows['Status_description']."</td>
                        <td onclick='deleteSerial(".$rows['Serial_id'].")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td></tr>";
                    }
                }
                else
                {
                    echo mysqli_error($conn);
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
            case 'updateEquipment':
                $sql="SELECT Property_Number FROM Property WHERE Property_Number='".$_POST['equipment_number']."' AND Property_Id!='".$_POST['equipment_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  echo "Duplicate Equipment Name detected";
                }else{
                     $sql='UPDATE Property SET Property_Number="'.$_POST['equipment_number'].'"
                     ,Property_Description="'.$_POST['equipment_desc'].'"
                     ,Property_Acquisition="'.$_POST['equipment_acquisition'].'"
                     ,Acquisition_Date="'.$_POST['equipment_acquisitiondate'].'"
                     ,Acquisition_Cost="'.$_POST['equipment_acquisitioncost'].'"
                     ,Property_InventoryTag="'.$_POST['equipment_tag'].'"
                     ,fkModel_Id="'.$_POST['model_id'].'"
                     ,Property_Condition="'.$_POST['equipment_condition'].'"
                     ,fkBrand_Id="'.$_POST['brand_id'].'"
                     ,fkClassification_Id="'.$_POST['classification_id'].'"';
                        $sql=$sql.' WHERE Property_Id = '.$_POST['equipment_id'].' ';
                        $resultSet=  mysqli_query($conn, $sql);
                        if ($resultSet)
                        {
                            echo 'Update Successful';
                        }
                        else
                        {
                            echo mysqli_error($conn);
                        }
                }
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
            case 'paginationEquipment':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql='SELECT Property.*, M_Brand.*, M_Classification.*,M_Model.*
                    FROM Property
                    INNER JOIN M_Brand ON Property.fkBrand_Id=M_Brand.Brand_Id
                    INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                    INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                    WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                    OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                    OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                    OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
                    OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_InventoryTag LIKE "%'.$stringToSearch.'%"
                    OR M_Classification.Classification_Name LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Condition LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Acquisition LIKE "%'.$stringToSearch.'%"
                    ORDER BY Property.Property_Number LIMIT  '.$offset.','.$rowsperpage.'';
                    $result = mysqli_query($conn, $sql);
                    echo '<table class="table table-hover"  id="search_table">
                                  <tr>
                                     <td style="width:12%;"><b>Property No.</b></td>
                                     <td style="width:12%;"><b>Description</b></td>
                                     <td style="width:12%;"><b>Inventory Tag</b></td>
                                     <td style="width:12%;"><b>Model</b></td>
                                     <td style="width:12%;"><b>Brand</b></td>
                                     <td style="width:12%;"><b>Classification</b></td>
                                     <td style="width:12%;"><b>Condition</b></td>
                                     <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                                  </tr>';
                    foreach ($result as $row)
                            {
                              echo "<tr>
                                      <td style='word-break: break-all'>".$row['Property_Number']."</td>
                                      <td style='word-break: break-all'>".$row['Property_Description']."</td>
                                      <td style='word-break: break-all'>".$row['Property_InventoryTag']."</td>
                                      <td style='word-break: break-all'>".$row['Model_Name']."</td>
                                      <td style='word-break: break-all'>".$row['Brand_Name']."</td>
                                      <td style='word-break: break-all'>".$row['Classification_Name']."</td>
                                      <td style='word-break: break-all'>".$row['Property_Condition']."</td>
                                      <td align='right'><a href='#!'><span onclick='viewEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editEquipment(".$row['Property_Id'].",".$row['fkModel_Id'].",".$row['fkBrand_Id'].",".$row['fkClassification_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='deleteEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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
?>