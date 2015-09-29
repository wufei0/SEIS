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
                $reportActive="class='active'";
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
                            <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Inventory of Equipment Report<br><br></h3></div>
                            <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" readonly="readonly"   placeholder="Select Personnel" id="equipment_personnel">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="selectPersonnel();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button onclick="SearchInventoryEquipment()" disabled="disabled" id="SearchInventoryEquipment" type="button" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                </button>
                                <button type="button" onclick="printPropertyInventoryovermodal()" disabled="disabled" id="PrintInventoryEquipment" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body bodyul" style="overflow: auto">
                        <div id="page_search">
                            <table class="table table-hover table-bordered fixed" id="search_table">
                                <tr align="center">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <td rowspan="2"><b>Article</b></td>
                                            <td rowspan="2"><b>Description</b></td>
                                            <td rowspan="2"><b>Date Acquired</b></td>
                                            <td rowspan="2"><b>Inventory Tag #</b></td>
                                            <td rowspan="2"><b>Property Number</b></td>
                                            <td rowspan="2"><b>Qty Unit</b></td>
                                            <td rowspan="2"><b>Unit Value</b></td>
                                            <td colspan="2"><b>BALANCE PER STOCK CARD</b></td>
                                            <td colspan="2"><b>ON HAND PER COUNT</b></td>
                                            <td rowspan="2"><b>REMARKS</b></td>
                                        </div>
                                    </div>
                                </tr>
                                <tr align="center">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                            <td><b>Qty</b></td>
                                            <td><b>Value</b></td>
                                        </div>
                                    </div>
                                </tr>
                                <?php
                                    global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
                                    $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                                    if (mysqli_connect_error())
                                    {
                                        echo "Connection Error";
                                        die();
                                    }
                                    $sql='SELECT Property_Acknowledgement_Subset.*, Property.* FROM Property_Acknowledgement_Subset
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id';
                                    $resultset=  mysqli_query($conn, $sql);
                                    $sqlcount='SELECT parproperty_Id FROM Property_Acknowledgement_Subset';
                                    $resultCount= mysqli_query($conn, $sqlcount);
                                    $numOfRow=mysqli_num_rows($resultCount);
                                    $num=1;
                                    foreach($resultset as $rows)
                                    {
                                        $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                        INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                        INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                        $resultSet=  mysqli_query($conn, $sql);
                                        $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                        $datepar=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                        $acquiredcost='Php '. number_format($rows['Acquisition_Cost'], 2);
                                        echo "<tr  align='center'>
                                        <td>Not Working</td>
                                        <td>".$rows['Property_Description']."</td>
                                        <td>".$datepar."</td>
                                        <td>".$rows['Property_InventoryTag']."</td>
                                        <td>".$rows['Property_Number']."</td>
                                        <td>NOT YET AVAILABLE</td><td>".$acquiredcost."</td><td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        </tr>";
                                        $num++;
                                    }
                               ?>
                            </table>
                        </div>
                         </div>
                        <div class="panel-footer footer-size">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="searchStatus" class="panel-footer"></div>
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
        include_once('modal.php');
        include_once('../modal.php');
    ?>
    <!---------------end Modal container--------------->
    <?php
        $root='';
        include_once('../footer.php');
    ?>
    <script language="JavaScript" type="text/javascript">
        var form_name='USER';
        var personnelid;
        var varinventory="";
        var varheader="";
        var varsignatories="";
        function SearchInventoryEquipment() {
                      $('#PrintInventoryEquipment').prop('disabled', false);
                      var module_name='searchInventoryEquipment';
                      jQuery.ajax({
                              type: "POST",
                              url:"crud.php",
                              dataType:'html', // Data type, HTML, json etc.
                              data:{form:form_name,module:module_name,inventory_month:$("#inventorymonth").val(),inventory_year:$("#inventoryyear").val()},
                              beforeSend: function()
                              {
                                  $.blockUI();
                              },
                              success:function(response)
                              {
                                  var splitResult=response.split("ajaxseparator");
                                  var resultinventory=splitResult[0];
                                  varheader=splitResult[1];
                                  varsignatories=splitResult[2];
                                  varinventory=resultinventory;
                                  $.unblockUI();
                                  if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                                  {
                                      $.growl.error({ message: response });
                                  }
                                  else
                                  {
                                      $("#page_search").html(resultinventory);
                                  }
                              },
                              error:function (xhr, ajaxOptions, thrownError){
                                  $.unblockUI();
                                  $.growl.error({ message: thrownError });
                              }
                      });
                      return false;
        }

        function selectPersonnel(){
                      var module_name='selectPersonnel';
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
                              $("#modalContent").html('<div class="row"><div class="col-md-12"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" onclick="searchPersonnel(document.getElementById(\'txtpersonnel\').value);" type="button"><span class="glyphicon glyphicon-search"></span></button></span><input type="text" id="txtpersonnel" class="form-control"  onkeyup="if(event.keyCode == 13){searchPersonnel(this.value)};" placeholder="Search Personnel"></div></div><div class="col-md-12"><div style="height:300px;overflow:auto; clear:both; margin-top:10px;" id="content"></div>');
                              $("#content").append(response);
                          },
                      });
                      document.getElementById('modalTitle').innerHTML='Select Recipient';
                      $("#footerNote").html("");
                      $('#myModal').modal('show');

        }

        function searchPersonnel(searchstring){
                      var module_name='searchPersonnel';
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

        function selectedPersonnel(fname,mname,lname,id){
            $('#myModal').modal('hide');
            document.getElementById('equipment_personnel').value=lname+', '+fname+' '+mname;
            personnelid=id;
            btnenable();
        }

        function btnenable(){
            var personnel=document.getElementById("equipment_personnel").value;
            if(personnel==''){
                $('#SearchInventoryEquipment').prop('disabled', true);
                $('#PrintInventoryEquipment').prop('disabled', true);
            }
            else{
                $('#SearchInventoryEquipment').prop('disabled', false);
            }
        }

        function printPropertyInventoryovermodal(){
          var windowWidth = 1200;
          var windowHeight = 500;
          var xPos = (screen.width/2) - (windowWidth/2);
          var yPos = (screen.height/2) - (windowHeight/2);
          window.open("INVENTORYOFEQUIPMENTPDFreport.php?id="+personnelid,"POPUP","width="
          + windowWidth+",height="+windowHeight +",left="+xPos+",top="+yPos);
        }

    </script>
</body>
</html>