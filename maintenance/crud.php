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
    //<!---------------Department Module--------------->
    switch ($_POST['module'])
    {
        case 'addDepartment':
            if((strlen($_POST['department_name']))==0)
            {
                echo "Cannot save blank Department";
                die();
            }
            if(verify_duplicate('department'))
            {
                echo "Department already exist.";
                die();
            }
            createData();
            break;

        case 'searchDepartment':
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

        case 'viewDepartment':
            viewData($_POST['department_id']);
            break;

        case 'editDepartment':
            viewEditData($_POST['department_id']);
            break;

        case 'updateDepartment':
            if((strlen($_POST['department_name']))==0)
            {
                  echo "Cannot Save blank Department";
                  die();
            }
            updateData();
            break;

        case 'deleteDepartment':
            deleteData();
            break;

        case 'paginationDepartment':
            pagination();
            break;
    //<!---------------End Department Module--------------->

    //<!---------------Division--------------->

        case 'addDivision':
             if((strlen($_POST['division_name']))==0 || (strlen($_POST['division_chiefofficer']))==0)
            {
                echo "Cannot save blank Division";
                die();
            }
            if(verify_duplicate('division'))
            {
                echo "Division already exist.";
                die();
            }
            createData();
            break;

        case 'searchDivision':
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

        case 'viewDivision':
            viewData($_POST['division_id']);
            break;

        case 'editDivision':
            viewEditData($_POST['division_id']);
            break;

        case 'updateDivision':
             if((strlen($_POST['division_name']))==0 || (strlen($_POST['division_chiefofficer']))==0)
            {
                echo "Cannot save blank Division";
                die();
            }
            updateData();
            break;

        case 'deleteDivision':
            deleteData();
            break;

        case 'paginationDivision':
            pagination();
            break;

        case 'selectChiefOfficer':
            searchModal();
            break;

        case 'searchChiefOfficer':
            searchModal();
            break;

        case 'selectChiefOfficerovermodal':
            searchModal();
            break;

        case 'searchChiefOfficerovermodal':
            searchModal();
            break;
       //<!---------------End Division Module--------------->

       //<!-------------------------BRAND-------------------------------->
        case 'addBrand':
            if(isset($_POST['brand_name']))
            {
    			$brand_name=$_POST['brand_name'];
    			$desc_name=$_POST['desc_name'];
            }

            if((strlen($brand_name))==0)
            {
    			echo "Cannot save blank Brand Name";
            }
            else
            {
    			if (verify_duplicate('Brand'))
    			{
    				echo "Duplicate Brand Name detected";
    				die();
    			}
               createData();
            }
            break;

        case 'searchBrand':
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

        case 'viewBrand':
            viewData($_POST['brand_id']);
            break;

        case 'editBrand':
            viewEditData($_POST['brand_id']);
            break;

        case 'updateBrand':
            if((strlen($_POST['brand_name']))==0)
            {
                echo "Cannot Save blank Brand Name";
                die();
            }
            updateData();
            break;

        case 'deleteBrand':
            deleteData();
            break;

        case 'paginationBrand':
            pagination();
            break;
        //<!-------------------------end BRAND-------------------------------->

        //<!-------------------------TYPE-------------------------------->
        case 'addType':
            if(isset($_POST['type_name']))
            {
                $type_name=$_POST['type_name'];
                $desc_name=$_POST['desc_name'];
            }
            if((strlen($type_name))==0)
            {
                echo "Cannot save blank Type Name";
            }
            else
            {
                if (verify_duplicate('Type'))
                {
                    echo "Duplicate Type Name detected";
                    die();
                }
                createData();
            }
            break;

        case 'searchType':
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

        case 'viewType':
            viewData($_POST['type_id']);
            break;

        case 'editType':
            viewEditData($_POST['type_id']);
            break;

        case 'updateType':
            if((strlen($_POST['type_name']))==0)
            {
                echo "Cannot Save blank Type Name";
                die();
            }
            updateData();
            break;

        case 'deleteType':
            deleteData();
            break;

        case 'paginationType':
            pagination();
            break;
        //<!-------------------------end TYPE-------------------------------->

        //<!---------------Classification--------------->
        case 'addClassification':
             if((strlen($_POST['classification_name']))==0)
            {
                echo "Cannot save blank Classification";
                die();
            }
            if(verify_duplicate('classification'))
            {
                echo "Classification already exist.";
                die();
            }
            createData();
            break;

        case 'searchClassification':
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

        case 'viewClassification':
            viewData($_POST['classification_id']);
            break;

        case 'editClassification':
            viewEditData($_POST['classification_id']);
            break;

        case 'updateClassification':
            if((strlen($_POST['classification_name']))==0)
            {
                echo "Cannot Save blank Type Name";
                die();
            }
            updateData();
            break;

        case 'deleteClassification':
            deleteData();
            break;

        case 'paginationClassification':
            pagination();
            break;
       //<!---------------End Division Module--------------->

       //<!---------------start Personnel Module--------------->
       case 'addPersonnel':
            $idnum =filter_input(INPUT_POST,'personnel_idnumber',FILTER_VALIDATE_INT);
            if((strlen($_POST['personnel_idnumber'])==0) || (strlen($_POST['personnel_fname'])==0) || (strlen($_POST['personnel_mname'])==0) || (strlen($_POST['personnel_lname'])==0) || (strlen($_POST['personnel_designation'])==0) || (strlen($_POST['personnel_position'])==0))
            {
    		    echo "Cannot save blank Personnel Information";
            }
            else if($idnum===false){
                echo "Invalid ID Number. Please Enter a numeric value";
            }
            else
            {
                if (verify_duplicate('personnel'))
    			{
    				echo "Duplicate Personnel Name detected";
    				die();
    			}
                createData();
            }
            break;

        case 'searchPersonnel':
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

        case 'viewPersonnel':
            viewData($_POST['personnel_id']);
            break;

        case 'editPersonnel':
            viewEditData($_POST['personnel_id']);
            break;

        case 'updatePersonnel':
            $idnum =filter_input(INPUT_POST,'personnel_idnumber',FILTER_VALIDATE_INT);
            if((strlen($_POST['personnel_idnumber'])==0) ||(strlen($_POST['personnel_fname'])==0) || (strlen($_POST['personnel_mname'])==0) || (strlen($_POST['personnel_lname'])==0) || (strlen($_POST['personnel_designation'])==0))
            {
                echo "Cannot Save blank Personnel Information";
                die();
            }
            else if($idnum===false){
                echo "Invalid ID Number. Please Enter a numeric value";
                die();
            }
            updateData();
            break;

        case 'deletePersonnel':
            deleteData();
            break;

        case 'paginationPersonnel':
            pagination();
            break;
       //<!---------------End Personnel Module--------------->

       //<!---------------start Model Module--------------->
        case 'addModel':
            if((strlen($_POST['model_name']))==0)
            {
                echo "Cannot save blank Model";
                die();
            }
            if(verify_duplicate('model'))
            {
                echo "Model already exist.";
                die();
            }
            createData();
            break;

        case 'searchModel':
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

        case 'viewModel':
            viewData($_POST['model_id']);
            break;

        case 'editModel':
            viewEditData($_POST['model_id']);
            break;

        case 'updateModel':
            if((strlen($_POST['model_name']))==0)
            {
                    echo "Cannot Save blank Type Name";
                    die();
            }
            updateData();
            break;

        case 'deleteModel':
            deleteData();
            break;

        case 'paginationModel':
            pagination();
            break;
       //<!---------------End Model Module--------------->

       //<!-------------------------SUPPLIER-------------------------------->
           case 'addSupplier':
            if(isset($_POST['supplier_name']))
            {
    			$supplier_name=$_POST['supplier_name'];
    			$desc_name=$_POST['desc_name'];
            }

            if((strlen($supplier_name))==0)
            {
    			echo "Cannot save blank Supplier Name";
            }
            else
            {
    			if (verify_duplicate('Supplier'))
    			{
    				echo "Duplicate Supplier Name detected";
    				die();
    			}
               createData();
            }
            break;

            case 'searchSupplier':
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

            case 'viewSupplier':
                viewData($_POST['supplier_id']);
                break;

            case 'editSupplier':
                viewEditData($_POST['supplier_id']);
                break;

            case 'updateSupplier':
                if((strlen($_POST['supplier_name']))==0)
                {
                    echo "Cannot Save blank Supplier Name";
                    die();
                }
                updateData();
                break;

            case 'deleteSupplier':
                deleteData();
                break;

            case 'paginationSupplier':
                pagination();
                break;
        //<!-------------------------end SUPPLIER-------------------------------->

           case 'addAccountableOfficer':
              if((strlen($_POST['accountableofficer_name']))==0 || (strlen($_POST['accountableofficer_position']))==0 || (strlen($_POST['division_id']))==0 || (strlen($_POST['accountableofficer_section']))==0)
              {
                  echo "Cannot save blank Section";
                  die();
              }
              if(verify_duplicate('accountableofficer'))
              {
                  echo "Section already filled.";
                  die();
              }
              createData();
              break;

           case 'searchAccountableOfficer':
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

           case 'paginationAccountableOfficer':
                pagination();
                break;

           case 'viewAccountableOfficer':
                viewData($_POST['accountableofficer_id']);
                break;

           case 'editAccountableOfficer':
                viewEditData($_POST['accountableofficer_id']);
                break;

           case 'deleteAccountableOfficer':
                deleteData();
                break;

           case 'updateAccountableOfficer':
                if((strlen($_POST['accountableofficer_name']))==0 || (strlen($_POST['accountableofficer_position']))==0 || (strlen($_POST['accountableofficer_division']))==0 || (strlen($_POST['accountableofficer_section']))==0)
                {
                    echo "Cannot save blank Section";
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
            case 'department':
                $sql="SELECT Department_Name FROM M_Department WHERE Department_Name='".$_POST['department_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'division':
                $sql="SELECT Division_Name FROM M_Division WHERE Division_Name='".$_POST['division_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                    $verify_duplicate=true;
                }
                break;

            case 'Brand':
                $sql="SELECT Brand_Name FROM M_Brand WHERE Brand_Name='".$_POST['brand_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'Type':
                $sql="SELECT Type_Name FROM M_Type WHERE Type_Name='".$_POST['type_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'classification':
                $sql="SELECT Classification_Name FROM M_Classification WHERE Classification_Name='".$_POST['classification_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                    $verify_duplicate=true;
                }
                break;

            case 'personnel':
                $sql="SELECT Personnel_Id FROM M_Personnel WHERE Personnel_Id='".$_POST['personnel_idnumber']."' ";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'model':
                $sql="SELECT Model_Name FROM M_Model WHERE Model_Name='".$_POST['model_name']."' ";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'Supplier':
                $sql="SELECT Supplier_Name FROM M_Supplier WHERE Supplier_Name='".$_POST['supplier_name']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                  $verify_duplicate=true;
                }
                break;

            case 'accountableofficer':
                $sql="SELECT AccountableOfficer_Section FROM M_AccountableOfficer WHERE AccountableOfficer_Section='".$_POST['accountableofficer_section']."'";
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
            case 'addDepartment':
                $sql="INSERT INTO M_Department(Department_Name,Description) values('".$_POST['department_name']."','".$_POST['desc_name']."') ";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                      echo 'Department added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                 break;

            case 'addDivision':
                $sql="INSERT INTO M_Division(Division_Name,Division_Description,fkDepartment_Id,fkDivision_Id) values('".$_POST['division_name']."','".$_POST['desc_name']."',".$_POST['department_id'].",'".$_POST['chiefofficer_id']."')";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                    echo 'Division added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                 break;

            case 'addBrand':
                global $brand_name;
                global $desc_name;
                $sql="INSERT INTO M_Brand(Brand_Name,Brand_Description) values('".$brand_name."','".$desc_name."') ";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                    echo 'Brand added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'addType':
                    global $type_name;
                    global $desc_name;
                    $sql="INSERT INTO M_Type(Type_Name,Type_Description) values('".$type_name."','".$desc_name."') ";
                    $resultset=mysqli_query($conn,$sql);
                    if ($resultset)
                    {
                        echo 'Type added successfully';
                    }
                    else
                    {
                        echo mysqli_error($conn);
                    }
                    break;

            case 'addClassification':
                $sql="INSERT INTO M_Classification(Classification_Name,Classification_Description,fkType_Id) values('".$_POST['classification_name']."','".$_POST['desc_name']."',".$_POST['type_id'].") ";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                    echo 'Classification added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                 break;

            case 'addPersonnel':
                $sql="INSERT INTO M_Personnel(Personnel_Id,Personnel_Fname,Personnel_Lname,Personnel_Mname,fkDivision_Id,Personnel_Position) values('".$_POST['personnel_idnumber']."','".$_POST['personnel_fname']."','".$_POST['personnel_lname']."','".$_POST['personnel_mname']."','".$_POST['personnel_designation']."','".$_POST['personnel_position']."') ";
                $resultset=mysqli_query($conn,$sql);

                if ($resultset)
                {
                    echo 'Personnel added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'addModel':
                $sql="INSERT INTO M_Model(Model_Name,Model_Description,fkBrand_Id) values('".$_POST['model_name']."','".$_POST['desc_name']."',".$_POST['fkModelId'].") ";
                $resultset=mysqli_query($conn,$sql);

                if ($resultset)
                {
                    echo 'Model added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'addSupplier':
                global $supplier_name;
                global $desc_name;
                $sql="INSERT INTO M_Supplier(Supplier_Name,Supplier_Description) values('".$supplier_name."','".$desc_name."') ";
                $resultset=mysqli_query($conn,$sql);

                if ($resultset)
                {
                    echo 'Supplier added successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

             case 'addAccountableOfficer':
                $sql="INSERT INTO M_AccountableOfficer(AccountableOfficer_Name,AccountableOfficer_Position,fkDivision_Id,AccountableOfficer_Section)values('".$_POST['accountableofficer_name']."','".$_POST['accountableofficer_position']."','".$_POST['division_id']."','".$_POST['accountableofficer_section']."') ";
                $resultset=mysqli_query($conn,$sql);
                if ($resultset)
                {
                      echo 'Section filled successfully';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                 break;
        }
                mysqli_close($conn);
    }
    function searchModal()
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

                case 'searchChiefOfficer':
                    $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                    INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
                    WHERE M_Personnel.Personnel_Fname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Lname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedChiefOfficer(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
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

                case 'selectChiefOfficer':
                      $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                      INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedChiefOfficer(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
                                    <td>".$row['Personnel_Fname']."</td>
                                    <td>".$row['Personnel_Mname']."</td>
                                    <td>".$row['Personnel_Lname']."</td>
                                    <td>".$row['Division_Name']."</td>
                                </tr>";
                            }
                            echo ' </table> ';
                            break;

                case 'searchChiefOfficerovermodal':
                    $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                    INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id
                    WHERE M_Personnel.Personnel_Fname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Lname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Personnel_Mname LIKE "%'.$_POST['search_string'].'%"
                    OR M_Personnel.Transdate LIKE "%'.$_POST['search_string'].'%"';
                    $resultSet= mysqli_query($conn, $sql);
                    $numOfRow=mysqli_num_rows($resultSet);
                    echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                          <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                          foreach ($resultSet as $row)
                          {
                              echo "
                              <tr onclick='selectedChiefOfficerovermodal(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
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

                case 'selectChiefOfficerovermodal':
                      $sql='SELECT M_Personnel.*,M_Division.Division_Name FROM M_Personnel
                      INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                      $resultSet= mysqli_query($conn, $sql);
                      echo '<table style="overflow:scroll" class="table table-bordered table-hover tablechoose">
                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Designation</th></tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr onclick='selectedChiefOfficerovermodal(\"".$row['Personnel_Fname']."\",\"".$row['Personnel_Mname']."\",\"".$row['Personnel_Lname']."\",\"".$row['Personnel_Id']."\");'>
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
            case 'searchDepartment':
                $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name LIMIT 0,10';
                $sqlcount='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name';
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
                                <td class="groupNameWidth"><b>Department</b></td>
                                <td class="groupDescWidth"><b>Description</b></td>
                                <td class="groupTransdateWidth"><b>Transdate</b></td>
                                <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                foreach ($resultSet as $row)
                {
                    echo "
                    <tr>
                            <td>".$row['Department_Name']."</td>
                            <td>".$row['Description']."</td>
                            <td>".$row['Transdate']."</td>
                            <td align='right'><a href='#!'><span onclick='viewDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </tr>";
                }
                echo ' </table>
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
                                      echo '
                                  </ul>
                                </nav>
                            </div>
                        </div>
                      </div>';
                      echo 'ajaxseparator';
                      echo "".$numOfRow."";
                      break;

            case 'searchDivision':
                $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name,M_Personnel.*  FROM M_Division JOIN M_Department ON';
                $sql=$sql . ' M_Division.fkDepartment_Id = M_Department.Department_Id
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_Division.fkPersonnel_Id
                WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name LIMIT 0,10';

                $sqlcount='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name  FROM M_Division JOIN M_Department ON';
                $sqlcount=$sqlcount . ' M_Division.fkDepartment_Id = M_Department.Department_Id
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_Division.fkPersonnel_Id
                WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name ';
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
                                <td class="divisionNameWidth"><b>Division</b></td>
                                <td class="divisionDescWidth"><b>Description</b></td>
                                <td class="divisionDepartmentWidth"><b>Department</b></td>
                                <td class="divisionTransdateWidth"><b>Chief Officer</b></td>
                                <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                        foreach ($resultSet as $row)
                        {
                            echo "
                            <tr>
                                <td>".$row['Division_Name']."</td>
                                <td>".$row['Division_Description']."</td>
                                <td>".$row['Department_Name']."</td>
                                <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."</td>
                                <td>".$row['Transdate']."</td>
                                <td align='right'><a href='#!'><span onclick='viewDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                <td align='right'><a href='#!'><span onclick='editDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                <td align='right'><a href='#!'><span onclick='deleteDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                            </tr>";
                        }
                    echo ' </table>
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
                                    echo '
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

            case 'searchBrand':
                    $sql='SELECT Brand_Id, Brand_Name, Brand_Description,Transdate from M_Brand';
                    $sql=$sql .' WHERE Brand_Name LIKE "%'.$stringToSearch.'%" OR Brand_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Brand_Name LIMIT 0,10';
                    $sqlcount='SELECT Brand_ID, Brand_Name, Brand_Description,Transdate from M_Brand';
                    $sqlcount=$sqlcount .' WHERE Brand_Name LIKE "%'.$stringToSearch.'%" OR Brand_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Brand_Name';
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
                                        <td class="groupNameWidth"><b>Brand Name</b></td>
                                        <td class="groupDescWidth"><b>Description</b></td>
                                        <td class="groupTransdateWidth"><b>Transdate</b></td>
                                        <td colspan="3" align="right"><b>Control Content</b></td>
                                </tr>';

                        foreach ($resultSet as $row)
                        {
                            echo "
                            <tr>
                                    <td>".$row['Brand_Name']."</td>
                                    <td>".$row['Brand_Description']."</td>
                                    <td>".$row['Transdate']."</td>
                                    <td align='right'><a href='#!'><span onclick='viewBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='editBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='deleteBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                            </tr>";
                        }
                        echo ' </table>
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
                                        echo '
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>';
                    echo 'ajaxseparator';
                    echo "".$numOfRow."";
                    break;

            case 'searchType':
                    $sql='SELECT Type_ID, Type_Name, Type_Description,Transdate from M_Type';
                    $sql=$sql .' WHERE Type_Name LIKE "%'.$stringToSearch.'%" OR Type_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Type_Name LIMIT 0,10';
                    $sqlcount='SELECT Type_ID, Type_Name, Type_Description,Transdate from M_Type';
                    $sqlcount=$sqlcount .' WHERE Type_Name LIKE "%'.$stringToSearch.'%" OR Type_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Type_Name';
                    $resultSet= mysqli_query($conn, $sql);
                    $resultCount= mysqli_query($conn, $sqlcount);
                    $numOfRow=mysqli_num_rows($resultCount);
                    $rowsperpage = 10;
                    $totalpages = ceil($numOfRow / $rowsperpage);
                    $num=1;
                    echo '<div class="panel-body bodyul" style="overflow: auto">
                              <table class="table table-hover fixed"  id="search_table">
                                    <tr>
                                            <td class="groupNameWidth"><b>Type Name</b></td>
                                            <td class="groupDescWidth"><b>Type Description</b></td>
                                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                                            <td colspan="3" align="right"><b>Control Content</b></td>
                                    </tr>';
                            foreach ($resultSet as $row)
                            {
                                echo "
                                <tr>
                                        <td>".$row['Type_Name']."</td>
                                        <td>".$row['Type_Description']."</td>
                                        <td>".$row['Transdate']."</td>
                                        <td align='right'><a href='#!'><span onclick='viewType(".$row['Type_ID'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                        <td align='right'><a href='#!'><span onclick='editType(".$row['Type_ID'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                        <td align='right'><a href='#!'><span onclick='deleteType(".$row['Type_ID'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                                </tr>";
                            }
                            echo ' </table>
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
                                            echo '
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>';
                        echo 'ajaxseparator';
                        echo "".$numOfRow."";
                        break;

            case 'searchClassification':
                  $sql='SELECT Classification_Id, Classification_Name, Classification_Description, M_Classification.Transdate,M_Type.Type_Name  FROM M_Classification JOIN M_Type ON';
                  $sql=$sql . ' M_Classification.fkType_Id = M_Type.Type_ID WHERE Classification_Name LIKE "%'.$stringToSearch.'%" OR Type_Description LIKE "%'.$stringToSearch.'%" OR M_Type.Type_Name LIKE "%'.$stringToSearch.'%" ORDER BY Classification_Name LIMIT 0,10';
                  $sqlcount='SELECT Classification_Id, Classification_Name, Classification_Description, M_Classification.Transdate,M_Type.Type_Name  FROM M_Classification JOIN M_Type ON';
                  $sqlcount=$sqlcount . ' M_Classification.fkType_Id = M_Type.Type_ID WHERE Classification_Name LIKE "%'.$stringToSearch.'%" OR Type_Description LIKE "%'.$stringToSearch.'%" OR M_Type.Type_Name LIKE "%'.$stringToSearch.'%" ORDER BY Classification_Name ';
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
                                <td class="divisionNameWidth"><b>Classification</b></td>
                                <td class="divisionDescWidth"><b>Description</b></td>
                                <td class="divisionDepartmentWidth"><b>Type</b></td>
                                <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                    foreach ($resultSet as $row)
                    {
                    echo "
                    <tr>
                            <td>".$row['Classification_Name']."</td>
                            <td>".$row['Classification_Description']."</td>
                            <td>".$row['Type_Name']."</td>
                            <td>".$row['Transdate']."</td>
                            <td align='right'><a href='#!'><span onclick='viewClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </tr>";
                }
                echo ' </table>
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
                                            echo '
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>';
                        echo 'ajaxseparator';
                        echo "".$numOfRow."";
                        break;

            case 'searchPersonnel':
                        $sql='SELECT M_Personnel.*,M_Division.Division_Name from M_Personnel
                        INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                        $sql=$sql .' WHERE M_Personnel.Personnel_Id LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Fname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Mname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Lname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Position LIKE "%'.$stringToSearch.'%" OR M_Division.Division_Name LIKE "%'.$stringToSearch.'%" ORDER BY M_Personnel.Personnel_Lname LIMIT 0,10';

                        $sqlcount='SELECT M_Personnel.*,M_Division.Division_Name from M_Personnel
                        INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id';
                        $sqlcount=$sqlcount .' WHERE M_Personnel.Personnel_Id LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Fname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Mname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Lname LIKE "%'.$stringToSearch.'%" OR M_Personnel.Personnel_Position LIKE "%'.$stringToSearch.'%" OR M_Division.Division_Name LIKE "%'.$stringToSearch.'%" ORDER BY M_Personnel.Personnel_Lname';
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
                                       <td class="personnelIdnumberWidth"><b>ID Number</b></td>
                                       <td class="personnelFNameWidth"><b>First Name</b></td>
                                       <td class="personnelMNameWidth"><b>Middle Name</b></td>
                                       <td class="personnelLNameWidth"><b>Last Name</b></td>
                                       <td class="personnelDesignationWidth"><b>Designation</b></td>
                                       <td class="personnelDesignationWidth"><b>Position</b></td>
                                       <td class="personnelTransdateWidth"><b>Transdate</b></td>
                                       <td colspan="3" align="right"><b>Control Content</b></td>
                                  </tr>';

                          foreach ($resultSet as $row)
                          {
                              echo "
                                  <tr>
                                      <td>".$row['Personnel_Id']."</td>
                                      <td>".$row['Personnel_Fname']."</td>
                                      <td>".$row['Personnel_Mname']."</td>
                                      <td>".$row['Personnel_Lname']."</td>
                                      <td>".$row['Division_Name']."</td>
                                      <td>".$row['Personnel_Position']."</td>
                                      <td>".$row['Transdate']."</td>
                                      <td align='right'><a href='#!'><span onclick='viewPersonnel(".$row['Personnel_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='editPersonnel(".$row['Personnel_Id'].",".$row['fkDivision_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                      <td align='right'><a href='#!'><span onclick='deletePersonnel(".$row['Personnel_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                                  </tr>";
                          }
                          echo ' </table>
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
                                            echo '
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>';
                        echo 'ajaxseparator';
                        echo "".$numOfRow."";
                        break;

            case 'searchModel':
                $sql='SELECT Model_Id, Model_Name, Model_Description, M_Model.Transdate, M_Brand.Brand_Name FROM M_Model join M_Brand ON';
                $sql=$sql . ' M_Model.fkBrand_Id = M_Brand.Brand_Id WHERE Model_Name LIKE "%'.$stringToSearch.'%" OR Model_Description LIKE "%'.$stringToSearch.'%" OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%" ORDER BY Model_Name LIMIT 0,10';
                $sqlcount='SELECT Model_Id, Model_Name, Model_Description, M_Model.Transdate, M_Brand.Brand_Name FROM M_Model join M_Brand ON';
                $sqlcount=$sqlcount . ' M_Model.fkBrand_Id = M_Brand.Brand_Id WHERE Model_Name LIKE "%'.$stringToSearch.'%" OR Model_Description LIKE "%'.$stringToSearch.'%" OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%" ';
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
                            <td class="divisionNameWidth"><b>Model</b></td>
                            <td class="divisionNameWidth"><b>Description</b></td>
                            <td class="divisionNameWidth"><b>Brand</b></td>
                            <td class="divisionNameWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr>
                            <td>".$row['Model_Name']."</td>
                            <td>".$row['Model_Description']."</td>
                            <td>".$row['Brand_Name']."</td>
                            <td>".$row['Transdate']."</td>
                            <td align='right'><a href='#!'><span onclick='viewModel(".$row['Model_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editModel(".$row['Model_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteModel(".$row['Model_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                        </tr>";
                    }
                    echo ' </table>
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
                                    echo '
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

        case 'searchSupplier':
                $sql='SELECT Supplier_Id, Supplier_Name, Supplier_Description,Transdate from M_Supplier';
                $sql=$sql .' WHERE Supplier_Name LIKE "%'.$stringToSearch.'%" OR Supplier_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Supplier_Name LIMIT 0,10';
                $sqlcount='SELECT Supplier_ID, Supplier_Name, Supplier_Description,Transdate from M_Supplier';
                $sqlcount=$sqlcount .' WHERE Supplier_Name LIKE "%'.$stringToSearch.'%" OR Supplier_Description LIKE "%'.$stringToSearch.'%"  ORDER BY Supplier_Name';
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
                            <td class="groupNameWidth"><b>Supplier Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr>
                            <td>".$row['Supplier_Name']."</td>
                            <td>".$row['Supplier_Description']."</td>
                            <td>".$row['Transdate']."</td>
                            <td align='right'><a href='#!'><span onclick='viewSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='editSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='right'><a href='#!'><span onclick='deleteSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                        </tr>";
                    }
                    echo ' </table>
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
                                    echo '
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>';
                echo 'ajaxseparator';
                echo "".$numOfRow."";
                break;

        case 'searchAccountableOfficer':
                $sql='SELECT M_AccountableOfficer.*, M_Division.Division_Name from M_AccountableOfficer
                INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                ';
                $sql=$sql .' WHERE AccountableOfficer_Name LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Position LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Position LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Section LIKE "%'.$stringToSearch.'%"
                OR Division_Name LIKE "%'.$stringToSearch.'%"
                ORDER BY AccountableOfficer_Name LIMIT 0,10';

                $sqlcount='SELECT * from M_AccountableOfficer   INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id ';
                $sqlcount=$sqlcount .' WHERE AccountableOfficer_Name LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Position LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Position LIKE "%'.$stringToSearch.'%"
                OR AccountableOfficer_Section LIKE "%'.$stringToSearch.'%"
                OR Division_Name LIKE "%'.$stringToSearch.'%"
                ORDER BY AccountableOfficer_Name';

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
                               <td style=" width: 20%"><b>Name</b></td>
                               <td style=" width: 20%"><b>Position</b></td>
                               <td style=" width: 20%"><b>Division</b></td>
                               <td style=" width: 20%"><b>Section</b></td>
                               <td  style=" width: 10%" colspan="3" align="center"><b>Manage</b></td>
                        </tr>';
                    foreach ($resultSet as $row)
                    {
                        echo "
                        <tr>
                            <td>".$row['AccountableOfficer_Name']."</td>
                            <td>".$row['AccountableOfficer_Position']."</td>
                            <td>".$row['Division_Name']."</td>";
                                    if($row['AccountableOfficer_Section']=='PARA'){echo "<td>Property Acknowledgement Receipt - Approver</td>";}
                                    if($row['AccountableOfficer_Section']=='PRSR'){echo "<td>Property Return Slip - Receiver</td>";}
                                    if($row['AccountableOfficer_Section']=='PRSA'){echo "<td>Property Return Slip - Approver</td>";}
                                    if($row['AccountableOfficer_Section']=='IOECO'){echo "<td>Inventory of Equipment - Conductor</td>";}
                                    if($row['AccountableOfficer_Section']=='IOEP'){echo "<td>Inventory of Equipment - Preparer</td>";}
                                    if($row['AccountableOfficer_Section']=='IOECH'){echo "<td>Inventory of Equipment - Checker</td>";}
                                    if($row['AccountableOfficer_Section']=='IOEN'){echo "<td>Inventory of Equipment - Noter</td>";}
                                    if($row['AccountableOfficer_Section']=='IOECE'){echo "<td>Inventory of Equipment - Certifier</td>";}
                                    if($row['AccountableOfficer_Section']=='IOEAT'){echo "<td>Inventory of Equipment - Attester</td>";}
                                    if($row['AccountableOfficer_Section']=='IOEAP'){echo "<td>Inventory of Equipment - Approver</td>";}
                            echo "<td align='center'><a href='#!'><span onclick='viewAccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td align='center'><a href='#!'><span onclick='editAccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td align='center'><a href='#!'><span onclick='deleteAccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                        </tr>";
                    }
                    echo ' </table>
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


    function viewData($id)
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

            case 'viewDepartment':
                $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE ';
                $sql=$sql.' Department_Id='.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Department:</td>
                            <td class='desc-width'><input  readonly='readonly type='text' class='form-control' value='".$row['Department_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Description']."'></td>
                        </tr>
                         <tr>
                            <td>Transaction Date:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                        </tr>
                      </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'viewDivision':
                $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name,M_Personnel.*  FROM M_Division JOIN M_Department ON';
                $sql=$sql. ' M_Division.fkDepartment_Id = M_Department.Department_Id
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_Division.fkPersonnel_Id
                WHERE Division_Id='.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Division:</td>
                            <td class='desc-width'><input  readonly='readonly type='text' class='form-control' value='".$row['Division_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Division_Description']."'></td>
                        </tr>
                        <tr>
                            <td>Department:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Department_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Chief Officer:</td>
                            <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."'></td>
                        </tr>
                         <tr>
                            <td>Transaction Date:</td>
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                        </tr>

                    </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'viewBrand':
                $sql='SELECT Brand_Name, Brand_Description, Transdate from M_Brand WHERE ';
                $sql=$sql. ' Brand_Id = '.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                          <td>Brand Name:</td>
                          <td class='desc-width'><input onkeyup='meme();'  readonly='readonly'  type='text' class='form-control' value='".$row['Brand_Name']."'></td>
                        </tr>
                        <tr>
                          <td>Description:</td>
                          <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Brand_Description']."'></td>
                        </tr>
                        <tr>
                          <td>Transaction Date:</td>
                          <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                        </tr>
                      </table>";
                      echo "</div>";
                      echo "</div>";
                      break;

            case 'viewType':
                 $sql='SELECT Type_Name, Type_Description, Transdate from M_Type WHERE ';
                 $sql=$sql. ' Type_ID = '.$id.' ';
                 $resultSet=  mysqli_query($conn, $sql);
                 $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                 echo "<div class='row'>";
                 echo "<div class='col-md-12'>";
                 echo "<table>
                          <tr>
                              <td>Type Name:</td>
                              <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Type_Name']."'></td>
                          </tr>
                          <tr>
                              <td>Description:</td>
                              <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Type_Description']."'></td>
                          </tr>
                          <tr>
                              <td>Transaction Date:</td>
                              <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                          </tr>
                        </table>";
                        echo "</div>";
                        echo "</div>";
                        break;

            case 'viewClassification':
                $sql='SELECT Classification_Id, Classification_Name, Classification_Description, M_Classification.Transdate,M_Type.Type_Name  FROM M_Classification JOIN M_Type ON';
                $sql=$sql. ' M_Classification.fkType_Id = M_Type.Type_ID WHERE Classification_Id='.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                          <tr>
                                <td>Classification:</td>
                                <td class='desc-width'><input  readonly='readonly type='text' class='form-control' value='".$row['Classification_Name']."'></td>
                          </tr>
                          <tr>
                                <td>Description:</td>
                                <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Classification_Description']."'></td>
                          </tr>
                          <tr>
                                <td>Type:</td>
                                <td class='desc-width'><input   readonly='readonly type='text' class='form-control' value='".$row['Type_Name']."'></td>
                          </tr>
                          <tr>
                                <td>Transaction Date:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                          </tr>
                        </table>";
                        echo "</div>";
                        echo "</div>";
                        break;

            case 'viewPersonnel':
                $sql='SELECT M_Personnel.*,M_Division.Division_Name from M_Personnel
                INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id WHERE';
                $sql=$sql. ' M_Personnel.Personnel_Id = '.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                            <tr>
                                <td>ID Number:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Id']."'></td>
                            </tr>
                            <tr>
                                <td>First Name:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Fname']."'></td>
                            </tr>
                             <tr>
                                <td>Middle Name:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Mname']."'></td>
                            </tr>
                             <tr>
                                <td>Last Name:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Lname']."'></td>
                            </tr>
                            <tr>
                                <td>Designation:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Division_Name']."'></td>
                            </tr>
                            <tr>
                                <td>Position:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Personnel_Position']."'></td>
                            </tr>
                </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'viewModel':
                $sql='SELECT Model_Id, Model_Name, Model_Description, M_Model.Transdate,M_Brand.Brand_Name  FROM M_Model JOIN M_Brand ON';
                $sql=$sql. ' M_Model.fkBrand_Id = M_Brand.Brand_ID WHERE Model_Id='.$id.'';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                                <tr>
                                    <td>Model:</td>
                                    <td class='desc-width'><input  readonly='readonly model='text' class='form-control' value='".$row['Model_Name']."'></td>
                                </tr>
                                <tr>
                                    <td>Description:</td>
                                    <td class='desc-width'><input   readonly='readonly model='text' class='form-control' value='".$row['Model_Description']."'></td>
                                </tr>
                                <tr>
                                    <td>Brand:</td>
                                    <td class='desc-width'><input   readonly='readonly model='text' class='form-control' value='".$row['Brand_Name']."'></td>
                                </tr>
                                 <tr>
                                    <td>Transaction Date:</td>
                                    <td class='desc-width'><input  readonly='readonly'  model='text' class='form-control' value='".$row['Transdate']."'></td>
                                </tr>

                            </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'viewSupplier':
                $sql='SELECT Supplier_Name, Supplier_Description, Transdate from M_Supplier WHERE ';
                $sql=$sql. ' Supplier_Id = '.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                            <tr>
                                <td>Supplier Name:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Supplier_Name']."'></td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Supplier_Description']."'></td>
                            </tr>
                            <tr>
                                <td>Transaction Date:</td>
                                <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                            </tr>
                        </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'viewAccountableOfficer':
                $sql="SELECT M_AccountableOfficer.*, M_Division.Division_Name from M_AccountableOfficer
                INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                WHERE AccountableOfficer_Id='".$id."'";
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                            <tr>
                                <td>Officer Name:</td>
                                <td class='desc-width'><input readonly='readonly' type='text' class='form-control' value='".$row['AccountableOfficer_Name']."'></td>
                            </tr>
                            <tr>
                                <td>Officer Position:</td>
                                <td class='desc-width'><input readonly='readonly' type='text' class='form-control' value='".$row['AccountableOfficer_Position']."'></td>
                            </tr>
                            <tr>
                                <td>Officer Division</td>
                                <td class='desc-width'><input readonly='readonly' type='text' class='form-control' value='".$row['Division_Name']."'></td>
                            </tr>
                            <tr>
                                <td>Officer Section</td>
                                <td class='desc-width'>";
                                    if($row['AccountableOfficer_Section']=='PARA'){echo "<input readonly='readonly' type='text' class='form-control' value='Property Acknowledgement Receipt - Approver'></td>";}
                                    if($row['AccountableOfficer_Section']=='PRSR'){echo "<input readonly='readonly' type='text' class='form-control' value='Property Return Slip - Receiver'></td>";}
                                    if($row['AccountableOfficer_Section']=='PRSA'){echo "<input readonly='readonly' type='text' class='form-control' value='Property Return Slip - Approver'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOECO'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Conductor'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOEP'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Preparer'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOECH'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Checker'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOEN'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Noter'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOECE'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Certifier'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOEAT'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Attester'></td>";}
                                    if($row['AccountableOfficer_Section']=='IOEAP'){echo "<input readonly='readonly' type='text' class='form-control' value='Inventory of Equipment - Approver'></td>";}

                               echo "</td>
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
            case 'editDepartment':
                $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE ';
                $sql=$sql.' Department_Id='.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                        <tr>
                            <td>Department:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department' type='text' class='form-control' value='".$row['Department_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Description']."'></td>
                        </tr>
                      </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'editDivision':
                $sql='SELECT Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name,fkDepartment_Id,M_Personnel.*  FROM M_Division JOIN M_Department ON';
                $sql=$sql. ' M_Division.fkDepartment_Id = M_Department.Department_Id
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_Division.fkPersonnel_Id
                WHERE Division_Id='.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                $deptid=$row['fkDepartment_Id'];
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
    			echo "<table>
                        <td>Division:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};'  id='mymodal_division_name'   type='text' class='form-control' value='".$row['Division_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_division_description'   type='text' class='form-control' value='".$row['Division_Description']."'></td>
                        </tr>
                        <tr>
                            <td>Department:</td>
                            <td class='desc-width'>";
                                $sql="SELECT Department_Id, Department_Name,Description FROM M_Department ORDER BY Department_Name";
                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select id='mymodal_department_id' class='form-control input-size'>";
                                    foreach($resultset as $rows)
                                    {
                                        if($rows['Department_Id']==$deptid)
                                        {
                                            echo "<option value=".$rows['Department_Id']." selected>".$rows['Department_Name']." - ".$rows['Description']."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=".$rows['Department_Id'].">".$rows['Department_Name']."  - ".$rows['Description']."</option>";
                                        }

                                    }
                                    echo "</select>";
                echo "</tr>
                     <tr>
                            <td>Chief Officer:</td>
                            <td class='desc-width'>
                             <div class='input-group' style='width:100%;'>
                                    <input type='text' class='form-control' readonly='readonly'   placeholder='Select Model' id='mymodal_division_chiefofficer' value='".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."'>
                                    <span class='input-group-btn'>
                                    <button class='btn btn-default' onclick='selectChiefOfficerovermodal();' type='button'><span class='glyphicon glyphicon-plus'></span></button>
                                    </span>
                                </div>


                            </td>
                        </tr>
                </table>";
                echo "</div>";
                echo "</div>";
                break;

            case 'editBrand':
                    $sql='SELECT Brand_Name, Brand_Description from M_Brand WHERE ';
                    $sql=$sql. ' Brand_Id = '.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<table>
                        <tr>
                            <td>Brand Name:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_brand_name' name='brand_name'  type='text' class='form-control' value='".$row['Brand_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_brand_desc' name='brand_desc' type='text' class='form-control' value='".$row['Brand_Description']."'></td>
                        </tr>
                    </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'editType':
                    $sql='SELECT Type_Name, Type_Description from M_Type WHERE ';
                    $sql=$sql. ' Type_ID = '.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<table>
                        <tr>
                            <td>Type Name:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_type_name' name='type_name'  type='text' class='form-control' value='".$row['Type_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_type_desc' name='type_desc' type='text' class='form-control' value='".$row['Type_Description']."'></td>
                        </tr>
                    </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'editClassification':
                    $sql='SELECT Classification_Name, Classification_Description, M_Classification.Transdate,M_Type.Type_Name,fkType_Id  FROM M_Classification JOIN M_Type ON';
                    $sql=$sql. ' M_Classification.fkType_Id = M_Type.Type_ID WHERE Classification_Id='.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    $deptid=$row['fkType_Id'];
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
    			    echo "<table>
                        <tr>
                        <td>Classification:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_classification_name'   type='text' class='form-control' value='".$row['Classification_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_classification_description'   type='text' class='form-control' value='".$row['Classification_Description']."'></td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td class='desc-width'>";
                                $sql="SELECT Type_ID, Type_Name,Type_Description FROM M_Type ORDER BY Type_Name";
                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select id='mymodal_type_id' class='form-control input-size'>";
                                foreach($resultset as $rows)
                                {
                                        if($rows['Type_ID']==$deptid)
                                        {
                                            echo "<option value=".$rows['Type_ID']." selected>".$rows['Type_Name']." - ".$rows['Type_Description']."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=".$rows['Type_ID'].">".$rows['Type_Name']."  - ".$rows['Type_Description']."</option>";
                                        }

                                }
                                echo "</select>";
                        echo "</tr>
                        </table>";
                        echo "</div>";
                        echo "</div>";
                        break;

            case 'editPersonnel':
                    $sql='SELECT M_Personnel.*,M_Division.Division_Name from M_Personnel
                    INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id WHERE';
                    $sql=$sql. ' M_Personnel.Personnel_Id = '.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    $divisionid=$row['fkDivision_Id'];
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<table>
                            <tr>
                                <td>ID Number:</td>
                                <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_personnel_idnumber'  type='text' class='form-control' value='".$row['Personnel_Id']."'></td>
                            </tr>
                            <tr>
                                <td>First Name:</td>
                                <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_personnel_fname'  type='text' class='form-control' value='".$row['Personnel_Fname']."'></td>
                            </tr>
                             <tr>
                                <td>Middle Name:</td>
                                <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_personnel_mname'  type='text' class='form-control' value='".$row['Personnel_Mname']."'></td>
                            </tr>
                             <tr>
                                <td>Last Name:</td>
                                <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_personnel_lname' type='text' class='form-control' value='".$row['Personnel_Lname']."'></td>
                            </tr>
                            <tr>
                                <td>Designation:</td>
                                <td class='desc-width'>";


                                        $sql="SELECT Division_Name,Division_Id,Division_Description FROM M_Division ORDER BY Division_Name";
                                  $resultset=  mysqli_query($conn, $sql);
                                  echo "<select id='mymodal_personnel_designation' class='form-control input-size'>";
                                  foreach($resultset as $rows)
                                  {
                                          if($rows['Division_Id']==$divisionid)
                                          {
                                               echo "<option value=".$rows['Division_Id']." selected>".$rows['Division_Name']."</option>";
                                          }
                                          else
                                          {
                                               echo "<option value=".$rows['Division_Id'].">".$rows['Division_Name']."</option>";
                                          }
                                  }
                                  echo "</select>";




                                echo "</td>
                            </tr>
                            <tr>
                                <td>Position:</td>
                                <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_personnel_position' type='text' class='form-control' value='".$row['Personnel_Position']."'></td>
                            </tr>
                    </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'editModel':
                    $sql='SELECT Model_Name, Model_Description, M_Model.Transdate,M_Brand.Brand_Name,fkBrand_Id  FROM M_Model JOIN M_Brand ON';
                    $sql=$sql. ' M_Model.fkBrand_Id = M_Brand.Brand_ID WHERE Model_Id='.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    $deptid=$row['fkBrand_Id'];
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
        			echo "<table>
                          <td>Model:</td>
                              <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_model_name'   type='text' class='form-control' value='".$row['Model_Name']."'></td>
                          </tr>
                          <tr>
                              <td>Description:</td>
                              <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_model_description'  type='text' class='form-control' value='".$row['Model_Description']."'></td>
                          </tr>
                          <tr>
                              <td>Brand:</td>
                              <td class='desc-width'>";
                                  $sql="SELECT Brand_ID, Brand_Name,Brand_Description FROM M_Brand ORDER BY Brand_Name";
                                  $resultset=  mysqli_query($conn, $sql);
                                  echo "<select id='mymodal_brand_id' class='form-control input-size'>";
                                  foreach($resultset as $rows)
                                  {
                                          if($rows['Brand_ID']==$deptid)
                                          {
                                              echo "<option value=".$rows['Brand_ID']." selected>".$rows['Brand_Name']." - ".$rows['Brand_Description']."</option>";
                                          }
                                          else
                                          {
                                              echo "<option value=".$rows['Brand_ID'].">".$rows['Brand_Name']."  - ".$rows['Brand_Description']."</option>";
                                          }
                                  }
                                  echo "</select>";
                          echo "</tr>
                          </table>";
                          echo "</div>";
                          echo "</div>";
                          break;

            case 'editSupplier':
                    $sql='SELECT Supplier_Name, Supplier_Description from M_Supplier WHERE ';
                    $sql=$sql. ' Supplier_Id = '.$id.' ';
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    echo "<table>
                        <tr>
                            <td>Supplier Name:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_supplier_name' name='supplier_name'  type='text' class='form-control' value='".$row['Supplier_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_supplier_desc' name='supplier_desc' type='text' class='form-control' value='".$row['Supplier_Description']."'></td>
                        </tr>
                    </table>";
                    echo "</div>";
                    echo "</div>";
                    break;

            case 'editAccountableOfficer';
                    $sql="SELECT M_AccountableOfficer.*, M_Division.Division_Name from M_AccountableOfficer
                    INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                    WHERE AccountableOfficer_Id='".$id."'";
                    $resultSet=  mysqli_query($conn, $sql);
                    $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                    $officerid=$row['fkDivision_Id'];
                         echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                        echo "<table>
                        <tr>
                            <td>Officer Name:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_accountableofficer_name' name='accountableofficer_name'  type='text' class='form-control' value='".$row['AccountableOfficer_Name']."'></td>
                        </tr>
                        <tr>
                            <td>Officer Position:</td>
                            <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_accountableofficer_position' name='accountableofficer_position'  type='text' class='form-control' value='".$row['AccountableOfficer_Position']."'></td>
                        </tr>
                        <tr>
                            <td>Officer Division:</td>
                            <td class='desc-width'>";
                                $sql="SELECT Division_Id, Division_Name,Division_Description FROM M_Division ORDER BY Division_Name";
                                $resultset=  mysqli_query($conn, $sql);
                                echo "<select id='mymodal_accountableofficer_division' class='form-control input-size'>";
                                foreach($resultset as $rows)
                                {
                                        if($rows['Division_Id']==$officerid)
                                        {
                                            echo "<option value=".$rows['Division_Id']." selected>".$rows['Division_Name']." - ".$rows['Division_Description']."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=".$rows['Division_Id'].">".$rows['Division_Name']."  - ".$rows['Division_Description']."</option>";
                                        }

                                }
                                echo "</select>";
                        echo "</tr>
                         <tr>
                            <td>Officer Section:</td>
                            <td class='desc-width'>";
                               echo "<select id='mymodal_accountableofficer_section' class='form-control input-size selectpicker'>";
                                    echo "<option value='PARA'"; if($row['AccountableOfficer_Section'] == 'PARA'){ echo "selected='selected'";} echo ">Property Acknowledgement Receipt - Approver</option>";
                                    echo "<option value='PRSR'"; if($row['AccountableOfficer_Section'] == 'PRSR'){ echo "selected='selected'";} echo ">Property Return Slip - Receiver</option>";
                                    echo "<option value='PRSA'"; if($row['AccountableOfficer_Section'] == 'PRSA'){ echo "selected='selected'";} echo ">Property Return Slip - Approver</option>";
                                    echo "<option value='IOECO'";if($row['AccountableOfficer_Section'] == 'IOECO'){echo "selected='selected'";} echo ">Inventory of Equipment - Conductor</option>";
                                    echo "<option value='IOEP'"; if($row['AccountableOfficer_Section'] == 'IOEP'){ echo "selected='selected'";} echo ">Inventory of Equipment - Preparer</option>";
                                    echo "<option value='IOECH'";if($row['AccountableOfficer_Section'] == 'IOECH'){echo "selected='selected'";} echo ">Inventory of Equipment - Checker</option>";
                                    echo "<option value='IOEN'"; if($row['AccountableOfficer_Section'] == 'IOEN'){ echo "selected='selected'";} echo ">Inventory of Equipment - Noter</option>";
                                    echo "<option value='IOECE'";if($row['AccountableOfficer_Section'] == 'IOECE'){echo "selected='selected'";} echo ">Inventory of Equipment - Certifier</option>";
                                    echo "<option value='IOEAT'";if($row['AccountableOfficer_Section'] == 'IOEAT'){echo "selected='selected'";} echo ">Inventory of Equipment - Attester</option>";
                                    echo "<option value='IOEAP'";if($row['AccountableOfficer_Section'] == 'IOEAP'){echo "selected='selected'";} echo ">Inventory of Equipment - Approver</option>";
                            echo "</select>";
                        echo "</tr>";
                    echo "</div>";
                    echo "</div>";
                    break;

        }
        mysqli_close($conn);
    }

    function updateData()
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
                    }
                }
                break;

            case 'updateDivision':
                $sql="SELECT Division_Name FROM M_Division WHERE Division_Name='".$_POST['division_name']."' AND Division_Id!='".$_POST['division_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                     echo "Duplicate Division Name detected";
                }
                else{
                    $sql='UPDATE M_Division SET Division_Name="'.$_POST['division_name'].'",Division_Description="'.$_POST['division_desc'].'", ';
                    $sql=$sql .' fkDepartment_Id="'.$_POST['department_id'].'",fkPersonnel_Id="'.$_POST['edit_chiefofficerid'].'" WHERE Division_Id= '.$_POST['division_id'].' ';
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

            case 'updateBrand':
                $sql="SELECT Brand_Name FROM M_Brand WHERE Brand_Name='".$_POST['brand_name']."' AND Brand_Id!='".$_POST['brand_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                 echo "Duplicate Brand Name detected";
                }else{
                    $sql='UPDATE M_Brand SET Brand_Name = "'.$_POST['brand_name'].'",Brand_Description = "'.$_POST['brand_desc'].'" ';
                    $sql=$sql.' WHERE Brand_Id = '.$_POST['brand_id'];
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

            case 'updateType':
                $sql="SELECT Type_Name FROM M_Type WHERE Type_Name='".$_POST['type_name']."' AND Type_ID!='".$_POST['type_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                    echo "Duplicate Type Name detected";
                }
                else{
                    $sql='UPDATE M_Type SET Type_Name = "'.$_POST['type_name'].'",Type_Description = "'.$_POST['type_desc'].'" ';
                    $sql=$sql.' WHERE Type_ID = '.$_POST['type_id'];
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

            case 'updateClassification':
                $sql="SELECT Classification_Name FROM M_Classification WHERE Classification_Name='".$_POST['classification_name']."' AND Classification_Id!='".$_POST['classification_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                   echo "Duplicate Classification Name detected";
                }
                else{
                     $sql='UPDATE M_Classification SET Classification_Name="'.$_POST['classification_name'].'",Classification_Description="'.$_POST['classification_desc'].'", ';
                     $sql=$sql .' fkType_Id="'.$_POST['type_id'].'" WHERE Classification_Id= '.$_POST['classification_id'].' ';
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

            case 'updatePersonnel':
                $sql="SELECT Personnel_Id FROM M_Personnel WHERE Personnel_Id='".$_POST['personnel_idnumber']."' AND Personnel_Id!='".$_POST['personnel_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                   echo "Duplicate Personnel Name detected";
                }
                else{
                       $sql='UPDATE M_Personnel SET Personnel_Id = "'.$_POST['personnel_idnumber'].'", Personnel_Fname = "'.$_POST['personnel_fname'].'",Personnel_Mname = "'.$_POST['personnel_mname'].'",Personnel_Lname = "'.$_POST['personnel_lname'].'",fkDivision_Id = "'.$_POST['personnel_designation'].'",Personnel_Position = "'.$_POST['personnel_position'].'" ';
                    $sql=$sql.' WHERE Personnel_Id = '.$_POST['personnel_id'];
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

            case 'updateModel':
                $sql="SELECT Model_Name FROM M_Model WHERE Model_Name='".$_POST['model_name']."' AND Model_Id!='".$_POST['model_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                   echo "Duplicate Model Name detected";
                }
                else{
                     $sql='UPDATE M_Model SET Model_Name="'.$_POST['model_name'].'",Model_Description="'.$_POST['model_desc'].'", ';
                     $sql=$sql .' fkBrand_Id="'.$_POST['brand_id'].'" WHERE Model_Id= '.$_POST['model_id'].' ';
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

            case 'updateSupplier':
                $sql="SELECT Supplier_Name FROM M_Supplier WHERE Supplier_Name='".$_POST['supplier_name']."' AND Supplier_Id!='".$_POST['supplier_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                 echo "Duplicate Supplier Name detected";
                }else{
                    $sql='UPDATE M_Supplier SET Supplier_Name = "'.$_POST['supplier_name'].'",Supplier_Description = "'.$_POST['supplier_desc'].'" ';
                    $sql=$sql.' WHERE Supplier_Id = '.$_POST['supplier_id'];
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

            case 'updateAccountableOfficer':
                $sql="SELECT AccountableOfficer_Section FROM M_AccountableOfficer WHERE AccountableOfficer_Section='".$_POST['accountableofficer_section']."' AND AccountableOfficer_Id!='".$_POST['accountableofficer_id']."'";
                $rowset=mysqli_query($conn,$sql);
                if (mysqli_num_rows($rowset)>=1)
                {
                 echo "Section filled Already!";
                }else{
                    $sql='UPDATE M_AccountableOfficer SET
                    AccountableOfficer_Name = "'.$_POST['accountableofficer_name'].'",
                    AccountableOfficer_Position = "'.$_POST['accountableofficer_position'].'",
                    fkDivision_Id = "'.$_POST['accountableofficer_division'].'",
                    AccountableOfficer_Section = "'.$_POST['accountableofficer_section'].'"
                    WHERE AccountableOfficer_Id = "'.$_POST['accountableofficer_id'].'"';
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


    function deleteData()
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
            case 'deleteDepartment':
                $sql='DELETE FROM M_Department WHERE Department_Id = '.$_POST['department_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteDivision':
                $sql='DELETE FROM M_Division WHERE Division_Id = '.$_POST['division_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteBrand':
                $sql="DELETE FROM M_Brand WHERE Brand_Id = ".$_POST['brand_id']."";
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteType':
                $sql="DELETE FROM M_Type WHERE Type_ID = ".$_POST['type_id']."";
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteClassification':
                $sql='DELETE FROM M_Classification WHERE Classification_Id = '.$_POST['classification_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deletePersonnel':
                $sql="DELETE FROM M_Personnel WHERE Personnel_Id = ".$_POST['personnel_id']."";
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteModel':
                $sql='DELETE FROM M_Model WHERE Model_Id = '.$_POST['model_id'].' ';
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteSupplier':
                $sql="DELETE FROM M_Supplier WHERE Supplier_Id = ".$_POST['supplier_id']."";
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {
                    echo mysqli_error($conn);
                }
                break;

            case 'deleteAccountableOfficer':
                $sql="DELETE FROM M_AccountableOfficer WHERE AccountableOfficer_Id = ".$_POST['accountableofficer_id']."";
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Delete Successful';
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
            case 'paginationDepartment':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name  ';
                    $sql=$sql.' LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name LIMIT  '.$offset.','.$rowsperpage.' ';
                    $result = mysqli_query($conn, $sql);
                    echo '
                         <table class="table table-hover"  id="search_table">
                                  <tr>
                                            <td class="groupNameWidth"><b>Department</b></td>
                                            <td class="groupDescWidth"><b>Description</b></td>
                                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                                            <td colspan="3" align="right"><b>Control Content</b></td>
                                  </tr>';
                    foreach ($result as $row)
                    {
                              echo "
                                <tr>
                                        <td>".$row['Department_Name']."</td>
                                        <td>".$row['Description']."</td>
                                        <td>".$row['Transdate']."</td>
                                        <td align='right'><a href='#!'><span onclick='viewDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                        <td align='right'><a href='#!'><span onclick='editDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                        <td align='right'><a href='#!'><span onclick='deleteDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

            case 'paginationDivision':
                $rowsperpage=10;
                $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                $stringToSearch =$_POST['search_string'];
                $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name,M_Personnel.*  FROM M_Division JOIN M_Department ON';
                $sql=$sql . ' M_Division.fkDepartment_Id = M_Department.Department_Id
                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=M_Division.fkPersonnel_Id
                WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name  LIMIT '.$offset.','.$rowsperpage.' ';
                $result = mysqli_query($conn, $sql);
                echo '
                    <table class="table table-hover"  id="search_table">
                             <tr>
                                       <td class="divisionNameWidth"><b>Division</b></td>
                                       <td class="divisionDescWidth"><b>Description</b></td>
                                       <td class="divisionDepartmentWidth"><b>Department</b></td>
                                       <td class="divisionTransdateWidth"><b>Chief Officer</b></td>
                                       <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                       <td colspan="3" align="right"><b>Control Content</b></td>
                             </tr>';
                    foreach ($result as $row)
                    {
                          echo "
                            <tr>
                                    <td>".$row['Division_Name']."</td>
                                    <td>".$row['Division_Description']."</td>
                                    <td>".$row['Department_Name']."</td>
                                    <td>".$row['Personnel_Lname'].", ".$row['Personnel_Fname']." ".$row['Personnel_Mname']."</td>
                                    <td>".$row['Transdate']."</td>
                                    <td align='right'><a href='#!'><span onclick='viewDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='editDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='deleteDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

              case 'paginationBrand':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql="SELECT * from M_Brand";
                    $sql=$sql ." WHERE Brand_Name LIKE '%".$stringToSearch."%' OR Brand_Description LIKE '%".$stringToSearch."%'  ORDER BY Brand_Name LIMIT   $offset,$rowsperpage";
                    $result = mysqli_query($conn, $sql);
                    echo '
                    <table class="table table-hover"  id="search_table">
                             <tr>
                                     <td class="groupNameWidth"><b>Brand Name</b></td>
                                     <td class="groupDescWidth"><b>Description</b></td>
                                     <td class="groupTransdateWidth"><b>Transdate</b></td>
                                     <td colspan="3" align="right"><b>Control Content</b></td>
                             </tr>';
                    foreach ($result as $row)
                    {
                                  echo "
                                    <tr>
                                            <td>".$row['Brand_Name']."</td>
                                            <td>".$row['Brand_Description']."</td>
                                            <td>".$row['Transdate']."</td>
                                            <td align='right'><a href='#!'><span onclick='viewBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                            <td align='right'><a href='#!'><span onclick='editBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                            <td align='right'><a href='#!'><span onclick='deleteBrand(".$row['Brand_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

            case 'paginationType':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql="SELECT * from M_Type";
                    $sql=$sql ." WHERE Type_Name LIKE '%".$stringToSearch."%' OR Type_Description LIKE '%".$stringToSearch."%'  ORDER BY Type_Name LIMIT   $offset,$rowsperpage";
                    $result = mysqli_query($conn, $sql);
                    echo '<table class="table table-hover"  id="search_table">
                        <tr>
                                <td class="groupNameWidth"><b>Type Name</b></td>
                                <td class="groupDescWidth"><b>Description</b></td>
                                <td class="groupTransdateWidth"><b>Transdate</b></td>
                                <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                    foreach ($result as $row)
    				{
    						echo "
    						<tr>
        						<td>".$row['Type_Name']."</td>
        						<td>".$row['Type_Description']."</td>
        						<td>".$row['Transdate']."</td>
        						<td align='right'><a href='#!'><span onclick='viewType(".$row['Type_ID'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
        						<td align='right'><a href='#!'><span onclick='editType(".$row['Type_ID'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
        						<td align='right'><a href='#!'><span onclick='deleteType(".$row['Type_ID'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
        					</tr>";
    				}
                    echo '</table>';
                    echo 'ajaxseparator';
                    changepagination( $_POST['page_id'],$_POST['total_pages'],$_POST['search_string']);
                    echo 'ajaxseparator';
                    echo "".$startPage."";
                    echo 'ajaxseparator';
                    echo "".$endPage."";
    		        break;

            case 'paginationClassification':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql='SELECT Classification_Id, Classification_Name, Classification_Description, M_Classification.Transdate,M_Type.Type_Name  FROM M_Classification JOIN M_Type ON';
                    $sql=$sql . ' M_Classification.fkType_Id = M_Type.Type_ID WHERE Classification_Name LIKE "%'.$stringToSearch.'%" OR Type_Description LIKE "%'.$stringToSearch.'%" OR M_Type.Type_Name LIKE "%'.$stringToSearch.'%" ORDER BY Classification_Name  LIMIT '.$offset.','.$rowsperpage.' ';
                    $result = mysqli_query($conn, $sql);
                    echo '<table class="table table-hover"  id="search_table">
                          <tr>
                                       <td class="divisionNameWidth"><b>Classification</b></td>
                                       <td class="divisionDescWidth"><b>Description</b></td>
                                       <td class="divisionDepartmentWidth"><b>Type</b></td>
                                       <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                       <td colspan="3" align="right"><b>Control Content</b></td>
                             </tr>';
                    foreach ($result as $row)
                    {
                          echo "
                            <tr>
                                    <td>".$row['Classification_Name']."</td>
                                    <td>".$row['Classification_Description']."</td>
                                    <td>".$row['Type_Name']."</td>
                                    <td>".$row['Transdate']."</td>
                                    <td align='right'><a href='#!'><span onclick='viewClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='editClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='deleteClassification(".$row['Classification_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

                case 'paginationPersonnel':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql="SELECT M_Personnel.*,M_Division.Division_Name from M_Personnel
                    INNER JOIN M_Division ON M_Division.Division_Id=M_Personnel.fkDivision_Id";
                    $sql=$sql ." WHERE M_Personnel.Personnel_Id LIKE '%".$stringToSearch."%' OR M_Personnel.Personnel_Fname LIKE '%".$stringToSearch."%' OR M_Personnel.Personnel_Mname LIKE '%".$stringToSearch."%' OR M_Personnel.Personnel_Lname LIKE '%".$stringToSearch."%' OR M_Personnel.Personnel_Position LIKE '%".$stringToSearch."%' OR M_Division.Division_Name LIKE '%".$stringToSearch."%' ORDER BY M_Personnel.Personnel_Lname LIMIT $offset,$rowsperpage";

                    $result = mysqli_query($conn, $sql);
                    echo '
                    <table class="table table-hover"  id="search_table">
                        <tr>
                               <td class="personnelIdnumberWidth"><b>ID Number</b></td>
                               <td class="personnelFNameWidth"><b>First Name</b></td>
                               <td class="personnelMNameWidth"><b>Middle Name</b></td>
                               <td class="personnelLNameWidth"><b>Last Name</b></td>
                               <td class="personnelDesignationWidth"><b>Designation</b></td>
                               <td class="personnelTransdateWidth"><b>Position</b></td>
                               <td class="personnelTransdateWidth"><b>Transdate</b></td>
                               <td colspan="3" align="right"><b>Control Content</b></td>
                        </tr>';
                        foreach ($result as $row)
    					{
    						echo "
    						<tr>
                                 <td>".$row['Personnel_Id']."</td>
                                 <td>".$row['Personnel_Fname']."</td>
                                 <td>".$row['Personnel_Mname']."</td>
                                 <td>".$row['Personnel_Lname']."</td>
                                 <td>".$row['Division_Name']."</td>
                                 <td>".$row['Personnel_Position']."</td>
                                 <td>".$row['Transdate']."</td>
                                 <td align='right'><a href='#!'><span onclick='viewPersonnel(".$row['Personnel_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                 <td align='right'><a href='#!'><span onclick='editPersonnel(".$row['Personnel_Id'].",".$row['fkDivision_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                 <td align='right'><a href='#!'><span onclick='deletePersonnel(".$row['Personnel_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                            </tr>";
    					}
                        echo '</table>';
                        echo 'ajaxseparator';
                        changepagination( $_POST['page_id'],$_POST['total_pages'],$_POST['search_string']);
                        echo 'ajaxseparator';
                        echo "".$startPage."";
                        echo 'ajaxseparator';
                        echo "".$endPage."";
        		        break;

                case 'paginationModel':
                        $rowsperpage=10;
                        $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                        $stringToSearch =$_POST['search_string'];
                        $sql='SELECT Model_Id, Model_Name, Model_Description, M_Model.Transdate,M_Brand.Brand_Name  FROM M_Model JOIN M_Brand ON';
                        $sql=$sql . ' M_Model.fkBrand_Id = M_Brand.Brand_ID WHERE Model_Name LIKE "%'.$stringToSearch.'%" OR Brand_Description LIKE "%'.$stringToSearch.'%" OR M_Brand.Brand_Name LIKE "%'.$stringToSearch.'%" ORDER BY Model_Name  LIMIT '.$offset.','.$rowsperpage.' ';
                        $result = mysqli_query($conn, $sql);
                        echo '<table class="table table-hover"  id="search_table">
                             <tr>
                                       <td class="divisionNameWidth"><b>Model</b></td>
                                       <td class="divisionDescWidth"><b>Description</b></td>
                                       <td class="divisionDepartmentWidth"><b>Brand</b></td>
                                       <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                       <td colspan="3" align="right"><b>Control Content</b></td>
                             </tr>';
                        foreach ($result as $row)
                        {
                          echo "
                            <tr>
                                    <td>".$row['Model_Name']."</td>
                                    <td>".$row['Model_Description']."</td>
                                    <td>".$row['Brand_Name']."</td>
                                    <td>".$row['Transdate']."</td>
                                    <td align='right'><a href='#!'><span onclick='viewModel(".$row['Model_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='editModel(".$row['Model_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                    <td align='right'><a href='#!'><span onclick='deleteModel(".$row['Model_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

                case 'paginationSupplier':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql="SELECT * from M_Supplier";
                    $sql=$sql ." WHERE Supplier_Name LIKE '%".$stringToSearch."%' OR Supplier_Description LIKE '%".$stringToSearch."%'  ORDER BY Supplier_Name LIMIT   $offset,$rowsperpage";
                    $result = mysqli_query($conn, $sql);
                    echo '
                    <table class="table table-hover"  id="search_table">
                             <tr>
                                     <td class="groupNameWidth"><b>Supplier Name</b></td>
                                     <td class="groupDescWidth"><b>Description</b></td>
                                     <td class="groupTransdateWidth"><b>Transdate</b></td>
                                     <td colspan="3" align="right"><b>Control Content</b></td>
                             </tr>';
                    foreach ($result as $row)
                    {
                                  echo "
                                    <tr>
                                            <td>".$row['Supplier_Name']."</td>
                                            <td>".$row['Supplier_Description']."</td>
                                            <td>".$row['Transdate']."</td>
                                            <td align='right'><a href='#!'><span onclick='viewSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                            <td align='right'><a href='#!'><span onclick='editSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                            <td align='right'><a href='#!'><span onclick='deleteSupplier(".$row['Supplier_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

                case 'paginationAccountableOfficer':
                    $rowsperpage=10;
                    $offset = ($_POST['page_id'] - 1) * $rowsperpage;
                    $stringToSearch =$_POST['search_string'];
                    $sql="SELECT M_AccountableOfficer.*, M_Division.Division_Name from M_AccountableOfficer
                    INNER JOIN M_Division ON M_Division.Division_Id=M_AccountableOfficer.fkDivision_Id
                    WHERE AccountableOfficer_Name LIKE '%".$stringToSearch."%'
                    OR AccountableOfficer_Position LIKE '%".$stringToSearch."%'
                    OR AccountableOfficer_Position LIKE '%".$stringToSearch."%'
                    OR AccountableOfficer_Section LIKE '%".$stringToSearch."%'
                    OR Division_Name LIKE '%".$stringToSearch."%'
                    ORDER BY AccountableOfficer_Name LIMIT $offset,$rowsperpage";

                    $result = mysqli_query($conn, $sql);
                    echo '
                    <table class="table table-hover"  id="search_table">
                             <tr>
                               <td style=" width: 20%"><b>Name</b></td>
                               <td style=" width: 20%"><b>Position</b></td>
                               <td style=" width: 20%"><b>Division</b></td>
                               <td style=" width: 20%"><b>Section</b></td>
                               <td  style=" width: 10%" colspan="3" align="center"><b>Manage</b></td>
                             </tr>';
                    foreach ($result as $row)
                    {
                            echo "
                            <tr>
                              <td>".$row['AccountableOfficer_Name']."</td>
                              <td>".$row['AccountableOfficer_Position']."</td>
                              <td>".$row['Division_Name']."</td>
                              <td>".$row['AccountableOfficer_Section']."</td>
                              <td align='center'><a href='#!'><span onclick='AccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                              <td align='center'><a href='#!'><span onclick='AccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                              <td align='center'><a href='#!'><span onclick='AccountableOfficer(".$row['AccountableOfficer_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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