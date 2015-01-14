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
                            <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Group - Users</h3></div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">

                        <!---------------start create group--------------->
                        <form class="form-horizontal" action="create.php" method="post">
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label group-inputtext">Group Name:</label>
                                <div class="col-sm-10 input-width">
                                  <input type="text" class="form-control input-size" id="group_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label group-inputtext">Description:</label>
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
                    <div class="panel-footer">
                        Note: <div id="message" ></div>
                    </div>
                </div>
            </div>
           <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Current Articles</h3></div>
                                          <div class="col-xs-12 col-sm-12 col-md-4">

                                            <!---------------start search--------------->
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                              </span>
                                            </div>
                                            <!---------------end search--------------->

                                          </div>
                                      </div>
                                    </div>
                                        <div class="panel-body bodyul" style="overflow: auto">
                                            <table class="table table-hover">
                                                <tr>
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <td ><b>Title</b></td><td><b>Date</b></td><td><b>Added by</b></td><td><b>Added by</b></td><td><b>Added by</b></td>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <td colspan="3" align="center"><b>Control Content</b></td>
                                                    </div>
                                                </div>
                                                </tr>
                                                <tr>

                                                <!---------------start table--------------->
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <td>Sample samplesamplesamplesamplesamplesamplesample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#">Link</a></td><td><a href="#">Link</a></td>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <td><a href="#"><span class="glyphicon glyphicon-eye-open" title="View"></span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil" title="Edit"></span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash" title="Delete"></span></a></td>
                                                    </div>
                                                </div>
                                                <!---------------end table--------------->

                                                </tr>
                                            </table>

                                        </div>
                                        <div class="panel-footer">
                                            <nav>

                                              <!---------------end pagination--------------->
                                              <ul class="rev-pagination pagination">
                                                <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                                <li><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
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
    <!---------------end container--------------->

    <?php
    	$root='';
    	include_once('../../footer.php');
    ?>

     <script language="JavaScript" type="text/javascript">


     //<!---------------Save Ajax--------------->

     $("#create_group").click(function (e) {
       var module_name='addGroup';
     e.preventDefault();


     jQuery.ajax({
            type: "POST",
            url:"create.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,group_name:$("#group_name").val(),desc_name:$("#description_name").val()},
             beforeSend: function()
            {
                document.getElementById('message').innerHTML='Saving....';
            },
            success:function(response)
            {
              //alert(response);
              document.getElementById('message').innerHTML='Group added successfully';
               if(response=='empty')
               {

                  document.getElementById('message').innerHTML='Cannot save blank Group Name';
               }
               else if (response=='duplicate')
               {
                    document.getElementById('message').innerHTML='Duplicate Group Name detected.';
               }
               else if (response=='save')
               {
                    document.getElementById('message').innerHTML='Group added successfully';
               }
               else
               {
                    document.getElementById('message').innerHTML='There ware error in saving.';
               }
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }

     });
     });

    ///<!---------------End Save Ajax--------------->



    </script>
  </body>
</html>