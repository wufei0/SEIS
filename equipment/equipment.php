<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>SEIS alpha</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

<link rel="stylesheet" type="text/css" href="../css/index.css" />
<script src="../jq/jquery-1.11.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</head>

<body>
<div class="navbar-fixed-top bluebackgroundcolor">
<?php
        $equipmentActive="class='active'";
	$rootDir='../';
	include_once('../header.php');

?>
</div>

<!-- ############################################################### container ######################################################## -->
<div class="container">
  	
            
                <ol class="breadcrumb">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Library</a></li>
                  <li class="active">Data</li>
                </ol>	
        
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Your file was uploaded successfully!</div>
                  <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;You must select a file first to upload!</div>
                </div>

                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New Article</h3>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                      <form role="form">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Article Title <small><i> (Required Field)</i></small></label>
                          <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Date</label>
                          <div class="row">
                            <div class="col-md-2">
                              <select class="form-control input-sm">
                                  <option>Date</option>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <select class="form-control input-sm">
                                  <option>Date</option>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <select class="form-control input-sm">
                                  <option>Date</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Content<small><i> (Required Field)</i></small></label>
                            <textarea class="form-control"></textarea>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Clear</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </form>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-8"><h3 class="panel-title">Current Articles</h3></div>
                                      <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                          <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Search</button>
                                          </span>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                    <div class="panel-body bodyul" style="overflow: auto">
                                        
                                        <table class="table table-hover">
                                            <tr>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <td><b><input disabled="disabled" type="checkbox" id="checkboxWarning" value="option1"></b></td><td ><b>Title</b></td><td><b>Date</b></td><td><b>Added by</b></td><td><b>Added by</b></td><td><b>Added by</b></td>
                                                </div>
                                                <div class="col-md-1">
                                                    <td colspan="3" align="center"><b>Control Content</b></td>
                                                </div>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample samplesamplesamplesamplesamplesamplesample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#">Link</a></td><td><a href="#">Link</a></td>
                                                </div>
                                                <div class="col-md-1">
                                                    <td><a href="#"><span class="glyphicon glyphicon-eye-open" title="View"></span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil" title="Edit"></span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash" title="Delete"></span></a></td>
                                                </div>
                                            </div>
                                            </tr>
                                        </table>
                                        
                                        <!-- <table class="table table-hover">
                                            <tr><td><b><input disabled="disabled" type="checkbox" id="checkboxWarning" value="option1"></b></td><td ><b>Title</b></td><td><b>Date</b></td><td><b>Added by</b></td><td colspan="3" align="center"><b>Control Content</b></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                            <tr><td><input type="checkbox" id="checkboxWarning" value="option1"></td><td>Sample sample</td><td>10/05/2014</td><td><a href="#">Link</a></td><td><a href="#"><span class="glyphicon glyphicon-eye-open">&nbsp;View</span></a></td><td><a href="#"><span class="glyphicon glyphicon-trash">&nbsp;Delete</span></a></td><td><a href="#"><span class="glyphicon glyphicon-pencil">&nbsp;Edit</span></a></td></tr>
                                        </table> -->
                                    </div>
                                    <div class="panel-footer">
                                        <nav>
                                          <ul class="pagination">
                                            <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                                          </ul>
                                        </nav>
                                    </div>
                            </div>
                    </div>
                
            </div>
</div>
<!-- ############################################################### end container ######################################################## -->

<?php
	$root='';
	include_once('../footer.php');

?>
</body>
</html>