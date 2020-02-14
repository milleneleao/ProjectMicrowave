<?php 
  session_start();
  require_once("../db/db_connection.php");
  require_once("dbFunctions.php"); 
?>
<!-- 
	File:    index.php
	Purpose: Upload CSV to permanent folder and upload data to Database
	Authors: Millene L B S Cesconetto
			     Olha Tymoshchuk
			     Omar Rafik
-->
<html>
  <head>
    <title> Winter 2020 Project - Lamp2 </title>
   	<link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
          $err_msg = validate_Form();
          if (count($err_msg) > 0) {
              form_1($err_msg);

              //displayErrors();

          } else {
              $status = processUploads();
              displayStatus($status);
          }
        } else {
          form_1(array(""));
        }

        function displayErrors(array $error_msg){
          echo "<p>\n";
          foreach($error_msg as $v){
              echo $v."<br>\n";
          }
          echo "</p>\n";
      } 
      function form_1($error){ 
    ?>
    <div class="container-fluid">
	    <div class="content">
        <div class="row ">
          <div class="col-12 bg-dark p-5"> 
	  		    <h1 class="text-center text-light "> Winter 2020 Project - Microwave Radio Path Web Site</h1> 
	      	</div>

          <div class="col-12 ">
            <div class="row  pt-5">
              <div class="col-3"></div>
              <div class="col-6 text-center">
               <h5>Select the .csv file by clicking the "Choose File" button. After choosing the file, click the "Save" button to send the file to the server and insert the data into the database.
                   If an error occurs, a message will be displayed.</h5>
                <form method="POST" action="./upload.php" enctype="multipart/form-data" class="pt-5">
                <div class="form-group ">
                  <input class="form-control-lg" type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                  <input class="form-control-lg" type="file" name="uploads" />   
                  <input class="btn btn-secondary btn-lg" type="submit" name="uploadFiles"  value="Save">
                  <?php if((!empty($error))) {?>
                      <div  class="visible pt-2 text-danger" id="fbage" >
                      <?php 
                      for ($i = 0; $i < count($error); $i++) {
                        echo $error[$i]. "<br />";
                       }
                      ?> 
                  </div>
                    <?php } ?>  
                </div>
                     
                </form>
              </div>
              <div class="col-3"></div>
            </div>
            <div class="col-lg-12 pt-5" style="text-align: center;">
              <a href="../index.php">Return to menu</a>
            </div>
	  	    </div>

        </div>
      </div>
    </div>  
    <?php  } 
    function validate_Form(){
    $error_file = array();

    //validate File
    $allowed_exts = array("csv");
    $allowed_types = array("text/csv");
    
    if (isset($_FILES['uploads']) && !empty($_FILES['uploads']['name'])){
      $up =$_FILES['uploads'];
      if ($up['error'] == 0){
        if ($up['size'] == 0){
          $error_file[] = "An empty file was uploaded";
        }
        $ext = strtolower(pathinfo($up['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_exts)){
          $error_file[]  = "File extension does not indicate that the uploaded file is of an  allowed file type";
        }
        if (!in_array($up['type'], $allowed_types)){
            $error_file[]  = "The uploaded file's MIME type is not allowed";
        }
        if (!file_exists($up['tmp_name'])){
            $error_file[]  = "No files exists on the server for this upload";
        }
      } else {
         $error_file[]  = "An error occured during file upload";
      } 
    } else {
        $error_file[]  = "No file was uploaded";
    }
    return $error_file;
    }

    function processUploads(){

      $status = "OK";

      //1) Move to permanet Directory
      if(!is_dir('uploads') || !is_writable("uploads")){ 
        $status = "NoDirectory";
      } else {
        $ext = strtolower(pathinfo($_FILES['uploads']['name'], PATHINFO_EXTENSION));
        $fn = $_FILES['uploads']['name'];
        $newName = "uploads/$fn.".rand(10000, 99999) . ".". $ext;
        $_SESSION['store_file_name'] = $newName;
        $success = move_uploaded_file($_FILES['uploads']['tmp_name'], $newName);

        if (!$success){
          $status = "FailMove";
          return $status;
        } else {
          // Read each line and send to Database
          $handle  = fopen($newName, "r");
          $count_line = 1;
          //print_r($_SESSION);

          $db_conn = connectDB();
          //$db_conn->beginTransaction();

          //b$db->eginTransaction();
          print_r($_SESSION);
          while  ($line  = fgetcsv($handle, 1000, ","))  {
            
            if($count_line == 1){
              $error = validatePathway($line);
              if(count($error) === 0){
                clearSession();
                insertPathway($db_conn);
              }
              else{
                break ;
              }
            }

            if ($count_line == 2){
              $error = validatePoint($line,"start");
              if(count($error) === 0){
                clearSession();
                insertPoints("start", $db_conn );
              }
              else{
                break;
              }
            }

            if ($count_line == 3){
                         
              $error = validatePoint($line,"end");
              
              if(count($error) === 0){
                clearSession();
                insertPoints("end", $db_conn ); 
              }
              else{
                break;
              }
            }

            if ($count_line > 3){
        
              $error = validateMidPoints($line);
              //echo count($error);
              if(count($error) === 0){
                clearSession();
                insertValidMidpoints( $db_conn );
              }
              else{
                break ;
              }
            }
            
            $count_line++;   
          }//end while
          // if(count($error) === 0) {
          //   $db_conn->commit();
          // }
          // else{
          //   $db_conn->rollback();
          // }
          $db_conn = NULL;     
        }
      }
      displayErrors($error);
      return $status;
    }  

    function displayStatus($status){
      $createSumary = false;
      $msg = "";
      if ($status == "FailMove"){
        $msg = "File upload failed - failed to move file to permanent storage"; 
      }  else if ($status == "NoDirectory") {
        $msg ="File upload failed - The permanent storage directory does not exist or is not accessible";
      }  else if ($status == "PrepareFail"){
        $msg = "File upload failed - Error getting ready to insert data into the database ";
      } else if ($status == "ExecuteFail"){
        $msg = "File upload failed - Error inserting data into the database ";
      } else if ($status == "DBConnectionFail"){
        $msg = "File upload failed - Error connecting to the database";
      } else {
        $msg = "File uploaded successfully";
        $createSumary = true;
        $file_name   = $_FILES['uploads']['name'];
        $store_file_name = $_SESSION['store_file_name'];
        $file_uploaded =  date('Y/m/d'); 
        $filesize =  $_FILES['uploads']['size'];
        $file_type =  $_FILES['uploads']['type'];
      }
    ?>
    <div class="row pt-5">
      <div class="col"> </div>
      <div class="col-8">
        <h4 class="text-center"><?php echo $msg ?></h4>
      </div>
    </div>  
    <?php } ?>
  </body>
</html>