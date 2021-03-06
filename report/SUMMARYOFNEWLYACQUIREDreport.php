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
                                <div class="col-xs-12 col-sm-12 col-md-12"><h3 class="panel-title">Summary of Newly Acquired Equipment Report<br><br></h3></div>
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
                                                    <!-- To display year 1990 to present -->
                                                    <option>Select Year</option>
                                                    <?php
                                                      $theYear = date('Y'); //Get present year and display it to select box
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
                        <div class="panel-body bodyul" style="overflow: auto;height: 330px">
                            <div id="page_search">
                                <table class="table table-bordered table-hover" id="search_table">
                                    <tr align="center">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <td><b>ITEM NO.</b></td>
                                                <td><b>ARTICLES</b></td>
                                                <td><b>PARTICULARS</b></td>
                                                <td><b>QTY</b></td>
                                                <td><b>UNIT</b></td>
                                                <td><b>UNIT COST</b></td>
                                                <td><b>TOTAL COST</b></td>
                                                <td><b>GSO NO.</b></td>
                                                <td><b>DATE ACQUIRED</b></td>
                                                <td><b>OFFICE</b></td>
                                                <td><b>END USER</b></td>
                                                <td><b>REMARKS</b></td>
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
                                    //Display Table of Newly Acquired Summary
                                    $sql='SELECT Property_Acknowledgement_Subset.*, Property.*,M_Classification.*,M_Type.* FROM Property_Acknowledgement_Subset
                                    INNER JOIN Property ON Property_Acknowledgement_Subset.fkProperty_Id=Property.Property_Id
                                    INNER JOIN M_Classification ON M_Classification.Classification_Id=Property.fkClassification_Id
                                    INNER JOIN M_Type ON M_Type.Type_ID=M_Classification.fkType_Id';
                                    $resultset=  mysqli_query($conn, $sql);
                                    //Count all Sleceted Date for Pagination
                                    $sqlcount='SELECT parproperty_Id FROM Property_Acknowledgement_Subset';
                                    $resultCount= mysqli_query($conn, $sqlcount);
                                    $numOfRow=mysqli_num_rows($resultCount);
                                    $num=1;

                                    foreach($resultset as $rows)
                                    {
                                        $sql='SELECT Property_Acknowledgement.*, M_Personnel.*,M_Division.Division_Name FROM Property_Acknowledgement
                                        INNER JOIN M_Personnel ON M_Personnel.Personnel_Id=Property_Acknowledgement.fkPersonnel_Id
                                        INNER JOIN M_Division ON M_Division.Division_Id=Property_Acknowledgement.fkDivision_Id
                                        where Property_Acknowledgement.Par_Id='.$rows['fkPar_Id'].'';
                                        $resultSet=  mysqli_query($conn, $sql);
                                        $row=mysqli_fetch_array($resultSet,MYSQL_ASSOC);
                                        $datepar=date('F d, Y', strtotime($rows['Acquisition_Date']));
                                        $acquiredcost=number_format($rows['Acquisition_Cost'], 2);
                                        echo "
                                        <tr  align='center'><td>".$num."</td>
                                        <td>".$rows['Property_Description']."</td>
                                        <td>".$rows['Type_Name']."</td><td>1</td>
                                        <td>".$rows['Property_Unit']."</td><td>".$acquiredcost."</td>
                                        <td>".$acquiredcost."</td><td>".$row['Par_GSOno']."</td><td>".$datepar."</td>
                                        <td>".$row['Division_Name']."</td>
                                        <td>".$row['Personnel_Fname']." ".$row['Personnel_Mname'][0].". ".$row['Personnel_Lname']."</td>
                                        <td>".$row['Par_Remarks']."</td>
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
        <!---------------start Modal container--------------->
        <?php
            include_once('modal.php'); //modal for edit
            include_once('../modal.php'); //modal for LogIn
        ?>
        <!---------------end Modal container--------------->
        <?php
        	$root='';
        	include_once('../footer.php');
        ?>
        <script language="JavaScript" type="text/javascript">
        var form_name='USER';
        //<!---------------Search Ajax--------------->
        function SearchSummaryEquipment() {//Function To Search Equipments that is Newly Required
                      $('#PrintSummaryEquipment').prop('disabled', false);//Disable Button Print
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
                              $.unblockUI();
                              if (response=='Insufficient Group Privilege. Please contact your Administrator.')
                              {
                                  $.growl.error({ message: response });
                              }
                              else
                              {
                                  $("#page_search").html(response);
                              }
                              },
                              error:function (xhr, ajaxOptions, thrownError){
                                  $.unblockUI();
                                  $.growl.error({ message: thrownError });
                              }
                       });
                       return false;
        }

        function btnenable(){ //To Change Button To Disable and Enable
            var month=document.getElementById("summarymonth").value; //get value of month in user input
            var year=document.getElementById("summaryyear").value; //get value of month in user input
            if(month=="Select Month" || year=="Select Year"){ //disable Search and Print Button if no year and month is selected
                 $('#SearchSummaryEquipment').prop('disabled', true); //jquery method to  disable a button
                 $('#PrintSummaryEquipment').prop('disabled', true);
            }
            else{
               $('#SearchSummaryEquipment').prop('disabled', false);
            }
        }

        function printPropertySummaryovermodal(){ //Function To Open New Window For Generating Report of Newly Acquired Equipments
            var month=document.getElementById("summarymonth").value; //get value of month in user input
            var year=document.getElementById("summaryyear").value; //get value of year in user input
            var windowWidth = 1200; //set width of new window
            var windowHeight = 500; //set height of new window
            var xPos = (screen.width/2) - (windowWidth/2);
            var yPos = (screen.height/2) - (windowHeight/2);
            window.open("SUMMARYOFNEWLYACQUIREDPDFreport.php?month="+month+"&year="+year,"POPUP","width="
            + windowWidth+",height="+windowHeight +",left="+xPos+",top="+yPos); //open the new window and will read the file "SUMMARYOFNEWLYACQUIREDPDFreport.php" passing the value of year and month
        }
        ///<!---------------End Search Ajax--------------->
  </script>
</body>
</html>