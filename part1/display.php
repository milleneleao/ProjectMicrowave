<?php 
  require_once("../db/db_connection.php");
?>
<!-- 
	File:    displayPathway.php
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
  </head>
  <body>
  <div class="container-fluid">
	    <div class="content">
        <div class="row ">
        <div class="col-2"> </div>
          <div class="col-12 bg-dark p-5"> 
	  		    <h1 class="text-center text-light "> Winter 2020 Project - Microwave Radio Path Web Site</h1> 
	      </div>
          <div class="col-12 ">
            <div class="row  pt-5">
              <div class="col-3"></div>
              <div class="col-6 text-center">


			<table class="table table-bordered">
			<thead class="thead-light">
  			  <tr>
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
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
			<tr>
	   			<td><?php echo $row['pathname']; ?></td>
                <th scope="row"><input type="radio" name="list_select[]" value="<?php echo $row['idpathway']; ?>"></th>
  
			</tr>
<?php $db_conn = NULL; } ?>

<?php
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
 
    <div class="col-3"></div>
            </div>
            <div class="col-lg-12 pt-5" style="text-align: center;">
              <a href="../index.php">Return to menu</a>
            </div>
	  	    </div>

        </div>
      </div>
    </div>  
 </body>
 </html>
