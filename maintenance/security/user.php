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
        include("../../connection.php");
        global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
        
        
        if (mysqli_connect_error())
      {
            echo "Connection Error";
            die();
      }
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
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Users</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

<!---------------start create user--------------->
                        <form class="form-horizontal" onSubmit="return AddUser()">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">User Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="user_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Full Name:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="full_name">
                                </div>
                            </div>
                             <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Designation:</label>
                                <div class="col-sm-10 input-width">
                                    <input type="text" class="form-control input-size" id="designation">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label group-inputtext">Group Name:</label>
                                <div class="col-sm-10 input-width">
                                    <?php
                                        $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                                        $sql="SELECT Security_GroupID, Security_GroupName,Security_GroupDescription FROM Security_Group ORDER BY Security_GroupName";
                                        $resultset=  mysqli_query($conn, $sql);
                                        echo "<select id='group_id' class='form-control input-size'>";
                                        foreach($resultset as $rows)
                                        {
                                            echo "<option value=".$rows['Security_GroupID'].">".$rows['Security_GroupName']."   -   ".$rows['Security_GroupDescription']."</option>";
                                        }
                                        echo "</select>";
                                       
                                        mysqli_close($conn);
                                    ?>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary button-right" >Create</button>
                                </div>
                            </div>
                        </form>
<!---------------end create user--------------->

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
                                         <form class="form-horizontal"  onSubmit="return SearchUser();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_user" class="btn btn-default btn-size" type="submit">
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
                                                        
                                                                <td class="userNameWidth"><b>User Name</b></td>
                                                                <td class="userFullNameWidth"><b>Full Name</b></td>
                                                                <td class="userDesignWidth"><b>Designation</b></td>
                                                                <td class="userGroupWidth"><b>Group</b></td>
                                                                <td class="userTransdateWidth"><b>Transdate</b></td>
                                                        
                                                        
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
    include_once("../../modal.php");
    ?>
           
<!---------------end Modal container--------------->
    <?php
    	$root='';
    	include_once('../../footer.php');
    ?>


     <script language="JavaScript" type="text/javascript">
         
         
         var pk_user;
         var pk_group;
//<!---------------Search Ajax--------------->
    function SearchUser() {
        
        var module_name='searchUser';
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
                  $("#page_search").html(response);
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

    function AddUser()
    {
        var module_name='addUser';
        var groupid=document.getElementById('group_id').value;
        jQuery.ajax({
               type: "POST",
               url:"crud.php",
               dataType:'html', // Data type, HTML, json etc.
               data:{module:module_name,user_name:$("#user_name").val(),full_name:$("#full_name").val(),designation:$("#designation").val(),group_id:groupid},
                beforeSend: function()
               {
                  
                    document.getElementById('addStatus').innerHTML='Saving....';
               },
               success:function(response)
               {
                 
                    $("#addStatus").html(response);
                  
               },
               error:function (xhr, ajaxOptions, thrownError){
                   alert(thrownError);
               }
            

        });
           return false;
    }

///<!---------------End Save Ajax--------------->


//<!---------------View Modal--------------->
//
    function viewUser(UserID)
    {
        var module_name='viewUser';
        var userid=parseInt(UserID);
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,user_id:userid},
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
    function editUser(UserID,GroupID)
    {
        var module_name='editUser';
        var userid=parseInt(UserID);
        var groupid=parseInt(GroupID);
        pk_user=UserID;    
        pk_group=GroupID;
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:"html", 
            data:{module:module_name,user_id:userid,group_id:groupid},
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
       
        var module_name='updateUser'
        var groupId=(document.getElementById('mymodal_group_id').value)
        var userId=window.pk_user
        var username=document.getElementById('mymodal_user_name').value;
        var fullname=document.getElementById('mymodal_full_name').value;
        var designation=document.getElementById('mymodal_designation').value;
        //var groupName=document.getElementById('mymodal_group_name').value;
        
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,groupId:groupId,user_id:userId,user_name:username,full_name:fullname,vardesignation:designation},
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
//
function deleteUser($id)
{
        var module_name='viewUser';
        var userid=parseInt($id);
        pk_user=$id;
        
        jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,user_id:userid},
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
//
function sendDelete()
{
   
    if (confirm("Are you sure you want to delete?") == false)
    {
        return;
    }
    
    var module_name='deleteUser'
    var groupId=window.pk_user;
    
     jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,user_id:groupId},
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

function paginationButton(pageId,searchstring){
  var module_name="paginationUser";
  var page_Id=parseInt(pageId);
       jQuery.ajax({
            type: "POST",
            url:"crud.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,page_id:page_Id,search_string:searchstring},
             beforeSend: function()
            {
                document.getElementById('searchStatus').innerHTML='Searching....';

            },
            success:function(response)
            {
                $("#search_table").html(response);
                document.getElementById('searchStatus').innerHTML='';    

            },
            error:function (xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);


            }


     });

}




//<!---------------end Delete Modal--------------->




    </script>
  </body>
</html>