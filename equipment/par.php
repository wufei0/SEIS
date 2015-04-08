<!DOCTYPE html>
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
                            <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Property Acknowlegdement Receipt</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: fixed;">

<!---------------start create par--------------->
            <form class="form-horizontal" onSubmit="return AddEquipment()">

            <div class="panel-body bodyul">
                <div class="row">
                        
                        <div class="scrollwd">
                            <table style="width:2500px;" class="table table-bordered table-hover tablechoose">
                            <tr>
                                <th>Prop No.</th>
                                <th>Description</th>
                                <th>Acq Date</th>
                                <th>Acq Cost</th>
                                <th>Serial</th>
                                <th>Serial</th>
                                <th>Serial</th>
                                <th>Serial</th>
                                <th>Serial</th>
                                <th>Serial</th>
                                <th>Description</th>
                                <th>Description</th>
                                <th>Description</th>
                                <th>Description</th>
                                
                            </tr>   
                        </table>
                        </div>
                            <div class="buttonright">
                                <button style="width:79px;" type="button" class="btn btn-success" onclick="selectProperty();">Add</button>
                                <button type="button" class="btn btn-danger">Remove</button>
                            </div>
                    </div>
                </div>
               
                    
                           
                        <div class="form-group">
                                <div id="col-left1">
                                    <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">GSO No.:</label>
                                <div class="col-sm-4 colsm04">
                                    <input type="text" placeholder="GSO No..." class="form-control input-size" id="equipment_number">
                                </div>
                                </div>
                            
                            <div id="col-left1">
                                <label  style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Date:</label>
                                <div class="col-sm-4 colsm04">
                                  <input type="date" class="form-control input-size" id="equipment_number">
                                </div>
                                </div>
                            
                                <div id="col-right1">
                                <label style="float:left; margin-left:15px; padding-top: 7px;">Office:</label>
                               <div class="col-sm-4 colsm04right">
                             <div class="input-group">
                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Office" id="equipment_brand">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="selectBrand();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                              </div><!-- /input-group -->
                            </div>
                            </div>
                            
                            <div id="col-left1">
                                    <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Recipient:</label>
                                <div class="col-sm-4 colsm04">
                                    <div class="input-group">
                                <input type="text" class="form-control input-size" readonly="readonly"   placeholder="Select Recipient" id="equipment_brand">
                                <span class="input-group-btn">
                                  <button class="btn btn-default" onclick="selectBrand();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                </span>
                              </div>
                                </div>
                                </div>
                            
                            <div id="col-left1">
                                    <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">PAR Type:</label>
                                <div class="col-sm-4 colsm04">
                                    <select class='form-control input-size selectpicker'>  
                                        <option data-subtext='Donation' value='Donation' >Donation</option>
                                        <option data-subtext='Office Use' value='Donation' >Office Use</option>
                                    </select>

                                
                                </div>
                                </div>
                            
                            <div class="tclear"></div>
                            
                            <div id="col-width1">
                                    <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Note:</label>
                                <div class="col-sm-4 colsmwhole4">
                                    <input style="width:100%;" type="text" placeholder="Remarks..." class="form-control input-size" id="equipment_number">
                                </div>
                                </div>
                            
                            <div class="tclear"></div>
            
                            <div id="col-width1">
                                    <label style="float:left; margin-left:15px; width:65px; padding-top: 7px;">Remarks:</label>
                                <div class="col-sm-4 colsmwhole4">
                                    <input style="width:100%;" type="text" placeholder="Remarks..." class="form-control input-size" id="equipment_number">
                                </div>
                                </div>
                           
                            

                             </div>
                <div class="retyrewt">
                                    <button type="submit" class="btn btn-primary button-right" id="create_equipment">Submit</button>
                                </div>

                     
                    
                
                
                </form>
            </div>
            
<div id="addStatus" class="panel-footer footer-size">

                    </div>
<!---------------end create par--------------->
                   
                    
                </div>
            </div>
           <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading header-size">
                                      <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title"></h3></div>
                                          <div class="col-xs-12 col-sm-12 col-md-4">

<!---------------start search--------------->
                                         <form class="form-horizontal"  onSubmit="return SearchEquipment();">
                                            <div class="input-group">
                                                <input id="search_text" type="text" class="form-control search-size" placeholder="Search...">
                                              <span class="input-group-btn">
                                                <button id="search_personnel" class="btn btn-default btn-size" type="submit">
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
                                                                <td class="equipNumberWidth"><b>Equipment Number</b></td>
                                                                <td class="equipDescWidth"><b>Equipment Description</b></td>
                                                                <td class="equipModelWidth"><b>Model</b></td>
                                                                <td class="equipStatusWidth"><b>Status</b></td>
                                                                <td class="equipLocationWidth"><b>Location</b></td>
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
<!-- ############################################################### end container ######################################################## -->

<!---------------Modal container--------------->
    <?php
    include_once('../modal.php');
    ?>

<!---------------end Modal container--------------->

<?php
	$root='';
	include_once('../footer.php');

?>
<script>
    
    //Show Modal and Select Property
    function selectProperty()
    {
        var module_name='selectProperty';
        jQuery.ajax({
            type: "POST",
            url:"crad.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name},
             beforeSend: function()
            {
                $("#modalContent").html("<div style='margin:0px 50%;'><img src='../images/ajax-loader.gif' /></div>");
            },
            success:function(response)
            {
                $("#modalButton").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>');
                $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" \n\
                                        onclick="searchProperty(document.getElementById(\'txtProperty\').value);" type="button"><span class="glyphicon glyphicon-search">\n\
                                        </span></button></span><input type="text" id="txtProperty" class="form-control"  onkeyup="if(event.keyCode == 13)\n\
                                        {searchProperty(this.value)};" placeholder="Search Property"></div></div><div class="col-md-12">\n\
                                        <div style="height:400px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                $("#content").append(response);
            }
            
            });
            document.getElementById('modalTitle').innerHTML='Search Property';
            $("#footerNote").html("");
            $('#myModal').modal('show');
        
    }
    
    //Search Property Function on Modal
    function searchProperty(searchstring)
    {
        var module_name='searchProperty';
        jQuery.ajax({
            type: "POST",
            url:"crad.php",
            dataType:'html', // Data type, HTML, json etc.
            data:{module:module_name,search_string:searchstring},
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
                         var message="Your Search - <b><i>"+searchstring+"</i></b> - did not match any criteria.";
                         $("#content").html(message);
                         $("#footerNote").html('');
                    }
            }
            
            });
        
    }
    
    
    


    //<!---------------Pagination--------------->
    function paginationButton(pageId,searchstring,totalpages){
    var module_name='paginationEquipment';
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





</script>
</body>
</html>