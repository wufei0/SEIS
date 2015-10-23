<?php
include("../../connection.php");
include("../../security.php");
//echo $_SERVER['HTTP_REFERER'];

//CHECK FOR HTTP REFERRER TO BE USED FOR PRIVILEGE CHECKING
$path = $_SERVER['HTTP_REFERER'];
//FileReferer='';
if (substr($path,-1)=='?')
{
    $path=substr($path,0, -1);
}
$file=substr($path,0, -4);
define('FileReferer',strtoupper(substr(strrchr($file, "/"), 1)));
//echo FileReferer;
//die();
/////////

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
        updateData();
        break;
    
    
    case 'deleteGroup':
        deleteData();
        break;

    case 'paginationGroup':
        pageGroup();
        break;

    case 'paginationUser':
        pageUser();
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
        updateData();
        break;
        
     case 'deleteUser':
        deleteData();
        break;
    //<!-------------------------end USER--------------------------------> 
   
    //<!-------------------------start PRIVILEGE--------------------------------> 
    
    case 'renderPrivilege':
        renderOnLoad();
        break;
    
    case 'updatePrivilege':
        updateData();
        break;
    
    //<!-------------------------end PRIVILEGE--------------------------------> 
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
          
          case 'addGroup':
            global $group_name;
            global $desc_name;
            
            mysqli_autocommit($conn,FALSE);
            $flag=true;
            
            $sql="INSERT INTO Security_Group(Security_GroupName,Security_GroupDescription) VALUES('".$group_name."','".$desc_name."') ";
            $resultset=mysqli_query($conn,$sql);
            $sql='SELECT LAST_INSERT_ID()';
            $recordsets=mysqli_query($conn,$sql);
            $rows=  mysqli_fetch_row($recordsets);
            $lastId= $rows[0];
        
            mysqli_free_result($recordsets);
            
            $sql='SELECT Privilege_Id FROM M_Privilege ORDER BY Privilege_Id ASC';
            $recordset=mysqli_query($conn,$sql)or die(mysqli_error($conn));
            while ($rows =mysqli_fetch_array($recordset))
            {
                $sql='INSERT INTO M_PrivilegeUser(fkGroup_Id,fkPrivilege_Id) VALUES ('.$lastId.','.$rows['Privilege_Id'].')';
                $resultset=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                if (!$resultset)
                {
                    $flag=false;
                }
            }
            
            
            if ($flag) 
            {
                mysqli_commit($conn);
                 echo 'Group added successfully';
            }
            else 
            {
                mysqli_rollback($conn);
                echo mysqli_error($conn);
               
            }
             mysqli_free_result($recordset);
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
            }
                
                break;
              
            }
      
mysqli_close($conn);
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



function searchText($stringToSearch)
{
        if(!systemPrivilege('P_Read',$_SESSION['GROUPNAME'],FileReferer))
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
        case 'searchGroup':
            $sql='SELECT Security_GroupId, Security_GroupName, Security_GroupDescription,Transdate from Security_Group';
            $sql=$sql .' WHERE Security_GroupName LIKE "%'.$stringToSearch.'%" OR Security_GroupDescription LIKE "%'.$stringToSearch.'%"  ORDER BY Security_GroupName LIMIT 0,10';
            $sqlcount='SELECT Security_GroupId, Security_GroupName, Security_GroupDescription,Transdate from Security_Group';
            $sqlcount=$sqlcount .' WHERE Security_GroupName LIKE "%'.$stringToSearch.'%" OR Security_GroupDescription LIKE "%'.$stringToSearch.'%"  ORDER BY Security_GroupName';
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
                            <td class="groupNameWidth"><b>Group Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                    </tr>
                    ';

            foreach ($resultSet as $row)
            {
                echo "
                <tr>
                        <td>".$row['Security_GroupName']."</td>
                        <td>".$row['Security_GroupDescription']."</td>
                        <td>".$row['Transdate']."</td>
                        <td><a href='#!'><span onclick='viewGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
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
                                                              $currentPage=1;
                                                              $startPage = $currentPage - 4; //1-4=-3
                                                              $endPage = $currentPage + 4;  //1+4=5
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
                                                              }
                                                              if ($endPage < $totalpages && $indicate=="higher"){
                                                                  $pageNext=$currentPage+1;
                                                                  echo "<li><a href='#!' onclick=paginationButton('".$pageNext."','".$stringToSearch."','".$totalpages."');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                                                              }
                                                              echo '
                                                      </ul>
                                            </nav>
                                                    </div>
                                            </div>
                                        </div>';
                  echo 'ajaxseparator';
                  echo "".$numOfRow."";
            break;

        case 'searchUser':
            $sql='SELECT Security_UserId,Security_UserName,Security_FullName,Designation,Security_User.Transdate,Security_GroupName, Security_GroupId from Security_User';
            $sql=$sql.' JOIN Security_Group ON Security_User.fkSecurity_Groupid = Security_Group.Security_GroupId ';
            $sql=$sql.' WHERE Security_UserName LIKE "%'.$stringToSearch.'%" OR Security_FullName LIKE "%'.$stringToSearch.'%" ';
            $sql=$sql.' OR Security_GroupName LIKE "%'.$stringToSearch.'%" ORDER BY Security_UserName LIMIT 0,10';

            $sqlcount='SELECT Security_UserId,Security_UserName,Security_FullName,Designation,Security_User.Transdate,Security_GroupName, Security_GroupId from Security_User';
            $sqlcount=$sqlcount.' JOIN Security_Group ON Security_User.fkSecurity_Groupid = Security_Group.Security_GroupId ';
            $sqlcount=$sqlcount.' WHERE Security_UserName LIKE "%'.$stringToSearch.'%" OR Security_FullName LIKE "%'.$stringToSearch.'%" ';
            $sqlcount=$sqlcount.' OR Security_GroupName LIKE "%'.$stringToSearch.'%" ORDER BY Security_UserName ';
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
                                <td class="userNameWidth"><b>User Name</b></td>
                                <td class="userFullNameWidth"><b>Full Name</b></td>
                                <td class="userDesignWidth"><b>Designation</b></td>
                                <td class="userGroupWidth"><b>Group</b></td>
                                <td class="userTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="right"><b>Control Content</b></td>
                    </tr>
                   ';

            foreach ($resultSet as $row)
            {
                echo "
                 <tr>
                        <td class='userNameWidth'>".$row['Security_UserName']."</td>
                        <td class='userFullNameWidth'>".$row['Security_FullName']."</td>
                        <td class='userDesignWidth'>".$row['Designation']."</td>
                        <td class='userGroupWidth'>".$row['Security_GroupName']."</td>
                        <td class='userTransdateWidth'>".$row['Transdate']."</td>
                        <td><a href='#!'><span onclick='viewUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editUser(".$row['Security_UserId'].",".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                </tr>";
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
                                                              $currentPage=1;
                                                              $startPage = $currentPage - 4; //1-4=-3
                                                              $endPage = $currentPage + 4;  //1+4=5
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
                                                              }
                                                              if ($endPage < $totalpages && $indicate=="higher"){
                                                                  $pageNext=$currentPage+1;
                                                                  echo "<li><a href='#!' onclick=paginationButton('".$pageNext."','".$stringToSearch."','".$totalpages."');><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
                                                              }
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

        mysqli_free_result($resultSet);
        mysqli_close($conn);
}


function viewData($id)
{
          if(!systemPrivilege('P_Read',$_SESSION['GROUPNAME'],FileReferer))
    {
        echo 'Insufficient Group Privilege. Please contact your Administrator.';
        die();
    }
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
          if(!systemPrivilege('P_Read',$_SESSION['GROUPNAME'],FileReferer))
    {
        echo 'Insufficient Group Privilege. Please contact your Administrator.';
        die();
    }
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
    
        switch ($_POST['module'])
        {
            case 'editGroup':
                $sql='SELECT Security_GroupName, Security_GroupDescription from Security_Group WHERE ';
                $sql=$sql. ' Security_GroupId = '.$id.' ';
                $resultSet=  mysqli_query($conn, $sql);
                
                $row=  mysqli_fetch_array($resultSet,MYSQL_ASSOC);
//             
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<table>
                    <tr>
                        <td>Group Name:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_group_name' name='group_name'  type='text' class='form-control' value='".$row['Security_GroupName']."'></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_group_desc' name='group_desc' type='text' class='form-control' value='".$row['Security_GroupDescription']."'></td>
                    </tr>

                </table>";
                echo "</div>";
                echo "</div>";


//               
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
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_user_name'    type='text' class='form-control' value='".$row['Security_UserName']."'></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_full_name'    type='text' class='form-control' value='".$row['Security_FullName']."'></td>
                    </tr>
                    <tr>
                        <td>Designation:</td>
                        <td class='desc-width'><input onkeyup='if(event.keyCode == 13){sendUpdate()};' id='mymodal_designation' type='text' class='form-control' value='".$row['Designation']."'></td>
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
        //mysqli_free_result($row);
        mysqli_close($conn);
    }
    
function updateData()
    {
          if(!systemPrivilege('P_Update',$_SESSION['GROUPNAME'],FileReferer))
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
            
        case 'updateGroup':
            mysqli_autocommit($conn,FALSE);
            $flag=true;
            $sql="SELECT Security_GroupName FROM Security_Group WHERE Security_GroupName='".$_POST['group_name']."' AND Security_GroupId!=".$_POST['group_id']."";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
               echo "Duplicate Group Name detected";
            }
            else
            {
                 $sql='UPDATE Security_Group SET Security_GroupName = "'.$_POST['group_name'].'",Security_GroupDescription = "'.$_POST['group_desc'].'" ';
                 $sql=$sql.' WHERE Security_GroupId = '.$_POST['group_id'];
                 $resultSet=  mysqli_query($conn, $sql);
                 if (!$resultSet)
                 {
                     $flag=false;
                 }
                 
                 $sql='SELECT Privilege_id FROM M_Privilege where Privilege_Id not in (select fkPrivilege_Id from M_PrivilegeUser WHERE fkGroup_Id='.$_POST['group_id'].') ';
                 $resultSet=mysqli_query($conn,$sql);
                 while ($row=  mysqli_fetch_array($resultSet))
                 {
                    $sql='INSERT INTO M_PrivilegeUser(fkGroup_Id,fkPrivilege_Id) VALUES ('.$_POST['group_id'].','.$row['Privilege_id'].')';
                    $qresult=mysqli_query($conn,$sql);
                    if (!$qresult)
                    {
                        $flag=false;
                    }
                     
                 }
                 
                 
            }
            mysqli_free_result($rowset);
            
           
            
            if ($flag) 
            {
                mysqli_commit($conn);
                echo 'Update Successful';
            }
            else 
            {
                echo mysqli_error($conn);
                mysqli_rollback($conn);
                
            }
            
            
            break;
            
        case 'updateUser':
            $sql='SELECT Security_UserName from Security_User WHERE Security_UserName ="'.$_POST['user_name'].'" AND Security_UserId!="'.$_POST['user_id'].'"';
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
               echo "Duplicate User Name detected";
            }
            else{
                 $sql='UPDATE Security_User SET Security_UserName="'.$_POST['user_name'].'", Security_FullName="'.$_POST['full_name'].'", Designation="'.$_POST['vardesignation'].'" ';
                 $sql=$sql.' ,fkSecurity_Groupid='.$_POST['groupId']." WHERE Security_UserId = ".$_POST['user_id']." ";
                 $resultSet=  mysqli_query($conn, $sql);
                 if ($resultSet)
                 {
                     echo 'Update Successful';
                 }
                 else
                 {
                     echo mysqli_error($conn);
                     //echo '<br>';
                     //echo $sql;
                 }
            }
            break;
            
            case 'updatePrivilege':
                $columnName=$_POST['chkvalue'];
                $flag=$_POST['chkflag'];
                $id=$_POST['chkid'];
                if ($flag=='true')
                {
                    $sql='UPDATE M_PrivilegeUser set '.$columnName.'=1 WHERE  PrivilegeUser_Id='.$id;
                }
                else
                {
                    $sql='UPDATE M_PrivilegeUser set '.$columnName.'=0 WHERE  PrivilegeUser_Id='.$id;
                }
//                echo $sql;
//                die();
                $resultSet=  mysqli_query($conn, $sql);
                if ($resultSet)
                {
                    echo 'Update Successful';
                }
                 else
                 {
                     echo mysqli_error($conn);
                     //echo '<br>';
                     //echo $sql;
                 }
            break;
        
        
        }
        
        
        mysqli_close($conn);
    }
    
function deleteData()
    {
          if(!systemPrivilege('P_Delete',$_SESSION['GROUPNAME'],FileReferer))
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
           case 'deleteGroup':
               $sql="DELETE FROM Security_Group WHERE Security_GroupID = ".$_POST['group_id']." ";
                $resultSet=  mysqli_query($conn, $sql);

                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {

                    echo mysqli_error($conn);
//                    echo '<br>';
//                    echo $sql;
                }
               break;
               
           case 'deleteUser':
               $sql="DELETE FROM Security_User WHERE Security_UserId = ".$_POST['user_id']." ";
                $resultSet=  mysqli_query($conn, $sql);

                if ($resultSet)
                {
                    echo 'Delete Successful';
                }
                else
                {

                    echo mysqli_error($conn);
//                    echo '<br>';
//                    echo $sql;
                }
               break;
       }
        
        
        
        mysqli_close($conn);
    }

    
function pageGroup(){
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
      $sql="SELECT * from Security_Group";
      $sql=$sql ." WHERE Security_GroupName LIKE '%".$stringToSearch."%' OR Security_GroupDescription LIKE '%".$stringToSearch."%'  ORDER BY Security_GroupName LIMIT   $offset,$rowsperpage";
      $result = mysqli_query($conn, $sql);
      echo '
           <table class="table table-hover"  id="search_table">
                    <tr>
                            <td class="groupNameWidth"><b>Group Name</b></td>
                            <td class="groupDescWidth"><b>Description</b></td>
                            <td class="groupTransdateWidth"><b>Transdate</b></td>
                            <td colspan="3" align="center"><b>Control Content</b></td>
                    </tr>
                    ';
// while there are rows to be fetched...
foreach ($result as $row)
            {
              echo "
                <tr>
                        <td>".$row['Security_GroupName']."</td>
                        <td>".$row['Security_GroupDescription']."</td>
                        <td>".$row['Transdate']."</td>
                        <td><a href='#!'><span onclick='viewGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteGroup(".$row['Security_GroupId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                </tr>
           ";
              }
                      echo ' </table>';
                      echo 'ajaxseparator';
                    $currentPage=$_POST['page_id'];
                    $totalpages=$_POST['total_pages'];
                    $stringToSearch=$_POST['search_string'];
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
                    echo 'ajaxseparator';
                    echo "".$startPage."";
                    echo 'ajaxseparator';
                    echo "".$endPage."";
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
                            <td class="userNameWidth"><b>User Name</b></td>
                                <td class="userFullNameWidth"><b>Full Name</b></td>
                                <td class="userDesignWidth"><b>Designation</b></td>
                                <td class="userGroupWidth"><b>Group</b></td>
                                <td class="userTransdateWidth"><b>Transdate</b></td>
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
                        <td class='userNameWidth'>".$row['Security_UserName']."</td>
                        <td class='userFullNameWidth'>".$row['Security_FullName']."</td>
                        <td class='userDesignWidth'>".$row['Designation']."</td>
                        <td class='userGroupWidth'>".$row['Security_GroupName']."</td>
                        <td class='userTransdateWidth'>".$row['Transdate']."</td>
                        <td><a href='#!'><span onclick='viewUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                        <td><a href='#!'><span onclick='editUser(".$row['Security_UserId'].",".$row['Security_GroupId'].")' class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                        <td><a href='#!'><span onclick='deleteUser(".$row['Security_UserId'].")' class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                </tr>";
              }
                      echo ' </table>';
                      echo 'ajaxseparator';
                    $currentPage=$_POST['page_id'];
                    $totalpages=$_POST['total_pages'];
                    $stringToSearch=$_POST['search_string'];
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
                    echo 'ajaxseparator';
                    echo "".$startPage."";
                    echo 'ajaxseparator';
                    echo "".$endPage."";
    }
    
function renderOnLoad()
{
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
        
        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
        
        if(!systemPrivilege('P_Delete',$_SESSION['GROUPNAME'],FileReferer))
    {
        echo 'Insufficient Group Privilege. Please contact your Administrator.';
        die();
    }
        
        
    switch ($_POST['module'])
    {
        case 'renderPrivilege':
            $id=$_POST['groupid'];
            $sql='SELECT P_Read,P_Create,P_Update,P_Delete,Module_Name,PrivilegeUser_Id from M_Privilege ';
            $sql = $sql.' JOIN M_PrivilegeUser on M_Privilege.Privilege_Id = M_PrivilegeUser.fkPrivilege_Id ';
            $sql=$sql.' WHERE fkGroup_Id = '.$id. ' ORDER BY Module_Name ASC';
            $result=mysqli_query($conn,$sql);
            echo '
            <table id="privTable" class="table table-bordered table-hover">
            <tr class="info">
                                            
                        <div class="col-md-12">
                            <td align="center"><b>Description</b></td>
                            <td align="center"><b>Read</b></td>
                            <td align="center"><b>Create</b></td>
                            <td align="center"><b>Update</b></td>
                            <td align="center"><b>Delete</b></td>
                        </div>
            </tr>
            
            
            
                ';
            foreach($result as $rows)
            {
                echo '
                    
                    <tr>
                        <td>
                            '.$rows['Module_Name'].'
                        </td>
                    ';
                
                echo '<div class="checkbox"><td align="center">';
                if ($rows['P_Read']<>0)
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" checked value="P_Read">';
                }
                else
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" value="P_Read">';
                }
                echo '</td>';
                echo '<td align="center">';
                if ($rows['P_Create']<>0)
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" checked value="P_Create">';
                }
                else
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" value="P_Create">';
                }
                echo '</td>';    
                echo '<td align="center">';
                if ($rows['P_Update']<>0)
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" checked value="P_Update">';
                }
                else
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" value="P_Update">';
                }
                echo '</td>';
                echo '<td align="center">';
                if ($rows['P_Delete']<>0)
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" checked value="P_Delete">';
                }
                else
                {
                    echo '<input name="chkPriv" type="checkbox" id="'.$rows['PrivilegeUser_Id'].'" value="P_Delete">';
                }
                echo '</td></div>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<button style="float:right;" type="button" class="btn btn-primary" onclick="updateData()">Update</button>';
            break;
    }
    
    
    
}

?>