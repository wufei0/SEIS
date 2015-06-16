<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>SEIS alpha</title>
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../../css/index.css" />
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap-select.css" />
        <script src="../../jq/jquery-1.11.1.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/bootstrap-select.js"></script>
        <script src="../../js/jquery.blockUI.js"></script>
        <script src="../../js/jquery.growl.js" type="text/javascript"></script>
        <link href="../../css/jquery.growl.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="navbar-fixed-top bluebackgroundcolor">
            <?php
                $maintenanceActive="class='active'";
            	$rootDir='../../';
            	include_once('../../header.php');
                include("../../connection.php");
                global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
                $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                if (mysqli_connect_error())
                {
                    echo "Connection Error";
                    die();
                }
            ?>
        </div>
        <!-- ############################################################### container ######################################################## -->
        <div class="container">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Privileges</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed">
                        <form>
                            <div class="row">
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label group1-inputtext">Group:</label>
                                        <div class="col-sm-11 input1-width">
                                            <?php
                                                $sql='SELECT Security_GroupId,Security_GroupName,Security_GroupDescription FROM Security_Group ORDER BY Security_GroupName ASC';
                                                $result=  mysqli_query($conn, $sql);
                                                echo "<select  id='sel_groupid' class='form-control input-size selectpicker'  >";
                                                foreach ($result as $rows)
                                                {
                                                    echo "<option  data-subtext='".$rows['Security_GroupDescription']."' value=".$rows['Security_GroupId'].">".$rows['Security_GroupName']."</option>";
                                                }
                                                echo '</select><br/><br/>';
                                            ?>
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="privilegeRender"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="PrivilegeStatus" class="panel-footer footer-size"></div>
                </div>
            </div>
        </div>
        <!-- ############################################################### end container ######################################################## -->
        <?php
        	$root='';
        	include_once('../../footer.php');
            mysqli_close($conn);
        ?>
        <script>
            $(function() {
                renderPrivilege();
            });
            document.getElementById("sel_groupid").onchange = function()
            {
                renderPrivilege();
            };

            function renderPrivilege(){
                var module_name='renderPrivilege';
                var group_id=parseInt(document.getElementById('sel_groupid').value);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{module:module_name,groupid:group_id},
                    beforeSend: function()
                    {
                       $("#privilegeRender").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
                       $.blockUI();
                    },
                    success:function(response)
                    {
                        $.unblockUI();
                         if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                            {
                                $.growl.error({ message: response });
                            }
                            else
                            {
                                $("#privilegeRender").html(response);
                            }
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                        $.unblockUI();
                    }
                });
                $("#privilegeRender").html('');
                document.getElementById('PrivilegeStatus').innerHTML='';
            }

            function updateData(){
                $("input:checkbox").each(function () {
                    var chkFlag;
                    var chkId;
                    var chkValue;
                    chkId=$(this).attr("id");
                    chkValue=$(this).val();
                    if($(this).is(':checked'))
                    {
                        chkFlag='true';
                    }
                    else
                    {
                        chkFlag='false';
                    }
                    $("#PrivilegeStatus").html("<div style='margin:0px 1%;'><img src='../../images/ajax-loader.gif' /></div>");
                    loopPrivilege(chkId,chkValue,chkFlag);
                });
                $("#PrivilegeStatus").html("");
            }

            function loopPrivilege(id,value,flag)
            {
                var module_name='updatePrivilege';
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{module:module_name,chkid:id,chkvalue:value,chkflag:flag},
                     beforeSend: function()
                    {
                        $.blockUI();
                    },
                    success:function(response)
                    {
                         $.unblockUI();
                         if (response=='Update Successful')
                            {
                                $.growl.notice({ message: response });
                            }
                            else if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                            {
                                $.growl.error({ message: response });
                            }
                            else
                            {
                                $.growl.warning({ message: response });
                            }
                    },
                    error:function (xhr, ajaxOptions, thrownError)
                    {
                        $.unblockUI();
                    }
                });
            }
        </script>
    </body>
    </html>