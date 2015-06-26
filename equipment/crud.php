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
           //----------------------Start Classification Modal----------------------------
           case 'selectClassification':
                searchModal();
                break;

           case 'searchClassification':
                searchModal();
                break;

           case 'selectClassificationovermodal':
                searchModal();
                break;

           case 'searchClassificationovermodal':
                searchModal();
                break;
           //----------------------End Classification Modal----------------------------

           //----------------------Start Model Modal----------------------------
            case 'selectModel':
                searchModal();
                break;

            case 'searchModel':
                searchModal();
                break;

            case 'selectModelovermodal':
                searchModal();
                break;

            case 'searchModelovermodal':
                searchModal();
                break;
           //----------------------End Model Modal----------------------------

           //----------------------Start Property PAR Modal----------------------------
            case 'selectPropertyPAR':
                searchModal();
                break;

            case 'searchPropertyPAR':
                searchModal();
                break;

            case 'selectPropertyPARovermodal':
                searchModal();
                break;

            case 'selectPropertyPARovermodalovermodal':
                searchModal();
                break;

            case 'searchPropertyPARovermodalovermodal':
                searchModal();
                break;

            case 'addPropertyPARovermodalovermodal':
                if(verify_duplicate('equipmentPARovermodal'))
                {
                    echo "Equipment already exist";
                    die();
                }
                createData();
                break;
           //----------------------End Property PAR Modal----------------------------

           //----------------------Start Personnel Modal----------------------------
            case 'searchPersonnel':
                searchModal();
                break;

            case 'selectPersonnel':
                searchModal();
                break;


            case 'selectPersonnelovermodal':
                searchModal();
                break;

            case 'searchPersonnelovermodal':
                searchModal();
                break;
           //----------------------End Personnel Modal----------------------------

           //----------------------Start Division Modal----------------------------
            case 'searchDivision':
                searchModal();
                break;

            case 'selectDivision':
                searchModal();
                break;

            case 'selectDivisionovermodal':
                searchModal();
                break;

            case 'searchDivisionovermodal':
                searchModal();
                break;
           //----------------------End Division Modal----------------------------

           //----------------------Start Supplier Modal----------------------------
            case 'searchSupplier':
                searchModal();
                break;

            case 'selectSupplier':
                searchModal();
                break;

            case 'selectSupplierovermodal':
                searchModal();
                break;

            case 'searchSupplierovermodal':
                searchModal();
                break;
           //----------------------End Supplier Modal----------------------------

           //----------------------Start Serial Modal----------------------------
            case 'deleteSerial':
                deleteData();
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
           //----------------------End Serial Modal----------------------------

           //----------------------Start Equipment----------------------------
            case 'addEquipment':
                if((strlen($_POST['equipment_number']))==0 || (strlen($_POST['equipment_description']))==0 || (strlen($_POST['equipment_acquisitiondate']))==0 || (strlen($_POST['equipment_acquisitioncost']))==0  || (strlen($_POST['equipment_model']))==0 || (strlen($_POST['equipment_tag']))==0 || (strlen($_POST['equipment_classification']))==0 || (strlen($_POST['equipment_acquisition']) )==0 || (strlen($_POST['equipment_condition']) )==0 || ($_POST['equipment_serial'])=='' || (strlen($_POST['equipment_supplier']))==0 || (strlen($_POST['equipment_remarks']))==0)
                {
                    echo "Cannot Save Blank Equipment Information";
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
                if((strlen($_POST['equipment_number']))==0 || (strlen($_POST['equipment_desc']))==0 || (strlen($_POST['equipment_acquisition']))==0 || (strlen($_POST['equipment_acquisitiondate']))==0 || (strlen($_POST['equipment_acquisitioncost']))==0 || (strlen($_POST['equipment_tag']))==0 || (strlen($_POST['equipment_model']))==0 || (strlen($_POST['equipment_condition']))==0 || (strlen($_POST['equipment_classification']))==0 || (strlen($_POST['equipment_supplier']))==0 || (strlen($_POST['equipment_remarks']))==0)
                {
                    echo "Cannot Save Blank Equipment Information";
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
           //----------------------End Equipment----------------------------

           //----------------------Start Equipment PAR----------------------------

            case 'addEquipmentPAR':
                if((strlen($_POST['equipmentpar_gsonumber']))==0 || (strlen($_POST['equipmentpar_date']))==0 || (strlen($_POST['equipmentpar_division']))==0 || (strlen($_POST['equipmentpar_personnel']))==0  || (strlen($_POST['equipmentpar_type']))==0 || (strlen($_POST['equipmentpar_note']))==0 || (strlen($_POST['equipmentpar_remarks']))==0 || empty($_POST['property_array']))
                {
                    echo "Cannot Save Blank Equipment PAR Information";
                    die();
                }
                createData();
                break;

            case 'searchEquipmentPAR':
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

            case 'viewEquipmentPAR':
                viewData($_POST['equipmentpar_id']);
                break;

            case 'paginationEquipmentPAR':
                pagination();
                break;

            case 'editEquipmentPAR':
                viewEditData($_POST['equipmentpar_id']);
                break;

            case 'updateEquipmentPAR':
                if((strlen($_POST['equipmentpar_gso']))==0 || (strlen($_POST['equipmentpar_date']))==0 || (strlen($_POST['equipmentpar_division']))==0 || (strlen($_POST['equipmentpar_personnel']))==0 || (strlen($_POST['equipmentpar_type']))==0 || (strlen($_POST['equipmentpar_note']))==0 || (strlen($_POST['equipmentpar_remarks']))==0)
                {
                    echo "Cannot Save Blank Equipment Information";
                    die();
                }
                updateData();
                break;

            case 'deleteEquipmentPAR':
                deleteData();
                break;

            case 'deleteEquipmentPARovermodal':
                deleteData();
                break;
           //----------------------End Equipment PAR----------------------------

           //----------------------Start Property Return----------------------------
            case 'addPropertyReturn':
                if((strlen($_POST['propertyreturn_date']))==0 || (strlen($_POST['propertyreturn_note']))==0 || empty($_POST['propertyreturn_array']) || empty($_POST['propertyreturn_status']))
                {
                    echo "Cannot Save Blank Property Return.</br>Fill Up Needed Information";
                    die();
                }
                createData();
                break;

            case 'searchPropertyReturn':
                searchModal();
                break;

            case 'selectPropertyReturn':
                searchModal();
                break;

            case 'searchEquipmentReturn':
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

                case 'paginationPropertyReturn':
                pagination();
                break;

            case 'viewPropertyReturn':
                viewData($_POST['propertyreturn_id']);
                break;

            case 'deletePropertyReturn':
                deleteData();
                break;

              case 'editPropertyReturn':
                viewEditData($_POST['propertyreturn_id']);
                break;

            case 'selectPropertyReturnovermodal':
                searchModal();
                break;

              case 'deletePropertyReturnovermodal':
                deleteData();
                break;

             case 'selectPropertyReturnovermodalovermodal':
                searchModal();
                break;

             case 'searchPropertyReturnovermodalovermodal':
                searchModal();
                break;

             case 'selectedPropertyReturnovermodalovermodal':
                if(verify_duplicate('equipmentReturnovermodal'))
                {
                    echo "Equipment already exist";
                    die();
                }
                searchModal();
                break;

               case 'updatePropertyReturn':
                if((strlen($_POST['equipmentreturn_note']))==0 || (strlen($_POST['equipmentreturn_date']))==0 || (strlen($_POST['equipmentreturn_status']))==0 )
                {
                    echo "Cannot Save Blank Property Return Information";
                    die();
                }
                updateData();
                break;

           //----------------------End Property Return----------------------------
           //----------------------Start Repar Modal----------------------------
            case 'searchPropertyRePar':
                searchModal();
                break;

            case 'selectPropertyRePar':
                searchModal();
                break;

            case 'selectedPropertyRePar':
                searchModal();
                break;
           //----------------------End Repar Modal----------------------------
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

                case 'equipmentPARovermodal':
                    $sql="SELECT fkProperty_Id  FROM Property_Acknowledgement_Subset WHERE fkProperty_Id='".$_POST['equipment_id']."'";
                    $rowset=mysqli_query($conn,$sql);
                    if (mysqli_num_rows($rowset)>=1)
                    {
                      $verify_duplicate=true;
                    }
                    break;

                case 'equipmentReturnovermodal':
                    $sql="SELECT fkProperty_Id  FROM Property_Return_Subset WHERE fkProperty_Id='".$_POST['propertyreturn_id']."'";
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
            mysqli_close($conn);
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
                $sql="INSERT INTO Property(Property_Number,Property_Description,Acquisition_Date,Acquisition_Cost,fkModel_Id,
                Property_InventoryTag,fkClassification_Id,Property_Acquisition,Property_Condition,fkSupplier_Id,Property_Remarks)
                values('".$_POST['equipment_number']."','".$_POST['equipment_description']."','".$_POST['equipment_acquisitiondate']."',
                '".$_POST['equipment_acquisitioncost']."','".$_POST['model_id']."',
                '".$_POST['equipment_tag']."','".$_POST['classification_id']."',
                '".$_POST['equipment_acquisition']."','".$_POST['equipment_condition']."','".$_POST['supplier_id']."','".$_POST['equipment_remarks']."')";
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
                        $sql="INSERT INTO Property_Serial(Serialno,Status_description,fkProperty_id) values('".$value."',
                        '".$serial_desc_array[$num]."','".$lastId."') ";
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

            case 'addEquipmentPAR':
                $property_array = $_POST['property_array'];
                $checkifequipmentexist=0;
                $PARarray= array();
                if (is_array($property_array)){
                    foreach ($property_array as $value1){
                      $sql='SELECT Property_Acknowledgement_Subset.*, Property.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      WHERE Property_Acknowledgement_Subset.fkProperty_Id="'.$value1.'"';
                      $rowset=mysqli_query($conn,$sql);
                      if (mysqli_num_rows($rowset)>=1)
                      {
                        foreach($rowset as $row)
                        {
                           $try2=$row['Property_Number'];
                           $checkifequipmentexist++;
                           array_push($PARarray,$try2);
                        }
                      }
                    }
                }

                if($checkifequipmentexist>0){
                         echo "Property is already used in other PAR";
                         echo "<table>";
                         foreach ($PARarray as $value2){
                            echo "<tr><td>'".$value2."'</td></tr>";
                         }
                          echo "</table>";
                }else{
                         $sql="INSERT INTO Property_Acknowledgement(fkPersonnel_Id,Par_Date,Par_Type,Par_Remarks,Par_GSOno,fkDivision_Id,Par_Note)
                         values('".$_POST['personnel_id']."','".$_POST['equipmentpar_date']."','".$_POST['equipmentpar_type']."','".$_POST['equipmentpar_remarks']."',
                         '".$_POST['equipmentpar_gsonumber']."','".$_POST['division_id']."','".$_POST['equipmentpar_note']."')";
                         $resultset=mysqli_query($conn,$sql);
                         if ($resultset)
                         {
                            echo 'PAR added successfully';
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
                         $property_array = $_POST['property_array'];
                         if (is_array($property_array)){
                            foreach ($property_array as $value){
                                $sql="INSERT INTO Property_Acknowledgement_Subset(fkPar_Id,fkProperty_id) values('".$lastId."','".$value."') ";
                                $resultset=mysqli_query($conn,$sql);
                            }
                         }
                }
                break;

            case 'addPropertyPARovermodalovermodal':
                $sql="INSERT INTO Property_Acknowledgement_Subset(fkPar_Id,fkProperty_Id)
                values('".$_POST['equipmentpar_id']."','".$_POST['equipment_id']."')";
                $resultset=mysqli_query($conn,$sql);

                $sql='SELECT LAST_INSERT_ID()';
                $recordsets=mysqli_query($conn,$sql);
                $rows=  mysqli_fetch_row($recordsets);
                $lastId= $rows[0];
                mysqli_free_result($recordsets);

                      $sql='SELECT Property_Acknowledgement_Subset.*, Property.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      WHERE Property_Acknowledgement_Subset.parproperty_Id="'.$lastId.'"';
                      $resultSet= mysqli_query($conn, $sql);
                       foreach ($resultSet as $row)
                          {
                          echo "
                          <tr>
                              <td>".$row['Property_Number']."</td>
                              <td>".$row['Property_Description']."</td>
                              <td onclick='deletePropertyPAR(\"".$row['parproperty_Id']."\",\"".$row['fkPar_Id']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                          }

                echo "ajaxseparator";

                     $sql='SELECT Property_Acknowledgement_Subset.*, Property.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      WHERE Property_Acknowledgement_Subset.fkPar_Id="'.$_POST['equipmentpar_id'].'"';
                      $resultSet= mysqli_query($conn, $sql);

                    echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertypar'>";
                                    foreach($resultSet as $row)
                                    {
                                        echo "<option disabled  data-subtext='".$row['Property_Description']."'>".$row['Property_Number']."</option>";
                                    }
                                    echo "</select>";

                          break;

            case 'addPropertyReturn':
                $propertyreturn_array = $_POST['propertyreturn_array'];
                $checkifequipmentexist=0;
                $ReturnPARarray= array();
                if (is_array($propertyreturn_array)){
                    foreach ($propertyreturn_array as $value1){
                      $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.Property_Number,Property_Acknowledgement_Subset.fkProperty_Id
                      FROM Property_Return_Subset
                      INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                      INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                      WHERE Property_Return_Subset.fkProperty_Id='.$value1.'';
                      $rowset=mysqli_query($conn,$sql);
                      if (mysqli_num_rows($rowset)>=1)
                      {
                        foreach($rowset as $row)
                        {
                           $try2=$row['Property_Number'];
                           $checkifequipmentexist++;
                           array_push($ReturnPARarray,$try2);
                        }
                      }
                    }
                }

                if($checkifequipmentexist>0){
                         echo "Property is already used in other Return";
                         echo "<table>";
                         foreach ($ReturnPARarray as $value2){
                            echo "<tr><td>'".$value2."'</td></tr>";
                         }
                          echo "</table>";
                }else{
                         $sql="INSERT INTO Property_Return(PropertyReturn_Note,PropertyReturn_Date,PropertyReturn_Status)
                         values('".$_POST['propertyreturn_note']."','".$_POST['propertyreturn_date']."','".$_POST['propertyreturn_status']."')";
                         $resultset=mysqli_query($conn,$sql);
                         if ($resultset)
                         {
                            echo 'Property Return added successfully';
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
                         $propertyreturn_array = $_POST['propertyreturn_array'];
                         if (is_array($propertyreturn_array)){
                            foreach ($propertyreturn_array as $value){
                                $sql="INSERT INTO Property_Return_Subset(fkPropertyReturn_Id,fkProperty_id) values('".$lastId."','".$value."') ";
                                $resultset=mysqli_query($conn,$sql);
                            }
                         }
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
                $sql='SELECT Property.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
                WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Remarks LIKE "%'.$stringToSearch.'%"
                OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
                OR M_Supplier.Supplier_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_InventoryTag LIKE "%'.$stringToSearch.'%"
                OR M_Classification.Classification_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Condition LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Acquisition LIKE "%'.$stringToSearch.'%"
                ORDER BY Property.Property_Number LIMIT 0,10';

                $sqlcount='SELECT Property.*, M_Classification.*,M_Model.*
                FROM Property
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
                WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                OR M_Supplier.Supplier_Name LIKE "%'.$stringToSearch.'%"
                OR Property.Property_Remarks LIKE "%'.$stringToSearch.'%"
                OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
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
                                <td style="width:10%;"><b>Property No.</b></td>
                                <td style="width:10%;"><b>Description</b></td>
                                <td style="width:10%;"><b>Inventory Tag</b></td>
                                <td style="width:10%;"><b>Model</b></td>
                                <td style="width:10%;"><b>Classification</b></td>
                                <td style="width:10%;"><b>Condition</b></td>
                                <td style="width:10%;"><b>Remarks</b></td>
                                <td style="width:10%;" colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';

                foreach ($resultSet as $row)
                {
                    echo "
                    <tr>
                            <td style='word-break: break-all'>".$row['Property_Number']."</td>
                            <td style='word-break: break-all'>".$row['Property_Description']."</td>
                            <td style='word-break: break-all'>".$row['Property_InventoryTag']."</td>
                            <td style='word-break: break-all'>".$row['Model_Name']."</td>
                            <td style='word-break: break-all'>".$row['Classification_Name']."</td>
                            <td style='word-break: break-all'>".$row['Property_Condition']."</td>
                            <td style='word-break: break-all'>".$row['Property_Remarks']."</td>
                            <td align='right'><a href='#!'><span onclick='viewEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editEquipment(".$row['Property_Id'].",".$row['fkModel_Id'].",".$row['fkClassification_Id'].",".$row['fkSupplier_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteEquipment(".$row['Property_Id'].",\"$stringToSearch\")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

            case 'searchEquipmentPAR':
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
                            <td align='right'><a href='#!'><span onclick='viewEquipmentPAR(".$row['Par_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editEquipmentPAR(".$row['Par_Id'].",".$row['Personnel_Id'].",".$row['Division_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteEquipmentPAR(".$row['Par_Id'].",\"$stringToSearch\")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

            case 'searchEquipmentReturn':
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
                                      <td align='right'><a href='#!'><span onclick='viewPropertyReturn(".$row['PropertyReturn_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editPropertyReturn(".$row['PropertyReturn_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='deletePropertyReturn(".$row['PropertyReturn_Id'].",\"$stringToSearch\")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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
                //---------------Start Classification Modal---------------
                case 'searchClassification':
                    $sql='SELECT M_Classification.*,M_Type.* FROM M_Classification
                    INNER JOIN M_Type ON M_Classification.fkType_Id=M_Type.Type_Id WHERE
                    M_Classification.Classification_Name LIKE "%'.$_POST['search_string'].'%" OR
                    M_Classification.Classification_Description LIKE "%'.$_POST['search_string'].'%" OR
                    M_Classification.Transdate LIKE "%'.$_POST['search_string'].'%" OR
                    M_Type.Type_Name LIKE "%'.$_POST['search_string'].'%"';
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

                case 'selectClassification':
                    $sql='SELECT M_Classification.*,M_Type.* FROM M_Classification
                    INNER JOIN M_Type ON M_Classification.fkType_Id=M_Type.Type_Id';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Type</th><th>Classification</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedClassification(\"".$row['Classification_Name']."\",\"".$row['Classification_Id']."\");'>
                                  <td>".$row['Type_Name']."</td><b></b>
                                  <td>".$row['Classification_Name']."</td>
                                  <td>".$row['Classification_Description']."</td>
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
                          echo '</table> ';
                          break;
                //---------------End Classification Modal---------------

                //---------------Start Model Modal---------------
                case 'searchModel':
                    $sql='SELECT M_Model.*,M_Brand.* FROM M_Model
                    INNER JOIN M_Brand ON M_Model.fkBrand_Id=M_Brand.Brand_Id WHERE
                    M_Model.Model_Name LIKE "%'.$_POST['search_string'].'%" OR
                    M_Model.Model_Description LIKE "%'.$_POST['search_string'].'%" OR
                    M_Model.Transdate LIKE "%'.$_POST['search_string'].'%" OR
                    M_Brand.Brand_Name LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Brand</th><th>Mode</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedModel(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                                  <td>".$row['Brand_Name']."</td>
                                  <td>".$row['Model_Name']."</td>
                                  <td>".$row['Model_Description']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;

                case 'selectModel':
                    $sql='SELECT M_Model.*,M_Brand.* FROM M_Model
                    INNER JOIN M_Brand ON M_Model.fkBrand_Id=M_Brand.Brand_Id';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Brand</th><th>Model</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedModel(\"".$row['Model_Name']."\",\"".$row['Model_Id']."\");'>
                                  <td>".$row['Brand_Name']."</td>
                                  <td>".$row['Model_Name']."</td>
                                  <td>".$row['Model_Description']."</td>
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
                          echo '</table> ';
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
                //---------------End Model Modal---------------

                //---------------Start Supplier Modal---------------
                case 'searchSupplier':
                    $sql='SELECT * FROM M_Supplier WHERE
                    Supplier_Name LIKE "%'.$_POST['search_string'].'%" OR
                    Supplier_Description LIKE "%'.$_POST['search_string'].'%" OR
                    Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Supplier</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedSupplier(\"".$row['Supplier_Name']."\",\"".$row['Supplier_Id']."\");'>
                                  <td>".$row['Supplier_Name']."</td>
                                  <td>".$row['Supplier_Description']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;

                case 'selectSupplier':
                    $sql='SELECT * FROM M_Supplier';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Supplier</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedSupplier(\"".$row['Supplier_Name']."\",\"".$row['Supplier_Id']."\");'>
                                  <td>".$row['Supplier_Name']."</td>
                                  <td>".$row['Supplier_Description']."</td>
                              </tr>";
                          }
                          echo '</table> ';
                          break;

                case 'selectSupplierovermodal':
                    $sql='SELECT * FROM M_Supplier';
                    $resultSet= mysqli_query($conn, $sql);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Supplier</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedSupplierovermodal(\"".$row['Supplier_Name']."\",\"".$row['Supplier_Id']."\");'>
                                 <td>".$row['Supplier_Name']."</td>
                                 <td>".$row['Supplier_Description']."</td>
                              </tr>";
                          }
                          echo '</table> ';
                          break;

                case 'searchSupplierovermodal':
                        $sql='SELECT * FROM M_Supplier WHERE
                        Supplier_Name LIKE "%'.$_POST['search_string'].'%" OR
                        Supplier_Description LIKE "%'.$_POST['search_string'].'%" OR
                        Transdate LIKE "%'.$_POST['search_string'].'%"';
                        $resultSet= mysqli_query($conn, $sql);
                        $numOfRow=mysqli_num_rows($resultSet);
                        echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                              <tr><th>Supplier</th><th>Description</th></tr>';
                              foreach ($resultSet as $row)
                              {
                                  echo "
                                  <tr onclick='selectedSupplierovermodal(\"".$row['Supplier_Name']."\",\"".$row['Supplier_Id']."\");'>
                                      <td>".$row['Supplier_Name']."</td>
                                      <td>".$row['Supplier_Description']."</td>
                                  </tr>";
                              }
                              echo '</table>';
                              echo 'ajaxseparator';
                              echo "".$numOfRow."";
                              break;
                //---------------End Supplier Modal---------------

                //---------------Start Property PAR Modal---------------
                case 'searchPropertyPAR':
                    $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                    FROM Property
                    INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                    INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                    INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
                    WHERE Property.Property_Number LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Description LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Acquisition_Date LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Acquisition_Cost LIKE "%'.$_POST['search_string'].'%"
                    OR M_Model.Model_Name LIKE "%'.$_POST['search_string'].'%"
                    OR M_Supplier.Supplier_Name LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_InventoryTag LIKE "%'.$_POST['search_string'].'%"
                    OR M_Classification.Classification_Name LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Condition LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Acquisition LIKE "%'.$_POST['search_string'].'%"
                    ORDER BY Property.Property_Number ASC';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Property Number</th><th>Property Tag</th><th>Description</th><th>Model</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedProperty(\"".$row['Property_Id']."\",\"".$row['Property_Number']."\",\"".$row['Property_Description']."\",\"".$row['Acquisition_Date']."\",\"".$row['Acquisition_Cost']."\",\"".$row['Model_Name']."\",\"".$row['fkBrand_Id']."\",\"".$row['Property_InventoryTag']."\",\"".$row['Classification_Name']."\",\"".$row['Status']."\",\"".$row['Location']."\",\"".$row['Property_Condition']."\",\"".$row['Property_Acquisition']."\");'>
                                  <td>".$row['Property_Number']."</td>
                                  <td>".$row['Property_InventoryTag']."</td>
                                  <td>".$row['Property_Description']."</td>
                                  <td>".$row['Model_Name']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;

              case 'selectPropertyPAR':
                      $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                      FROM Property
                      INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                      INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                      INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                      <tr><th>Property Number</th><th>Property Tag</th><th>Description</th><th>Model</th></tr>';
                      foreach ($resultSet as $row)
                      {
                          echo "
                          <tr onclick='selectedProperty(\"".$row['Property_Id']."\",\"".$row['Property_Number']."\",\"".$row['Property_Description']."\",\"".$row['Acquisition_Date']."\",\"".$row['Acquisition_Cost']."\",\"".$row['Model_Name']."\",\"".$row['fkBrand_Id']."\",\"".$row['Property_InventoryTag']."\",\"".$row['Classification_Name']."\",\"".$row['Status']."\",\"".$row['Location']."\",\"".$row['Property_Condition']."\",\"".$row['Property_Acquisition']."\");'>
                              <td>".$row['Property_Number']."</td>
                              <td>".$row['Property_InventoryTag']."</td>
                              <td>".$row['Property_Description']."</td>
                              <td>".$row['Model_Name']."</td>
                          </tr>";
                      }
                      echo '</table>';
                      break;

              case 'selectPropertyPARovermodal':
                      $sql='SELECT Property_Acknowledgement_Subset.*, Property.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      WHERE Property_Acknowledgement_Subset.fkPar_Id="'.$_POST['par_id'].'"
                      ';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose" id="table_propertypar">
                      <tr><th>Property Number</th><th>Description</th><th></th></tr>';
                      foreach ($resultSet as $row)
                      {
                          echo "
                          <tr>
                              <td>".$row['Property_Number']."</td>
                              <td>".$row['Property_Description']."</td>
                              <td onclick='deletePropertyPAR(\"".$row['parproperty_Id']."\",\"".$row['fkPar_Id']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                      }
                      echo '</table> ';
                      break;

              case 'selectPropertyPARovermodalovermodal':
                      $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                      FROM Property
                      INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                      INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                      INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Property Number</th><th>Description</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyPARovermodalovermodal(\"".$row['Property_Id']."\");'>
                                    <td>".$row['Property_Number']."</td>
                                    <td>".$row['Property_Description']."</td>
                                </tr>";
                            }
                            echo '</table>';
                            break;

              case 'searchPropertyPARovermodalovermodal':
                    $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                    FROM Property
                    INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                    INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                    INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
                    WHERE Property.Property_Number LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Description LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Acquisition_Date LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Acquisition_Cost LIKE "%'.$_POST['search_string'].'%"
                    OR M_Model.Model_Name LIKE "%'.$_POST['search_string'].'%"
                    OR M_Supplier.Supplier_Name LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_InventoryTag LIKE "%'.$_POST['search_string'].'%"
                    OR M_Classification.Classification_Name LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Condition LIKE "%'.$_POST['search_string'].'%"
                    OR Property.Property_Acquisition LIKE "%'.$_POST['search_string'].'%"
                    ORDER BY Property.Property_Number ASC';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Property Number</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedPropertyPARovermodalovermodal(\"".$row['Property_Id']."\");'>
                                  <td>".$row['Property_Number']."</td>
                                  <td>".$row['Property_Description']."</td>
                              </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;
                //---------------End Property PAR Modal---------------

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

               case 'selectPersonnelovermodal':
                      $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                      INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPersonnelovermodal(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
                                    <td>".$row['Personnel_Fname']."</td>
                                    <td>".$row['Personnel_Mname']."</td>
                                    <td>".$row['Personnel_Lname']."</td>
                                    <td>".$row['Division_Name']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

               case 'searchPersonnelovermodal':
                      $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                      INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
                      WHERE M_Personnel.Personnel_Fname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Lname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%" OR M_Personnel.Transdate LIKE "%'.$_POST['search_string'].'%" OR M_Division.Division_Name LIKE "%'.$_POST['search_string'].'%"';
                      $resultSet= mysqli_query($conn, $sql);
                      $numOfRow=mysqli_num_rows($resultSet);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPersonnelovermodal(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
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
                  //---------------End Personnel Modal---------------

                  //---------------Start Division Modal---------------

                  case 'searchDivision':
                      $sql='SELECT * FROM M_Division where Division_Name LIKE "%'.$_POST['search_string'].'%" OR Division_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                      $resultSet= mysqli_query($conn, $sql);
                      $numOfRow=mysqli_num_rows($resultSet);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Division Name</th><th>Division_Description</th><th>Transdate</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedDivision(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                  <td>".$row['Division_Name']."</td>
                                  <td>".$row['Division_Description']."</td>
                                  <td>".$row['Transdate']."</td>
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
                            <tr><th>Division Name</th><th>Division_Description</th><th>Transdate</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedDivision(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                    <td>".$row['Division_Name']."</td>
                                    <td>".$row['Division_Description']."</td>
                                    <td>".$row['Transdate']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

                  case 'searchDivisionovermodal':
                        $sql='SELECT * FROM M_Division where Division_Name LIKE "%'.$_POST['search_string'].'%" OR Division_Description LIKE "%'.$_POST['search_string'].'%" OR Transdate LIKE "%'.$_POST['search_string'].'%"';
                        $resultSet= mysqli_query($conn, $sql);
                        $numOfRow=mysqli_num_rows($resultSet);
                        echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                              <tr><th>Division Name</th><th>Division_Description</th><th>Transdate</th></tr>';
                              foreach ($resultSet as $row)
                              {
                                  echo "
                                  <tr onclick='selectedDivisionovermodal(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                    <td>".$row['Division_Name']."</td>
                                    <td>".$row['Division_Description']."</td>
                                    <td>".$row['Transdate']."</td>
                                  </tr>";
                              }
                              echo '</table>';
                              echo 'ajaxseparator';
                              echo "".$numOfRow."";
                              break;

                   case 'selectDivisionovermodal':
                          $sql='SELECT * FROM M_Division';
                          $resultSet= mysqli_query($conn, $sql);
                          echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                                <tr><th>Division Name</th><th>Division_Description</th><th>Transdate</th></tr>';
                                foreach ($resultSet as $row)
                                {
                                    echo "
                                    <tr onclick='selectedDivisionovermodal(\"".$row['Division_Name']."\",\"".$row['Division_Id']."\");'>
                                        <td>".$row['Division_Name']."</td>
                                        <td>".$row['Division_Description']."</td>
                                        <td>".$row['Transdate']."</td>
                                    </tr>";
                                }
                                echo ' </table> ';
                                break;
                  //---------------End Division Modal---------------

                  //---------------Start Property Return Modal---------------

                   case 'searchPropertyReturn':
                      $sql='SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_Id,Property.Property_Number,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                      where Property.Property_Number LIKE "%'.$_POST['search_string'].'%" ';

                      $resultSet= mysqli_query($conn, $sql);
                      $numOfRow=mysqli_num_rows($resultSet);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Property Number</th><th>Name of End User</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyReturn(\"".$row['parproperty_Id']."\",\"".$row['Property_Number']."\");'>
                                   <td>".$row['Property_Number']."</td>
                                   <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Fname']."</td>
                                </tr>";
                            }
                            echo '</table>';
                            echo 'ajaxseparator';
                            echo "".$numOfRow."";
                            break;

                  case 'selectPropertyReturn':
                      $sql='SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_Id,Property.Property_Number,Property.Property_Id,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Property Number</th><th>Name of End User</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyReturn(\"".$row['parproperty_Id']."\",\"".$row['Property_Number']."\",\"".$row['Par_GSOno']."\",\"".$row['Par_Date']."\",\"".$row['fkDivision_Id']."\",\"".$row['Personnel_Fname']."\",\"".$row['Par_Type']."\",\"".$row['Par_Note']."\",\"".$row['Par_Remarks']."\");'>
                                    <td>".$row['Property_Number']."</td>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Fname']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;


              case 'selectPropertyReturnovermodal':

                      $sql='Select Property_Return_Subset.fkProperty_Id,Property_Return_Subset.fkPropertyReturn_Id,Property_Return_Subset.PropertyReturnSubset_Id,
                      Property_Acknowledgement_Subset.parproperty_Id,
                      Property.Property_Id, Property.Property_Number
                      FROM Property_Return_Subset
                      inner Join Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                      inner join Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                      WHERE Property_Return_Subset.fkPropertyReturn_Id="'.$_POST['return_id'].'"';



                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose" id="table_propertyreturn">
                      <tr><th>Property Number</th><th></th></tr>';
                      foreach ($resultSet as $row)
                      {
                          echo "
                          <tr>
                              <td>".$row['Property_Number']."</td>
                              <td onclick='deletePropertyReturnovermodal(".$row['PropertyReturnSubset_Id'].",".$row['fkPropertyReturn_Id'].")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                      }
                      echo '</table> ';
                      break;

               case 'selectPropertyReturnovermodalovermodal':
                      $sql='SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_Id,Property.Property_Number,Property.Property_Id,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Property Number</th><th>Name of End User</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyReturnovermodalovermodal(\"".$row['parproperty_Id']."\");'>
                                    <td>".$row['Property_Number']."</td>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Fname']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

               case 'searchPropertyReturnovermodalovermodal':
                      $sql='SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_id,Property.Property_Number,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                      where Property.Property_Number LIKE "%'.$_POST['search_string'].'%" ';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>Property Number</th><th>Description</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                               <tr onclick='selectedPropertyReturnovermodalovermodal(\"".$row['parproperty_Id']."\");'>
                                    <td>".$row['Property_Number']."</td>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Fname']."</td>
                                </tr>";
                          }
                          echo '</table>';
                          echo 'ajaxseparator';
                          echo "".$numOfRow."";
                          break;


               case 'selectedPropertyReturnovermodalovermodal':
                      $sql="INSERT INTO Property_Return_Subset(fkPropertyReturn_Id,fkProperty_Id)
                      values('".$_POST['equipmentreturn_id']."','".$_POST['propertyreturn_id']."')";
                      $resultset=mysqli_query($conn,$sql);


                      $sql='SELECT LAST_INSERT_ID()';
                      $recordsets=mysqli_query($conn,$sql);
                      $rows=  mysqli_fetch_row($recordsets);
                      $lastId= $rows[0];
                      mysqli_free_result($recordsets);

                      $sql='Select Property_Return_Subset.fkProperty_Id,Property_Return_Subset.fkPropertyReturn_Id,Property_Return_Subset.PropertyReturnSubset_Id,
                      Property_Acknowledgement_Subset.parproperty_Id,
                      Property.Property_Id, Property.Property_Number
                      FROM Property_Return_Subset
                      inner join Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                      inner join Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                      WHERE Property_Return_Subset.PropertyReturnSubset_Id="'.$lastId.'"';

                            $resultSet= mysqli_query($conn, $sql);
                             foreach ($resultSet as $row)
                                {
                                echo "
                                <tr>
                                    <td>".$row['Property_Number']."</td>
                                    <td onclick='deletePropertyReturn(\"".$row['PropertyReturnSubset_Id']."\",\"".$row['fkPropertyReturn_Id']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                                </tr>";
                                }

                      echo "ajaxseparator";

                                    $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.Property_Number,Property_Acknowledgement_Subset.fkProperty_Id
                                        FROM Property_Return_Subset
                                        INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                                        INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                                        WHERE Property_Return_Subset.fkPropertyReturn_Id='.$_POST['equipmentreturn_id'].'';
                            $resultSet= mysqli_query($conn, $sql);

                          echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertyreturn'>";
                                          foreach($resultSet as $row)
                                          {
                                              echo "<option disabled>".$row['Property_Number']."</option>";
                                          }
                                          echo "</select>";

                          break;
                  //---------------End Property Return Modal---------------
                  //---------------Start Property Repar Modal-------------
                  case 'selectPropertyRePar':
                      $sql='SELECT Property_Acknowledgement.*,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Recipient</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyRePar(\"".$row['Par_Id']."\");'>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

                   case 'searchPropertyRePar':
                      $sql='SELECT Property_Acknowledgement.*,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                      where M_Personnel.Personnel_Id LIKE "%'.$_POST['search_string'].'%" OR
                      M_Personnel.Personnel_Id LIKE "%'.$_POST['search_string'].'%" OR
                      M_Personnel.Personnel_Fname LIKE "%'.$_POST['search_string'].'%" OR
                      M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%" OR
                      M_Personnel.Personnel_Lname LIKE "%'.$_POST['search_string'].'%"';

                      $resultSet= mysqli_query($conn, $sql);
                      $numOfRow=mysqli_num_rows($resultSet);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>Recipient</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedPropertyRePar(\"".$row['Par_Id']."\");'>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."</td>
                                </tr>";
                            }
                            echo '</table>';
                            echo 'ajaxseparator';
                            echo "".$numOfRow."";
                            break;

               case 'selectedPropertyRePar':
                      $sql1='Select Property_Acknowledgement.fkPersonnel_Id,M_Personnel.*
                      FROM Property_Acknowledgement
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                      WHERE Property_Acknowledgement.Par_Id="'.$_POST['par_id'].'"';
                      $resultSet1= mysqli_query($conn, $sql1);
                      $rowpersonnel=  mysqli_fetch_array($resultSet1,MYSQL_ASSOC);

                      $sql2='Select Property_Acknowledgement_Subset.fkPar_Id,Property.Property_Number,Property.Property_Description,
                      Property_Acknowledgement.Par_Id,Property_Acknowledgement.fkPersonnel_Id,M_Personnel.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                      INNER JOIN Property_Acknowledgement ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                      INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                      WHERE Property_Acknowledgement_Subset.fkPar_Id="'.$_POST['par_id'].'"';

                      $resultSet2= mysqli_query($conn, $sql2);
                      $numOfRow=mysqli_num_rows($resultSet2);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose" id="table_propertypar">
                      <tr class="active"><th style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></th><th>Property Number</th><th>Description</th></tr>';
                            foreach ($resultSet2 as $row)
                            {
                                echo "
                                <tr>
                                    <td style='width: 30px'><input style='cursor: default' type='checkbox' aria-label='...'/></td>
                                    <td>".$row['Property_Number']."</td>
                                    <td>".$row['Property_Description']."</td>
                                </tr>";

                            }
                            echo ' </table> ';
                            echo 'ajaxseparator';
                            echo "".$rowpersonnel['Personnel_Lname'].", ".$rowpersonnel['Personnel_Fname']." ".$rowpersonnel['Personnel_Mname']."";
                            echo 'ajaxseparator';
                            echo $numOfRow;
                            break;
                  //---------------End Property Repar Modal---------------
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
                $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                FROM Property
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
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
                            <td>Classification:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Classification_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Supplier:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Supplier_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Remarks:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Property_Remarks']."'></td>
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
                    <td onclick='deleteSerial(\"".$rows['Serial_id']."\",\"".$rows['Serialno']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td></tr>";
                }
                break;

            case 'viewEquipmentPAR':
                $sql='SELECT Property_Acknowledgement.*, M_Personnel.*, M_Division.*
                FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON Property_Acknowledgement.fkPersonnel_Id=M_Personnel.Personnel_Id
                INNER JOIN M_Division ON Property_Acknowledgement.fkDivision_Id=M_Division.Division_Id
                WHERE Property_Acknowledgement.Par_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Property Number:</td>
                            <td class='desc-width'>";
                                $sql='SELECT Property_Acknowledgement_Subset.*,Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select readonly='readonly' class='form-control input-size selectpicker'>";
                                    foreach($resultset as $rows)
                                    {
                                        echo "<option disabled  data-subtext='".$rows['Property_Description']."'>".$rows['Property_Number']."</option>";
                                    }
                                    echo "</select>";
                                echo "</td>
                        </tr>
                        <tr>
                            <td>GSO Number:</td>
                            <td class='desc-width'><input readonly='readonly type='text' class='form-control' value='".$row['Par_GSOno']."'></td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Par_Date']."'></td>
                        </tr>
                        <tr>
                            <td>Office:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Division_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Recipient:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Lname']." ".$row['Personnel_Fname'].", ".$row['Personnel_Mname']."'></td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Par_Type']."'></td>
                        </tr>
                        <tr>
                            <td>Note:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Par_Note']."'></td>
                        </tr>
                        <tr>
                            <td>Remarks:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Par_Remarks']."'></td>
                        </tr>
                       </table>";
                       echo "</div>";
                       echo "</div>";
                       break;

                case 'viewPropertyReturn':
                        $sql='SELECT *
                        FROM Property_Return
                        WHERE PropertyReturn_Id='.$id.'';
                        $resultSet=  mysqli_query($conn, $sql);
                        $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                        echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo "<table>
                                <tr>
                                    <td>Property No:</td>
                                    <td class='desc-width'>";
                                        $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.Property_Number,Property_Acknowledgement_Subset.fkProperty_Id
                                        FROM Property_Return_Subset
                                        INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                                        INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                                        WHERE Property_Return_Subset.fkPropertyReturn_Id='.$row['PropertyReturn_Id'].'';
                                        $resultset=  mysqli_query($conn, $sql);
                                        echo "<select readonly='readonly' class='form-control input-size selectpicker'>";
                                            foreach($resultset as $rows)
                                            {
                                                echo "<option disabled>".$rows['Property_Number']."</option>";
                                            }
                                            echo "</select>";
                                        echo "</td>
                                </tr>
                                <tr>
                                    <td>Note:</td>
                                    <td class='desc-width'><input readonly='readonly type='text' class='form-control' value='".$row['PropertyReturn_Note']."'></td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['PropertyReturn_Date']."'></td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['PropertyReturn_Status']."'></td>
                                </tr>
                               </table>";
                               echo "</div>";
                               echo "</div>";
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
                $sql='SELECT Property.*, M_Classification.*,M_Model.*,M_Supplier.*
                FROM Property
                INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
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
                                </div>
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
                            </td>
                         </tr>
                         <tr>
                            <td>Condition:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_condition'  type='text' class='form-control' value='".$row['Property_Condition']."'></td>
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
                        <tr>
                            <td>Supplier:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Supplier' id='equipment_supplierovermodal' value='".$row['Supplier_Name']."'>
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectSupplierovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Remarks:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipment_remarks' type='text' class='form-control' value='".$row['Property_Remarks']."'></td>
                        </tr>
                      </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'editEquipmentPAR':
                $sql='SELECT Property_Acknowledgement.*, M_Personnel.*, M_Division.*
                FROM Property_Acknowledgement
                INNER JOIN M_Personnel ON Property_Acknowledgement.fkPersonnel_Id=M_Personnel.Personnel_Id
                INNER JOIN M_Division ON Property_Acknowledgement.fkDivision_Id=M_Division.Division_Id
                WHERE Property_Acknowledgement.Par_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Property Number:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'> ";

                                     $sql='SELECT Property_Acknowledgement_Subset.*,Property.* FROM Property_Acknowledgement_Subset
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                WHERE Property_Acknowledgement_Subset.fkPar_Id='.$row['Par_Id'].'';
                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertypar'>";
                                    foreach($resultset as $rows)
                                    {
                                        echo "<option disabled  data-subtext='".$rows['Property_Description']."'>".$rows['Property_Number']."</option>";
                                    }
                                    echo "</select>";

                                    echo "
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectPropertyPARovermodal(".$row['Par_Id'].");' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>GSO Number:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentpar_gso' type='text' class='form-control' value='".$row['Par_GSOno']."'></td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentpar_date'  type='date' class='form-control' value='".$row['Par_Date']."'></td>
                        </tr>
                        <tr>
                            <td>Office:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Office' id='equipmentpar_division_overmodal' value='".$row['Division_Name']."'>
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectDivisionovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Recipient:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Recipient' id='equipmentpar_personnel_overmodal' value='".$row['Personnel_Lname']." ".$row['Personnel_Fname'].", ".$row['Personnel_Mname']."'>
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectPersonnelovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td class='desc-width'>
                                <select  class='form-control' style='width:100%;' id='mymodal_equipmentpar_type' >";
                                    if($row['Par_Type'] =='Donation'){
                                       echo "<option selected>Donation</option>
                                       <option>Office Use</option>";
                                    }
                                    else if($row['Par_Type'] =='Office Use'){
                                       echo "<option selected >Office Use</option>
                                       <option>Donation</option>";
                                    }
                                    echo "
                                </select>
                            </td>
                        </tr>
                         <tr>
                            <td>Note:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentpar_note'  type='text' class='form-control' value='".$row['Par_Note']."'></td>
                        </tr>
                        <tr>
                            <td>Remarks:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentpar_remarks'  type='text' class='form-control' value='".$row['Par_Remarks']."'></td>
                        </tr>
                      </table>";
                echo "</div>";
                echo "</div>";
                break;

        case 'editPropertyReturn':
                $sql='SELECT *
                FROM Property_Return
                WHERE PropertyReturn_Id='.$id.'';


                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>


                            <td>Property Number:</td>
                            <td class='desc-width'>
                                <div class='input-group' style='width:100%;'> ";

                                $sql='SELECT Property_Return_Subset.fkPropertyReturn_Id,Property.Property_Number,Property_Acknowledgement_Subset.fkProperty_Id
                                        FROM Property_Return_Subset
                                        INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                                        INNER JOIN Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                                        WHERE Property_Return_Subset.fkPropertyReturn_Id='.$row['PropertyReturn_Id'].'';

                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertyreturn'>";
                                    foreach($resultset as $rows)
                                    {
                                        echo "<option disabled>".$rows['Property_Number']."</option>";
                                    }
                                    echo "</select>";

                                    echo "
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectPropertyReturnovermodal(".$row['PropertyReturn_Id'].");' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Note:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentreturn_note' type='text' class='form-control' value='".$row['PropertyReturn_Note']."'></td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_equipmentreturn_date'  type='date' class='form-control' value='".$row['PropertyReturn_Date']."'></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td class='desc-width'>
                            <select  class='form-control' style='width:100%;' id='mymodal_equipmentreturn_status' >";
                                    if($row['PropertyReturn_Status'] =='Disposal'){
                                       echo "<option selected>Disposal</option>
                                             <option>Repair</option>
                                             <option>Returned to Stock</option>
                                             <option>Other</option>";
                                    }
                                    else if($row['PropertyReturn_Status'] =='Repair'){
                                            echo "<option>Disposal</option>
                                             <option selected>Repair</option>
                                             <option>Returned to Stock</option>
                                             <option>Other</option>";
                                    }
                                    else if($row['PropertyReturn_Status'] =='Returned to Stock'){
                                           echo "<option>Disposal</option>
                                             <option>Repair</option>
                                             <option selected>Returned to Stock</option>
                                             <option>Other</option>";
                                    }
                                    else if($row['PropertyReturn_Status'] =='Other'){
                                        echo "<option>Disposal</option>
                                             <option>Repair</option>
                                             <option>Returned to Stock</option>
                                             <option selected>Other</option>";
                                    }
                                    echo "
                                </select>
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
                        <td onclick='deleteSerial(\"".$rows['Serial_id']."\",\"".$rows['Serialno']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td></tr>";
                    }
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteEquipmentPAR':
                mysqli_autocommit($conn,FALSE);
                $sql='DELETE FROM Property_Acknowledgement_Subset WHERE fkPar_Id = '.$_POST['equipmentpar_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                $sql='DELETE FROM Property_Acknowledgement WHERE Par_Id = '.$_POST['equipmentpar_id'].' ';
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

            case 'deleteEquipmentPARovermodal':
                mysqli_autocommit($conn,FALSE);
                $sql='DELETE FROM Property_Acknowledgement_Subset WHERE parproperty_Id = '.$_POST['equipmentpar_id'].' ';
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
                echo "ajaxseparator";
                  $sql='SELECT Property_Acknowledgement_Subset.*, Property.*
                      FROM Property_Acknowledgement_Subset
                      INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                      WHERE Property_Acknowledgement_Subset.fkPar_Id="'.$_POST['par_id'].'"';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose" id="table_propertypar">
                      <tr><th>Property Number</th><th>Description</th><th></th></tr>';
                      foreach ($resultSet as $row)
                      {
                          echo "
                          <tr>
                              <td>".$row['Property_Number']."</td>
                              <td>".$row['Property_Description']."</td>
                              <td onclick='deletePropertyPAR(\"".$row['parproperty_Id']."\",\"".$row['fkPar_Id']."\")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                      }
                      echo '</table> ';
                        echo "ajaxseparator";
                    echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertypar'>";
                                    foreach($resultSet as $row)
                                    {
                                        echo "<option disabled  data-subtext='".$row['Property_Description']."'>".$row['Property_Number']."</option>";
                                    }
                                    echo "</select>";
                break;

            case 'deletePropertyReturn':
                mysqli_autocommit($conn,FALSE);
                $sql='DELETE FROM Property_Return_Subset WHERE fkPropertyReturn_Id = '.$_POST['propertyreturn_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                $sql='DELETE FROM Property_Return WHERE PropertyReturn_Id = '.$_POST['propertyreturn_id'].' ';
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


             case 'deletePropertyReturnovermodal':
                mysqli_autocommit($conn,FALSE);
                $sql='DELETE FROM Property_Return_Subset WHERE PropertyReturnSubset_Id = '.$_POST['propertyreturn_id'].' ';
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
                echo "ajaxseparator";
                      $sql='Select Property_Return_Subset.fkProperty_Id,Property_Return_Subset.fkPropertyReturn_Id,Property_Return_Subset.PropertyReturnSubset_Id,
                      Property_Acknowledgement_Subset.parproperty_Id,
                      Property.Property_Id, Property.Property_Number
                      FROM Property_Return_Subset
                      inner Join Property_Acknowledgement_Subset ON Property_Acknowledgement_Subset.parproperty_Id=Property_Return_Subset.fkProperty_Id
                      inner join Property ON Property.Property_Id=Property_Acknowledgement_Subset.fkProperty_Id
                      WHERE Property_Return_Subset.fkPropertyReturn_Id="'.$_POST['return_id'].'"';

                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose" id="table_propertyreturn">
                      <tr><th>Property Number</th><th></th></tr>';
                      foreach ($resultSet as $row)
                      {
                          echo "
                           <tr>
                              <td>".$row['Property_Number']."</td>
                              <td onclick='deletePropertyReturnovermodal(".$row['PropertyReturnSubset_Id'].",".$row['fkPropertyReturn_Id'].")' style='width:10px;' ><span class='glyphicon glyphicon-remove removecolor'></span></td>
                          </tr>";
                      }
                      echo '</table> ';
                        echo "ajaxseparator";
                    echo "<select readonly='readonly' class='form-control input-size selectpicker' id='selectpropertyreturn'>";
                                    foreach($resultSet as $row)
                                    {
                                        echo "<option disabled>".$row['Property_Number']."</option>";
                                    }
                                    echo "</select>";
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
                     ,Property_Remarks="'.$_POST['equipment_remarks'].'"
                     ,fkModel_Id="'.$_POST['model_id'].'"
                     ,Property_Condition="'.$_POST['equipment_condition'].'"
                     ,fkClassification_Id="'.$_POST['classification_id'].'"
                     ,fkSupplier_Id="'.$_POST['supplier_id'].'"';
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

            case 'updateEquipmentPAR':
                     $sql='UPDATE Property_Acknowledgement SET
                      fkPersonnel_Id="'.$_POST['equipmentpar_personnelid'].'"
                     ,Par_Date="'.$_POST['equipmentpar_date'].'"
                     ,Par_Type="'.$_POST['equipmentpar_type'].'"
                     ,Par_Remarks="'.$_POST['equipmentpar_remarks'].'"
                     ,Par_GSOno="'.$_POST['equipmentpar_gso'].'"
                     ,fkDivision_Id="'.$_POST['equipmentpar_divisionid'].'"
                     WHERE Par_Id = '.$_POST['equipmentpar_id'].'';
                     $resultSet=  mysqli_query($conn, $sql);
                     if ($resultSet)
                     {
                         echo 'Update Successful';
                     }
                     else
                     {
                         echo mysqli_error($conn);
                     }
                     break;

              case 'updatePropertyReturn':
                     $sql='UPDATE Property_Return SET
                     PropertyReturn_Note="'.$_POST['equipmentreturn_note'].'"
                     ,PropertyReturn_Date="'.$_POST['equipmentreturn_date'].'"
                     ,PropertyReturn_Status="'.$_POST['equipmentreturn_status'].'"
                     WHERE PropertyReturn_Id = '.$_POST['equipmentreturn_id'].'';
                     $resultSet=  mysqli_query($conn, $sql);
                     if ($resultSet)
                     {
                         echo 'Update Successful';
                     }
                     else
                     {
                         echo mysqli_error($conn);
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
                    $sql='SELECT Property.*, M_Classification.*,M_Model.*
                    FROM Property
                    INNER JOIN M_Classification ON Property.fkClassification_Id=M_Classification.Classification_Id
                    INNER JOIN M_Model ON Property.fkModel_Id=M_Model.Model_Id
                    INNER JOIN M_Supplier ON Property.fkSupplier_Id=M_Supplier.Supplier_Id
                    WHERE Property.Property_Number LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Description LIKE "%'.$stringToSearch.'%"
                    OR Property.Acquisition_Date LIKE "%'.$stringToSearch.'%"
                    OR Property.Acquisition_Cost LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Remarks LIKE "%'.$stringToSearch.'%"
                    OR M_Model.Model_Name LIKE "%'.$stringToSearch.'%"
                    OR M_Supplier.Supplier_Name LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_InventoryTag LIKE "%'.$stringToSearch.'%"
                    OR M_Classification.Classification_Name LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Condition LIKE "%'.$stringToSearch.'%"
                    OR Property.Property_Acquisition LIKE "%'.$stringToSearch.'%"
                    ORDER BY Property.Property_Number LIMIT  '.$offset.','.$rowsperpage.'';
                    $result = mysqli_query($conn, $sql);
                    echo '<table class="table table-hover"  id="search_table">
                                  <tr>
                                     <td style="width:10%;"><b>Property No.</b></td>
                                     <td style="width:10%;"><b>Description</b></td>
                                     <td style="width:10%;"><b>Inventory Tag</b></td>
                                     <td style="width:10%;"><b>Model</b></td>
                                     <td style="width:10%;"><b>Classification</b></td>
                                     <td style="width:10%;"><b>Condition</b></td>
                                     <td style="width:10%;"><b>Remarks</b></td>
                                     <td style="width:10%;" colspan="3" align="right"><b>Control Content</b></td>
                    </tr>';
                    foreach ($result as $row)
                            {
                              echo "<tr>
                                      <td style='word-break: break-all'>".$row['Property_Number']."</td>
                                      <td style='word-break: break-all'>".$row['Property_Description']."</td>
                                      <td style='word-break: break-all'>".$row['Property_InventoryTag']."</td>
                                      <td style='word-break: break-all'>".$row['Model_Name']."</td>
                                      <td style='word-break: break-all'>".$row['Classification_Name']."</td>
                                      <td style='word-break: break-all'>".$row['Property_Condition']."</td>
                                      <td style='word-break: break-all'>".$row['Property_Remarks']."</td>
                                      <td align='right'><a href='#!'><span onclick='viewEquipment(".$row['Property_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editEquipment(".$row['Property_Id'].",".$row['fkModel_Id'].",".$row['fkClassification_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
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

            case 'paginationEquipmentPAR':
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
                        ORDER BY Property_Acknowledgement.Par_Id LIMIT '.$offset.','.$rowsperpage.'';
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
                                      <td style='word-break: break-all'>".$row['Personnel_Lname']." ".$row['Personnel_Mname'].", ".$row['Personnel_Fname']."</td>
                                      <td style='word-break: break-all'>".$row['Par_Type']."</td>
                                      <td style='word-break: break-all'>".$row['Par_Note']."</td>
                                      <td style='word-break: break-all'>".$row['Par_Remarks']."</td>
                                      <td align='right'><a href='#!'><span onclick='viewEquipmentPAR(".$row['Par_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editEquipmentPAR(".$row['Par_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='deleteEquipmentPAR(".$row['Par_Id'].",\"$stringToSearch\")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

                case 'paginationPropertyReturn':
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
                                      <td align='right'><a href='#!'><span onclick='viewPropertyReturn(".$row['PropertyReturn_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editPropertyReturn(".$row['PropertyReturn_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='deletePropertyReturn(".$row['PropertyReturn_Id'].",\"$stringToSearch\")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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