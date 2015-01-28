<?php

include("../connection.php");
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
         if((strlen($_POST['division_name']))==0)
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
        updateData();
        break;
    
    case 'deleteDivision':
        deleteData();
        break;
    
    case 'paginationDivision':
         pagination();
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
            if ($verify_duplicate==true)
            {
                return true;
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
           // global $group_name;
            $sql="SELECT Type_Name FROM M_Type WHERE Type_Name='".$_POST['type_name']."'";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
              $verify_duplicate=true;
            }
            break;
             
}
    mysqli_close($conn);
}

function createData()
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
                echo '<br>';
                echo $sql;
            }
             break;

        
        case 'addDivision':
            $sql="INSERT INTO M_Division(Division_Name,Division_Description,fkDepartment_Id) values('".$_POST['division_name']."','".$_POST['desc_name']."',".$_POST['department_id'].") ";
            $resultset=mysqli_query($conn,$sql);

            if ($resultset)
            {
                echo 'Division added successfully';
            }
            else
            {
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;  
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
                echo '<br>';
                echo $sql;

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
                    echo '<br>';
                    echo $sql;
                }
                break;
    }
 mysqli_close($conn);
}


function searchText($stringToSearch)
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
        
        case 'searchDepartment':
            
            $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name LIMIT 0,10';
            //$sql=$sql . ' WHERE Department_Name LIKE '%".$stringToSearch."%' OR Description LIKE '%".$stringToSearch."%' ORDER BY Department_Name LIMIT 0,10';
            $sqlcount='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name';
            //$sqlcount=$sqlcount . ' WHERE Department_Name LIKE '%".$stringToSearch."%' OR Description LIKE '%".$stringToSearch."%' ORDER BY Department_Name ';
          
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
                    </tr>
                    ';
            
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

                          <ul class="rev-pagination pagination" id="change_button">
                            <li><a href="#!"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                            while($num<=$totalpages){
                                 echo "  <li><a href='#!' onclick=paginationButton('".$num."','".$stringToSearch."');>".$num."</a></li>  ";
                                 $num++;
                            }
                            echo "<li><a href='#!');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                            echo '
                          </ul>

                        </nav>
                                </div>
                        </div>
                    </div>';
                break;
            
            
        case 'searchDivision':
            
            $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name  FROM M_Division JOIN M_Department ON';
            $sql=$sql . ' M_Division.fkDepartment_Id = M_Department.Department_Id WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name LIMIT 0,10';
            $sqlcount='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name  FROM M_Division JOIN M_Department ON';
            $sqlcount=$sqlcount . ' M_Division.fkDepartment_Id = M_Department.Department_Id WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name ';
          
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
                            <td class="divisionTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                    </tr>
                    ';
            
            foreach ($resultSet as $row)
            {
                echo "
                <tr>
                        <td>".$row['Division_Name']."</td>
                        <td>".$row['Division_Description']."</td>
                        <td>".$row['Department_Name']."</td>   
                        <td>".$row['Transdate']."</td>
                        <td align='right'><a href='#!'><span onclick='viewDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td align='right'><a href='#!'><span onclick='editDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td align='right'><a href='#!'><span onclick='deleteDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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

                          <ul class="rev-pagination pagination" id="change_button">
                            <li><a href="#!"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                            while($num<=$totalpages){
                                 echo "  <li><a href='#!' onclick=paginationButton('".$num."','".$stringToSearch."');>".$num."</a></li>  ";
                                 $num++;
                            }
                            echo "<li><a href='#!');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                            echo '
                          </ul>

                        </nav>
                                </div>
                        </div>
                    </div>';
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
                                    <td class="groupDescWidth"><b>Brand Description</b></td>
                                    <td class="groupTransdateWidth"><b>Transdate</b></td>
                                    <td colspan="3" align="right"><b>Control Content</b></td>
                            </tr>
                            ';

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

                                                      <ul class="rev-pagination pagination" id="change_button">
                                                        <li><a href="#!"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                                                        while($num<=$totalpages){
                                                             echo "  <li><a href='#!' onclick=paginationButton('".$num."','".$stringToSearch."');>".$num."</a></li>  ";
                                                             $num++;
                                                        }
                                                        echo "<li><a href='#!');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                                                        echo '
                                                      </ul>

                                                    </nav>
                                                            </div>
                                                    </div>
                                                </div>';

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
                    echo '
                    <div class="panel-body bodyul" style="overflow: auto">
                    <table class="table table-hover fixed"  id="search_table">
                            <tr>
                                    <td class="groupNameWidth"><b>Type Name</b></td>
                                    <td class="groupDescWidth"><b>Type Description</b></td>
                                    <td class="groupTransdateWidth"><b>Transdate</b></td>
                                    <td colspan="3" align="right"><b>Control Content</b></td>
                            </tr>
                            ';

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

                                                      <ul class="rev-pagination pagination" id="change_button">
                                                        <li><a href="#!"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                                                        while($num<=$totalpages){
                                                             echo "  <li><a href='#!' onclick=paginationButton('".$num."','".$stringToSearch."');>".$num."</a></li>  ";
                                                             $num++;
                                                        }
                                                        echo "<li><a href='#!');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                                                        echo '
                                                      </ul>

                                                    </nav>
                                                            </div>
                                                    </div>
                                                </div>';

                    break;
            }
    
    mysqli_close($conn);
}


function viewData($id)
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
    
            $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name  FROM M_Division JOIN M_Department ON';
            $sql=$sql. ' M_Division.fkDepartment_Id = M_Department.Department_Id WHERE Division_Id='.$id.' ';
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
                            <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Brand_Name']."'></td>
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
               
    } 
    
    //mysqli_free_result($row);
    mysqli_close($conn);
}

function viewEditData($id)
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
                        <td class='desc-width'><input  id='mymodal_department' type='text' class='form-control' value='".$row['Department_Name']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input  id='mymodal_department_description'  type='text' class='form-control' value='".$row['Description']."'></td>
                    </tr>

                </table>";
            echo "</div>";
            echo "</div>";
            
            break;

        
        case 'editDivision':
            $sql='SELECT Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name,fkDepartment_Id  FROM M_Division JOIN M_Department ON';
            $sql=$sql. ' M_Division.fkDepartment_Id = M_Department.Department_Id WHERE Division_Id='.$id.' ';
            $resultSet=  mysqli_query($conn, $sql);
            $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);  
            $deptid=$row['fkDepartment_Id'];
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
			echo "<table>
                    <td>Division:</td>
                        <td class='desc-width'><input id='mymodal_division_name'   type='text' class='form-control' value='".$row['Division_Name']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input id='mymodal_division_description'   type='text' class='form-control' value='".$row['Division_Description']."'></td>
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
                        <td class='desc-width'><input id='mymodal_brand_name' name='brand_name'  type='text' class='form-control' value='".$row['Brand_Name']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input id='mymodal_brand_desc' name='brand_desc' type='text' class='form-control' value='".$row['Brand_Description']."'></td>
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
                        <td class='desc-width'><input id='mymodal_type_name' name='type_name'  type='text' class='form-control' value='".$row['Type_Name']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input id='mymodal_type_desc' name='type_desc' type='text' class='form-control' value='".$row['Type_Description']."'></td>
                    </tr>


                </table>";
                echo "</div>";
                echo "</div>";

                break;
        




    }
    
   // mysqli_free_result($row);
    mysqli_close($conn);
}



function updateData()
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
         
        case 'updateDepartment':
            $sql='UPDATE M_Department SET Department_Name ="'.$_POST['department_name'].'", Description="'.$_POST['department_desc'].'" ';
            $sql=$sql.' WHERE Department_Id = '.$_POST['department_id'].' ';
            
            
            $resultSet=  mysqli_query($conn, $sql);
            
            if ($resultSet)
            {
                echo 'Saved';
            }
            else
            {
                
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;

            
        case 'updateDivision':
            $sql='UPDATE M_Division SET Division_Name="'.$_POST['division_name'].'",Division_Description="'.$_POST['division_desc'].'", ';
            $sql=$sql .' fkDepartment_Id="'.$_POST['department_id'].'" WHERE Division_Id= '.$_POST['division_id'].' ';
            $resultSet=  mysqli_query($conn, $sql);
        
            if ($resultSet)
            {
                echo 'Saved';
            }
            else
            {
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;
        
            case 'updateBrand':
            $sql='UPDATE M_Brand SET Brand_Name = "'.$_POST['brand_name'].'",Brand_Description = "'.$_POST['brand_desc'].'" ';
            $sql=$sql.' WHERE Brand_Id = '.$_POST['brand_id'];

            $resultSet=  mysqli_query($conn, $sql);
            if ($resultSet)
            {
                echo 'Saved';
            }
            else
            {
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;


        case 'updateType':
            $sql='UPDATE M_Type SET Type_Name = "'.$_POST['type_name'].'",Type_Description = "'.$_POST['type_desc'].'" ';
            $sql=$sql.' WHERE Type_ID = '.$_POST['type_id'];
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Saved';
            }
            else
            {

                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;
    }
    
    mysqli_close($conn);
}


function deleteData()
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
         
        case 'deleteDepartment':
            
            $sql='DELETE FROM M_Department WHERE Department_Id = '.$_POST['department_id'].' ';
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Department Deleted';
            }
            else
            {

                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;

            
        case 'deleteDivision':
            $sql='DELETE FROM M_Division WHERE Division_Id = '.$_POST['division_id'].' ';
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Division Deleted';
            }
            else
            {

                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;


        case 'deleteBrand':
            $sql="DELETE FROM M_Brand WHERE Brand_Id = ".$_POST['brand_id']."";
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Brand Deleted';
            }
            else
            {

                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            break;

        case 'deleteType':
            $sql="DELETE FROM M_Type WHERE Type_ID = ".$_POST['type_id']."";
            $resultSet=  mysqli_query($conn, $sql);

            if ($resultSet)
            {
                echo 'Type Deleted';
            }
            else
            {

                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
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
                //$sql=$sql ." WHERE Security_GroupName LIKE '%".$stringToSearch."%' OR Security_GroupDescription LIKE '%".$stringToSearch."%'  ORDER BY Security_GroupName LIMIT   $offset,$rowsperpage";
                $result = mysqli_query($conn, $sql);
                echo '
                     <table class="table table-hover"  id="search_table">
                              <tr>
                                        <td class="groupNameWidth"><b>Department</b></td>
                                        <td class="groupDescWidth"><b>Description</b></td>
                                        <td class="groupTransdateWidth"><b>Transdate</b></td>
                                        <td colspan="3" align="right"><b>Control Content</b></td>
                              </tr>
                              ';
            // while there are rows to be fetched...
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
                            </tr>
                       ";
                          }
                        echo ' </table>';
                        break;

        case 'paginationDivision':
            $rowsperpage=10;
            $offset = ($_POST['page_id'] - 1) * $rowsperpage;
            $stringToSearch =$_POST['search_string'];
//                $sql='SELECT Department_Id, Department_Name, Description, Transdate FROM M_Department WHERE Department_Name  ';
//                $sql=$sql.' LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" ORDER BY Department_Name LIMIT  '.$offset.','.$rowsperpage.' ';
                //$sql=$sql ." WHERE Security_GroupName LIKE '%".$stringToSearch."%' OR Security_GroupDescription LIKE '%".$stringToSearch."%'  ORDER BY Security_GroupName LIMIT   $offset,$rowsperpage";
            $sql='SELECT Division_Id, Division_Name, Division_Description, M_Division.Transdate,M_Department.Department_Name  FROM M_Division JOIN M_Department ON';
            $sql=$sql . ' M_Division.fkDepartment_Id = M_Department.Department_Id WHERE Division_Name LIKE "%'.$stringToSearch.'%" OR Description LIKE "%'.$stringToSearch.'%" OR M_Department.Department_Name LIKE "%'.$stringToSearch.'%" ORDER BY Division_Name  LIMIT '.$offset.','.$rowsperpage.' ';
            $result = mysqli_query($conn, $sql);
            echo '
                <table class="table table-hover"  id="search_table">
                         <tr>
                                   <td class="divisionNameWidth"><b>Division</b></td>
                                   <td class="divisionDescWidth"><b>Description</b></td>
                                   <td class="divisionDepartmentWidth"><b>Department</b></td>
                                   <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                   <td colspan="3" align="right"><b>Control Content</b></td>
                         </tr>
                         ';
                // while there are rows to be fetched...
                foreach ($result as $row)
                    {
                      echo "
                        <tr>
                                <td>".$row['Division_Name']."</td>
                                <td>".$row['Division_Description']."</td>
                                <td>".$row['Department_Name']."</td>   
                                <td>".$row['Transdate']."</td>
                                <td align='right'><a href='#!'><span onclick='viewDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                                <td align='right'><a href='#!'><span onclick='editDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                                <td align='right'><a href='#!'><span onclick='deleteDivision(".$row['Division_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                        </tr>
                   ";
                      }
                echo ' </table>';
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
                         </tr>
                         ';
// while there are rows to be fetched...
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
                                </tr>
                           ";
                              }
                    echo '</table>';
                    break;
                    

        case 'paginationType':
            $rowsperpage=10;
            $offset = ($_POST['page_id'] - 1) * $rowsperpage;
            $stringToSearch =$_POST['search_string'];
            $sql="SELECT * from M_Type";
            $sql=$sql ." WHERE Type_Name LIKE '%".$stringToSearch."%' OR Type_Description LIKE '%".$stringToSearch."%'  ORDER BY Type_Name LIMIT   $offset,$rowsperpage";
            $result = mysqli_query($conn, $sql);
            echo '
                <table class="table table-hover"  id="search_table">
                    <tr>
                            <td class="groupNameWidth"><b>Type Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                    </tr>
                    ';
// while there are rows to be fetched...
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
						</tr>
						";
					}
                echo '</table>';
				break;


      }
       mysqli_close($conn);
  }             
?>