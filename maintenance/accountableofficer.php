<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>SEIS alpha</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../css/index.css" />
<script src="../jq/jquery-1.11.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.blockUI.js"></script>
<script src="../js/jquery.growl.js" type="text/javascript"></script>
    <link href="../css/jquery.growl.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="navbar-fixed-top bluebackgroundcolor">
<?php
    $maintenanceActive="class='active'";
	$rootDir='../';
	include_once('../header.php');
    include("../connection.php");
    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
?>
</div>

<!-- ############################################################### container ######################################################## -->
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Reports Accountable Officer</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed;">

<!---------------start create group--------------->


                        <form class="form-horizontal" onSubmit="return AddAccountableOfficer()" id="form_accountableofficer">
                        <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Section:</label>
                                <div class="col-sm-10 input-width">
                                    <select id='accountableofficer_section' class='form-control input-size selectpicker'>
                                    <option value="PARA">Property Acknowledgement Receipt - Approver</option>
                                    <option value="PRSR">Property Return Slip - Receiver</option>
                                    <option value="PRSA">Property Return Slip - Approver</option>
                                    <option value="IOECO">Inventory of Equipment - Conductor</option>
                                    <option value="IOEP">Inventory of Equipment - Preparer</option>
                                    <option value="IOECH">Inventory of Equipment - Checker</option>
                                    <option value="IOEN">Inventory of Equipment - Noter</option>
                                    <option value="IOECE">Inventory of Equipment - Certifier</option>
                                    <option value="IOEAT">Inventory of Equipment - Attester</option>
                                    <option value="IOEAP">Inventory of Equipment - Approver</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Full Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="accountableofficer_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Position:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="accountableofficer_position">
                                </div>
                            </div>
                        <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Division:</label>
                                <div class="col-sm-10 input-width">
                                    <?php
                                        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                                        if (mysqli_connect_error())
                                        {
                                            echo "Connection Error";
                                            die();
                                        }
                                        $sql="SELECT Division_Name,Division_Id,Division_Description FROM M_Division ORDER BY Division_Name";
                                        $resultset=  mysqli_query($conn, $sql);
                                        echo "<select id='division_id' class='form-control input-size selectpicker'>";
                                        foreach($resultset as $rows)
                                        {
                                            echo "<option data-subtext='".$rows['Division_Description']."' value=".$rows['Division_Id'].">".$rows['Division_Name']."</option>";
                                        }
                                        echo "</select>";

                                        mysqli_close($conn);
                                    ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" id="create_accountableofficer">Create</button>
                                </div>
                            </div>
                        </form>
<!---------------end create group--------------->
                    </div>
                    <div id="addStatus" class="panel-footer footer-size">

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
                                         <form class="form-horizontal"  onSubmit="return SearchAccountableOfficer();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_brand" class="btn btn-default btn-size" type="submit">
                                                    <span class="glyphicon glyphicon-search">
                                                    </span>
                                                </button>
                                              </span>
                                            </div>
                                        </form>
<!---------------end search--------------->

                                          </div>
                                      </div>
                                    </div>
                                          <div id="page_search">
                                        <div class="panel-body bodyul" style="overflow: auto">
                                            <table class="table table-hover fixed" id="search_table">
                                                <tr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                                <td style=" width: 20%"><b>Name</b></td>
                                                                <td style=" width: 20%"><b>Position</b></td>
                                                                <td style=" width: 20%"><b>Division</b></td>
                                                                <td style=" width: 20%"><b>Section</b></td>


                                                    </div>
                                                    <div class="col-md-1">
                                                       <td  style=" width: 10%" colspan="3" align="center"><b>Manage</b></td>
                                                    </div>
                                                </div>
                                                </tr>
                                                <tr>

<!---------------start table--------------->
                                                <div class="row">


                                                </div>
<!---------------end table--------------->

                                                </tr>
                                            </table>

                                        </div>
                                        <div class="panel-footer footer-size">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div id="searchStatus" class="panel-footer">

                                                    </div>
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
    include_once('../modal.php');


//<!---------------end Modal container--------------->


	include_once('../footer.php');

?>
<script language="JavaScript" type="text/javascript">
    var form_name='USER';//holder for privilege checking
    var pk_accountableofficer;
    //<!---------------Save Ajax--------------->
    function AddAccountableOfficer()
    {
        var module_name='addAccountableOfficer';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,accountableofficer_name:$("#accountableofficer_name").val(),accountableofficer_position:$("#accountableofficer_position").val(),division_id:$("#division_id").val(),accountableofficer_section:$("#accountableofficer_section").val()},
                beforeSend: function()
               {
                    $.blockUI();
                    document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                    $.unblockUI();
                    $("#addStatus").html('');
                if (response=='Section filled successfully')
                {
                    $.growl.notice({ message: response });
                    $('#form_accountableofficer')[0].reset();
                }
                else if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                {
                    $.growl.error({ message: response });
                    $('#myModal').modal('hide');
                }
                else
                {
                    $.growl.warning({ message: response });
                }
               },
               error:function (xhr, ajaxOptions, thrownError){
                   $.unblockUI();
                   $("#addStatus").html('');
                   $.growl.error({ message: thrownError });
               }
        });
           return false;
    }


    function SearchAccountableOfficer()
    {
        var module_name='searchAccountableOfficer';
         jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,searchText:$("#search_text").val()},
                beforeSend: function()
                {
                    $.blockUI();
                    document.getElementById('searchStatus').innerHTML='Searching....';
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
                      var splitResult=response.split("ajaxseparator");
                      var response=splitResult[0];
                      var numberOfsearch=splitResult[1];
                      document.getElementById('searchStatus').innerHTML='';
                      $("#page_search").html(response);
                      if(numberOfsearch!=0){
                      document.getElementById('1').className="active";
                      }else{
                           $("#searchStatus").html("No Results Found");
                      }
                    }

                },
                error:function (xhr, ajaxOptions, thrownError){
                    $.unblockUI();

                    $.growl.error({ message: thrownError });
                }
         });
         document.getElementById('searchStatus').innerHTML='';
         return false;
    }
    ///<!---------------End Save Ajax--------------->

    //<!---------------Start Pagination--------------->
function paginationButton(pageId,searchstring,totalpages){
  var module_name='paginationAccountableOfficer'
  var page_Id=parseInt(pageId);
       jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
           data:{form:form_name,module:module_name,page_id:page_Id,search_string:searchstring,total_pages:totalpages},
             beforeSend: function()
            {
                 $.blockUI();
                document.getElementById('searchStatus').innerHTML='Searching....';

            },
            success:function(response)
            {
                $.unblockUI();
               document.getElementById('searchStatus').innerHTML='';
               var splitResult=response.split("ajaxseparator");
               var search_table=splitResult[0];
               var pagination_change=splitResult[1];
               var startPage=splitResult[2];
               var endPage=splitResult[3];
               $("#search_table").html(search_table);
               $("#change_button").html(pagination_change);
               while(startPage<=endPage){
                    document.getElementById(startPage).className="";
                    startPage++;
               }
               document.getElementById(pageId).className="active";
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                $.unblockUI();
                $.growl.error({ message: thrownError });


            }


     });

}

//<!---------------View Modal--------------->

   ///<!---------------View Modal--------------->
    function viewAccountableOfficer(AccountableOfficerID)
    {
        var module_name='viewAccountableOfficer';
        var accountableofficerid=parseInt(AccountableOfficerID);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,accountableofficer_id:accountableofficerid},
             beforeSend: function()
            {
                 $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
              $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
              $("#modalContent").html(response);
            },
            error:function (xhr, ajaxOptions, thrownError){
                $.unblockUI();
                 $.growl.error({ message: thrownError });
            }
        });
        document.getElementById('modalTitle').innerHTML='View';
        $('#myModal').modal('show');
        $("#footerNote").html("");
    }
    ///<!---------------End View Modal--------------->


    function editAccountableOfficer(AccountableOfficerID)
    {
        var module_name='editAccountableOfficer';
        var accountableofficerid=parseInt(AccountableOfficerID);
        pk_accountableofficer=AccountableOfficerID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{form:form_name,module:module_name,accountableofficer_id:accountableofficerid},
             beforeSend: function()
            {
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#footerNote").html("");
                $("#modalContent").html(response);
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left" id="save_changes" onclick="sendUpdate();">Update</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');

            },
             error:function (xhr, ajaxOptions, thrownError)
            {
                $.unblockUI();
                 $.growl.error({ message: thrownError });
            }
        });
        $("#footerNote").html("");
        document.getElementById('modalTitle').innerHTML='Edit';
        $('#myModal').modal('show');
    }
    function deleteAccountableOfficer($id)
    {
        var module_name='viewAccountableOfficer';
        var accountableofficerid=parseInt($id);
        pk_accountableofficer=$id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,accountableofficer_id:accountableofficerid},
             beforeSend: function()
            {
                $("#footerNote").html("");
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left"  onclick="sendDelete();">Delete</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            },
            success:function(response)
            {
                $("#modalContent").html(response);
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                $.unblockUI();
                 $.growl.error({ message: thrownError });
            }
        });
        document.getElementById('modalTitle').innerHTML='Delete';
        $('#myModal').modal('show');
    }
    function sendDelete()
    {
        if (confirm("Are you sure you want to delete?") == false)
        {
            return;
        }

        var module_name='deleteAccountableOfficer';
        var accountableofficerId=window.pk_accountableofficer;
        alert(accountableofficerId);
         jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,accountableofficer_id:accountableofficerId},
                 beforeSend: function()
                {
                    $("#footerNote").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    if (response=='Delete Successful')
                    {
                            $.growl.notice({ message: response });
                            $('#myModal').modal('hide');
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
                    $.growl.error({ message: thrownError });


                }
         });
    }

    function sendUpdate()
    {
        var module_name='updateAccountableOfficer';
        var accountableofficerid=window.pk_accountableofficer;
        var accountableofficername=document.getElementById('mymodal_accountableofficer_name').value;
        var accountableofficerposition=document.getElementById('mymodal_accountableofficer_position').value;
        var accountableofficerdivision=document.getElementById('mymodal_accountableofficer_division').value;
        var accountableofficersection=document.getElementById('mymodal_accountableofficer_section').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,accountableofficer_id:accountableofficerid,accountableofficer_name:accountableofficername,accountableofficer_position:accountableofficerposition,accountableofficer_division:accountableofficerdivision,accountableofficer_section:accountableofficersection},
            beforeSend: function()
            {
                $("#footerNote").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                if (response=='Update Successful')
                {
                    $.growl.notice({ message: response });
                    $('#myModal').modal('hide');
                }
                else if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                {
                    $.growl.error({ message: response });
                    $('#myModal').modal('hide');
                }
                else
                {
                    $("#footerNote").html(response);
                }

            },
            error:function (xhr, ajaxOptions, thrownError){
                $.unblockUI();
                $.growl.error({ message: thrownError });

            }

     });
    }
</script>
</body>
</html>