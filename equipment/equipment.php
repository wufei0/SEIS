<!DOCTYPE html>
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
                            <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Equipment</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddEquipment()">
                             <div class="form-group">
                               <label  class="col-sm-2 control-label group-inputtext">Equip. No:</label>
                                <div class="col-sm-4">
                                  <input type="text" class="form-control input-size" id="equipment_number">
                                </div>
                                <label  class="col-sm-2 control-label group-inputtext">Description:</label>
                                <div class="col-sm-4">
                                  <input type="text" class="form-control input-size" id="equipment_description">
                                </div>
                             </div>
                             <div class="form-group">
                                  <label  class="col-sm-2 control-label group-inputtext">Acq. Date:</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control input-size" id="equipment_acquisitiondate">
                                </div>

                                <label  class="col-sm-2 control-label group-inputtext">Acq. Cost:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control input-size" id="equipment_acquisitioncost">
                                </div>
                             </div>
                             <div class="form-group">
                                   <label  class="col-sm-2 control-label group-inputtext">Serial:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-size" id="equipment_serial">
                                </div>

                                <label  class="col-sm-2 control-label group-inputtext">Model:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-size" id="equipment_model">
                                </div>
                             </div>
                             <div class="form-group">

                                <label  class="col-sm-2 control-label group-inputtext">Brand:</label>
                               <div class="col-sm-4">
                             <div class="input-group">
                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Brand" id="equipment_brand">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="selectBrand();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                              </div><!-- /input-group -->
                            </div>

                                <label  class="col-sm-2 control-label group-inputtext">Tag:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-size" id="equipment_tag">
                                </div>

                             </div>
                             <div class="form-group">
                                 <label  class="col-sm-2 control-label group-inputtext">Classification:</label>
                               <div class="col-sm-4">
                             <div class="input-group">
                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Classification" id="equipment_classification">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="selectClassification();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                              </div><!-- /input-group -->
                            </div>

                                <label  class="col-sm-2 control-label group-inputtext">Division:</label>
                               <div class="col-sm-4">
                             <div class="input-group">
                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Division" id="equipment_division">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="selectDivision();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                              </div><!-- /input-group -->
                            </div>
                             </div>
                             <div class="form-group">
                                 <label  class="col-sm-2 control-label group-inputtext">Status:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-size" id="equipment_status">
                                </div>

                                <label  class="col-sm-2 control-label group-inputtext">Location:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-size" id="equipment_location">
                                </div>
                             </div>
                              <div class="retyrewt">
                                    <button type="submit" class="btn btn-primary button-right" id="create_equipment">Create</button>
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
                                         <form class="form-horizontal"  onSubmit="return SearchEquipment();">
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
                                                                <td class="equipNumberWidth"><b>Equipment Number</b></td>
                                                                <td class="equipDescWidth"><b>Equipment Description</b></td>
                                                                <td class="equipModelWidth"><b>Model</b></td>
                                                                <td class="equipStatusWidth"><b>Status</b></td>
                                                                <td class="equipLocationWidth"><b>Location</b></td>
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
    var form_name='USER';//holder for privilege checking
    var pk_brand;
    var brandid;
    var classificationid;
    var divisionid;
    function selectClassification(){
            var module_name='selectClassification';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name},
                beforeSend: function()
                {
                    $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchClassification(document.getElementById(\'txtclassification\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtclassification" class="form-control"  onkeyup="if(event.keyCode == 13){searchClassification(this.value)};" placeholder="Search Classification"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                    $("#content").append(response);
                },
            });
            document.getElementById('modalTitle').innerHTML='Classification';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchClassification(searchstring){
            var module_name='searchClassification';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,search_string:searchstring},
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Classification Name";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
                },
            });
    }

    function selectedClassification(search_classification,id){
        $('#myModal').modal('hide');
        document.getElementById('equipment_classification').value=search_classification;
        classificationid=id;
    }

    function selectBrand()
    {
            var module_name='selectBrand';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name},
                beforeSend: function()
                {
                   $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchBrand(document.getElementById(\'txtbrand\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtbrand" class="form-control" onkeyup="if(event.keyCode == 13){searchBrand(this.value)};" placeholder="Search Brand"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                    $("#content").append(response);
                },
            });
            document.getElementById('modalTitle').innerHTML='Brand';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchBrand(searchstring){
            var module_name='searchBrand';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,search_string:searchstring},
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Brand Name";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
                },
            });
    }

    function selectedBrand(search_brand,id){
        $('#myModal').modal('hide');
        document.getElementById('equipment_brand').value=search_brand;
        brandid=id;
    }

    function selectDivision()
    {
        var module_name='selectDivision';
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name},
             beforeSend: function()
            {
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchDivision(document.getElementById(\'txtdivision\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtdivision" class="form-control"  onkeyup="if(event.keyCode == 13){searchDivision(this.value)};" placeholder="Search Division"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                $("#content").append(response);
            },
        });
        document.getElementById('modalTitle').innerHTML='Division';
        $("#footerNote").html("");
        $('#myModal').modal('show');
    }

    function searchDivision(searchstring){
        var module_name='searchDivision';
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,search_string:searchstring},
            beforeSend: function()
            {
                $("#footerNote").html('');
                $("#content").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
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
                    var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Division Name";
                    $("#content").html(message);
                    $("#footerNote").html('');
                }
            },
        });
    }

    function selectedDivision(search_equipment,id){
        $('#myModal').modal('hide');
        document.getElementById('equipment_division').value=search_equipment;
        divisionid=id;
    }



    //<!---------------Save Ajax--------------->
    function AddEquipment()
    {
        var module_name='addEquipment';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,equipment_number:$("#equipment_number").val(),equipment_description:$("#equipment_description").val(),equipment_acquisitiondate:$("#equipment_acquisitiondate").val(),equipment_acquisitioncost:$("#equipment_acquisitioncost").val(),equipment_serial:$("#equipment_serial").val(),equipment_model:$("#equipment_model").val(),equipment_brand:$("#equipment_brand").val(),equipment_tag:$("#equipment_tag").val(),equipment_classification:$("#equipment_classification").val(),equipment_division:$("#equipment_division").val(),equipment_status:$("#equipment_status").val(),equipment_location:$("#equipment_location").val(),brand_id:brandid,classification_id:classificationid,division_id:divisionid},
                beforeSend: function()
               {
                   $.blockUI();
                   document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {

                $.unblockUI();
                $("#addStatus").html('');
                if (response=='Equipment added successfully')
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

        function SearchEquipment() {
        var module_name='searchEquipment';
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
                    $("#page_search").html(response);
                }


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

                },
                error:function (xhr, ajaxOptions, thrownError){
                    $.unblockUI();
                    $.growl.error({ message: thrownError });
                }
         });
         return false;
    }

    function viewEquipment(EquipmentID)
    {
        var module_name='viewEquipment';
        var equipmentid=parseInt(EquipmentID);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,equipment_id:equipmentid},
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
    function editEquipment(EquipmentID)
    {
        var module_name='editEquipment';
        var equipmentid=parseInt(EquipmentID);
        pk_equipment=EquipmentID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{form:form_name,module:module_name,equipment_id:equipmentid},
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
        var module_name='updateEquipment'
        var equipmentId=window.pk_equipment;
        var equipmentName=document.getElementById('mymodal_equipment_name').value;
        var equipmentDesc=document.getElementById('mymodal_equipment_desc').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html',
            data:{form:form_name,module:module_name,equipment_id:equipmentId,equipment_name:equipmentName,equipment_desc:equipmentDesc},
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
    function deleteEquipment($id)
    {
        var module_name='viewEquipment';
        var equipmentid=parseInt($id);
        pk_equipment=$id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,equipment_id:equipmentid},
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
        var module_name='deleteEquipment'
        var equipmentId=window.pk_equipment;
        jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,equipment_id:equipmentId},
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
    var module_name='paginationEquipment';
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
               $.unblockUI();
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