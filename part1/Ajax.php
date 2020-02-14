<?php
// <!-- 
// File:    Ajax.php
// Purpose: page requested by Ajax.js. Returns an array with data when the request is "Display" 
//          and returns a status array when the function is "Reset"
// Authors: Millene L B S Cesconetto
//          Olha Tymoshchuk
//          Omar Rafik
// -->
header("Content-Type: application/json");
require_once("./dbFunctions.php");
require_once("../db/db_connection.php");

if(isset($_POST['display'])){
    $id = $_POST['id'];
    $db_conn = connectDB();

    $qry = "select * from pathway where idpathway = ?";
    $field_data = array($id);
	$stmt = $db_conn->prepare($qry);
    $status = $stmt->execute($field_data);
    if ($stmt->rowCount() > 0){
        $result = array("status" => "OK");
        $result['pathway'] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($result['pathway'], $row);
        }

        $qry = "select * from points where idpathway = ?";
        $field_data = array($id);
        $stmt = $db_conn->prepare($qry);
        $status = $stmt->execute($field_data);
        if ($stmt->rowCount() > 0){
            $result['points'] = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($result['points'], $row);
            }
        }

        $qry = "select * from midpoint where idpathway = ?";
        $field_data = array($id);
        $stmt = $db_conn->prepare($qry);
        $status = $stmt->execute($field_data);
        if ($stmt->rowCount() > 0){
            $result['midpoint'] = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($result['midpoint'], $row);
            }
        }

        disconnect_db($db_conn);
        echo json_encode($result);
    } else {
        echo '{ "status": "None" }';
    }  
   
}



 if(isset($_POST['resetID'])){
    $id = $_POST['id'];

    $error_msg = array();
    $file ="";
    $db_conn = connectDB();
    
    $qry = "select * from pathway where idpathway = ?";
    $field_data = array($id);
    $stmt = $db_conn->prepare($qry);
    $status = $stmt->execute($field_data);
    if ($stmt->rowCount() > 0){
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $file = $row['pathfile'];
        }
    }

    $db_conn->beginTransaction();
  
    //first delete all register 

    // Delete MidPoint register
    $qry = "delete from midpoint where  idpathway =  ?";
    $field_data = array($id);
    $stmt = $db_conn->prepare($qry);
    $status = $stmt->execute($field_data);
    if (!$stmt){
        $status = "Error getting points ready to delete data into the midpoint table";
        $error_msg[] = $status;
    } 
    else {
        $result = $stmt->execute();
        if(!$result){
            $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            $error_msg[] = $status;
        } 
    }

    // Delete points register
    if(count($error_msg) === 0) {
        $qry = "delete from points where idpathway =  ?";
        $field_data = array($id);
        $stmt = $db_conn->prepare($qry);
        $status = $stmt->execute($field_data);
        if (!$stmt){
            $status = "Error getting points ready to delete data into the points table";
            $error_msg[] = $status;
        } 
        else {
            $result = $stmt->execute();
            if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                $error_msg[] = $status;
            } 
        }
    }

    // Delete pathway register
    if(count($error_msg) === 0) {
        $qry = "delete from pathway where idpathway =  ?";
        $field_data = array($id);
        $stmt = $db_conn->prepare($qry);
        $status = $stmt->execute($field_data);
        if (!$stmt){
            $status = "Error getting pathway ready to delete data into the pathway table";
            $error_msg[] = $status;
        } 
        else {
            $result = $stmt->execute();
            if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                $error_msg[] = $status;
            } 
        }
    }


    
    //inserir os dados novamente
    $count_line = 1;
    
    $handle  = fopen($file, "r");



    while  ($line  = fgetcsv($handle, 1000, ","))  {
       if($count_line == 1){
        $error_msg = validatePathway($line,$count_line);
        if(count($error_msg) === 0){
          $status =  insertPathway($db_conn,$file);
          if($status !== 'OK'){
            $error_msg[] = $status; 
            break;
          }
          clearSession();
        }
        else{
          break ;
        }
       }     

      if ($count_line == 2){
        $error_msg = validatePoint($line,"start",$count_line);
        if(count($error_msg) === 0){
          $status =  insertPoints("start", $db_conn );
          if($status !== 'OK'){
            $error_msg[] = $status; 
            break;
          }
          clearSession();
        }
        else{
          break;
        }
      }



      if ($count_line == 3){
                   
        $error = validatePoint($line,"end",$count_line);
        
        if(count($error_msg) === 0){
          $status = insertPoints("end", $db_conn,$count_line ); 
          if($status !== 'OK'){
            $error_msg[] = $status; 
            break;
          }
          clearSession();
        }
        else{
          break;
        }
      }

      if ($count_line > 3){
        $error_msg = validateMidPoints($line,$count_line);
        if(count($error_msg) === 0){
          insertValidMidpoints( $db_conn,$count_line );
          clearSession();
        }
        else{
          break ;
        }
      }
      
      $count_line++;   
    }

    if(count($error_msg) === 0) {
        $db_conn->commit();
        disconnect_db($db_conn);
        $result = array("status" => "Success!");
        echo json_encode($result);
    }
      else{
        $db_conn->rollback();
        disconnect_db($db_conn);
        $result = array("status" => "Fail");
        $result['errors'] = array();
        array_push($result['errors'],$error_msg);
        echo json_encode($result);
    }
    
 }  



?>