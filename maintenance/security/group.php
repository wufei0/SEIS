<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SEIS alpha</title>
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../css/index.css" />
    <script src="../../jq/jquery-1.11.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.blockUI.js"></script>
    <script src="../../js/jquery.growl.js" type="text/javascript"></script>
    <link href="../../css/jquery.growl.css" rel="stylesheet" type="text/css" />

  </head>
  <body>
<div class="navbar-fixed-top bluebackgroundcolor">
  <?php
      $maintenanceActive="class='active'";
  	$rootDir='../../';
  	include_once('../../header.php');
  ?>
</div>
<!---------------container--------------->
    <div class="container">
       
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Group</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

<!---------------start create group--------------->
                        <form class="form-horizontal" onSubmit="return AddGroup()">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Group Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="group_name">
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
                                    <button type="submit" class="btn btn-primary button-right" id="create_group">Create</button>
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
                                         <form class="form-horizontal"  onSubmit="return SearchGroup();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_group" class="btn btn-default btn-size" type="submit">
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
                                                        
                                                                <td class="groupNameWidth"><b>Group Name</b></td>

                                                           
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
<!---------------end container--------------->

<!---------------Modal container--------------->
    <?php
    include_once('../../modal.php');
    ?>
           
<!---------------end Modal container--------------->
    <?php
    	$root='';
    	include_once('../../footer.php');
    ?>


     <script language="JavaScript" type="text/javascript">
         
         var form_name='GROUP';//holder for privilege checking
         var pk_group;
//<!---------------Search Ajax--------------->
    function SearchGroup() 
    {
        var module_name='searchGroup';
         jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{form:form_name,module:module_name,searchText:$("#search_text").val()},
                beforeSend: function()
                {
                    document.getElementById('searchStatus').innerHTML='Searching....';
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
                        $("#page_search").html(response);
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
                            $("#searchStatus").html("No Results Found");
                        }
                    }},
                    error:function (xhr, ajaxOptions, thrownError){
                   $.unblockUI();
                   $.growl.error({ message: thrownError });
                   $("#addStatus").html('');
               }
                
         });
         document.getElementById('searchStatus').innerHTML='';
         return false;
         }

//<!---------------end Search Ajax--------------->




//<!---------------Save Ajax--------------->

    function AddGroup()
    {
        var module_name='addGroup';

        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{form:form_name,module:module_name,group_name:$("#group_name").val(),desc_name:$("#description_name").val()},
                beforeSend: function()
               {
                   document.getElementById('addStatus').innerHTML='Saving....';
                    $.blockUI();
               },
               success:function(response)
               {
                    $("#addStatus").html('');
                    $.unblockUI();
                    if (response=='Group added successfully')
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
                   $.growl.error({ message: thrownError });
                   $("#addStatus").html('');
               }
            

        });
           return false;
    }

///<!---------------End Save Ajax--------------->


//<!---------------View Modal--------------->

    function viewGroup(GroupID)
    {
        var module_name='viewGroup';
        var groupid=parseInt(GroupID);
        
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,group_id:groupid},
             beforeSend: function()
            {   
                $.blockUI();
                 $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
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
        //alert(GroupID);


    }

//<!---------------End View Modal--------------->


//<!--------------- Edit Modal--------------->
    function editGroup(GroupID)
    {
        var module_name='editGroup';
        var groupid=parseInt(GroupID);
       
        pk_group=GroupID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html", 
            data:{form:form_name,module:module_name,group_id:groupid},
             beforeSend: function()
            {   
                 $.blockUI();
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
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
       
        var module_name='updateGroup'
        var groupId=window.pk_group;
        var groupName=document.getElementById('mymodal_group_name').value;
        var groupDesc=document.getElementById('mymodal_group_desc').value;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,group_id:groupId,group_name:groupName,group_desc:groupDesc},
             beforeSend: function()
            {    
                $.blockUI();
                $("#footerNote").html("Updating.....");
            },
            success:function(response)
            {
                $.unblockUI();
                $("#footerNote").html(response);
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
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                $.unblockUI();
                $.growl.error({ message: thrownError });
                $("#footerNote").html("");
            }

     });
        
    }
    

//<!---------------end Edit Modal--------------->


//<!---------------Delete Modal--------------->

function deleteGroup(id)
{
        var module_name='viewGroup';
        var groupid=parseInt(id);
        pk_group=id;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,group_id:groupid},
             beforeSend: function()
            {   
                 $.blockUI();
                $("#footerNote").html("");
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
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
    
    var module_name='deleteGroup'
    var groupId=window.pk_group;
    
     jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{form:form_name,module:module_name,group_id:groupId},
             beforeSend: function()
            {   
                 $.blockUI();
                $("#footerNote").html("Deleting....");
                
            },
            success:function(response)
            {
                
                $.unblockUI();
                $("#footerNote").html('');
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
                
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                 $.unblockUI();
                 $.growl.error({ message: thrownError });
                $("#footerNote").html('');
               
            }

     });
  
     
}




//<!---------------end Delete Modal--------------->

function paginationButton(pageId,searchstring,totalpages){
  var module_name='paginationGroup'
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
                alert(thrownError);


            }


     });

}




    </script>
  </body>
</html>