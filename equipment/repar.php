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
                <div class="col-md-4" style=" padding-right: 5px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Search Property Acnowledgement Receipt</h3></div>
                            </div>
                        </div>
                        <div class="panel-body bodyul"  style="overflow: auto;height: 380px">
                            <!---------------start create return--------------->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <input id="search_parrecipient" type="text" disabled="disabled" class="form-control" placeholder="Search Recipient">
                                                    <span class="input-group-btn">
                                                        <button id="search_personnel_from" onclick="selectPropertyRePar();" class="btn btn-default" type="button">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-12">
                                            <div class="form-group">
                                                <div style="height: 255px; overflow: auto">
                                                    <table border="1px" disabled="disabled" class="table table-bordered" id="table_propertypar">
                                                        <tr class="active"><th style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></th><th>Property Number</th><th>Description</th></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                        <tr><td style="width: 30px"><input style="cursor: default" disabled="disabled" type="checkbox" aria-label="..."  /></td><td></td><td></td></tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" disabled="disabled" onclick="repar();" class="btn btn-warning button-right" id="btn_repar">Transfer Selected <span class="glyphicon glyphicon-arrow-right"></span></button>
                                            </div>
                                        </div>
                                    </div>

                                 </div>
                        <div id="addStatus" class="panel-footer footer-size"></div>
                        </div>

                        <!---------------end create return--------------->
                    </div>




                   <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Re-Property Acnowledgement Receipt</h3></div>
                            </div>
                        </div>

                            <!---------------start create return--------------->
                                 <div class="panel-body bodyul" style="overflow: auto;height: 380px;background-color: #EDEDED" id="table_repar1">
                                             <form class="form-horizontal" style=" "  onSubmit="return addEquipmentREPAR()" id="form_propertyrepar">
                                         <div class="row">
                                          <div class="col-md-5" style=" padding-right: 0px">
                                                  <div style="height: 350px; border: 1px solid #C0C0C0; overflow: auto; background-color: #EDEDED" id="table_repar2">
                                                      <table border="1px" disabled="disabled" class="table table-bordered" id="table_propertyrepar">

                 <thead>
                                                        <tr class="active"><th colspan="2">List of Property for REPAR</th></tr> </thead>
                                                        <tbody>
                                                        </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                               <div class="col-md-7">
                                                         <div class="form-group">
                                              <div class="col-sm-12 ">

                                                  <input type="text" class="form-control input-group-sm" style="margin-bottom: 3px;" placeholder="GSO Number" disabled="disabled" id="repar_gsono">
                                                   <input type="text"  onfocus="(this.type='date')" class="form-control" style="margin-bottom: 3px;" placeholder="Date" disabled="disabled" id="repar_date">
                                                     <div class="input-group" style="margin-bottom: 3px;">
                                                        <input id="repar_division" disabled="disabled"  type="text" class="form-control" placeholder="Search Office">
                                                        <span class="input-group-btn">
                                                            <button id="btnoffice" onclick="selectDivisionRePar();" disabled="disabled" class="btn btn-default" type="button">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                      </span>
                                                    </div>

                                                    <div class="input-group" style="margin-bottom: 3px;">
                                                      <input id="repar_newrecipient" disabled="disabled" type="text" class="form-control" placeholder="Search New Recepient">
                                                      <span class="input-group-btn">
                                                          <button id="btnrecipient" onclick="selectPropertyNewRecipient();" disabled="disabled" class="btn btn-default" type="button">
                                                              <span class="glyphicon glyphicon-plus"></span>
                                                          </button>
                                                    </span>
                                                  </div>
                                                    <input type="text" style="margin-bottom: 3px;" class="form-control input-size" placeholder="Type" disabled="disabled" id="repar_type">

                                                     <input type="text" style="margin-bottom: 3px;" class="form-control input-size" placeholder="Note" disabled="disabled" id="repar_note">

                                                     <input type="text"style="margin-bottom: 3px;" class="form-control input-size" placeholder="Remarks" disabled="disabled" id="repar_remarks">

                                                     <hr>
                                        <button type="submit" class="btn btn-primary button-right" disabled="disabled" id="btnrepar">Submit</button>
                                              </div>
                                                   </div>
                                              </div>
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
            var personnelcheck='';
            var divisionid;
            var propertyrepar_array = [];
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPropertyRePar(document.getElementById(\'txtPropertyRePar\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtPropertyRePar" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyRePar(this.value)};" placeholder="Search Recipient"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Select Recipient';
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
            function selectedPropertyRePar(personnelid){
                 var module_name='selectedPropertyRePar';
                    jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,personnel_id:personnelid},
                       beforeSend: function()
                       {
                           $("#footerNote").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                       },
                       success:function(response)
                       {
                          var splitResult=response.split("ajaxseparator");
                          var partable=splitResult[0];
                          var recipient=splitResult[1];
                            $("#table_propertypar > tbody").html(partable);
                            document.getElementById('search_parrecipient').value=recipient;
                            $('#myModal').modal('hide');
                            $('#btn_repar').prop('disabled', true);
                            personnelcheck=personnelid;
                       },
                       error:function (xhr, ajaxOptions, thrownError){
                           $.unblockUI();
                           $("#addStatus").html('');
                           $.growl.error({ message: thrownError });
                       }
                    });
                    return false;
            }
            function repar(){
               $('#table_propertypar tr ').has('input:checkbox:checked').each( function(){
                   var propertyid=$(this).find('td:nth-child(2)').text();
                   var propertynumber=$(this).find('td:nth-child(3)').text();
                   var propertydesc=$(this).find('td:nth-child(4)').text();
                   var tdnum=$('#table_propertyrepar tr > td:nth-child(2)').filter(function() { return $(this).text() == propertynumber;});
                   if(tdnum.length>0){
                      var response=propertynumber+" already added in the table list for repar";
                      $.growl.warning({ message: response });
                   }else{
                      $("#table_propertyrepar tbody").prepend('<tr  id=\"'+propertynumber+'\" onclick=removeListrepar(this)><td hidden="hidden">'+propertyid+'</td><td>'+propertynumber+'</td><td  style="width: 30px"><a><span class="glyphicon glyphicon-remove"></span></a></td></tr>');
                       propertyrepar_array.push(propertyid);
                   }

                 });
                  $('#repar_gsono').prop('disabled', false);
                  $('#repar_date').prop('disabled', false);
                  $('#btnoffice').prop('disabled', false);
                  $('#btnrecipient').prop('disabled', false);
                  $('#repar_type').prop('disabled', false);
                  $('#repar_note').prop('disabled', false);
                  $('#repar_remarks').prop('disabled', false);
                  $('#table_repar1').css("background-color", "#ffffff");
                  $('#table_repar2').css("background-color", "#ffffff");
                   $('#btnrepar').prop('disabled', false);
            }

            function selectPropertyNewRecipient()
            {
                var module_name='selectPropertyNewRecipient';
                jQuery.ajax({
                    type: "POST",
                    url:"crud.php",
                    dataType:'html', // Data type, HTML, json etc.
                    data:{form:form_name,module:module_name,personnel_check:personnelcheck},
                    beforeSend: function()
                    {
                        $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
                    },
                    success:function(response)
                    {
                        $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPropertyNewRecipient(document.getElementById(\'txtPersonnel\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtPersonnel" class="form-control"  onkeyup="if(event.keyCode == 13){searchPropertyNewRecipient(this.value)};" placeholder="Search Personnel"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Personnel';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }

            function searchPropertyNewRecipient(searchstring)
            {
                var module_name='searchPropertyNewRecipient';
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
            function selectedPropertyNewRecipient(newreceipt,id){
               $('#myModal').modal('hide');
               document.getElementById('repar_newrecipient').value=newreceipt;
               personnelid=id;
            }
            function changereparbtn(){
                  var inputcheck=$('#table_propertypar tr').has('input:checkbox:checked').length;
                     if(inputcheck==0){
                          $('#btn_repar').prop('disabled', true);
                     }else{
                          $('#btn_repar').prop('disabled', false);
                     }
            }

            function removeListrepar(property_number){
                var rowoftable=property_number.rowIndex;
                document.getElementById("table_propertyrepar").deleteRow(rowoftable);
                propertyrepar_array = [];
                 $('#table_propertyrepar tr > td:nth-child(1)').each( function(){
                    propertyrepar_array.push( $(this).text() );
                 });
                  var length = $('#equipment_serial > option').length;
                                var rowCount = $('#table_repar1 tr').length-1;
                    if(rowCount==0){
                      $('#form_propertyrepar')[0].reset();
                  $('#repar_gsono').prop('disabled', true);
                  $('#repar_date').prop('disabled', true);
                  $('#btnoffice').prop('disabled', true);
                  $('#btnrecipient').prop('disabled', true);
                  $('#repar_type').prop('disabled', true);
                  $('#repar_note').prop('disabled', true);
                  $('#repar_remarks').prop('disabled', true);
                  $('#table_repar1').css("background-color", "#EDEDED");
                  $('#table_repar2').css("background-color", "#EDEDED");
                  $('#btnrepar').prop('disabled', true);
                  $('#repar_date').get(0).type = 'text';
                    }
            }

            function addEquipmentREPAR()
            {
                var module_name='addEquipmentREPAR';
                jQuery.ajax({
                       type: "POST",
                       url:"crud.php",
                       dataType:'html', // Data type, HTML, json etc.
                       data:{form:form_name,module:module_name,repar_gsono:$("#repar_gsono").val(),repar_date:$("#repar_date").val(),repar_division:$("#repar_division").val(),repar_newrecipient:$("#repar_newrecipient").val(),repar_type:$("#repar_type").val(),repar_note:$("#repar_note").val(),repar_remarks:$("#repar_remarks").val(),personnel_id:personnelid,division_id:divisionid,propertyrepar_array:propertyrepar_array},
                       beforeSend: function()
                       {
                           $.blockUI();
                       },
                       success:function(response)
                       {
                           $.unblockUI();
                           $("#addStatus").html('');
                           if (response=='REPAR added successfully')
                           {
                                $.growl.notice({ message: response });
                                $('#form_propertyrepar')[0].reset();
                                $("#table_propertyrepar").html("<table border='1px' class='table table-bordered' id='table_propertyrepar'><thead><tr class='active'><th>Properties For REPAR</th><th></th></tr></thead><tbody></tbody></table>");
                                propertyrepar_array = [];
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

            function selectDivisionRePar()
            {
                var module_name='selectDivisionRePar';
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
                        $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default"onclick="searchDivisionRePar(document.getElementById(\'txtDivision\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtDivision" class="form-control"  onkeyup="if(event.keyCode == 13){searchDivisionRePar(this.value)};" placeholder="Search Division"></div></div><div class="col-md-12"><div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                        $("#content").append(response);
                    }
                });
                document.getElementById('modalTitle').innerHTML='Search Division';
                $("#footerNote").html("");
                $('#myModal').modal('show');
            }

            function searchDivisionRePar(searchstring)
            {
                var module_name='searchDivisionRePar';
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

            function selectedDivisionRePar(search_division,id){
                $('#myModal').modal('hide');
                document.getElementById('repar_division').value=search_division;
                divisionid=id;
            }
        </script>
      </body>
</html>