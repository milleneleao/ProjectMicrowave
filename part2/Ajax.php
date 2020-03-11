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
require_once("../db/dbFunctions.php");
require_once("../db/db_connection.php");

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['select'])){
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
        } 
        else {
            echo '{ "status": "None" }';
        }  
       
      }

    }

    if(isset($_POST['update'])){
        $data = $_POST['data'];
        $error_msg = [];
        $line = [];
        array_push($line,$data[1],$data[2],$data[3],$data[4]);
        $error_msg = validatePathway($line,0);
        if(count($error_msg) === 0){
          $db_conn = connectDB();  
          $status =  UpdatePathway($db_conn,$data);
          disconnect_db($db_conn);
          if($status !== 'OK'){
            $result = array("status" => "Error"); 
            $result['error_msg'] = $status;
            echo json_encode($result);
          } else {
            $result = array("status" => "Ok"); 
            $result['error_msg'] = 'Upload Success!!';
            echo json_encode($result);
          }
        } else {
            $result = array("status" => "Error"); 
            $result['error_msg'] = $error_msg;
            echo json_encode($result);
            
        }
    }

?>