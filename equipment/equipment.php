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
                            <form class="form-horizontal" onSubmit="return AddEquipment()" id="form_equipment">
                                 <div class="form-group">
                                    <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Property No.:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="text" class="form-control input-size" id="equipment_number">
                                        </div>
                                    </div>
                                    <div id="col-right">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Inventory Tag:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="text" class="form-control input-size" id="equipment_tag">
                                        </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Description:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="text" class="form-control input-size" id="equipment_description">
                                        </div>
                                    </div>
                                    <div id="col-right">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Model:</label>
                                        <div class="col-sm-4 colsm4">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Model" id="equipment_model">
                                                <span class="input-group-btn">
                                                  <button class="btn btn-default" onclick="selectModel();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                     <div id="col-left">
                                         <label  class="col-sm-2 control-label group-inputtext textsize">Acquisition:</label>
                                         <div class="col-sm-4 colsm4">
                                         <input type="text" class="form-control input-size" id="equipment_acquisition">
                                         </div>
                                     </div>

                                         <div id="col-right">
                                         <label  class="col-sm-2 control-label group-inputtext textsize">Classification:</label>
                                       <div class="col-sm-4 colsm4">
                                          <div class="input-group">
                                              <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Classification" id="equipment_classification">
                                              <span class="input-group-btn">
                                                    <button class="btn btn-default" onclick="selectClassification();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                              </span>
                                          </div>
                                       </div>
                                     </div>

                                 </div>
                                 <div class="form-group">
                                     <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Acq. Date:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="date" class="form-control input-size" id="equipment_acquisitiondate">
                                        </div>
                                     </div>

                                     <div id="col-right">
                                         <label  class="col-sm-2 control-label group-inputtext textsize">Condition:</label>
                                         <div class="col-sm-4 colsm4">
                                         <input type="text" class="form-control input-size" id="equipment_condition">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Acq. Cost:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="number" step="0.01" class="form-control input-size" id="equipment_acquisitioncost">
                                        </div>
                                     </div>


                                     <div id="col-right">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Supplier
                                        :</label>
                                        <div class="col-sm-4 colsm4">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Supplier" id="equipment_supplier">
                                                <span class="input-group-btn">
                                                  <button class="btn btn-default" onclick="selectSupplier();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Serial:</label>
                                        <div class="col-sm-4 colsm4">
                                            <div class="input-group">
                                                <select class="form-control" readonly="readonly" id="equipment_serial"></select>
                                                <div id="txtserial_hidden_desc"></div>
                                                    <span class="input-group-btn">
                                                      <button class="btn btn-default" onclick="addSerial();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="col-right">
                                         <label  class="col-sm-2 control-label group-inputtext textsize">Remarks:</label>
                                         <div class="col-sm-4 colsm4">
                                         <input type="text" class="form-control input-size" id="equipment_remarks">
                                         </div>
                                     </div>
                                 </div>
                                 <div>
                                    <button type="submit" class="btn btn-primary button-right" id="create_equipment">Create</button>
                                 </div>
                            </form>
                        </div>
                        <div id="addStatus" class="panel-footer">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-xs-5 col-sm-5 col-md-5" style=" padding-right: 5px">
                                    <!---------------start search--------------->
                                        <form class="form-horizontal"  onSubmit="return SearchEquipment();">
                                            <div class="input-group input-group-sm">
                                                <input id="search_text" type="text" class="form-control" placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button id="search_personnel" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                </span>
                                            </div>
                                        </form>
                                    <!---------------end search--------------->
                                    </div>
                                    <div class="col-xs-7 col-sm-7 col-md-7 alert alert-danger" id="searchStatus" style=" display: none"  align="center">
                                       No Results Found!
                                    </div>
                            </div>
                        </div>
                        <div id="page_search">
                            <div class="panel-body bodyul" style="overflow: auto">
                                <table class="table table-hover fixed" id="search_table">
                                    <tr>
                                         <td style="width:10%;"><b>Property No.</b></td>
                                         <td style="width:10%;"><b>Description</b></td>
                                         <td style="width:10%;"><b>Inventory Tag</b></td>
                                         <td style="width:10%;"><b>Model</b></td>
                                         <td style="width:10%;"><b>Classification</b></td>
                                         <td style="width:10%;"><b>Condition</b></td>
                                         <td style="width:10%;"><b>Remarks</b></td>
                                         <td style="width:10%;" colspan="3" align="right"><b>Control Content</b></td>
                                    </tr>
                                    <tr>
                                        <!---------------start table--------------->
                                        <div class="row"></div>
                                        <!---------------end table--------------->
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-footer footer-size">
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
            include_once('modal.php');
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
<script language="JavaScript" type="text/javascript">
    var form_name='USER';//holder for privilege checking
    var modelid;
    var classificationid;
    var supplierid;
    var edit_modelid;
    var edit_classificationid;
    var edit_supplierid;
    var property_number;
    //----------------------Start Serial Modal-----------------------
    function addSerial(){
                    if($('#equipment_serial').has('option').length>0) {
                          $("#modalButton").html('<button type="button" id="button_done_1" class="btn btn-success" data-dismiss="modal">Done</button><button type="button" id="button_clear_1" class="btn btn-primary" onclick="clearList();">Clear</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                          $("#modalContent").html('<div class="row"><div class="col-md-4"><input type="text" id="txtserial" onkeyup="if(event.keyCode == 13){addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value)};" class="form-control" autofocus placeholder="Enter Serial"></div><div class="col-md-6"><input type="text" id="txtserial_description" onkeyup="if(event.keyCode == 13){addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value)};" class="form-control" autofocus placeholder="Description"></div><div class="col-md-2"><button class="btn btn-default" onclick="addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value);" type="button"><span class="glyphicon glyphicon-plus"></span></button></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"><table style="overflow:scroll" id="tableList" class="table table-bordered table-hover tablechoose"></table></div>');
                          var length = $('#equipment_serial > option').length;
                          length--;
                          while(length>=0){
                            var str = document.getElementById("equipment_serial");
                            var serial_value = str.options[length].value;
                            var str_desc = serial_value+'desc_serial';
                            var serial_desc = document.getElementById(str_desc).value;
                            $("#tableList").append('<tr onclick=removeList(this,\"'+serial_value+'\");><td>'+serial_value+'</td><td>'+serial_desc+'</td><td style="width:10px;" ><span class="glyphicon glyphicon-remove removecolor"></span></td></tr>');
                            length--;
                          }
                    }
                    else{
                          $("#modalButton").html('<button type="button" id="button_done_2" disabled class="btn btn-success" data-dismiss="modal">Done</button><button type="button" id="button_clear_2" disabled class="btn btn-primary" onclick="clearList();">Clear</button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                          $("#modalContent").html('<div class="row"><div class="col-md-4"><input type="text" id="txtserial" onkeyup="if(event.keyCode == 13){addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value)};" class="form-control" autofocus placeholder="Enter Serial"></div><div class="col-md-6"><input type="text" id="txtserial_description" onkeyup="if(event.keyCode == 13){addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value)};" class="form-control" autofocus placeholder="Description"></div><div class="col-md-2"><button class="btn btn-default" onclick="addSerialToList(document.getElementById(\'txtserial\').value,document.getElementById(\'txtserial_description\').value);" type="button"><span class="glyphicon glyphicon-plus"></span></button></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"><table style="overflow:scroll" id="tableList" class="table table-bordered table-hover tablechoose"></table></div>');
                    }
            document.getElementById('modalTitle').innerHTML='Add Serial';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function addSerialToList(serial_value,desc){
            if($("#equipment_serial option[value=\'"+serial_value+"\']").length > 0){
                $("#footerNote").html('<b>'+serial_value+'</b> is already added in the list');
            }
            else{
                if(serial_value==''){
                    $("#footerNote").html('Please enter a valid Serial Number...');
                }else{
                    $("#tableList").prepend('<tr onclick=removeList(this,\"'+serial_value+'\");><td>'+serial_value+'</td><td>'+desc+'</td><td style="width:10px;" ><span class="glyphicon glyphicon-remove removecolor"></span></td></tr>');
                    $("#equipment_serial").prepend('<option value=\"'+serial_value+'\" disabled>'+serial_value+' - '+desc+'</option>');
                    $("#txtserial_hidden_desc").prepend('<input type="hidden" value=\"'+desc+'\" name="Testing" id=\"'+serial_value+'desc_serial\">');
                    document.getElementById('txtserial').value = "";
                    document.getElementById('txtserial_description').value = "";
                    $("#footerNote").html('');

               }
               $('#button_done_1').prop('disabled', false);
               $('#button_done_2').prop('disabled', false);
               $('#button_clear_1').prop('disabled', false);
               $('#button_clear_2').prop('disabled', false);
            }
    }

    function removeList(serialIndex,serial_value){
      var remove_hidden_serial=serial_value+'desc_serial';
        var elem = document.getElementById(remove_hidden_serial);
        elem.remove();
        document.getElementById("tableList").deleteRow(serialIndex.rowIndex);
        $("#equipment_serial option[value=\'"+serial_value+"\']").remove();
        $("#footerNote").html('');
        if($('#equipment_serial').has('option').length==0) {
            $('#button_done_1').prop('disabled', true);
            $('#button_done_2').prop('disabled', true);
            $('#button_clear_1').prop('disabled', true);
            $('#button_clear_2').prop('disabled', true);
        }
    }

    function clearList(){
        $("#txtserial_hidden_desc").html('');
        $("#footerNote").html('');
        $('#tableList').html("");
        $('#equipment_serial')
        .find('option')
        .remove()
        .append('');
         $('#button_done_1').prop('disabled', true);
         $('#button_done_2').prop('disabled', true);
         $('#button_clear_1').prop('disabled', true);
         $('#button_clear_2').prop('disabled', true);
         txtserial_hidden_desc
    }
    //----------------------End Serial Modal-----------------------


    //----------------------Start Classification Modal-----------------------
    function selectClassification(){
            var module_name='selectClassification';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
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
            document.getElementById('modalTitle').innerHTML='Select Classification';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchClassification(searchstring){
            var module_name='searchClassification';
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
    //----------------------End Classification Modal-----------------------

    //<!---------------Start Model Modal--------------->
    function selectModel(){
            var module_name='selectModel';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
                beforeSend: function()
                {
                    $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchModel(document.getElementById(\'txtmodel\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtmodel" class="form-control"  onkeyup="if(event.keyCode == 13){searchModel(this.value)};" placeholder="Search Model"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                    $("#content").append(response);
                },
            });
            document.getElementById('modalTitle').innerHTML='Select Model';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchModel(searchstring){
            var module_name='searchModel';
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Model Name";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
                },
            });
    }

    function selectedModel(search_model,id){
        $('#myModal').modal('hide');
        document.getElementById('equipment_model').value=search_model;
        modelid=id;
    }
    //<!---------------End Model Modal--------------->

    //----------------------Start Add Equipment-----------------------
    function AddEquipment()
    {
          var serial_array = [];
          var serial_desc_array = [];
          $('#equipment_serial option').each(function() {
              serial_array.push($(this).val());
              var trytry=$(this).val()+'desc_serial';
              serial_desc_array.push(document.getElementById(trytry).value);
          });
          var module_name='addEquipment';
          jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,equipment_number:$("#equipment_number").val(),equipment_description:$("#equipment_description").val(),equipment_acquisitiondate:$("#equipment_acquisitiondate").val(),equipment_acquisitioncost:$("#equipment_acquisitioncost").val(),equipment_model:$("#equipment_model").val(),equipment_tag:$("#equipment_tag").val(),equipment_classification:$("#equipment_classification").val(),equipment_acquisition:$("#equipment_acquisition").val(),equipment_condition:$("#equipment_condition").val(),equipment_supplier:$("#equipment_supplier").val(),model_id:modelid,supplier_id:supplierid,classification_id:classificationid,serial_array:serial_array,equipment_serial:$("#equipment_serial").text(),serial_desc_array:serial_desc_array,equipment_remarks:$("#equipment_remarks").val()},
               beforeSend: function()
               {
                    $.blockUI();
               },
               success:function(response)
               {
                    $.unblockUI();
                    $("#addStatus").html('');
                    if (response=='Equipment added successfully')
                    {
                        $.growl.notice({ message: response });
                        $('#form_equipment')[0].reset();
                        $('#equipment_serial')[0].options.length = 0;
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
    //----------------------End Add Equipment-----------------------

    //----------------------Start Search Equipment-----------------------
    function SearchEquipment() {
        var module_name='searchEquipment';
        jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,searchText:$("#search_text").val()},
                beforeSend: function()
                {
                    $('#searchStatus').hide();
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
                        var splitResult=response.split("ajaxseparator");
                        var response=splitResult[0];
                        var numberOfsearch=splitResult[1];
                        $("#page_search").html(response);
                        if(numberOfsearch!=0){
                        document.getElementById('1').className="active";
                        }else{
                             $('#searchStatus').show();
                             $('#searchStatus').delay(5000).fadeOut(1000);
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
    //----------------------End Search Equipment-----------------------

    //----------------------Start View Equipment-----------------------
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
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                $("#modalContent").html(response);
            },
        });
        document.getElementById('modalTitle').innerHTML='View Property';
        $('#myModal').modal('show');
        $("#footerNote").html("");
    }
    //<!---------------End View Modal--------------->

    //<!---------------Start Edit equipment--------------->
    function editEquipment(EquipmentID,modelid,classificationid,supplierid)
    {
        edit_modelid=modelid;
        edit_classificationid=classificationid;
        edit_supplierid=supplierid;
        property_number=EquipmentID;
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
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#footerNote").html("");
                $("#modalContent").html(response);
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left" id="save_changes" onclick="sendUpdate();">Update</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            },
        });
        $("#footerNote").html("");
        document.getElementById('modalTitle').innerHTML='Edit Property';
        $('#myModal').modal('show');
    }

    function sendUpdate()
    {
        var module_name='updateEquipment'
        var equipmentId=window.pk_equipment;
        var equipmentNumber=document.getElementById('mymodal_equipment_number').value;
        var equipmentDesc=document.getElementById('mymodal_equipment_description').value;
        var equipmentAcquisition=document.getElementById('mymodal_equipment_acquisition').value;
        var equipmentAcquisitionDate=document.getElementById('mymodal_equipment_acquisitiondate').value;
        var equipmentAcquisitionCost=document.getElementById('mymodal_equipment_acquisitioncost').value;
        var equipmentTag=document.getElementById('mymodal_equipment_tag').value;
        var equipmentModel=document.getElementById('equipment_modelovermodal').value;
        var equipmentCondition=document.getElementById('mymodal_equipment_condition').value;
        var equipmentClassification=document.getElementById('equipment_classificationovermodal').value;
        var equipmentSupplier=document.getElementById('equipment_supplierovermodal').value;
        var equipmentRemarks=document.getElementById('mymodal_equipment_remarks').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html',
            data:{form:form_name,module:module_name,equipment_id:equipmentId,equipment_number:equipmentNumber,equipment_remarks:equipmentRemarks,equipment_desc:equipmentDesc,equipment_acquisition:equipmentAcquisition,equipment_acquisitiondate:equipmentAcquisitionDate,equipment_acquisitioncost:equipmentAcquisitionCost,equipment_tag:equipmentTag,equipment_model:equipmentModel,equipment_condition:equipmentCondition,equipment_classification:equipmentClassification,equipment_supplier:equipmentSupplier,model_id:edit_modelid,classification_id:edit_classificationid,supplier_id:edit_supplierid},
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
                }
                else if (response=='Cannot Save Blank Equipment Information')
                {
                     $("#footerNote").html(response);
                }
                      else if (response=='Duplicate Equipment Name detected')
                {
                     $("#footerNote").html(response);
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                $.unblockUI();
                $.growl.error({ message: thrownError });
                $("#footerNote").html("Update failed");
            }
        });
    }
     ///<!---------------End Edit Modal--------------->

     ///<!---------------Start Delete Equipment--------------->
    function deleteEquipment($id,string_search)
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
                $("#footerNote").html("");
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left"  onclick="sendDelete();">Delete</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            },
            success:function(response)
            {
                $("#modalContent").html(response);
            },
        });
        document.getElementById('modalTitle').innerHTML='Delete Property';
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
                dataType:'text', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,equipment_id:equipmentId},
                beforeSend: function()
                {
                    $("#footerNoteovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    if (response=="Delete Successful")
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
                    $("#footerNote").html("");
                },
                error:function (xhr, ajaxOptions, thrownError)
                {
                    $.unblockUI();
                    $.growl.error({ message: thrownError });
                }
        });

    }
    //<!---------------End Delete Modal--------------->

    //<!---------------Start Pagination--------------->
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
                  },
                  success:function(response)
                  {
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
    //<!---------------End Pagination--------------->

    //<!---------------Start Edit Classification Modal Over Modal--------------->
    function selectClassificationovermodal(){
            var module_name='selectClassificationovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
                beforeSend: function()
                {
                    $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButtonovermodal").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchClassificationovermodal(document.getElementById(\'txtclassificationovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtclassificationovermodal" class="form-control"  onkeyup="if(event.keyCode == 13){searchClassificationovermodal(this.value)};" placeholder="Search Classification"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                    $("#contentovermodal").append(response);
                },
            });
            document.getElementById('modalTitleovermodal').innerHTML='Select Classification';
            $("#footerNoteovermodal").html("");
            $('#myModalovermodal').modal('show');
    }

    function searchClassificationovermodal(searchstring){
            var module_name='searchClassificationovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,search_string:searchstring},
                beforeSend: function()
                {
                    $("#footerNoteovermodal").html('');
                    $("#contentovermodal").html("<div align=\'center\'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    var splitResult=response.split("ajaxseparator");
                    var response=splitResult[0];
                    var numberOfsearch=splitResult[1];
                    if(numberOfsearch!=0){
                         $("#contentovermodal").html(response);
                         if(searchstring!=''){
                            var message="Showing results for <b>"+searchstring+"</b>";
                            $("#footerNoteovermodal").html(message);
                         }else{
                            $("#footerNoteovermodal").html('');
                         }
                    }else{
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Classification Name";
                         $("#contentovermodal").html(message);
                         $("#footerNoteovermodal").html('');
                    }
                },
            });
    }

    function selectedClassificationovermodal(search_classification,id){
        $('#myModalovermodal').modal('hide');
        document.getElementById('equipment_classificationovermodal').value=search_classification;
        classificationid=id;
        edit_classificationid=id;
    }
    //<!---------------End Edit Classification Modal Over Modal--------------->



    //<!---------------Start Edit Model Modal Over Modal--------------->
    function selectModelovermodal()
    {
            var module_name='selectModelovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
                beforeSend: function()
                {
                   $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButtonovermodal").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchModelovermodal(document.getElementById(\'txtmodelovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtmodelovermodal" class="form-control" onkeyup="if(event.keyCode == 13){searchModelovermodal(this.value)};" placeholder="Description"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                    $("#contentovermodal").append(response);
                },
            });
            document.getElementById('modalTitleovermodal').innerHTML='Select Model';
            $("#footerNoteovermodal").html("");
            $('#myModalovermodal').modal('show');
    }

    function searchModelovermodal(searchstring){
            var module_name='searchModelovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,search_string:searchstring},
                beforeSend: function()
                {
                    $("#footerNoteovermodal").html('');
                    $("#contentovermodal").html("<div align=\'center\'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    var splitResult=response.split("ajaxseparator");
                    var response=splitResult[0];
                    var numberOfsearch=splitResult[1];
                    if(numberOfsearch!=0){
                         $("#contentovermodal").html(response);
                         if(searchstring!=''){
                            var message="Showing results for <b>"+searchstring+"</b>";
                            $("#footerNoteovermodal").html(message);
                         }else{
                            $("#footerNoteovermodal").html('');
                         }
                    }else{
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Model Name";
                         $("#contentovermodal").html(message);
                         $("#footerNoteovermodal").html('');
                    }
                },
            });
    }

    function selectedModelovermodal(search_model,id){
        $('#myModalovermodal').modal('hide');
        document.getElementById('equipment_modelovermodal').value=search_model;
        modelid=id;
        edit_modelid=id;
    }
    //<!---------------Start Edit Model Modal Over Modal--------------->

    //<!---------------Start Edit Serial Modal Over Modal--------------->
    function addSerialovermodal(serial_id){
            var module_name='addSerialovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,serial_id:serial_id},
                beforeSend: function()
                {
                    $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButtonovermodal").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-4"><input type="text" id="txtserialovermodal" onkeyup="if(event.keyCode == 13){addSerialToListovermodal(document.getElementById(\'txtserialovermodal\').value,document.getElementById(\'txtserial_descriptionovermodal\').value)};" class="form-control" autofocus placeholder="Enter Serial"></div><div class="col-md-6"><input type="text" id="txtserial_descriptionovermodal" onkeyup="if(event.keyCode == 13){addSerialToListovermodal(document.getElementById(\'txtserialovermodal\').value,document.getElementById(\'txtserial_descriptionovermodal\').value)};" class="form-control" autofocus placeholder="Description"></div><div class="col-md-2"><button class="btn btn-default" onclick="addSerialToListovermodal(document.getElementById(\'txtserialovermodal\').value,document.getElementById(\'txtserial_descriptionovermodal\').value);" type="button"><span class="glyphicon glyphicon-plus"></span></button></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"><table style="overflow:scroll" id="tableListovermodal" class="table table-bordered table-hover tablechoose"></table></div>');
                    $("#tableListovermodal").append(response);
                },
            });
            document.getElementById('modalTitleovermodal').innerHTML='Add Serial';
            $('#myModalovermodal').modal('show');
            $("#footerNoteovermodal").html("");

    }

    function addSerialToListovermodal(serial_value,serial_desc){
            var module_name='addSerialToListovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,serial_value:serial_value,serial_desc:serial_desc,property_number:property_number},
                beforeSend: function()
                {
                   $("#footerNoteovermodal").html("");
                   $("#footerNoteovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                  if(response=="Duplicate Serial detected"){
                        $("#footerNoteovermodal").html("Duplicate Serial detected");
                  }
                  else if(response=="Cannot save blank Serial Number"){
                        $("#footerNoteovermodal").html("Cannot save blank Serial Number");
                  }
                  else{
                        var splitResult=response.split("ajaxseparator");
                        var tableserialcontent=splitResult[0];
                        var selectserialcontent=splitResult[1];
                        $("#tableListovermodal").append(tableserialcontent);
                        $("#mymodal_equipment_serial").append(selectserialcontent);
                        $("#footerNoteovermodal").html("");
                        document.getElementById('txtserialovermodal').value = "";
                        document.getElementById('txtserial_descriptionovermodal').value = "";
                  }
                },
            });
    }

    function deleteSerial(serialid,serialno){
        var module_name='deleteSerial';
        var serial_id=parseInt(serialid);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,serial_id:serialid,property_number:property_number},
            beforeSend: function()
            {
               $("#footerNoteovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                var splitResult=response.split("ajaxseparator");
                var delete_message=splitResult[0];
                var table_content=splitResult[1];
                $("#footerNoteovermodal").html(delete_message);
                $("#tableListovermodal").html(table_content);
                $("#mymodal_equipment_serial option[value=\'"+serialno+"\']").remove();
            },
        });
    }
    //<!---------------End Edit Serial Modal Over Modal--------------->

    //<!---------------Start Supplier Modal--------------->
    function selectSupplier(){
            var module_name='selectSupplier';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
                beforeSend: function()
                {
                    $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchSupplier(document.getElementById(\'txtsupplier\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtsupplier" class="form-control"  onkeyup="if(event.keyCode == 13){searchSupplier(this.value)};" placeholder="Search Supplier"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                    $("#content").append(response);
                },
            });
            document.getElementById('modalTitle').innerHTML='Select Supplier';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchSupplier(searchstring){
            var module_name='searchSupplier';
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Supplier Name";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
                },
            });
    }

    function selectedSupplier(search_supplier,id){
        $('#myModal').modal('hide');
        document.getElementById('equipment_supplier').value=search_supplier;
        supplierid=id;
    }
    //<!---------------End Supplier Modal--------------->

    //<!---------------Start Edit Supplier Modal Over Modal--------------->
    function selectSupplierovermodal()
    {
            var module_name='selectSupplierovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name},
                beforeSend: function()
                {
                   $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    $("#modalButtonovermodal").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchSupplierovermodal(document.getElementById(\'txtsupplierovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtsupplierovermodal" class="form-control" onkeyup="if(event.keyCode == 13){searchSupplierovermodal(this.value)};" placeholder="Description"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                    $("#contentovermodal").append(response);
                },
            });
            document.getElementById('modalTitleovermodal').innerHTML='Select Supplier';
            $("#footerNoteovermodal").html("");
            $('#myModalovermodal').modal('show');
    }

    function searchSupplierovermodal(searchstring){
            var module_name='searchSupplierovermodal';
            jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,search_string:searchstring},
                beforeSend: function()
                {
                    $("#footerNoteovermodal").html('');
                    $("#contentovermodal").html("<div align=\'center\'><img src='../images/ajax-loader.gif' /></div>");
                },
                success:function(response)
                {
                    var splitResult=response.split("ajaxseparator");
                    var response=splitResult[0];
                    var numberOfsearch=splitResult[1];
                    if(numberOfsearch!=0){
                         $("#contentovermodal").html(response);
                         if(searchstring!=''){
                            var message="Showing results for <b>"+searchstring+"</b>";
                            $("#footerNoteovermodal").html(message);
                         }else{
                            $("#footerNoteovermodal").html('');
                         }
                    }else{
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Supplier Name";
                         $("#contentovermodal").html(message);
                         $("#footerNoteovermodal").html('');
                    }
                },
            });
    }

    function selectedSupplierovermodal(search_supplier,id){
        $('#myModalovermodal').modal('hide');
        document.getElementById('equipment_supplierovermodal').value=search_supplier;
        supplierid=id;
        edit_supplierid=id;
    }
    //<!---------------Start Edit Supplier Modal Over Modal--------------->

</script>
</body>
</html>