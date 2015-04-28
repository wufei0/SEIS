
<!-- ############################################################### header ######################################################## -->
<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['LOGGED']))
{
    $_SESSION['LOGGED']=false;
}


    if (!isset($homeActive))
    {
           $homeActive = '';
    }
     
    if (!isset($equipmentActive))
    {
        $equipmentActive='';
    }
    if (!isset($supplyActive))
    {
       $supplyActive = ''; 
    }
        if (!isset($reportActive))
    {
       $reportActive = ''; 
    }
        if (!isset($maintenanceActive))
    {
       $maintenanceActive = ''; 
    }
    
        if (!isset($helpActive))
    {
       $helpActive = ''; 
    }

?>
<script>
       function logMeOut()
    {
        var module_name='logMeOut';

        jQuery.ajax({
               type: "POST",
              <?php //echo "url:'.$rootDir.'login.php',"; ?>
               <?php echo "url:'{$rootDir}login.php',";  ?>
               dataType:'html',
               data:{module:module_name},
                beforeSend: function()
               {
                    
               },
               success:function(response)
               {
                    $('#myModal').modal('hide');
                   window.location.reload(true);
                    
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
        });
    }
    function logMeIn()
    {
        
        var module_name='logMeIn';
        var user_name=document.getElementById('txtusername').value;
        var password=document.getElementById('txtpassword').value;
        jQuery.ajax({
               type: "POST",
               <?php echo "url:'{$rootDir}login.php',";  
               $gifSource=$rootDir.'images/ajax-loader.gif';
               ?>
               dataType:'html',
               data:{module:module_name,username:user_name,password:password},
                beforeSend: function()
               {
                    <?php echo "$('#footerNote').html('<div><img src=$gifSource /></div>');"; ?>
               
                   
                   
               },
               success:function(response)
               {
                    if (response=='true')
                    {
                        
                        $("#footerNote").html("Correct Username or Password");
                        $('#myModal').modal('hide');
                        window.location.reload(true);
                        return true;
                    }
                    else
                    {
                        $("#footerNote").html("Invalid Username or Password");
                        
                    }
                    
                   //$('#modal').modal('hide');
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
        });
    }
    
     function renderLogin()
    {
        var module_name='renderLogin';
        jQuery.ajax({
               type: "POST",
              <?php echo "url:'{$rootDir}login.php',";  ?>
               dataType:'html',
               data:{module:module_name},
                beforeSend: function()
               {
                   $('#footerNote').html('');
                   <?php echo "$('#modalContent').html('<div><img src=$gifSource /></div>');"; ?>
                    document.getElementById('modalTitle').innerHTML='LogIn';
                    $("#modalButton").html('');
                    $("#modalButton").html('<button type="submit" class="btn btn-primary" onclick="logMeIn()">Login</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></form>');
                    $('#myModal').modal('show');
               },
               success:function(response)
               {
                   $("#modalContent").html(response);
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
        });
    }
    </script>
<header>
  
  		<div class="container">
        
            <div class="row banner_row">
            		<div class="col-md-8">
                    		<div class="banner">
                                    <a href="<?php echo $rootDir;?>index.php"><img src="<?php echo $rootDir;?>images/logo/pgso_logo_2.png" width="70" height="70" align="left" title="SUPPLY AND EQUIPMENT INVENTORY SYSTEM alpha" /></a>
                                <h1>Provincial General Services Office</h1>
                                <p>SUPPLY AND EQUIPMENT INVENTORY SYSTEM alpha</p>
                            </div>
                    </div>
  					<div class="col-md-4">
                    	
                        <div id="imagelogo">
                            <a href="http://launion.gov.ph/index.php"><img src="<?php echo $rootDir;?>images/logo/pglu.png" width="50" height="50" title="Provincial Government of La Union" /></a>
                            <a href="index.php"><img src="<?php echo $rootDir;?>images/logo/pgso_logo_1.png" width="50" height="50" title="Provincial General Services Office" /></a>
                            <a href="#"><img src="<?php echo $rootDir;?>images/logo/mislogo.png" width="65" height="50" title="Management Information System Division" /></a>
                        </div>
                    </div>
            </div>
            
            <div class="container">
            
            <div class="row">
                <div class="col-md-8">
            		<ul  class="nav nav-tabs">
                            <li <?php echo $homeActive; ?> role="presentation"><a href="<?php echo $rootDir;?>index.php">Home</a></li>
                                <li <?php echo $equipmentActive; ?> role="presentation" class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  Equipment <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo $rootDir;?>equipment/equipment.php">Equipment</a></li>
                                    <li><a href="<?php echo $rootDir;?>equipment/par.php">Property Acknowledgement Receipt</a></li>
                                    <li><a href="<?php echo $rootDir;?>equipment/equipment.php">Property Disposal</a></li>
                                    <li><a href="<?php echo $rootDir;?>equipment/equipment.php">Property Condemn</a></li>
                                </ul>
                                </li>
                               
                            <li <?php echo $supplyActive; ?> role="presentation"><a href="<?php echo $rootDir;?>supply/supply.php">Supply</a></li>
                            <li <?php echo $reportActive; ?> role="presentation"><a href="<?php echo $rootDir;?>report/report.php">Report</a></li>
                            <li <?php echo $maintenanceActive; ?> role="presentation" class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  Maintenance <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo $rootDir;?>maintenance/brand.php">Brand</a></li>
                                    <li><a href="<?php echo $rootDir;?>maintenance/classification.php">Classification</a></li>
                                     <li><a href="<?php echo $rootDir;?>maintenance/model.php">Model</a></li>
                                    <li><a href="<?php echo $rootDir;?>maintenance/personel.php">Personel</a></li>
                                    <li><a href="<?php echo $rootDir;?>maintenance/department.php">Department</a></li>
                                    <li><a href="<?php echo $rootDir;?>maintenance/division.php">Division</a></li>
                                                <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Security</span></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="<?php echo $rootDir;?>maintenance/security/user.php"><span>Users</span></a></li>
                                                        <li><a href="<?php echo $rootDir;?>maintenance/security/group.php"><span>Group</span></a></li>
                                                        <li><a href="<?php echo $rootDir;?>maintenance/security/privileges.php"><span>Privileges</span></a></li>
                                                        <li><a href="<?php echo $rootDir;?>maintenance/security/audittrail.php"><span>Audit Trail</span></a></li>
                                                    </ul>
                                                </li>
                                  <li><a href="<?php echo $rootDir;?>maintenance/type.php">Type</a></li>
                                  <li><a href="<?php echo $rootDir;?>maintenance/supplier.php">Supplier</a></li>
                                </ul>
                              </li>
                              <li <?php echo $helpActive; ?> role="presentation"><a href="<?php echo $rootDir;?>help/help.php">Help</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p>Welcome <a href="#" style="color:#fff;">
                      <?php
                      if ($_SESSION['LOGGED'])
                      {
                          echo $_SESSION['USERNAME']."</a> | <a id='log' onclick='logMeOut();' data-toggle='modal' >Log Out</a></p>";
                      }
                      else
                      {
                          echo "Guest</a> | <a id='log' onclick='renderLogin();' data-target='#myModal'>Log In</a></p>";
                      }
                      ?>
                            
                </div>
            </div>
            
            </div>
            
		</div>			
  
</header>
<!-- ############################################################### end header ######################################################## -->