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

                                <div class="col-md-12"><h3 class="panel-title">Property, Plant and Equipment Schedule Report<br><br></h3></div>
                                <div class="col-md-3">
                                 <div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon1">From:</span>
  <input type="date" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
</div>
                                </div>

                                <div class="col-md-3">
                                 <div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon1">To:</span>
  <input type="date" class="form-control" placeholder="Username" aria-describedby="sizing-addon1">
</div>
                                </div>
                                        <div class="col-md-3">
                                 <div class="input-group input-group-sm">
  <span class="input-group-addon" id="sizing-addon1">Filter By Type:</span>
  <select class="form-control" aria-describedby="sizing-addon1">
  <option>Sample</option>
  </select>
</div>
                                </div>
                            </div>
                        </div>
                        <div id="page_search">
                        <div style="overflow: auto; height: 320px">
                            <div style="text-align: center" class="panel-body bodyul" style="overflow: auto">
                            <b>Property, Plant and Equipment Schedule</b>
                            <br>As of August 28, 2014<br><br>

                            <table style='width: 100%;'>
                            <tr align='center'><td>PPE Account</td><td>Account Code</td><td>Book</td></tr>
                            <tr><td>Motor Vehicles</td><td>241</td><td>General Fund</td></tr>
                            </table>
                             <br>
                            <?php
                              global $DB_HOST, $DB_USER,$DB_PASS, $BD_TABLE;
                              $conn=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$BD_TABLE);
                              if (mysqli_connect_error())
                              {
                                  echo "Connection Error";
                                  die();
                              }
                              echo "
                              <table class='table table-bordered' style='width: 100%;'>
                            <tr align='center'>
                                  <th>Property Number</th>
                                  <th>Description</th>
                                  <th>Acq. Date</th>
                                  <th>Est. Life</th>
                                  <th>Resp. Center</th>
                                  <th>Acquisition Cost</th>
                                  <th>Acc. Depreciation</th>
                                  <th>Net Book Value</th>
                            </tr>
                              ";
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
                            </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: right">
                                <div id="searchStatus"><a><span onclick="printInventorySchedule()" class="glyphicon glyphicon-print"></span></a></div>
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
         function printInventorySchedule(){
                    var module_name='printInventorySchedule';
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
                            $("#modalButtonovermodal").html('<button type="button" class="btn btn-default glyphicon glyphicon-save" data-dismiss="modal"></button><button type="button" class="btn btn-default glyphicon glyphicon-print" onclick="printo()";></button><button type="button" class="btn btn-danger glyphicon glyphicon-remove" data-dismiss="modal"></button>');
                            $("#modalContentovermodal").html('<div class="row"><div class="col-md-12"><div id="contentovermodal"></div></div></div>');
                            $("#contentovermodal").append(response);
                        },
                    });
                    document.getElementById('modalTitleovermodal').innerHTML='Print Property Acknowledgement Receipt';
                    $("#footerNoteovermodal").html("");
                    $('#myModalovermodal').modal('show');
      }
</script>
</body>
</html>