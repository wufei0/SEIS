<?php
include("../../connection.php");
if (!isset($_POST['module']))
{
    die();
}


switch ($_POST['module'])
{
//<!-------------------------GROUP-------------------------------->
    case 'addGroup':
        if(isset($_POST['group_name']))
        {
              $group_name=$_POST['group_name'];
              $desc_name=$_POST['desc_name'];
        }

        if((strlen($group_name))==0)
        {
              echo "empty";
        }
        else
        {
       
           if (verify_duplicate('Group'))
           {
               echo "duplicate";
               die();
           }
           createData();
        }
        break;
        
    case 'searchGroup':
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
        
    case 'viewGroup':
        
        viewData($_POST['group_id']);
        break;
    
    case 'editGroup':
       
        viewEditData($_POST['group_id']);
        break;
    
    case 'updateGroup':
        
            if((strlen($_POST['group_name']))==0)
        {
              echo "Cannot Save blank Group Name";
              die();
        }
//        if (verify_duplicate('Group'))
//        {
//            echo "Group Name already exist.";
//            die();
//        }
        updateData();
        break;
    
    
    case 'deleteGroup':
        deleteData();
        break;
    
    //<!-------------------------end GROUP-------------------------------->
    
    //<!-------------------------USER-------------------------------->
    case 'addUser':
       if(isset($_POST['user_name']))
        {
              $user_name=$_POST['user_name'];
              $full_name=$_POST['full_name'];
              $designation=$_POST['designation'];
              $groupid=$_POST['group_id'];
        }

        if((strlen($user_name))==0)
        {
              echo "Cannot save blank User Name";
              die();
        }
        if((strlen($full_name))==0)
        {
              echo "Cannot save blank Name";
              die();
        }
        
        if (verify_duplicate('User'))
        {
            echo "User Name already exist.";
            die();
        }
        
        createData();
        break;
        
    case 'searchUser':
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
}
    //<!-------------------------end USER--------------------------------> 

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
          case 'addGroup':
            global $group_name;
            global $desc_name;
            $sql="INSERT INTO Security_Group(Security_GroupName,Security_GroupDescription) values('".$group_name."','".$desc_name."') ";
            $resultset=mysqli_query($conn,$sql);
            if ($resultset)
            {
                  echo 'save';
            }
            else
            {
                  echo 'error';

            }
            mysqli_close($conn);
            break;
            
          case 'addUser':
            $sql="INSERT INTO Security_User(Security_UserName,Security_FullName,Designation,fkSecurity_Groupid) ";
            $sql=$sql ." VALUES ('".$_POST['user_name']."','".$_POST['full_name']."','".$_POST['designation']."',".$_POST['group_id'].") ";
            $resultset=mysqli_query($conn,$sql);
            if ($resultset)
            {
                echo 'User Name added successfully';
            }
            else
            {
                echo 'Something went wrong. <br><br>';
                echo $sql;

            }
                mysqli_close($conn);
                break;
              
            }
      

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
       
    case 'Group':
           // global $group_name;
            $sql="SELECT Security_GroupName FROM Security_Group WHERE Security_GroupName='".$_POST['group_name']."'";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
              $verify_duplicate=true;

            }
            
            break;
    
    case 'User':
            $sql='SELECT Security_UserName from Security_User WHERE Security_UserName ="'.$_POST['user_name'].'" ';
            $rowset=mysqli_query($conn,$sql);

            if (mysqli_num_rows($rowset)>=1)
            {
              $verify_duplicate=true;

            }
            break;
      
     }
           if ($verify_duplicate==true)
           {
             return true;
           }
           else
           {
             return false;
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
        case 'searchGroup':
            $sql='SELECT Security_GroupId, Security_GroupName, Security_GroupDescription,Transdate from Security_Group';
            $sql=$sql .' WHERE Security_GroupName LIKE "%'.$stringToSearch.'%" OR Security_GroupDescription LIKE "%'.$stringToSearch.'%"  ORDER BY Security_GroupName';
            $resultSet=  mysqli_query($conn, $sql);
           echo '   <table class="table table-hover" id="search_sample">
                    <tr>
                    <div class="row">
                        <div class="col-md-11">

                            <td class="groupNameWidth"><b>Group Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>

                        </div>
                        <div class="col-md-1">
                            <td colspan="3" align="center"><b>Control Content</b></td>
                        </div>
                    </div>
                    </tr>
                    <tr>';
            
            foreach ($resultSet as $row)
            {
                echo "
                <div class='row'>
                  <div >    
                    <div class='col-md-11'>
                        <td>".$row['Security_GroupName']."</td>
                        <td>".$row['Security_GroupDescription']."</td>
                        <td>".$row['Transdate']."</td>
                       
                    </div>

                    <div class='col-md-1'>
                        <td><a href='#!'><span onclick='viewGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </div>
                  </div> 
                </div>
                </tr>
            </table>";
                
            }
            
            break;
            
        case 'searchUser':
            $sql='SELECT Security_UserId,Security_UserName,Security_FullName,Designation,Transdate from Security_User';
            $sql=$sql .' WHERE Security_UserName LIKE "%'.$stringToSearch.'%" OR Security_FullName LIKE "%'.$stringToSearch.'%" ORDER BY Security_UserName';
            $resultSet=  mysqli_query($conn, $sql);
           echo '   <table class="table table-hover" id="search_table">
                    <tr>
                    <div class="row">
                        <div class="col-md-11">

                            <td class="userNameWidth"><b>User Name</b></td>
                            <td class="userFullNameWidth"><b>Full Name</b></td>
                            <td class="userDesignWidth"><b>Designation</b></td>
                            <td class="userTransdateWidth"><b>Transdate</b></td>

                        </div>
                        <div class="col-md-1">
                            <td colspan="3" align="center"><b>Control Content</b></td>
                        </div>
                    </div>
                    </tr>
                    <tr>';
            
            foreach ($resultSet as $row)
            {
                echo "
                <div class='row'>
                  <div >    
                    <div class='col-md-11'>
                        <td>".$row['Security_UserName']."</td>
                        <td>".$row['Security_FullName']."</td>
                        <td>".$row['Designation']."</td>
                        <td>".$row['Transdate']."</td>
                       
                    </div>

                    <div class='col-md-1'>
                        <td><a href='#!'><span onclick='viewUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </div>
                  </div> 
                </div>
                </tr>
            </table>";
                
            }
            break;
    }
    
        mysqli_free_result($resultSet);
        mysqli_close($conn);
}


function viewData($id)
{
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
    
    switch ($_POST['module'])
    {
        case 'viewGroup':
            $sql='SELECT Security_GroupName, Security_GroupDescription, Transdate from Security_Group WHERE ';
            $sql=$sql. ' Security_GroupId = '.$id.' ';
            $resultSet=  mysqli_query($conn, $sql);
            
            foreach ($resultSet as $row)
            {
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>Group Name:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Security_GroupName']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Security_GroupDescription']."'></td>
                    </tr>
                    <tr>
                        <td>Transaction Date:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                    </tr>
                </table>";
                echo "</div>";
                echo "</div>";
                 
                
            }
            break;
            
            
            
    }
    
        //mysqli_free_result($resultSet);
        mysqli_close($conn);
    
}

function viewEditData($id)
    {
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
    
        switch ($_POST['module'])
        {
            case 'editGroup':
                $sql='SELECT Security_GroupName, Security_GroupDescription from Security_Group WHERE ';
                $sql=$sql. ' Security_GroupId = '.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                
                foreach ($resultSet as $row)
            {
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>Group Name:</td>
                        <td class='desc-width'><input id='mymodal_group_name' name='group_name'  type='text' class='form-control' value='".$row['Security_GroupName']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input id='mymodal_group_desc' name='group_desc' type='text' class='form-control' value='".$row['Security_GroupDescription']."'></td>
                    </tr>
                    
                </table>";
                echo "</div>";
                echo "</div>";
                 
                
            }
            break;
                
                
                
        }
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
            
        case 'updateGroup':
            $sql='UPDATE Security_Group SET Security_GroupName = "'.$_POST['group_name'].'",Security_GroupDescription = "'.$_POST['group_desc'].'" ';
            $sql=$sql.' WHERE Security_GroupId = '.$_POST['group_id'];
            
            $resultSet=  mysqli_query($conn, $sql);
            
            if ($resultSet)
            {
                echo 'Saved';
            }
            else
            {
                
                echo 'Update failed';
            }
           
        
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
        
        $sql="DELETE FROM Security_Group WHERE Security_GroupID = ".$_POST['group_id']." ";
        $resultSet=  mysqli_query($conn, $sql);
            
        if ($resultSet)
        {
            echo 'Group Deleted';
        }
        else
        {

            echo 'Deleted failed';
        }
        
        mysqli_close($conn);
    }


?>