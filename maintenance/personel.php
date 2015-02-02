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
</head>

<body>
<div class="navbar-fixed-top bluebackgroundcolor">
<?php
        $maintenanceActive="class='active'";
	$rootDir='../';
	include_once('../header.php');

?>
</div>

<!-- ############################################################### container ######################################################## -->
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Personnel</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddPersonnel()">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">ID Number:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="id_number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">First Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="first_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Middle Name:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="middle_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Last Name:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="last_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Designation:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="personnel_designation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" id="create_personnel">Create</button>
                                </div>
                            </div>
                        </form>
<!---------------end create group--------------->
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
                                         <form class="form-horizontal"  onSubmit="return SearchPersonnel();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_personnel" class="btn btn-default btn-size" type="submit">
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
                                                                <td class="personnelIdnumberWidth"><b>ID Number</b></td>
                                                                <td class="personnelFNameWidth"><b>First Name</b></td>
                                                                <td class="personnelMNameWidth"><b>Middle Name</b></td>
                                                                <td class="personnelLNameWidth"><b>Last Name</b></td>
                                                                <td class="personnelDesignationWidth"><b>Designation</b></td>
                                                                <td class="personnelTransdateWidth"><b>Transdate</b></td>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <td colspan="3" align="right"><b>Control Content</b></td>
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
    ?>

<!---------------end Modal container--------------->

<?php
	$root='';
	include_once('../footer.php');

?>
<script>
var pk_personnel;
    //<!---------------Save Ajax--------------->
    function AddPersonnel()
    {
        var module_name='addPersonnel';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{module:module_name,personnel_idnumber:$("#id_number").val(),personnel_fname:$("#first_name").val(),personnel_mname:$("#middle_name").val(),personnel_lname:$("#last_name").val(),personnel_designation:$("#personnel_designation").val()},
                beforeSend: function()
               {
                   document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                $("#addStatus").html(response);
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
        });
           return false;
    }

    //<!---------------End Save Ajax--------------->

     //<!---------------Search Ajax--------------->
    function SearchPersonnel() {
         var module_name='searchPersonnel';
         jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,searchText:$("#search_text").val()},
                beforeSend: function()
                {
                    document.getElementById('searchStatus').innerHTML='Searching....';
                },
                success:function(response)
                {
                  document.getElementById('searchStatus').innerHTML='';
                  $("#page_search").html(response);
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
         });
         return false;
    }
     //<!---------------End Search Ajax--------------->

    //<!---------------View Modal--------------->
    function viewPersonnel(PersonnelID)
    {
        var module_name='viewPersonnel';
        var personnelid=parseInt(PersonnelID);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,personnel_id:personnelid},
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
                alert(thrownError);
            }
        });
        document.getElementById('modalTitle').innerHTML='View';
        $('#myModal').modal('show');
        $("#footerNote").html("");
    }
    //<!---------------End View Modal--------------->

    //<!---------------Edit Modal--------------->
    function editPersonnel(PersonnelID)
    {
        var module_name='editPersonnel';
        var personnelid=parseInt(PersonnelID);
        pk_personnel=PersonnelID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{module:module_name,personnel_id:personnelid},
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
                alert(thrownError);
            }
        });
           $("#footerNote").html("");
            document.getElementById('modalTitle').innerHTML='Edit';
           $('#myModal').modal('show');
    }

    function sendUpdate()
    {
        var module_name='updatePersonnel'
        var personnelId=window.pk_personnel;
        var personnelIDnumber=document.getElementById('mymodal_personnel_idnumber').value;
        var personnelFname=document.getElementById('mymodal_personnel_fname').value;
        var personnelMname=document.getElementById('mymodal_personnel_mname').value;
        var personnelLname=document.getElementById('mymodal_personnel_lname').value;
        var personnelDesignation=document.getElementById('mymodal_personnel_designation').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,personnel_idnumber:personnelIDnumber,personnel_id:personnelId,personnel_fname:personnelFname,personnel_mname:personnelMname,personnel_lname:personnelLname,personnel_designation:personnelDesignation},
             beforeSend: function()
            {
                 $("#footerNote").html("Updating.....");
            },
            success:function(response)
            {
                $("#footerNote").html(response);
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
                $("#footerNote").html("Update failed");
            }
        });
    }
    //<!---------------End Edit Modal--------------->

    //<!---------------Delete Modal--------------->
    function deletePersonnel($id)
    {
        var module_name='viewPersonnel';
        var personnelid=parseInt($id);
        pk_personnel=$id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,personnel_id:personnelid},
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
                alert(thrownError);
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
        var module_name='deletePersonnel'
        var personnelId=window.pk_personnel;
        jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,personnel_id:personnelId},
                 beforeSend: function()
                {
                    $("#footerNote").html("Deleting....");
                },
                success:function(response)
                {
                    $("#footerNote").html(response);
                },
                error:function (xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError);
                    $("#footerNote").html("Delete failed");
                }
        });
    }
    //<!---------------Edn Delete Modal--------------->

    //<!---------------Start Pagination--------------->
    function paginationButton(pageId,searchstring){
        var module_name='paginationPersonnel'
        var page_Id=parseInt(pageId);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,page_id:page_Id,search_string:searchstring},
             beforeSend: function()
            {
            },
            success:function(response)
            {
              $("#search_table").html(response);
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        });
    }
    //<!---------------End Delete Modal--------------->
</script>
</body>
</html>