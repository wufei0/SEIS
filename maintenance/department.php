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

?>
</div>

<!-- ############################################################### container ######################################################## -->
<div class="container">
  	
            
               
        
            
            <div class="row">            
                
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Department</h3>
                    </div>
                    <div class="panel-body" style="overflow: auto">
<!---------------start CREATE OFFICE--------------->
<form role="form"class="form-horizontal" onSubmit="return addDepartment()" id="form_department">
                        <div class="form-group">
                           <label  class="col-sm-2 control-label group-inputtext">Department:</label>
                            <div class="col-sm-10 input-width">
                              <input type="text" class="form-control input-size" id="department_name">
                            </div>
                        </div>
                        <div class="form-group">
                           <label  class="col-sm-2 control-label group-inputtext">Description:</label>
                            <div class="col-sm-10 input-width">
                              <input type="text" class="form-control input-size" id="desc_name">
                            </div>
                        </div>
                       <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" >Create</button>
                                </div>
                            </div>
                        
                          
                      </form>

<!---------------end CREATE OFFICE--------------->
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
                                         <form class="form-horizontal"  onSubmit="return SearchDepartment();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default btn-size" type="submit">
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
                                                    
                                                    <td class="groupNameWidth"><b>Department</b></td>
                                                    <td class="groupDescWidth"><b>Description</b></td>
                                                    <td class="groupTransdateWidth"><b>Transdate</b></td>
                                               
                                                </div>
                                                <div class="col-md-1">
                                                    <td colspan="3" align="center"><b>Control Content</b></td>
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

<?php
        include_once('../modal.php');
	$root='';
	include_once('../footer.php');
?>

 <script language="JavaScript" type="text/javascript">
     
     //<!---------------Add Ajax--------------->
     var form_name='DEPARTMENT';//holder for privilege checking
    var pk_deptid;
    function addDepartment()
    {
        var module_name='addDepartment';
        var departmentName=document.getElementById('department_name').value;
        var departmentDesc=document.getElementById('desc_name').value;

        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,department_name:departmentName,desc_name:departmentDesc},
                beforeSend: function()
               {
                    $.blockUI();
                    document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                  $.unblockUI();
               //  document.getElementById('addStatus').innerHTML='Group added successfully';
              
                    if (response=='Department added successfully')
                    {
                            $.growl.notice({ message: response });
                            $('#form_department')[0].reset();
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

///<!---------------End ADD Ajax--------------->

//<!---------------Search Ajax--------------->
    function SearchDepartment() {
           var module_name='searchDepartment';
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


//<!---------------View Modal--------------->

    function viewDepartment(DepartmentId)
    {
        var module_name='viewDepartment';
        var deptid=parseInt(DepartmentId);
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,department_id:deptid},
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
        document.getElementById('footerNote').innerHTML='';
        $('#myModal').modal('show');
        //alert(GroupID);


    }

//<!---------------End View Modal--------------->

//<!--------------- Edit Modal--------------->
    function editDepartment(DepartmentID)
    {
        var module_name='editDepartment';
        var departmentid=parseInt(DepartmentID);
       
        pk_deptid=DepartmentID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html", 
            data:{form:form_name,module:module_name,department_id:departmentid},
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
       
        var module_name='updateDepartment'
        var departmentId=window.pk_deptid;
        var deptName=document.getElementById('mymodal_department').value;
        var deptDesc=document.getElementById('mymodal_department_description').value;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,department_id:departmentId,department_name:deptName,department_desc:deptDesc},
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
                 $.unblockUI();
                $.growl.error({ message: thrownError });
                
            }

     });
        
    }
    
    

//<!---------------end Edit Modal--------------->


//<!---------------Delete Modal--------------->

function deleteDepartment(id)
{
        var module_name='viewDepartment';
        var departmentid=parseInt(id);
        pk_deptid=departmentid;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,department_id:departmentid},
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
    
    var module_name='deleteDepartment'
    var departmentId=window.pk_deptid;
    
     jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,department_id:departmentId},
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
                 $.unblockUI();
                $.growl.error({ message: thrownError });
               
               
            }

     });
     
}




//<!---------------end Delete Modal--------------->
     
     
     
//<!---------------start PAGINATION--------------->
function paginationButton(pageId,searchstring,totalpages){
  var module_name='paginationDepartment'
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

//<!---------------end pagination--------------->

</script>

</body>
</html>