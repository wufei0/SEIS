<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>SEIS alpha</title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
<script src="jq/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>



</head>

<body>
<div class="navbar-fixed-top ">
<?php
        $homeActive='class="active"';
	$rootDir='';
	include_once('header.php');
        
     

?>

</div>
<!-- ############################################################### container ######################################################## -->
<div class="container">
  	
        
            
            <div class="row">
              
            </div>
</div>
<!-- ############################################################### end container ######################################################## -->

<?php
    $root='';
    include_once('footer.php');
    include_once('modal.php');

?>


<script>
   
    
    
    
 
</script>

</body>
</html>