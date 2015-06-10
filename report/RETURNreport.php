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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Equipment</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul" style="overflow: auto">
                       <form>
  <div class="form-group">
    <label for="exampleInputEmail1">From:</label>
    <input type="date" class="form-control" id="exampleInputEmail1">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">To:</label>
    <input type="date" class="form-control" id="exampleInputPassword1">
  </div>

</form>
                        </div>
                        <div id="addStatus" class="panel-footer">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading header-size">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title"></h3></div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                    <!---------------start search--------------->
                                        <form class="form-horizontal"  onSubmit="return SearchEquipment();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button id="search_personnel" class="btn btn-default btn-size" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                </span>
                                            </div>
                                        </form>
                                    <!---------------end search--------------->
                                    </div>
                            </div>
                        </div>
                        <div id="page_search">
                            <div class="panel-body bodyul" style="overflow: auto">
                              <table class="table table-bordered  table-hover">
                        <tr>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Date</th>

                        <th style="text-align: center">Manage</th>
                        </tr>


                        <?php
                          global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);

        if (mysqli_connect_error())
        {
            echo "Connection Error";
            die();
        }
                           $sql='SELECT *
                FROM Property_Return';
                $resultSet= mysqli_query($conn, $sql);


                 foreach ($resultSet as $row)
                {
                    echo "
                    <tr>
                            <td style='word-break: break-all'>".$row['PropertyReturn_Status']."</td>
                            <td style='word-break: break-all'>".$row['PropertyReturn_Note']."</td>
                            <td style='word-break: break-all'>".$row['PropertyReturn_Date']."</td>
                            <td  style='text-align: center'><a onclick='printPARovermodal(".$row['PropertyReturn_Id'].");'><span class='glyphicon glyphicon-print'></span></a> </td>
                        </tr>";
                }


                        ?>
                        </table>
                            </div>
                            <div class="panel-footer footer-size">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div style="" id="searchStatus" class="panel-footer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############################################################### end container ######################################################## -->
        <!---------------Modal container--------------->
        <?php
            include_once('modal.php');
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>


<script language="JavaScript" type="text/javascript">
      var form_name='USER';
      function printPARovermodal(printpropertyreturnid){
                    var module_name='printPropertyReturnovermodal';
                    jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,printpropertyreturn_id:printpropertyreturnid},
                        beforeSend: function()
                        {
                            $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            $("#modalButtonovermodal").html('<button type="button" class="btn btn-default glyphicon glyphicon-save" data-dismiss="modal"></button><button type="button" class="btn btn-default glyphicon glyphicon-print" onclick="printo()";></button><button type="button" class="btn btn-danger glyphicon glyphicon-remove" data-dismiss="modal"></button>');
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div id="contentovermodal"></div></div></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Print Property Return Slip';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
            }
            function printo(){
              	window.print();
            }
</script>
</body>
</html>