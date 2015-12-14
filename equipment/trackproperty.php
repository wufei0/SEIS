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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Track Property<br><br></h3></div>
                                    <div class="col-xs-5 col-sm-5 col-md-5" style=" padding-right: 5px">
                                    <!---------------start search--------------->
                                        <form class="form-horizontal"  onSubmit="return SearchTrackProperty();">
                                            <div class="input-group input-group-sm ">
                                                <input id="search_text" type="text" autofocus="autofocus" class="form-control " placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button id="search_personnel" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
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
                            <div class="panel-body bodyul" style="overflow: auto;height: 330px">
                                <table class="table table-hover fixed" id="search_table">
                                    <tr>
                                               <td style="width:30%;"><b>Property Number</b></td>
                                               <td style="width:30%;"><b>Property Description</b></td>
                                               <td style="width:30%;"><b>Acquisition Date</b></td>
                                               <td style="width:12%;" align="center"><b>Control Content</b></td>
                                    </tr>
                                    <tr>
                                        <!---------------start table--------------->
                                        <div class="row"></div>
                                        <!---------------end table--------------->
                                    </tr>
                                </table>
                            </div>
                            <div class="panel-footer footer-size"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############################################################### end container ######################################################## -->
        <!---------------Modal container--------------->
        <?php
            include_once('modal.php');   //for Edit Modal
            include_once('../modal.php');//for LogIn Modal
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
        <script language="JavaScript" type="text/javascript">
        var form_name='USER';
        ///<!---------------Search Ajax--------------->
        function SearchTrackProperty() {
                      var module_name='searchTrackProperty';
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
                                  $('#myModal').modal('hide');
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
      //<!---------------End Search Ajax--------------->
      //<!---------------Pagination--------------->
      function paginationButton(pageId,searchstring,totalpages){
                      var module_name='paginationTrackProperty';
                      var page_Id=parseInt(pageId);
                      jQuery.ajax({
                            type: "POST",
                            url:"crud.php",
                            dataType:'html', // Data type, HTML, json etc.
                            data:{form:form_name,module:module_name,page_id:page_Id,search_string:searchstring,total_pages:totalpages},
                            beforeSend: function()
                            {
                                  $.blockUI();
                            },
                            success:function(response)
                            {
                                  $.unblockUI();
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
      //----------------------Start View Equipment-----------------------
      function viewTrackProperty(EquipmentID) //viewing the history of equipment 
      {
          var module_name='viewTrackProperty';
          var equipmentid=parseInt(EquipmentID);
          jQuery.ajax({
              type: "POST",
              url:"crud.php",
              dataType:'html', // Data type, HTML, json etc.
              data:{form:form_name,module:module_name,equipment_id:equipmentid},
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
          document.getElementById('modalTitle').innerHTML='Property History';
          $('#myModal').modal('show');
          $("#footerNote").html("");
      }
      //<!---------------End View Modal--------------->
  </script>
</body>
</html>