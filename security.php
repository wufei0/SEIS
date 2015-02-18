<?php



      

function systemPrivilege($dml,$group,$form)
{
    
    switch ($dml)
    {
        case 'P_Read':
            $lang='P_Read';
            break;
        case 'P_Create':
            $lang='P_Create';
            break;
        case 'P_Update':
            $lang='P_Update';
            break;
        case 'P_Delete':
            $lang='P_Delete';
            break;
    }
    
    $sql='SELECT '.$lang.' FROM M_Privilege JOIN M_PrivilegeUser ON M_Privilege.Privilege_Id
    =M_PrivilegeUser.fkPrivilege_Id JOIN Security_Group ON M_PrivilegeUser.fkGroup_Id = 
    Security_Group.Security_GroupId WHERE Security_GroupName = "'.$group.'" AND Module_Name= "'.$form.'" AND '.$lang.'=1 ';

//    echo $sql;
//    die();
    
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
      $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
      
      $recSet=  mysqli_query($conn, $sql);
      $numOfRow=mysqli_num_rows($recSet);
      if ($numOfRow>0)
      {
          return true;
      }
      else
      {
          return false;
      }
      mysqli_close($conn);
    
}