<?php 
  require_once("../db/db_connection.php");
?>
<!-- 
	File:    formDisplay.php
	Purpose: display the contact we entered
	Authors: Millene L B S Cesconetto
			 Olha Tymoshchuk
			 Omar Rafik
-->
<html>
  <head>
      <meta charset="utf-8">
	  <title>Path Way List</title>
      <link rel="stylesheet" href="../css/bootstrap.min.css">
	  <script src="js/jquery-3.3.1.min.js"></script> 
	  <script src="js/ajax.js"></script>
	  <script src="js/canvasjs.min.js"></script> 
  </head>
  <body>
  <div class="container-fluid" >
	    <div class="content">
        <div class="row">
        <div class="col-2"> </div>
        <div class="col-12 bg-dark p-5"> 
	  		    <h1 class="text-center text-light "> Winter 2020 Project - Microwave Radio Path Web Site</h1> 
	    </div>
		<div class="col-lg-12 mb-auto" id="div2">
        <div class="col-lg-12 pt-5" style="text-align: center;">
           <h3> <a href="../index.php">Return to menu</a></h3>
        </div>
        <div class="col-12 " >
            <div class="row  pt-5">
              <div class="col-3"></div>
              <div class="col-6 text-center">
		 	    <form method="POST" id="updateForm">
					<table class="table table-bordered">
						<thead class="thead-light">
  			  				<tr>
						    <th scope="col"></th>
              				<th scope="col">Path Name</th>
							<th scope="col"></th>
  			  				</tr>
  						</thead>
						<tbody>  
<?php
    $db_conn = connectDB();
	$field_data = array();
	$qry = "select * from pathway order by pathname;";
	$stmt = $db_conn->prepare($qry);
	if (!$stmt){
		echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
		exit(1);
	}
	
	$status = $stmt->execute($field_data);
	if ($status){
		if ($stmt->rowCount() > 0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$id = "earthCurvature_".strval($row['idpathway'] ) ;
?>
						<tr>
     						<th scope="row"><input type="radio" name="list_select" value="<?php echo $row['idpathway']; ?>"></th>
	   						<td><?php echo $row['pathname']; ?></td>	
							<td><select class="form-control custom-select" id="<?php echo $id ; ?>">
  									<option value="4/3">4/3</option>
									<option value="1">1</option>
									<option value="2/3">2/3</option>
									<option value="infinity">infinity</option>

								</select>
							</td>   																																																																																																																																																																																																																																																																																																																															
						</tr>
<?php 		$db_conn = NULL; } 
		} else {
?>
							<div>
							<p>No contacts to display</p>
							</div>
<?php
        }
        
	} else {

		echo "<p>Error in display execute ".$stmt->errorCode()."</p>\n<p>Message ".implode($stmt->errorInfo())."</p>\n";
		exit(1);
	}

?>
                 		</tbody>
                  	</table>
    				<div class="col-12 py-2" style="text-align: center;">
					  <button type="button" class="btn btn-success" id="calc_btn">Calc</button>
    				</div>
  				</form>
    		  <div class="col-3"></div>
              </div>
			  </div>
			<div  class="col-12 mb-auto "   >
       			 <div class="row  pt-5">
          			<div class="col-3"></div>
          			<div class="col-6 text-center" id="div1">
					</div>
				</div>	
			</div>
			<div></div>
        </div><!--row-->
      </div><!--content-->
    </div><!-- content-fluid-->  

	<div class="content">
      <div class="row pt-5">
        <div class="col-2"> </div>
        <div class="col-8 text-center"  id="div3"> 
		<div>
		<div class="col-2"> </div>
	  </div>
	  </div>
	
	  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
	 
 </body>
 </html>