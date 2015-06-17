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
        
        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
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
                        <h3 class="panel-title">Division</h3>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed">
                        
<!---------------start create division--------------->

                      <form class="form-horizontal" onSubmit="return AddDivision()" id="form_division">
                        
                             <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Division:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="division_name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Description:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="description_name">
                                </div>
                            </div>
                          
                          <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Department:</label>
                                <div class="col-sm-10 input-width">
                                    <?php
                                        
                                        $sql="SELECT Department_Id, Department_Name,Description FROM M_Department ORDER BY Department_Name";
                                        $resultset=  mysqli_query($conn, $sql);
                                        echo "<select  id='department_id' class='form-control input-size selectpicker'  >";
                                        foreach($resultset as $rows)
                                        {
                                            echo "<option  data-subtext='".$rows['Description']."' value=".$rows['Department_Id'].">".$rows['Department_Name']."</option>";
                                        }
                                        echo "</select>";
                                       
                                        mysqli_close($conn);
                                    ?>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Chief Officer:</label>
                                <div class="col-sm-10 input-width">
                                  <div class="input-group">
                                        <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Chief Officer" id="division_chiefofficer">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="selectChiefOfficer();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                  </div>
                                </div>
                            </div>
                          
                          
                        <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" id="create_group">Create</button>
                                </div>
                            </div>
                          
                      </form>


<!---------------end create division--------------->


                    </div>
                    <div id="addStatus" class="panel-footer footer-size">
                         
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title"></h3></div>
                                      <div class="col-xs-12 col-sm-12 col-md-4">
<!---------------start search--------------->
                                         <form class="form-horizontal"  onSubmit="return SearchDivision();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_division" class="btn btn-default btn-size" type="submit">
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
                                        
                                        <table class="table table-hover fixed">
                                            <tr>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    
                                                        <td class="divisionNameWidth"><b>Division</b></td>
                                                        <td class="divisionDescWidth"><b>Description</b></td>
                                                        <td class="divisionDepartmentWidth"><b>Department</b></td>
                                                        <td class="divisionTransdateWidth"><b>Chief Officer</b></td>
                                                        <td class="divisionTransdateWidth"><b>Transdate</b></td>
                                                </div>
                                                <div class="col-md-1">
                                                    <td colspan="3" align="right"><b>Control Content</b></td>
                                                </div>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                
                                                    
                                                </div>
                                            </div>
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
    include_once("../modal.php");
    ?>
<!---------------end Modal container--------------->
<?php
	$root='';
	include_once('../footer.php');
?>

 <script language="JavaScript" type="text/javascript">
     var form_name='DIVISION';//holder for privilege checking
     var chiefofficerid;
     var editchiefofficerid;
     var pk_division;

     //<!---------------Search Ajax--------------->
    function SearchDivision()
    {

        var module_name='searchDivision';
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

//<!---------------end Search Ajax--------------->

//<!---------------Save Ajax--------------->

    function AddDivision()
    {
        var module_name='addDivision';
        var departmentid=document.getElementById('department_id').value;
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,division_name:$("#division_name").val(),desc_name:$("#description_name").val(),division_chiefofficer:$("#division_chiefofficer").val(),department_id:departmentid,chiefofficer_id:chiefofficerid},
                beforeSend: function()
               {
                    $.blockUI();
                   document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
               $.unblockUI();
               if (response=='Division added successfully')
                {
                        $.growl.notice({ message: response });
                        $('#form_division')[0].reset();
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
                   $.growl.error({ message: thrownError });
               }
            

        });
        document.getElementById('addStatus').innerHTML='';
           return false;
    }

///<!---------------End Save Ajax--------------->

//<!---------------View Modal--------------->

function viewDivision(DivisionID)
    {
        var module_name='viewDivision';
        var divisionid=parseInt(DivisionID);
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,division_id:divisionid},
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
        document.getElementById('modalTitle').innerHTML='View';
        $("#footerNote").html("");
        $('#myModal').modal('show');
        //alert(GroupID);


    }

//<!---------------End View Modal--------------->


//<!--------------- Edit Modal--------------->
    function editDivision(DivisionID)
    {
        var module_name='editDivision';
        var divisionid=parseInt(DivisionID);
        //var departmentid=parseInt(DepartmentID)
        pk_division=divisionid;    
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html", 
            data:{form:form_name,module:module_name,division_id:divisionid},
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
                $.growl.error({ message: thrownError });
            }
         

     });
           $("#footerNote").html("");
            document.getElementById('modalTitle').innerHTML='Edit';
           $('#myModal').modal('show');
        
        
    }
    
    
    function sendUpdate()
    {
        var module_name='updateDivision'
        var departmentid=(document.getElementById('mymodal_department_id').value)
        var divisionId=window.pk_division
        var divisionname=document.getElementById('mymodal_division_name').value;
        var divisiondescription=document.getElementById('mymodal_division_description').value;
        var divisionchiefofficer=document.getElementById('mymodal_division_chiefofficer').value;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,division_id:divisionId,division_name:divisionname,division_desc:divisiondescription,department_id:departmentid,division_chiefofficer:divisionchiefofficer,edit_chiefofficerid:editchiefofficerid},
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

//<!---------------start Delete Modal--------------->
function deleteDivision(id)
{
        var module_name='viewDivision';
        var divisionid=parseInt(id);
        pk_division=divisionid;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,division_id:divisionid},
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
        
        document.getElementById('modalTitle').innerHTML='Delete';
        $('#myModal').modal('show');
        
}
function sendDelete()
{
    if (confirm("Are you sure you want to delete?") == false)
    {
        return;
    }
    
    var module_name='deleteDivision'
    var divisionId=window.pk_division;
    
     jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,division_id:divisionId},
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

//<!---------------Start Pagination--------------->
function paginationButton(pageId,searchstring,totalpages){
  var module_name='paginationDivision'
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

//<!---------------End Pagination--------------->

    function selectChiefOfficer(){
            var module_name='selectChiefOfficer';
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
                    $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchChiefOfficer(document.getElementById(\'txtchiefofficer\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtchiefofficer" class="form-control"  onkeyup="if(event.keyCode == 13){searchChiefOfficer(this.value)};" placeholder="Search Chief Officer"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                    $("#content").append(response);
                },
            });
            document.getElementById('modalTitle').innerHTML='Select ChiefOfficer';
            $("#footerNote").html("");
            $('#myModal').modal('show');
    }

    function searchChiefOfficer(searchstring){
            var module_name='searchChiefOfficer';
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Chief Officer";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
                },
            });
    }

    function selectedChiefOfficer(fname,mname,lname,id){
            $('#myModal').modal('hide');
            document.getElementById('division_chiefofficer').value=lname+', '+fname+' '+mname;
            chiefofficerid=id;
    }

    //<!---------------Start Edit Supplier Modal Over Modal--------------->
    function selectChiefOfficerovermodal()
    {
            var module_name='selectChiefOfficerovermodal';
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
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchChiefOfficerovermodal(document.getElementById(\'txtchiefofficerovermodal\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtchiefofficerovermodal" class="form-control" onkeyup="if(event.keyCode == 13){searchChiefOfficerovermodal(this.value)};" placeholder="Description"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="contentovermodal"></div>');
                    $("#contentovermodal").append(response);
                },
            });
            document.getElementById('modalTitleovermodal').innerHTML='Select Chief Officer';
            $("#footerNoteovermodal").html("");
            $('#myModalovermodal').modal('show');
    }

    function searchChiefOfficerovermodal(searchstring){
            var module_name='searchChiefOfficerovermodal';
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any Chief Officer";
                         $("#contentovermodal").html(message);
                         $("#footerNoteovermodal").html('');
                    }
                },
            });
        }

        function selectedChiefOfficerovermodal(fname,mname,lname,id){
            $('#myModalovermodal').modal('hide');
            document.getElementById('mymodal_division_chiefofficer').value=lname+', '+fname+' '+mname;
            editchiefofficerid=id;
        }
    //<!---------------Start Edit Supplier Modal Over Modal--------------->
</script>
     
</body>
</html>