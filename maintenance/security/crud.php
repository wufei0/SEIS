<?php
include("../../connection.php");
//echo "'".$_POST['module']."'";
if (!isset($_POST['module']))
{
    die();
}

switch ($_POST['module'])
{
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
       
           if (verify_duplicate($_POST['module']))
           {
               echo "duplicate";
               die();
           }
           create_group();
        }
        
        
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
        
    case 'viewGroup':
        
        viewData();
        
        
        
}






function create_group()
{
      global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
      $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

      if (mysqli_connect_error())
      {
            echo "Connection Error";
            die();
      }


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
      //mysqli_free_result($resultset);
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

     switch (isset($_POST['module']))
     {
       
     case 'addGroup':
            global $group_name;
            $sql="SELECT Security_GroupName FROM Security_Group WHERE Security_GroupName='".$group_name."'";
            $rowset=mysqli_query($conn,$sql);
            if (mysqli_num_rows($rowset)>=1)
            {
              $verify_duplicate=true;

            }



     }

           mysqli_free_result($rowset);
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
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

    if (mysqli_connect_error())
    {
        echo "Connection Error";
        die();
    }
    
    switch ($_POST['module'])
    {
        case 'searchGroup';
            $sql='SELECT Security_GroupId, Security_GroupName, Security_GroupDescription,Transdate from Security_Group';
            $sql=$sql .' WHERE Security_GroupName LIKE "%'.$stringToSearch.'%" OR Security_GroupDescription LIKE "%'.$stringToSearch.'%" ';
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
                        <td><a href='#!'><span onclick='viewGroup(".$row['Security_GroupId'].")'  class='glyphicon glyphicon-eye-open' title='View' ></span></a></td>
                            <td><a href='#!'><span class='glyphicon glyphicon-pencil' title='Edit' ></span></a></td>
                            <td><a href='#!'><span class='glyphicon glyphicon-trash' title='Delete'></span></a></td>
                    </div>
                  </div> 
                </div>
                </tr>
            </table>";
                
            }
    }
    
    
}

function viewData()
{
    
    switch ($_POST['module'])
    {
    
    }
}


?>