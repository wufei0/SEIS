<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SEIS alpha</title>
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../css/index.css" />
    <script src="../../jq/jquery-1.11.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

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
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Library</a></li>
            <li class="active">Data</li>
        </ol>
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
                                        <div class="panel-body bodyul" style="overflow: auto">
                                            <table class="table table-hover" id="search_table">
                                                <tr>
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        
                                                                <td class="groupNameWidth"><b>Group Name</b></td>

                                                           
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
                                                <div class="col-md-8">
                                            <nav>

<!---------------pagination--------------->
                                              <ul class="rev-pagination pagination">
                                                <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                                <li><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">5</a></li>
                                   
                                                <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                                              </ul>
<!---------------end pagination--------------->

                                            </nav>
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
         
         
         var pk_group;
//<!---------------Search Ajax--------------->
    function SearchGroup() {
           var module_name='searchGroup';
         jQuery.ajax({
                type: "POST",
                url:"crud.php",
                dataType:'html', // Data type, HTML, json etc.
                data:{module:module_name,searchText:$("#search_text").val()},
                beforeSend: function()
                {
                    document.getElementById('searchStatus').innerHTML='Searching....';
                },
                success:function(response)
                {
                  //alert(response);
                  document.getElementById('searchStatus').innerHTML='';
                  $("#search_table").html(response);
                  //document.getElementById('searchStatus').innerHTML='Note: Group added successfully';
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
         });
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
               data:{module:module_name,group_name:$("#group_name").val(),desc_name:$("#description_name").val()},
                beforeSend: function()
               {
                   document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                 //alert(response);
                 document.getElementById('addStatus').innerHTML='Group added successfully';
                  if(response=='empty')
                  {

                     document.getElementById('addStatus').innerHTML='Cannot save blank Group Name';
                  }
                  else if (response=='duplicate')
                  {
                       document.getElementById('addStatus').innerHTML='Duplicate Group Name detected.';
                  }
                  else if (response=='save')
                  {
                       document.getElementById('addStatus').innerHTML='Group added successfully';
                  }
                  else
                  {
                       document.getElementById('addStatus').innerHTML='There ware error in saving.';
                  }
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
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
            data:{module:module_name,group_id:groupid},
             beforeSend: function()
            {   
               
                 $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
              $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
              $("#modalContent").html(response);
               
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
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
            data:{module:module_name,group_id:groupid},
             beforeSend: function()
            {   
                
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#footerNote").html("");
                $("#modalContent").html(response);
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left" id="save_changes" onclick="sendUpdate();">Update</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            
            },
             error:function (xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
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
            data:{module:module_name,group_id:groupId,group_name:groupName,group_desc:groupDesc},
             beforeSend: function()
            {   
                 $("#footerNote").html("Updating.....");
            },
            success:function(response)
            {

                $("#footerNote").html(response);
        
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
                $("#footerNote").html("Update failed");
            }

     });
        
    }
    

//<!---------------end Edit Modal--------------->


//<!---------------Delete Modal--------------->

function deleteGroup($id)
{
        var module_name='viewGroup';
        var groupid=parseInt($id);
        pk_group=$id;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,group_id:groupid},
             beforeSend: function()
            {   
                $("#footerNote").html("");
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../../images/ajax-loader.gif' /></div>");
                $("#modalButton").html('<button type="button" class="btn btn-primary update-left"  onclick="sendDelete();">Delete</button>\n\<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
            },
            success:function(response)
            {
                
                $("#modalContent").html(response);
                
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
               
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
            data:{module:module_name,group_id:groupId},
             beforeSend: function()
            {   
                $("#footerNote").html("Deleting....");
                
            },
            success:function(response)
            {
                
               
                $("#footerNote").html(response);
                
                
            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
                $("#footerNote").html("Delete failed");
               
            }

     });
  
     
}




//<!---------------end Delete Modal--------------->




    </script>
  </body>
</html>