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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Property Acknowlegdement Receipt</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul" style="overflow: fixed;">
                            <!---------------start create par--------------->
                            <form class="form-horizontal" onSubmit="return addEquipmentPAR()" id="form_equipmentpar">
                                  <div class="panel-body bodyul">
                                      <div class="row">
                                              <div class="scrollwd">
                                                  <table style="width:2500px;" class="table table-bordered table-hover tablechoose" id="table_property">
                                                      <tr style="cursor: default">
                                                          <th style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></th>
                                                          <th>Prop No.</th>
                                                          <th>Description</th>
                                                          <th>Acq. Date</th>
                                                          <th>Acq. Cost</th>
                                                          <th>Model</th>
                                                          <th>Brand</th>
                                                          <th>Inventory Tag</th>
                                                          <th>Classification</th>
                                                          <th>Division</th>
                                                          <th>Remarks</th>
                                                          <th>Location</th>
                                                          <th>Condition</th>
                                                          <th>Acquisition</th>
                                                      </tr>
                                                  </table>
                                              </div>
                                              <div class="buttonright">
                                                    <button style="width:79px;" type="button" class="btn btn-success" onclick="selectProperty();">Add</button>
                                                    <button type="button" class="btn btn-danger" id="prop_remove" disabled="disabled" onclick="remove_property();">Remove</button>
                                              </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div id="col-left1">
                                          <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">GSO No.:</label>
                                          <div class="col-sm-4 colsm04">
                                                <input type="text" class="form-control input-size" id="equipmentpar_gsonumber">
                                          </div>
                                      </div>
                                      <div id="col-left1">
                                          <label  style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Date:</label>
                                          <div class="col-sm-4 colsm04">
                                            <input type="date" class="form-control input-size" id="equipmentpar_date">
                                          </div>
                                      </div>
                                      <div id="col-right1">
                                          <label style="float:left; margin-left:15px; padding-top: 7px;">Office:</label>
                                                <div class="col-sm-4 colsm04right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Office" id="equipmentpar_division">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" onclick="selectDivision();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                        </span>
                                                    </div>
                                                </div>
                                      </div>
                                      <div id="col-left1">
                                          <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Recipient:</label>
                                          <div class="col-sm-4 colsm04">
                                              <div class="input-group">
                                                    <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Recipient" id="equipmentpar_personnel">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" onclick="selectPersonnel();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="col-left1">
                                          <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">PAR Type:</label>
                                          <div class="col-sm-4 colsm04">
                                              <select class='form-control input-size selectpicker' id="equipmentpar_type">
                                                    <option data-subtext='Donation' value='Donation' >Donation</option>
                                                    <option data-subtext='Office Use' value='Donation' >Office Use</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="tclear"></div>
                                      <div id="col-width1">
                                          <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Note:</label>
                                          <div class="col-sm-4 colsmwhole4">
                                              <input style="width:100%;" type="text" class="form-control input-size" id="equipmentpar_note">
                                          </div>
                                      </div>
                                      <div class="tclear"></div>
                                      <div id="col-width1">
                                          <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Remarks:</label>
                                          <div class="col-sm-4 colsmwhole4">
                                                <input style="width:100%;" type="text" class="form-control input-size" id="equipmentpar_remarks">
                                          </div>
                                      </div>
                                  </div>
                                  <div>
                                      <button type="submit" class="btn btn-primary button-right" id="create_equipment">Submit</button>
                                  </div>
                            </form>
                        </div>
                        <div id="addStatus" class="panel-footer footer-size"></div>
                        <!---------------end create par--------------->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading header-size">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title"></h3></div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                            <!---------------start search--------------->
                                            <form class="form-horizontal"  onSubmit="return SearchEquipmentPAR();">
                                                <div class="input-group">
                                                  <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                                  <span class="input-group-btn">
                                                    <button id="search_personnel" class="btn btn-default btn-size" type="submit">
                                                        <span class="glyphicon glyphicon-search"></span>
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
                                                <td style="width:12%;"><b>GSO Number</b></td>
                                                <td style="width:12%;"><b>Date</b></td>
                                                <td style="width:12%;"><b>Office</b></td>
                                                <td style="width:12%;"><b>Recepient</b></td>
                                                <td style="width:12%;"><b>Type</b></td>
                                                <td style="width:12%;"><b>Note</b></td>
                                                <td style="width:12%;"><b>Remarks</b></td>
                                            </div>
                                            <div class="col-md-1">
                                                <td style="width:12%;" colspan="3" align="right"><b>Control Content</b></td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <!---------------start table--------------->
                                        <div class="row"></div>
                                        <!---------------end table--------------->
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-footer footer-size">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="searchStatus" class="panel-footer"></div>
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
            include_once('modal.php');
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
        <script>
            var form_name='USER';
            var personnelid;
            var divisionid;
            var edit_personnelid;
            var edit_divisionid;
            var property_array = [];
            var property_numberpar;
            function selectProperty()
            {
                var module_name='selectPropertyPAR';
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default"onclick="searchProperty(document.getElementById(\'txtProperty\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtProperty" class="form-control"  onkeyup="if(event.keyCode == 13){searchProperty(this.value)};" placeholder="Search Property"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Property';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }

            function searchProperty(searchstring)
            {
                var module_name='searchPropertyPAR';
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
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any property.";
                                 $("#content").html(message);
                                 $("#footerNote").html('');
                            }
                    }
                });
            }

            function selectedProperty(id,property_number,property_desc,acquisition_date,acquisition_cost,model,brand,property_tag,classification,remarks,location,property_condition,property_acquisition)
            {
               var search=property_number;
               var tdnum=$('#table_property tr > td:nth-child(3)').filter(function() { return $(this).text() == search;});
               if(tdnum.length>0){
                      $("#footerNote").html('Already added in the list.');
               }else{
                      $("#table_property").append('<tr><td><input type="checkbox" onchange="changeremovebtn();" /></td><td style="display:none">'+id+'</td><td>'+property_number+'</td><td>'+property_desc+'</td><td>'+acquisition_date+'</td><td>'+acquisition_cost+'</td><td>'+model+'</td><td>'+brand+'</td><td>'+property_tag+'</td><td>'+classification+'</td><td>"division"</td><td>'+remarks+'</td><td>'+location+'</td><td>'+property_condition+'</td><td>'+property_acquisition+'</td></tr>');
                      $('#myModal').modal('hide');
                      property_array.push(id);
               }
            }

            function selectPersonnel()
            {
                var module_name='selectPersonnel';
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default"onclick="searchPersonnel(document.getElementById(\'txtPersonnel\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtPersonnel" class="form-control"  onkeyup="if(event.keyCode == 13){searchPersonnel(this.value)};" placeholder="Search Personnel"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Personnel';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }

            function searchPersonnel(searchstring)
            {
                var module_name='searchPersonnel';
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
                                var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any personnel.";
                                $("#content").html(message);
                                $("#footerNote").html('');
                            }
                    }
                });
            }

            function selectedPersonnel(fname,mname,lname,id){
                $('#myModal').modal('hide');
                document.getElementById('equipmentpar_personnel').value=lname+', '+fname+' '+mname;
                personnelid=id;
                edit_personnelid=id;
            }

            function selectDivision()
            {
                var module_name='selectDivision';
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default"onclick="searchDivision(document.getElementById(\'txtDivision\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtDivision" class="form-control"  onkeyup="if(event.keyCode == 13){searchDivision(this.value)};" placeholder="Search Division"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Division';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }

            function searchDivision(searchstring)
            {
                var module_name='searchDivision';
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
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any division.";
                                 $("#content").html(message);
                                 $("#footerNote").html('');
                            }
                    }
                });
            }

            function selectedDivision(search_division,id){
                $('#myModal').modal('hide');
                document.getElementById('equipmentpar_division').value=search_division;
                divisionid=id;
                edit_divisionid=id;
            }

            function addEquipmentPAR()
            {
                var module_name='addEquipmentPAR';
                jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,equipmentpar_gsonumber:$("#equipmentpar_gsonumber").val(),equipmentpar_date:$("#equipmentpar_date").val(),equipmentpar_division:$("#equipmentpar_division").val(),equipmentpar_personnel:$("#equipmentpar_personnel").val(),equipmentpar_type:$("#equipmentpar_type").val(),equipmentpar_note:$("#equipmentpar_note").val(),equipmentpar_remarks:$("#equipmentpar_remarks").val(),personnel_id:personnelid,division_id:divisionid,property_array:property_array},
                       beforeSend: function()
                       {
                           $.blockUI();
                       },
                       success:function(response)
                       {
                           $.unblockUI();
                           $("#addStatus").html('');
                           if (response=='PAR added successfully')
                           {
                                $.growl.notice({ message: response });
                                $('#form_equipmentpar')[0].reset();
                                $("#table_property > tbody").html("<table style='width:2500px;' class='table table-bordered table-hover tablechoose' id='table_property'><th style='width: 30px'><input style='cursor: default' disabled='disabled' type='checkbox' aria-label='...'  /></th><th>Prop No.</th><th>Description</th><th>Acq. Date</th><th>Acq. Cost</th><th>Model</th><th>Brand</th><th>Inventory Tag</th><th>Classification</th><th>Division</th><th>Remarks</th><th>Location</th><th>Condition</th><th>Acquisition</th></table>");
                                property_array = [];
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

            function remove_property(){
                 $('#table_property tr ').has('input:checkbox:checked').remove();
                 $('#prop_remove').prop('disabled', true);
                 property_array = [];
                 $('#table_property tr > td:nth-child(2)').each( function(){
                    property_array.push( $(this).text() );
                 });
            }

            function changeremovebtn(){
                     var inputcheck=$('#table_property tr').has('input:checkbox:checked').length;
                     if(inputcheck==0){
                          $('#prop_remove').prop('disabled', true);
                     }else{
                          $('#prop_remove').prop('disabled', false);
                     }
            }

            //----------------------Start Search Equipment-----------------------
            function SearchEquipmentPAR(){
                var module_name='searchEquipmentPAR';
                jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,searchText:$("#search_text").val()},
                        beforeSend: function()
                        {
                            $.blockUI();
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
                 return false;
            }
            //----------------------End Search Equipment-----------------------

            function viewEquipmentPAR(EquipmentPARID)
            {
                var module_name='viewEquipmentPAR';
                var equipmentparid=parseInt(EquipmentPARID);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{form:form_name,module:module_name,equipmentpar_id:equipmentparid},
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
                document.getElementById('modalTitle').innerHTML='View Property PAR';
                $('#myModal').modal('show');
                $("#footerNote").html("");
            }

            //<!---------------Start Edit equipment--------------->
            function editEquipmentPAR(EquipmentPARID,personnelid,divisionid)
            {
                edit_personnelid=personnelid;
                edit_divisionid=divisionid;
                pk_parequipment=EquipmentPARID;
                var module_name='editEquipmentPAR';
                var equipmentparid=parseInt(EquipmentPARID);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:"html",
                    data:{form:form_name,module:module_name,equipmentpar_id:equipmentparid},
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
                document.getElementById('modalTitle').innerHTML='Edit Property PAR';
                $('#myModal').modal('show');
            }

            function sendUpdate()
            {

                var module_name='updateEquipmentPAR';
                var equipmentparId=pk_parequipment;
                var equipmentparGSO=document.getElementById('mymodal_equipmentpar_gso').value;
                var equipmentparDate=document.getElementById('mymodal_equipmentpar_date').value;
                var equipmentparDivision=document.getElementById('equipmentpar_division_overmodal').value;
                var equipmentparPersonnel=document.getElementById('equipmentpar_personnel_overmodal').value;
                var equipmentparType=document.getElementById('mymodal_equipmentpar_type').value;
                var equipmentparNote=document.getElementById('mymodal_equipmentpar_note').value;
                var equipmentparRemarks=document.getElementById('mymodal_equipmentpar_remarks').value;
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{form:form_name,module:module_name,equipmentpar_id:equipmentparId,equipmentpar_gso:equipmentparGSO,
                    equipmentpar_date:equipmentparDate,equipmentpar_division:equipmentparDivision,equipmentpar_personnel:equipmentparPersonnel,
                    equipmentpar_type:equipmentparType,equipmentpar_note:equipmentparNote,equipmentpar_remarks:equipmentparRemarks,
                    equipmentpar_divisionid:edit_divisionid,equipmentpar_personnelid:edit_personnelid},
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
            function deleteEquipmentPAR(id,string_search)
            {
                property_numberpar=id;
                var module_name='viewEquipmentPAR';
                var equipmentparid=parseInt(id);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html', // Data type, HTML, json etc.
                    data:{form:form_name,module:module_name,equipmentpar_id:equipmentparid},
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
                document.getElementById('modalTitle').innerHTML='Delete Property PAR';
                $('#myModal').modal('show');
            }

            function sendDelete()
            {
                equipmentparId=property_numberpar;
                if (confirm("Are you sure you want to delete?") == false)
                {
                    return;
                }
                var module_name='deleteEquipmentPAR';
                jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'text', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,equipmentpar_id:equipmentparId},
                        beforeSend: function()
                        {
                            $("#footerNote").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
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
                        },
                        error:function (xhr, ajaxOptions, thrownError)
                        {
                            $.unblockUI();
                            $.growl.error({ message: thrownError });
                        }
                });
            }
            //<!---------------End Delete Modal--------------->

            //<!---------------Start Edit Personnel Modal Over Modal--------------->
            function selectPersonnelovermodal(){
                    var module_name='selectPersonnelovermodal';
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
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPersonnelovermodal(document.getElementById(\'txtpersonnelovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtpersonnelovermodal" class="form-control"  onkeyup="if(event.keyCode == 13){searchPersonnelovermodal(this.value)};" placeholder="Search Personnel"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Select Recipient';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
            }

            function searchPersonnelovermodal(searchstring){
                    var module_name='searchPersonnelovermodal';
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
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Personnel Name";
                                 $("#contentovermodal").html(message);
                                 $("#footerNoteovermodal").html('');
                            }
                        },
                    });
            }

            function selectedPersonnelovermodal(fname,mname,lname,id){
                $('#myModalovermodal').modal('hide');
                document.getElementById('equipmentpar_personnel_modelovermodal').value=lname+', '+fname+' '+mname;
                personnelid=id;
                edit_personnelid=id;
            }
            //<!---------------End Edit Personnel Modal Over Modal--------------->

            //<!---------------Start Edit Division Modal Over Modal--------------->
            function selectDivisionovermodal(){
                    var module_name='selectDivisionovermodal';
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
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchDivisionovermodal(document.getElementById(\'txtdivisionovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtdivisionovermodal" class="form-control"  onkeyup="if(event.keyCode == 13){searchDivisionovermodal(this.value)};" placeholder="Search Division"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Select Recipient';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
            }

            function searchDivisionovermodal(searchstring){
                    var module_name='searchDivisionovermodal';
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
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Division Name";
                                 $("#contentovermodal").html(message);
                                 $("#footerNoteovermodal").html('');
                            }
                        },
                    });
            }

            function selectedDivisionovermodal(search_division,id){
                $('#myModalovermodal').modal('hide');
                document.getElementById('equipmentpar_division_modelovermodal').value=search_division;
                divisionid=id;
                edit_divisionid=id;
            }

            //<!---------------Start Edit Propertypar Modal Over Modal--------------->
            function selectPropertyPARovermodal(parid){
                    property_numberpar=parid;
                    var module_name='selectPropertyPARovermodal';
                    jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,par_id:parid},
                        beforeSend: function()
                        {
                            $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            $("#modalButtonovermodal").html('<button type="button" class="btn btn-primary" onclick="selectPropertyPARovermodalovermodal();"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div></div></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Edit Property PAR';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
            }

            function deletePropertyPAR(propertyparid,parid){
                var module_name='deleteEquipmentPARovermodal';
                jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'text', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,equipmentpar_id:propertyparid,par_id:parid},
                        beforeSend: function()
                        {
                            $("#footerNoteovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            var splitResult=response.split("ajaxseparator");
                            var deletemessage=splitResult[0];
                            var deletetable=splitResult[1];
                            var deleteselect=splitResult[2];
                            if (deletemessage=="Delete Successful")
                            {
                                $("#footerNoteovermodal").html(deletemessage);
                                $("#contentovermodal").html(deletetable);
                                $("#selectpropertypar").html(deleteselect);
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

            function selectPropertyPARovermodalovermodal(){
                    var module_name='selectPropertyPARovermodalovermodal';
                    jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name},
                        beforeSend: function()
                        {
                            $("#modalContentovermodalovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            $("#modalButtonovermodalovermodal").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                            $("#modalContentovermodalovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPropertyPARovermodalovermodal(document.getElementById(\'txtpropertyparovermodalovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtpropertyparovermodalovermodal" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyPARovermodalovermodal(this.value)};" placeholder="Search Property"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodalovermodal"></div>');
                            $("#contentovermodalovermodal").append(response);
                        },
                    });
                    $("#footerNoteovermodalovermodal").html("");
                    $('#myModalovermodalovermodal').modal('show');
            }

            function searchPropertyPARovermodalovermodal(searchstring){
                    var module_name='searchPropertyPARovermodalovermodal';
                    jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,search_string:searchstring},
                        beforeSend: function()
                        {
                            $("#footerNoteovermodalovermodal").html('');
                            $("#contentovermodalovermodal").html("<div align=\'center\'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            var splitResult=response.split("ajaxseparator");
                            var response=splitResult[0];
                            var numberOfsearch=splitResult[1];
                            if(numberOfsearch!=0){
                                 $("#contentovermodalovermodal").html(response);
                                 if(searchstring!=''){
                                    var message="Showing results for <b>"+searchstring+"</b>";
                                    $("#footerNoteovermodalovermodal").html(message);
                                 }else{
                                    $("#footerNoteovermodalovermodal").html('');
                                 }
                            }else{
                                 var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Property Name";
                                 $("#contentovermodalovermodal").html(message);
                                 $("#footerNoteovermodalovermodal").html('');
                            }
                        },
                    });
            }

            function selectedPropertyPARovermodalovermodal(equipmentid){
                 var module_name='addPropertyPARovermodalovermodal';
                    jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,equipmentpar_id:property_numberpar,equipment_id:equipmentid},
                       beforeSend: function()
                       {
                           $("#footerNoteovermodalovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                       },
                       success:function(response)
                       {
                           if (response=='Equipment already exist')
                           {
                                $("#footerNoteovermodalovermodal").html(response);
                           }else{
                                var splitResult=response.split("ajaxseparator");
                                var deletemessage=splitResult[0];
                                var deleteselect=splitResult[1];
                                $("#selectpropertypar").html(deleteselect);
                                $("#table_propertypar tbody").append(deletemessage);
                                $('#myModalovermodalovermodal').modal('hide');
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

            function paginationButton(pageId,searchstring,totalpages){
                var module_name='paginationEquipmentPAR';
                var page_Id=parseInt(pageId);
                   jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html',
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