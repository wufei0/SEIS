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
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Model</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed;">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddModel()">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Model Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="model_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Description:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="description_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Brand Name:</label>
                                <div class="col-sm-10 input-width">
                                    <?php
                                        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                                        if (mysqli_connect_error())
                                        {
                                            echo "Connection Error";
                                            die();
                                        }
                                        $sql="SELECT Brand_ID, Brand_Name,Brand_Description FROM M_Brand ORDER BY Brand_Name";
                                        $resultset=  mysqli_query($conn, $sql);
                                        echo "<select id='brand_id' class='form-control input-size selectpicker'>";
                                        foreach($resultset as $rows)
                                        {
                                            echo "<option data-subtext='".$rows['Brand_Description']."' value=".$rows['Brand_ID'].">".$rows['Brand_Name']."</option>";
                                        }
                                        echo "</select>";

                                        mysqli_close($conn);
                                    ?>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" id="create_brand">Create</button>
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
                                         <form class="form-horizontal"  onSubmit="return SearchModel();">
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

                                                                <td class="divisionNameWidth"><b>Model</b></td>
                                                                <td class="divisionNameWidth"><b>Description</b></td>
                                                                <td class="divisionNameWidth"><b>Brand</b></td>
                                                                <td class="divisionNameWidth"><b>Transdate</b></td>


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
  

//<!---------------end Modal container--------------->


	include_once('../footer.php');

?>
<script language="JavaScript" type="text/javascript">
    var form_name='USER';//holder for privilege checking
    var pk_model;
    //<!---------------Save Ajax--------------->
    function AddModel()
    {
        var module_name='addModel';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,model_name:$("#model_name").val(),desc_name:$("#description_name").val(),fkBrandId:$("#brand_id").val()},
                beforeSend: function()
               {
                    $.blockUI();
                    document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                   $.unblockUI();
                $("#addStatus").html('');
                if (response=='Model added successfully')
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
               error:function (xhr, ajaxOptions, thrownError){
                   $.unblockUI();
                   $("#addStatus").html('');
                   $.growl.error({ message: thrownError });
               }
        });
           return false;
    }
    ///<!---------------End Save Ajax--------------->

    ///<!---------------Search Ajax--------------->
    function SearchModel() {
        var module_name='searchModel';
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
                  document.getElementById('searchStatus').innerHTML='';
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
                    if(numberOfsearch!=0)
                    {
                        document.getElementById('1').className="active";
                    }
                    else
                    {
                         $("#searchStatus").html("No Result Found");
                    }

                    }
                  
                },
                error:function (xhr, ajaxOptions, thrownError){
                    $.unblockUI();
                    $.growl.error({ message: thrownError });
                }
         });
         return false;
    }
    ///<!---------------End Search Ajax--------------->

    ///<!---------------View Modal--------------->
    function viewBrand(BrandID)
    {
        var module_name='viewBrand';
        var brandid=parseInt(BrandID);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,brand_id:brandid},
             beforeSend: function()
            {
                 $.blockUI();
                 $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $.unblockUI();
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

    ///<!---------------Edit Modal--------------->
    function editBrand(BrandID)
    {
        var module_name='editBrand';
        var brandid=parseInt(BrandID);
        pk_brand=BrandID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{form:form_name,module:module_name,brand_id:brandid},
             beforeSend: function()
            {
                 $.blockUI();
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $.unblockUI();
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

    function sendUpdate()
    {
        var module_name='updateBrand'
        var brandId=window.pk_brand;
        var brandName=document.getElementById('mymodal_brand_name').value;
        var brandDesc=document.getElementById('mymodal_brand_desc').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html',
            data:{form:form_name,module:module_name,brand_id:brandId,brand_name:brandName,brand_desc:brandDesc},
             beforeSend: function()
            {
                 $.blockUI();
                 $("#footerNote").html("Updating.....");
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
                $("#footerNote").html("");
            },
            error:function (xhr, ajaxOptions, thrownError){
                $.unblockUI();
                 $.growl.error({ message: thrownError });
                $("#footerNote").html("Update failed");
            }
        });
    }
     ///<!---------------End Edit Modal--------------->

     ///<!---------------Delete Modal--------------->
    function deleteBrand($id)
    {
        var module_name='viewBrand';
        var brandid=parseInt($id);
        pk_brand=$id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,brand_id:brandid},
             beforeSend: function()
            {
                 $.blockUI();
                $("#footerNote").html("");
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left"  onclick="sendDelete();">Delete</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            },
            success:function(response)
            {
                $.unblockUI();
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
        var module_name='deleteBrand'
        var brandId=window.pk_brand;
        jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,brand_id:brandId},
                 beforeSend: function()
                {
                     $.blockUI();
                    $("#footerNote").html("Deleting....");
                },
                success:function(response)
                {
                    $.unblockUI();
                    if (response=='Delete Successful')
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
                    $("#footerNote").html("");
                },
                error:function (xhr, ajaxOptions, thrownError)
                {
                    $.unblockUI();
                     $.growl.error({ message: thrownError });
                    $("#footerNote").html("");
                }
        });
    }
    //<!---------------End Delete Modal--------------->

    //<!---------------Pagination--------------->
    function paginationButton(pageId,searchstring,totalpages){
    var module_name='paginationBrand';
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
</script>
</body>
</html>