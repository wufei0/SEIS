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
              echo "Cannot save blank Group Name";
        }
        else
        {
       
           if (verify_duplicate('Group'))
           {
               echo "Duplicate Group Name detected";
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
        
        
    case 'viewUser':
        
        viewData($_POST['user_id']);
        break;
    
    case 'editUser':
        viewEditData($_POST['user_id']);
        break;
        
    case 'updateUser':
        
            if((strlen($_POST['user_name']))==0)
        {
              echo "Cannot Save blank User Name";
              die();
        }
//        if (verify_duplicate('Group'))
//        {
//            echo "Group Name already exist.";
//            die();
//        }
        updateData();
        break;
        
     case 'deleteUser':
        deleteData();
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
                  echo 'Group added successfully';
            }
            else
            {
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;

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
                echo mysqli_error($conn);
                echo '<br>';
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
           echo '   <table class="table table-hover fixed" id="search_sample">
                    <tr>
                    <div class="row">
                        <div class="col-md-11">

                            <td class="groupNameWidth"><b>Group Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>

                        </div>
                        <div class="col-md-1">
                            <td colspan="3" align="right"><b>Control Content</b></td>
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
                        <td class='groupNameWidth'>".$row['Security_GroupName']."</td>
                        <td class='groupDescWidth'>".$row['Security_GroupDescription']."</td>
                        <td class='groupTransdateWidth'>".$row['Transdate']."</td>
                       
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
            $sql='SELECT Security_UserId,Security_UserName,Security_FullName,Designation,Security_User.Transdate,Security_GroupName, Security_GroupId from Security_User';
            $sql=$sql.' JOIN Security_Group ON Security_User.fkSecurity_Groupid = Security_Group.Security_GroupId ';
            $sql=$sql.' WHERE Security_UserName LIKE "%'.$stringToSearch.'%" OR Security_FullName LIKE "%'.$stringToSearch.'%" ';
            $sql=$sql.' OR Security_GroupName LIKE "%'.$stringToSearch.'%" ORDER BY Security_UserName ';
            $resultSet=  mysqli_query($conn, $sql);
           echo '   <table class="table table-hover" id="search_table">
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
                    <tr>';
            
            foreach ($resultSet as $row)
            {
                echo "
                <div class='row'>
                  <div >    
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
            $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
//            foreach ($resultSet as $row)
//            {
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
                 
                
//            }
            break;
            
            
        case 'viewUser':
            $sql='SELECT Security_UserName, Security_FullName, Designation,Security_User.Transdate, Security_GroupName ';
            $sql=$sql.' FROM Security_User JOIN Security_Group ON Security_User.fkSecurity_GroupiD = Security_Group.Security_GroupId';
            $sql=$sql.' WHERE Security_UserId = '.$_POST['user_id'].' ';
            $resultSet=  mysqli_query($conn, $sql);
            $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
//            foreach ($resultSet as $row)
//            {
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>User Name:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Security_UserName']."'></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Security_FullName']."'></td>
                    </tr>
                    <tr>
                        <td>Designation:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Designation']."'></td>
                    </tr>
                    <tr>
                        <td>Group:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Security_GroupName']."'></td>
                    </tr>
                    <tr>
                        <td>Transaction Date:</td>
                        <td class='desc-width'><input  readonly='readonly'  type='text' class='form-control' value='".$row['Transdate']."'></td>
                    </tr>
                </table>";
                echo "</div>";
                echo "</div>";
                 
                
//            }
           
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
                
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
//                foreach ($resultSet as $row)
//            {
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
                 
                
//                }
                break;
            
            case 'editUser':
                $sql='SELECT Security_UserName,Security_FullName,Designation,Security_GroupName, Security_GroupId from Security_User';
                $sql=$sql.' JOIN Security_Group ON Security_User.fkSecurity_Groupid = Security_Group.Security_GroupId ';
                $sql=$sql." WHERE Security_UserId = ".$_POST["user_id"]."";
                $resultSet=  mysqli_query($conn, $sql);
                
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
            
                
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>User Name:</td>
                        <td class='desc-width'><input id='mymodal_user_name'    type='text' class='form-control' value='".$row['Security_UserName']."'></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td class='desc-width'><input id='mymodal_full_name'    type='text' class='form-control' value='".$row['Security_FullName']."'></td>
                    </tr>
                    <tr>
                        <td>Designation:</td>
                        <td class='desc-width'><input   id='mymodal_designation' type='text' class='form-control' value='".$row['Designation']."'></td>
                    </tr>
                    <tr> <td>Group:</td><td class='desc-width'>";
                    
                    $groupid=$row['Security_GroupId'];
                    //$conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                    $sql="SELECT Security_GroupID, Security_GroupName,Security_GroupDescription FROM Security_Group ORDER BY Security_GroupName";
                    $resultset=  mysqli_query($conn, $sql);
                    echo "<select id='mymodal_group_id' class='form-control input-size'>";
                    foreach($resultset as $rows)
                    {
                        if($rows['Security_GroupID']==$groupid)
                        {
                            echo "<option value=".$rows['Security_GroupID']." selected>".$rows['Security_GroupName']."</option>";
                        }
                        else
                        {
                            echo "<option value=".$rows['Security_GroupID'].">".$rows['Security_GroupName']."</option>";
                        }
                        
                    }
                    echo "</select>";
                       
                        
                    
                    echo "</td></tr>
                    
                    <tr>
                        
                    </tr>
                    
                </table>";
                echo "</div>";
                echo "</div>";
                
                
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
                
                echo mysqli_error($conn);
                echo '<br>';
                echo $sql;
            }
            
            break;
            
        case 'updateUser':
            $sql='UPDATE Security_User SET Security_UserName="'.$_POST['user_name'].'", Security_FullName="'.$_POST['full_name'].'", Designation="'.$_POST['vardesignation'].'" ';
            $sql=$sql.' ,fkSecurity_Groupid='.$_POST['groupId']." WHERE Security_UserId = ".$_POST['user_id']." ";
            
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
           case 'deleteGroup':
               $sql="DELETE FROM Security_Group WHERE Security_GroupID = ".$_POST['group_id']." ";
                $resultSet=  mysqli_query($conn, $sql);

                if ($resultSet)
                {
                    echo 'Group Deleted';
                }
                else
                {

                    echo mysqli_error($conn);
                    echo '<br>';
                    echo $sql;
                }
               break;
               
           case 'deleteUser':
               $sql="DELETE FROM Security_User WHERE Security_UserId = ".$_POST['user_id']." ";
                $resultSet=  mysqli_query($conn, $sql);

                if ($resultSet)
                {
                    echo 'User Deleted';
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


?>