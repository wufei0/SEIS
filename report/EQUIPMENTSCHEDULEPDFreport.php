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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Property, Plant and Equipment Schedule<br><br></h3></div>
                                      <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" readonly="readonly"   placeholder="Select Personnel" id="equipment_personnel">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="selectPersonnel();" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                                        </span>
                                </div>
                            </div>
                                <div class="col-md-3">
                                 <div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon1">Month:</span>
    <select onchange="btnenable();" id="summarymonth" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
    <option value="Select Month">Select Month</option>
  <option value="01">January</option>
  <option value="02">February</option>
  <option value="03">March</option>
  <option value="04">April</option>
  <option value="05">May</option>
  <option value="06">June</option>
  <option value="07">July</option>
  <option value="08">August</option>
  <option value="09">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
  </select>
</div>
                                </div>

                                <div class="col-md-3">
                                 <div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon1">Year:</span>

  <select onchange="btnenable();" id="summaryyear" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
  <option>Select Year</option>
  <?php
    $theYear = date('Y');
    $end=1990;
    while ($theYear >= $end){
    echo "<option>".$theYear."</option>";
        $theYear--;
    }
?>
  </select>
</div>
                                </div>
                                        <div class="col-md-3">
                                    <button disabled="disabled" onclick="SearchSummaryEquipment()" id="SearchSummaryEquipment" type="button" class="btn btn-default btn-sm">
  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
</button>


                                    <button disabled="disabled" type="button" onclick="printPropertySummaryovermodal()" id="PrintSummaryEquipment" class="btn btn-default btn-sm">
  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
</button>


                                </div>
                        </div>
                        </div>
                            <div class="panel-body bodyul" style="overflow: auto">
                            <div id="page_search">
                              <div style="overflow: auto; height: 320px">
                                <table class="table table-bordered table-hover" id="search_table">
                                    <tr align="center">
                                                <td><b>Property Number</b></td>
                                                <td><b>Description</b></td>
                                                <td><b>Acq. Date</b></td>
                                                <td><b>Est. life</b></td>
                                                <td><b>Resp. Center</b></td>
                                                <td><b>Acquisition Cost</b></td>
                                                <td><b>Acc. Depreciation</b></td>
                                                <td><b>Net Book Values</b></td>
                                    </tr>

                               <?php
                              global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
                              $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                              if (mysqli_connect_error())
                              {
                                  echo "Connection Error";
                                  die();
                              }
                                $sql='SELECT Property_Acknowledgement.*,Property_Acknowledgement_Subset.parproperty_Id,Property.*,Property.Property_Id,M_Personnel.*,M_Division.Division_Name
                                FROM Property_Acknowledgement
                                INNER JOIN Property_Acknowledgement_Subset ON Property_Acknowledgement.Par_Id=Property_Acknowledgement_Subset.fkPar_Id
                                INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement                       .fkDivision_Id
                                ORDER BY Property.Property_Number';
                                $resultSet=  mysqli_query($conn, $sql);
                                foreach($resultSet as $rows)
                                {
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                echo "<tr><td>".$rows['Property_Number']."</td><td>".$rows['Property_Description']."</td><td>".$rows['Acquisition_Date']."</td><td>7 (Sample)</td><td>".$rows['Division_Name']."</td><td>".$rows['Acquisition_Cost']."</td><td>".$rows['Acquisition_Cost']."</td><td>Not Yet Available</td></tr>";
                                }
                                echo "</table>";
                            ?>
                                </table>
                              </div>
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
      var varsummary="";
      var varheader="";
      ///<!---------------Search Ajax--------------->
      function SearchSummaryEquipment() {
                    $('#PrintSummaryEquipment').prop('disabled', false);
                    var module_name='searchSummaryEquipment';
                    jQuery.ajax({
                            type: "POST",
                            url:"crud.php",
                            dataType:'html', // Data type, HTML, json etc.
                            data:{form:form_name,module:module_name,summary_month:$("#summarymonth").val(),summary_year:$("#summaryyear").val()},
                            beforeSend: function()
                            {
                                $.blockUI();
                            },
                            success:function(response)
                            {
                                var splitResult=response.split("ajaxseparator");
                                var resultsummary=splitResult[0];
                                varheader=splitResult[1];
                            varsummary=resultsummary;
                            $.unblockUI();
                            if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                            {
                                $.growl.error({ message: response });
                            }
                            else
                            {
                                $("#page_search").html(resultsummary);
                            }
                            },
                            error:function (xhr, ajaxOptions, thrownError){
                                $.unblockUI();
                                $.growl.error({ message: thrownError });
                            }
                     });
                     return false;
    }


    function btnenable(){
          var month=document.getElementById("summarymonth").value;
          var year=document.getElementById("summaryyear").value;
          if(month=="Select Month" || year=="Select Year"){
               $('#SearchSummaryEquipment').prop('disabled', true);
                $('#PrintSummaryEquipment').prop('disabled', true);
          }
          else{
             $('#SearchSummaryEquipment').prop('disabled', false);
          }
    }
       function printPropertySummaryovermodal(){
                    $("#modalButtonovermodal").html('<button type="button" class="btn btn-default glyphicon glyphicon-save" data-dismiss="modal"></button><button type="button" class="btn btn-default glyphicon glyphicon-print" onclick="printo()";></button><button type="button" class="btn btn-danger glyphicon glyphicon-remove" data-dismiss="modal"></button>');
                    $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div id="contentovermodal"></div></div></div>');
                    $("#contentovermodal").append('<div styel="text-align:center" style="height:430px;overflow:auto;">'+varheader+varsummary+'</div>');
                    document.getElementById('modalTitleovermodal').innerHTML='Print Summary of Newly Acquired Equipment';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
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

    ///<!---------------End Search Ajax--------------->
</script>
</body>
</html>