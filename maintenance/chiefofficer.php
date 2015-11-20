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
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Chief Officer</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed;">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddChief()" id="form_chief">
                              <div class="form-group">
                                        <label  class="col-sm-2 control-label group-inputtext">Chief Officer:</label>
                                        <div class="col-sm-10 input-width">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Personnel" id="equipment_chief">
                                                <span class="input-group-btn">
                                                  <button class="btn btn-default" onclick="selectChief();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                                </span>
                                            </div>
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
                                        $sql="SELECT * FROM M_Division ORDER BY Division_Name";
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
                                    <button type="submit" class="btn btn-primary button-right" id="create_chief">Create</button>
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
                                    <div class="panel-heading">
                                      <div class="row">
                                          <div class="col-xs-5 col-sm-5 col-md-5"  style="padding-right: 5px">
<!---------------start search--------------->
                                         <form class="form-horizontal"  onSubmit="return SearchChief();">
                                            <div class="input-group input-group-sm">
                                                <input id="search_text" type="text" class="form-control" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_chief" class="btn btn-default" type="submit">
                                                    <span class="glyphicon glyphicon-search">
                                                    </span>
                                                </button>
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
                                                <div class="row">
                                                    <div class="col-md-11">

                                                                <td class="groupNameWidth"><b>Chief Officer</b></td>


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
    var personnelid;
    var chiefid;
    //<!---------------Save Ajax--------------->
    function AddChief()
    {
        var divisionid=document.getElementById('division_id').value;
        var module_name='addChief';
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,personnel_id:personnelid,division_id:divisionid,equipment_chief:$("#equipment_chief").val()},
                beforeSend: function()
               {
                    $.blockUI();
                    document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                    $.unblockUI();
                    $("#addStatus").html('');
                if (response=='Chief Officer filled successfully')
                {
                    $.growl.notice({ message: response });
                    $('#form_chief')[0].reset();
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
    ///<!---------------End Save Ajax--------------->


      function selectChief(){
                      var module_name='selectChief';
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
                              $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchChief(document.getElementById(\'txtchief\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtchief" class="form-control"  onkeyup="if(event.keyCode == 13){searchChief(this.value)};" placeholder="Search Personnel"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                              $("#content").append(response);
                          },
                      });
                      document.getElementById('modalTitle').innerHTML='Select Chief Officer';
                      $("#footerNote").html("");
                      $('#myModal').modal('show');
        }

        function searchChief(searchstring){
                      var module_name='searchChief';
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
                                   var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Personnel Name";
                                   $("#content").html(message);
                                   $("#footerNote").html('');
                              }
                          },
                    });
        }

        function selectedChief(fname,mname,lname,id){
            $('#myModal').modal('hide');
            document.getElementById('equipment_chief').value=fname+' '+ mname+' '+lname;
            personnelid=id;
        }

            //<!---------------Search Ajax--------------->
    function SearchChief()
    {
        var module_name='search_Chief';
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

//<!---------------end Search Ajax--------------->

//<!---------------View Modal--------------->

function viewChief(ChiefId)
    {
        var module_name='viewChief';
        var chiefid=parseInt(ChiefId);

        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,chief_id:chiefid},
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
                $.growl.error({ message: thrownError });
            }

     });
        document.getElementById('modalTitle').innerHTML='View Chief officer';
        $("#footerNote").html("");
        $('#myModal').modal('show');
    }

//<!---------------End View Modal--------------->

//<!--------------- Edit Modal--------------->
    function editChief(ChiefId,personnel_id)
    {
        var module_name='editChief';
        chiefid=parseInt(ChiefId);
        pk_chief=chiefid;
        personnelid=personnel_id;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html",
            data:{form:form_name,module:module_name,chief_id:chiefid},
             beforeSend: function()
            {
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#modalContent").html(response);
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left" id="save_changes" onclick="sendUpdate();">Update</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');

            },
             error:function (xhr, ajaxOptions, thrownError)
            {
                $.growl.error({ message: thrownError });
            }
     });
           $("#footerNote").html("");
            document.getElementById('modalTitle').innerHTML='Edit';
           $('#myModal').modal('show');


    }

    function sendUpdate()
    {
        var module_name='updateChief';
        var divisionid=document.getElementById('mymodal_chief_division').value;
        var equipmentpersonnelovermodal=document.getElementById('equipment_personnelovermodal').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,chief_id:chiefid,personnel_id:personnelid,division_id:divisionid,equipment_personnelovermodal:equipmentpersonnelovermodal},
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
                $.growl.error({ message: thrownError });

            }

     });
    }
//<!---------------end Edit Modal--------------->

    //<!---------------Start Edit Classification Modal Over Modal--------------->
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
            document.getElementById('modalTitleovermodal').innerHTML='Select Personnels';
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
    //<!---------------End Edit Classification Modal Over Modal--------------->

           function selectedPersonnelovermodal(fname,mname,lname,id){
             $('#myModalovermodal').modal('hide');
            document.getElementById('equipment_personnelovermodal').value=fname+' '+ mname+' '+lname;
            personnelid=id;
        }

      function paginationButton(pageId,searchstring,totalpages){
                var module_name='paginationChief';
                var page_Id=parseInt(pageId);
                   jQuery.ajax({
                        type: "POST",
                        url:"crud.php",
                        dataType:'html',
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

//<!---------------start Delete Modal--------------->
function deleteChief(id)
{
        var module_name='viewChief';
        chiefid=parseInt(id);
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,chief_id:chiefid},
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
                $.growl.error({ message: thrownError });
            }

     });
        document.getElementById('modalTitle').innerHTML='Delete Chief Officer';
        $('#myModal').modal('show');

}
function sendDelete()
{
    if (confirm("Are you sure you want to delete?") == false)
    {
        return;
    }

    var module_name='deleteChief'
     jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,chief_id:chiefid},
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
                $.growl.error({ message: thrownError });
            }

     });
}
//<!---------------end Delete Modal--------------->

</script>
</body>
</html>