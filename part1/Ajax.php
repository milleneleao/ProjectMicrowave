<?php

header("Content-Type: application/json");
require_once("../db/db_connection.php");

$db_conn = connect_db();

if(isset($_POST['display'])){
    $id = $_POST['id'];

    $qry = "select * from pathway where idpathway = " .$id;
    $rs  = $db_conn->query($qry);
    if ($rs->num_rows > 0){
        $result = array("status" => "OK");
        $result['pathway'] = array();
        while ($row = $rs->fetch_assoc()){
            array_push($result['pathway'], $row);
        }

        $qry = "select * from points where idpathway = " .$id;
        $rs  = $db_conn->query($qry);
        if ($rs->num_rows > 0){
            $result['points'] = array();
            while ($row = $rs->fetch_assoc()){
                array_push($result['points'], $row);
            }
        }


        $qry = "select * from midpoint where idpathway = " .$id;
        $rs  = $db_conn->query($qry);
        if ($rs->num_rows > 0){
            $result['midpoint'] = array();
            while ($row = $rs->fetch_assoc()){
                array_push($result['midpoint'], $row);
            }
        }

        echo json_encode($result);
    } else {
        echo '{ "status": "None" }';
    }
    
     disconnect_db($db_conn);
}


if(isset($_POST['resetID'])){
    $id = $_POST['id'];
    $status = 'ok';
    $file ="";
    $db_conn = connect_db();



    $qry = "select * from pathway where idpathway = " .$id;
    $rs  = $db_conn->query($qry);
    if ($rs->num_rows > 0){
        $result = array("status" => "OK");
        $result['pathway'] = array();
        while ($row = $rs->fetch_assoc()){
            array_push($result['pathway'], $row);
        }
       $jPatway = json_encode($result);
    }

    //first delete all register 
    $stmt = $db_conn->prepare("delete from midpoint where  idpathway = " .$id);
    if (!$stmt){
        $status = "PrepareFail";
    } 
    else {
        $result = $stmt->execute();
        if(!$result){
            $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
        } else {
            $status = "ok";
        }
    }

    if($status == 'ok'){
        $stmt = $db_conn->prepare("delete from points where  idpathway = " .$id);
        if (!$stmt){
            $status = "PrepareFail";
        } 
        else {
            $result = $stmt->execute();
            if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            } else { $status = "ok";}
         }
    }

    if($status == 'ok'){
        $stmt = $db_conn->prepare("delete from pathway where idpathway = " .$id);
        if (!$stmt){
            $status = "PrepareFail";
        } 
        else {
            $result = $stmt->execute();
            if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            } else { $status = "ok";}
         }
    }  

    if($status == "ok"){
        //inserir os dados novamente
        echo $jPatway ;
  
    } else {
        echo '{ "status": "None" }';
    }

}  

 function connect_db(){
    $db_conn = new mysqli('localhost', 'microwaveuser', '!Lamp12!', 'microwave');
    if ($db_conn->connect_errno) {
       
        printf ("Could not connect to database server\n Error: "
            .$db_conn->connect_errno ."\n Report: "
            .$db_conn->connect_error."\n");
        die;
    }
	if (!$db_conn->set_charset("utf8")){
		echo "Error, could not set character set\n";
		$db_conn->close();
		die;
	}
    return $db_conn;
}

// function disconnect_db($db_conn){
//     $db_conn->close();
// }
?>