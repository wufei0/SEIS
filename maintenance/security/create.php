<?php
include("../../connection.php");

switch (isset($_POST['module']))
{
  case 'addGroup':
        if(isset($_POST['group_name'])){
              $group_name=$_POST['group_name'];
              $desc_name=$_POST['desc_name'];
        }

        if((strlen($group_name))==0)
        {
              echo "empty";
        }
        else
        {
          //echo     verify_duplicate($_POST['module']);
           if (verify_duplicate($_POST['module']))
           {
               echo "duplicate";
               die();
           }
           create_group();
        }
}






function create_group()
{
      global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
      $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

      if (mysqli_connect_error())
      {
            echo "Connection Error";
      }


      global $group_name;
      global $desc_name;
      $sql="INSERT INTO Security_Group(Security_GroupName,Security_GroupDescription) values('".$group_name."','".$desc_name."')";
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
?>