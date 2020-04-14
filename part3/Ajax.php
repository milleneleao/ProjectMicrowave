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
        // $id = 7;
        // $curv = '4/3';
        $id = $_POST['id'];
        $curv = $_POST['curv'];

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
            $opfrq = $result['pathway'][0]['opfrq'];
            $pathL = $result['points'][1]['endpoint'];

            $PA = 92.4 + (20 * log10($opfrq)) + (20 * log10($pathL));
            $result['pathway']["PA"] = $PA;

            // print_r($result);

            $qry = "select * from midpoint where idpathway = ?";
            $field_data = array($id);
            $stmt = $db_conn->prepare($qry);
            $status = $stmt->execute($field_data);
            if ($stmt->rowCount() > 0){
                $result['midpoint'] = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $row["FirstFreznel"] = 17.3*sqrt($row["distance"]*($pathL-$row["distance"])/($opfrq*$pathL));
                    $row["CurvatureHeight"] = 0;

                    switch ($curv) {
                        case '4/3':
                            $row["CurvatureHeight"] = ($row["distance"]*($pathL-$row["distance"]))/17;
                            break;
                        case '1':
                            $row["CurvatureHeight"] = ($row["distance"]*($pathL-$row["distance"]))/12.75;
                            break;
                        case '2/3':
                            $row["CurvatureHeight"] = ($row["distance"]*($pathL-$row["distance"]))/8.5;
                            break;
                        case 'infinity':
                            $row["CurvatureHeight"] = 0;
                        break;
                    }
                   

                    $row["ApparentGround"] = $row["groundheight"] + $row["obstrucheight"] + $row["CurvatureHeight"];
                    
                   
                    $row["Total"] = $row["ApparentGround"] + $row["FirstFreznel"];
                    array_push($result['midpoint'], $row);
                
                }
            }
      
           disconnect_db($db_conn);
           echo json_encode($result);
           //print_r($result);
        } 
        else {
            echo '{ "status": "None" }';
        }  
       
      }

   }

    

?>