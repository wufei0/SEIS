<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>SEIS alpha</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../css/index.css" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-select.css" />
    <script src="../jq/jquery-1.11.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-select.js"></script>
    <script src="../js/jquery.blockUI.js"></script>
    <script src="../js/jquery.growl.js" type="text/javascript"></script>
    <link href="../css/jquery.growl.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="navbar-fixed-top bluebackgroundcolor">
        <?php
                $reportActive="class='active'";
              	$rootDir='../';
              	include_once('../header.php');
                include("../connection.php");
                global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
                if (mysqli_connect_error())
                {
                    echo "Connection Error";
                    die();
                }
        ?>
    </div>

<!-- ############################################################### container ######################################################## -->
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Report</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul" style="overflow: auto">
                        <table class="table table-bordered">
                        <tr><th>Header 1</th>
                        <th>Header 1</th>
                        <th>Header 1</th>
                        <th>Header 1</th>
                        <th>Header 1</th>
                        <th style="text-align: center">Manage</th>
                        </tr>
                        <tr>
                        <td colspan="5">Property Return Acknowledgemetn Information Sample</td>
                        <td style="text-align: center">
                        <a><span class="glyphicon glyphicon-print"></span></a>
                        <a><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a><span class="glyphicon glyphicon-eye-open"></span></a>
                        </td>
                        </tr>
                         <tr>
                        <td colspan="5">Property Return Acknowledgemetn Information Sample</td>
                        <td style="text-align: center">
                        <a><span class="glyphicon glyphicon-print"></span></a>
                        <a><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a><span class="glyphicon glyphicon-eye-open"></span></a>
                        </td>
                        </tr>
                         <tr>
                        <td colspan="5">Property Return Acknowledgemetn Information Sample</td>
                        <td style="text-align: center">
                        <a><span class="glyphicon glyphicon-print"></span></a>
                        <a><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a><span class="glyphicon glyphicon-eye-open"></span></a>
                        </td>
                        </tr>
                        </table>
                        </div>
                        <div id="addStatus" class="panel-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############################################################### end container ######################################################## -->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
</body>
</html>