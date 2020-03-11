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
    if(isset($_POST['update'])){
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

?>