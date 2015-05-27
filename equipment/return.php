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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Property Return</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul" style="overflow: fixed;">
                            <!---------------start create return--------------->



                            <form class="form-horizontal" onSubmit="return addPropertyReturn()" id="form_propertyreturn">
                                 <div class="panel-body bodyul">
                                      <div class="row">

                                                                     <table class="table table-bordered">
                                    <tr class="info"><td>
                                     <div class="radio">
                                      <label><input type="radio" name="propertyreturn_status" value="Disposal">Disposal</label>
                                    </div>

                                    </td>
                                    <td>
                                     <div class="radio">
                                      <label><input type="radio" name="propertyreturn_status" value="Repair">Repair</label>
                                    </div>

                                    </td>
                                    <td>
                                     <div class="radio">
                                      <label><input type="radio" name="propertyreturn_status" value="Returned to Stock">Returned to Stock</label>
                                    </div>

                                    </td>
                                    <td>
                                     <div class="radio">
                                      <label><input type="radio" name="propertyreturn_status" value="Other">Other</label>
                                    </div>

                                    </td>

                                    </tr>
                               </table>
                                    <hr>
                                  <div class="scrollwd">
                                      <table class="table table-bordered" id="table_propertyreturn">
                                              <th style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></th>
                                                          <th>Property Number</th>
                                                          <th>GSO Number</th>
                                                          <th>Date</th>
                                                          <th>Office</th>
                                                          <th>Recepient</th>
                                                          <th>Type</th>
                                                          <th>Note</th>
                                                          <th>Remarks</th>
                                      </table>


                                      </div>
                                      <div class="buttonright">
                                                    <button style="width:79px;" type="button" class="btn btn-success" onclick="selectPropertyReturn();">Add</button>
                                                    <button type="button" class="btn btn-danger" id="prop_remove" disabled="disabled" onclick="remove_propertyreturn();">Remove</button>
                                              </div>
                                        </div>

                                  </div>
                                    <hr>
                                  <div class="form-group">
                                    <div id="col-left">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Date:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="date" class="form-control input-size" id="propertyreturn_date">
                                        </div>
                                    </div>
                                    <div id="col-right">
                                        <label  class="col-sm-2 control-label group-inputtext textsize">Note:</label>
                                        <div class="col-sm-4 colsm4">
                                            <input type="text" class="form-control input-size" id="propertyreturn_note">
                                        </div>
                                    </div>
                                 </div>
                                  <div>
                                      <button type="submit" class="btn btn-primary button-right" id="create_propertyreturn">Submit</button>
                                  </div>
                            </form>
                        </div>
                        <div id="addStatus" class="panel-footer footer-size"></div>
                        <!---------------end create return--------------->
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading header-size">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title"></h3></div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                            <!---------------start search--------------->
                                            <form class="form-horizontal"  onSubmit="return SearchEquipmentReturn();">
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
                                                <td style="width:12%;"><b>Property Return Note</b></td>
                                                <td style="width:12%;"><b>Property Return Date</b></td>
                                                <td style="width:12%;"><b>Property Return Status</b></td>
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
            var propertyreturn_array = [];
            var property_numberreturn;
            function addPropertyReturn()
            {
                var propertyreturn_status=$('input:radio[name=propertyreturn_status]:checked').val();
                var module_name='addPropertyReturn';
                jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,propertyreturn_date:$("#propertyreturn_date").val(),propertyreturn_note:$("#propertyreturn_note").val(),propertyreturn_status:propertyreturn_status,propertyreturn_array:propertyreturn_array},
                       beforeSend: function()
                       {
                           $.blockUI();
                       },
                       success:function(response)
                       {
                           $.unblockUI();
                           $("#addStatus").html('');
                           if (response=='Property Return added successfully')
                           {
                                $.growl.notice({ message: response });
                                $('#form_propertyreturn')[0].reset();
                                $("#table_propertyreturn > tbody").html("<table style='width:2500px;' class='table table-bordered table-hover tablechoose' id='table_property'><th style='width: 30px'><input style='cursor: default' disabled='disabled' type='checkbox' aria-label='...' /></th><th>Property Number</th><th>GSO Number</th><th>Date</th><th>Office</th><th>Recepient</th><th>Type</th><th>Note</th><th>Remarks</th></table>");
                                propertyreturn_array = [];
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


            function viewPropertyReturn(PropertyReturnId)
            {
                var module_name='viewPropertyReturn';
                var propertyreturnid=parseInt(PropertyReturnId);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html',
                    data:{form:form_name,module:module_name,propertyreturn_id:propertyreturnid},
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
                document.getElementById('modalTitle').innerHTML='View Property Return';
                $('#myModal').modal('show');
                $("#footerNote").html("");
            }


                  function SearchEquipmentReturn(){
                var module_name='searchEquipmentReturn';
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






            function selectPropertyReturn()
            {
                var module_name='selectPropertyReturn';
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default"onclick="searchPropertyReturn(document.getElementById(\'txtPropertyReturn\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtPropertyReturn" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyReturn(this.value)};" placeholder="Search Property"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Property Return';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }


            function searchPropertyReturn(searchstring)
            {
                var module_name='searchPropertyReturn';
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

            function selectedPropertyReturn(propertypar_id,propertyreturn_number,propertyreturn_gso,propertyreturn_date,propertyreturn_office,propertyreturn_recipient,propertyreturn_type,propertyreturn_note,propertyreturn_remarks)
            {
                var search=propertyreturn_number;
                var tdnum=$('#table_propertyreturn tr > td:nth-child(3)').filter(function() { return $(this).text() == search;});
                if(tdnum.length>0){
                      $("#footerNote").html('Already added in the list.');
                }else{
                      $("#table_propertyreturn").append('<tr><td><input type="checkbox" onchange="changeremovebtn();" /></td><td style="display:none">'+propertypar_id+'</td><td>'+propertyreturn_number+'</td><td>'+propertyreturn_gso+'</td><td>'+propertyreturn_date+'</td><td>'+propertyreturn_office+'</td><td>'+propertyreturn_recipient+'</td><td>'+propertyreturn_type+'</td><td>'+propertyreturn_note+'</td><td>'+propertyreturn_remarks+'</td></tr>');
                      $('#myModal').modal('hide');
                      propertyreturn_array.push(propertypar_id);
                }
            }
    function remove_propertyreturn(){
                 $('#table_propertyreturn tr ').has('input:checkbox:checked').remove();
                 $('#prop_remove').prop('disabled', true);
                 propertyreturn_array = [];
                 $('#table_propertyreturn tr > td:nth-child(2)').each( function(){
                    propertyreturn_array.push( $(this).text() );
                 });
                   alert(propertyreturn_array);
            }

            function changeremovebtn(){
                     var inputcheck=$('#table_propertyreturn tr').has('input:checkbox:checked').length;
                     if(inputcheck==0){
                          $('#prop_remove').prop('disabled', true);
                     }else{
                          $('#prop_remove').prop('disabled', false);
                     }
            }

    function deletePropertyReturn(id,string_search)
            {
                property_numberreturn=id;
                var module_name='viewPropertyReturn';
                var propertyreturnid=parseInt(id);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html', // Data type, HTML, json etc.
                    data:{form:form_name,module:module_name,propertyreturn_id:propertyreturnid},
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
                document.getElementById('modalTitle').innerHTML='Delete Property Return';
                $('#myModal').modal('show');
            }

            function sendDelete()
            {
                propertyreturnId=property_numberreturn;
                if (confirm("Are you sure you want to delete?") == false)
                {
                    return;
                }
                var module_name='deletePropertyReturn';
                jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'text', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,propertyreturn_id:propertyreturnId},
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


            function editPropertyReturn(PropertyReturnId)
            {
                var module_name='editPropertyReturn';
                var propertyreturnid=parseInt(PropertyReturnId);
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:"html",
                    data:{form:form_name,module:module_name,propertyreturn_id:propertyreturnid},
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
                document.getElementById('modalTitle').innerHTML='Edit Property Return';
                $('#myModal').modal('show');
            }



            function paginationButton(pageId,searchstring,totalpages){
                var module_name='paginationPropertyReturn';
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

            function selectPropertyReturnovermodal(returnid){
                    property_numberreturn=returnid;
                    var module_name='selectPropertyReturnovermodal';
                    jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,return_id:returnid},
                        beforeSend: function()
                        {
                            $("#modalContentovermodal").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                        },
                        success:function(response)
                        {
                            $("#modalButtonovermodal").html('<button type="button" class="btn btn-primary" onclick="selectPropertyReturnovermodalovermodal();"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div></div></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Edit Property Return';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
            }

            function deletePropertyReturnovermodal(propertyreturnid,returnid){
                var module_name='deletePropertyReturnovermodal';
                jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'text', // Data type, HTML, json etc.
                        data:{form:form_name,module:module_name,propertyreturn_id:propertyreturnid,return_id:returnid},
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
                                $("#selectpropertyreturn").html(deleteselect);
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



            function selectPropertyReturnovermodalovermodal(){
                    var module_name='selectPropertyReturnovermodalovermodal';
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
                            $("#modalContentovermodalovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPropertyReturnovermodalovermodal(document.getElementById(\'txtpropertyreturnovermodalovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtpropertyreturnovermodalovermodal" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyReturnovermodalovermodal(this.value)};" placeholder="Search Property"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodalovermodal"></div>');
                            $("#contentovermodalovermodal").append(response);
                        },
                    });
                    $("#footerNoteovermodalovermodal").html("");
                    $('#myModalovermodalovermodal').modal('show');
            }

                  function searchPropertyReturnovermodalovermodal(searchstring){
                    var module_name='searchPropertyReturnovermodalovermodal';
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

                function selectedPropertyReturnovermodalovermodal(propertyreturnid){
                 var module_name='addPropertyReturnovermodalovermodal';
                    jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,equipmentreturn_id:property_numberreturn,propertyreturn_id:propertyreturnid},
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

        </script>
</body>
</html>