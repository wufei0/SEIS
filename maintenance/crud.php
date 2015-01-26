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
        mysqli_close($conn);
        break;
            
       
    }
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
                    <div class="row">
                        <div class="col-md-11">
                            <td class="groupNameWidth"><b>Department</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                        </div>
                        <div class="col-md-1">
                            <td colspan="3" align="right"><b>Control Content</b></td>
                        </div>
                    </div>
                    </tr>
                    ';
            
            foreach ($resultSet as $row)
            {
                echo "
                <tr>
                  <div class='row'>
                    <div class='col-md-11'>
                        <td>".$row['Department_Name']."</td>
                        <td>".$row['Description']."</td>
                        <td>".$row['Transdate']."</td>
                    </div>
                    <div class='col-md-1'>
                        <td><a href='#!'><span onclick='viewDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteDepartment(".$row['Department_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </div>
                </div>
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
                      <div class="row">
                          <div class="col-md-11">
                                <td class="groupNameWidth"><b>Department</b></td>
                                <td class="groupDescWidth"><b>Description</b></td>
                                <td class="groupTransdateWidth"><b>Transdate</b></td>
                          </div>
                          <div class="col-md-1">
                              <td colspan="3" align="center"><b>Control Content</b></td>
                          </div>
                      </div>
                      </tr>
                      ';
    // while there are rows to be fetched...
    foreach ($result as $row)
                {
                  echo "
                    <tr>
                      <div class='row'>
                        <div class='col-md-11'>
                            <td>".$row['Department_Name']."</td>
                            <td>".$row['Description']."</td>
                            <td>".$row['Transdate']."</td>
                        </div>
                        <div class='col-md-1'>
                            <td><a href='#!'><span onclick='viewGroup(".$row['Department_Id'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td><a href='#!'><span onclick='editGroup(".$row['Department_Id'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td><a href='#!'><span onclick='deleteGroup(".$row['Department_Id'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                        </div>
                    </div>
                    </tr>
               ";
                  }
                          echo ' </table>';
                break;
      }
  }





    function pageUser(){
       global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
      $rowsperpage=10;
      $offset = ($_POST['page_id'] - 1) * $rowsperpage;
      $stringToSearch =$_POST['search_string'];
      $sql="SELECT Security_UserId,Security_UserName,Security_FullName,Designation,Security_User.Transdate,Security_GroupName, Security_GroupId from Security_User";
      $sql=$sql." JOIN Security_Group ON Security_User.fkSecurity_Groupid = Security_Group.Security_GroupId ";
      $sql=$sql." WHERE Security_UserName LIKE '%".$stringToSearch."%' OR Security_FullName LIKE '%".$stringToSearch."%'";
      $sql=$sql." OR Security_GroupName LIKE '%".$stringToSearch."%' ORDER BY Security_UserName LIMIT $offset,$rowsperpage";
      $result = mysqli_query($conn, $sql);
      echo '
          <table class="table table-hover"  id="search_table">
                    <tr>
                    <div class="row">
                        <div class="col-md-11">
                            <td class="userNameWidth"><b>User Name</b></td>
                                <td class="userFullNameWidth"><b>Full Name</b></td>
                                <td class="userDesignWidth"><b>Designation</b></td>
                                <td class="userGroupWidth"><b>Group</b></td>
                                <td class="userTransdateWidth"><b>Transdate</b></td>

                        </div>
                        <div class="col-md-1">
                            <td colspan="3" align="right"><b>Control Content</b></td>
                        </div>
                    </div>
                    </tr>
                    ';
// while there are rows to be fetched...
foreach ($result as $row)
            {
            echo "
                 <tr>
                <div class='row'>
                    <div class='col-md-11'>
                        <td class='userNameWidth'>".$row['Security_UserName']."</td>
                        <td class='userFullNameWidth'>".$row['Security_FullName']."</td>
                        <td class='userDesignWidth'>".$row['Designation']."</td>
                        <td class='userGroupWidth'>".$row['Security_GroupName']."</td>
                        <td class='userTransdateWidth'>".$row['Transdate']."</td>
                    </div>
                    <div class='col-md-1'>
                        <td><a href='#!'><span onclick='viewUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editUser(".$row['Security_UserId'].",".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </div>
                </div>
                </tr>";
              }
                      echo ' </table>';
    }
