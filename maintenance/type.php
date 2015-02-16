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
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Type</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddType()">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Type Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="type_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Description:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="description_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" id="create_type">Create</button>
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
                                         <form class="form-horizontal"  onSubmit="return SearchType();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_type" class="btn btn-default btn-size" type="submit">
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

                                                                <td class="groupNameWidth"><b>Type Name</b></td>


                                                                <td class="groupDescWidth"><b>Description</b></td>

                                                                <td class="groupTransdateWidth"><b>Transdate</b></td>


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
    var pk_type;
    //<!---------------Save Ajax--------------->
    function AddType()
    {
        var module_name='addType';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{module:module_name,type_name:$("#type_name").val(),desc_name:$("#description_name").val()},
                beforeSend: function()
               {
                   document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
               //alert(response);
               //  document.getElementById('addStatus').innerHTML='Group added successfully';
                $("#addStatus").html(response);
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
        });
           return false;
    }
    ///<!---------------End Save Ajax--------------->

     //<!---------------Search Ajax--------------->
    function SearchType() {
         var module_name='searchType';
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
                  document.getElementById('1').className="active";
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
         });
         return false;
    }

     //<!---------------View Modal--------------->
    function viewType(TypeID)
    {
        var module_name='viewType';
        var typeid=parseInt(TypeID);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,type_id:typeid},
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
    function editType(TypeID)
    {
        var module_name='editType';
        var typeid=parseInt(TypeID);
        pk_type=TypeID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{module:module_name,type_id:typeid},
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
        var module_name='updateType'
        var typeId=window.pk_type;
        var typeName=document.getElementById('mymodal_type_name').value;
        var typeDesc=document.getElementById('mymodal_type_desc').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,type_id:typeId,type_name:typeName,type_desc:typeDesc},
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
    function deleteType($id)
    {
        var module_name='viewType';
        var typeid=parseInt($id);
        pk_type=$id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,type_id:typeid},
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
        var module_name='deleteType'
        var typeId=window.pk_type;
        jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,type_id:typeId},
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
    function paginationButton(pageId,searchstring,totalpages){
        var module_name='paginationType'
        var page_Id=parseInt(pageId);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,page_id:page_Id,search_string:searchstring,total_pages:totalpages},
             beforeSend: function()
            {
               document.getElementById('searchStatus').innerHTML='Searching....';
            },
            success:function(response)
            {
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
                alert(thrownError);
            }
        });
    }
    //<!---------------End Delete Modal--------------->
</script>
</body>
</html>