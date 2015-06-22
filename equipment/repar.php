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
            $equipmentActive="class='active'";
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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Re-Property Acnowledgement Receipt</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul" style="overflow: fixed;">
                            <!---------------start create return--------------->
                            <form class="form-horizontal" onSubmit="return addPropertyRepar()" id="form_propertyrepar">
                                 <div class="panel-body bodyul">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="search_personnel" type="text" disabled="disabled" class="form-control" placeholder="Search PAR">
                                                    <span class="input-group-btn">
                                                        <button id="search_personnel_from" onclick="selectPropertyRePar();" class="btn btn-default" type="button">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                  </span>
                                                </div><br>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <div style="height: 300px; overflow: auto">
                                                    <table border="1px" class="table table-bordered">
                                                        <tr class="active"><th>Property Number</th><th>Description</th><th></th></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                        <tr><td></td><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <hr>
                                                <div style="height: 300px; overflow: auto">
                                                    <table border="1px" class="table table-bordered">
                                                        <tr class="active"><th>Properties For REPAR</th><th></th></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                        <tr><td></td><td style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="col-left">
                                            <label  class="col-sm-2 control-label group-inputtext textsize">Status:</label>
                                            <div class="col-sm-4 colsm4">
                                                <input type="text" class="form-control input-size" id="propertyreturn_date">
                                            </div>
                                        </div>
                                        <div id="col-right">
                                            <label  class="col-sm-2 control-label group-inputtext textsize">Note:</label>
                                            <div class="col-sm-4 colsm4">
                                                <input type="text" class="form-control input-size" id="propertyreturn_note">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="col-left">
                                            <label  class="col-sm-2 control-label group-inputtext textsize">Date:</label>
                                            <div class="col-sm-4 colsm4">
                                                <input type="date" class="form-control input-size" id="propertyreturn_date">
                                            </div>
                                        </div>
                                        <div id="col-right">
                                            <label  class="col-sm-2 control-label group-inputtext textsize">New Recipient:</label>
                                            <div class="col-sm-4 colsm4">
                                                <div class="input-group">
                                                    <input id="search_personnel_from" type="text" class="form-control" placeholder="Search New Recepient">
                                                    <span class="input-group-btn">
                                                        <button id="search_personnel_from" onclick="selectPropertyReparFrom();" class="btn btn-default" type="button">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div><hr>
                                 <div>
                                    <button type="submit" class="btn btn-primary button-right" id="create_propertyreturn">Submit</button>
                                 </div>
                            </form>
                        </div>
                        <div id="addStatus" class="panel-footer footer-size"></div>
                        <!---------------end create return--------------->
                    </div>
                </div>
            </div>
        </div>
        <!-- ############################################################### end container ######################################################## -->
        <!---------------Modal container--------------->
        <?php
            include_once('../modal.php');
            include_once('modal.php');
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
        <script>
            var form_name='USER';
            function selectPropertyRePar()
            {
                var module_name='selectPropertyRePar';
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{form:form_name,module:module_name},
                    beforeSend: function()
                    {
                        $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                    },
                    success:function(response)
                    {
                        $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPropertyRePar(document.getElementById(\'txtPropertyRePar\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtPropertyRePar" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyRePar(this.value)};" placeholder="Search PAR"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Select PAR';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }
            function searchPropertyRePar(searchstring)
            {
                var module_name='searchPropertyRePar';
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html', // Data type, HTML, json etc.
                    data:{form:form_name,module:module_name,search_string:searchstring},
                    beforeSend: function()
                    {
                        $("#footerNote").html('');
                        $("#content").html("<div align=\'center\'><img src='../images/ajax-loader.gif' /></div>");
                    },
                    success:function(response)
                    {
                        var splitResult=response.split("ajaxseparator");
                        var response=splitResult[0];
                        var numberOfsearch=splitResult[1];
                        if(numberOfsearch!=0){
                        $("#content").html(response);
                            if(searchstring!=''){
                                var message="Showing results for <b>"+searchstring+"</b>";
                                $("#footerNote").html(message);
                            }else{
                                    $("#footerNote").html('');
                                 }
                            }else{
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any property par.";
                                 $("#content").html(message);
                                 $("#footerNote").html('');
                            }
                    }
                });
            }
        </script>
      </body>
</html>