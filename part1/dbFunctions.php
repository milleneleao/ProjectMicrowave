<!-- 
	File:    dbFunctions.php
	Purpose: Validate's Functions and Database Functions 
	Authors: Millene L B S Cesconetto
			 Olha Tymoshchuk
			 Omar Rafik
-->
<?php

function clearSession(){
    $_SESSION['pathname'] = ""; 
    $_SESSION['description'] = "";
    $_SESSION['note'] = "";
    $_SESSION['store_file_name'] = ""; 
    $_SESSION['point'] = "";
    $_SESSION['groundheight'] = "";
    $_SESSION['antennaheight'] = "";
    $_SESSION['antennatype'] = "";
    $_SESSION['antennalength'] = "";
}
function validatePathway($data){
    $error_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(strlen($data[$i]) >  100){
                $error_msgs[] = "The maximum length is 100 characters";
            }
            else{
                $pathname = $data[$i];
            }
        }
        if($i == 1){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The field should be numeric";
            } 
            else if($data[$i] < 1.0 && $data[$i] > 100.0){
                $error_msgs[] = "The operating frequency for the path in
                Gigahertz (GHz). Allowed values are between
                1.0 and 100.0 GHz";
            }
            else{
                
                $opfrq = $data[$i];
               
            }
        }
        if($i == 2){
            if(!isset($data[$i])){
                $error_msgs[] = "the field is required";
            }
            else if(strlen($data[$i]) > 225){
                $error_msgs[] = "A short description of the path
                Maximum 255 characters in length";
            }
            else{
                $description = $data[$i];
                
            }
        }
        
        if($i == 3){
            if(strlen($data[$i]) > 65534){
                $error_msgs[] = "Notes about this path.
                May contain special characters.
                Maximum length of 65534 characters";
            }
            else{
                $note = $data[$i];
            }
        }
    }
    
    if(count($error_msgs) === 0){
        $_SESSION['pathname'] = $pathname;
        $_SESSION['opfrq'] = $opfrq;
        $_SESSION['description'] = $description;
        $_SESSION['note'] = $note;
        
    }

    return $error_msgs;
}

function validatePoint($data,$point){
    $error_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The field is numeric";
            }
            else if($data[$i] != 0 && $point == "start"){
                $error_msgs[] = "The distance of this end point from the start of
                the path in kilometres. On the second line this
                should be 0";
            }
            else{
                $point = $data[$i];
            }
            
            if($data[$i] < 0 && $point == "end"){
                $error_msgs[] = "The end point should be more than 0";
            }
            else {
                $point = $data[$i];
            }
        }
        if($i == 1){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "The value shouldn't be empty";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else {
                $groundheight = $data[$i];
            }

        }
        if($i == 2){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else {
                $antennaheight = $data[$i];
            }
        }
        if($i == 3){
            if($data[$i] !== "LDF4-50A" && 
                $data[$i] !== "LDF5-50A" &&
                $data[$i] !== "LDF-6-50" && 
                $data[$i] !== "LDF-6-50" && 
                $data[$i] !== "LDF7-50A" && 
                $data[$i] !== "LDF12-50"){
                
                    $error_msgs[] = "Allowed values are:<br/>
                LDF4-50A,<br/>
                LDF5-50A,<br/>
                LDF-6-50,<br/>
                LDF7-50A,<br/>
                LDF12-50";
            }
            else {
                $antennatype = $data[$i];
            }
        }
        if($i == 4){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else {
                $antennalength = $data[$i];
            }
        }
    }
    if(count($error_msgs) === 0){
        
        $_SESSION['point'] = $point;
        $_SESSION['groundheight'] = $groundheight;
        $_SESSION['antennatype'] = $antennatype;
        $_SESSION['antennalength'] = $antennalength;
    }
	return $error_msgs;
}

function validateMidPoints($data){
    $error_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else{
                $distance = $data[$i];
            }
        }
        if($i == 1){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is requires";
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = "The value should be numeric";
            }
            else{
                $groundheight = $data[$i];
            }

        }
        if($i == 2){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is requires";
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = "The value should not exceed 50 charaters";
            }
            else if($data[$i] !== "Grassland" 
                 && $data[$i] !== "Rough Grassland" 
                 && $data[$i] !== "Smooth rock" 
                 && $data[$i] !== "Bare Rock" 
                 && $data[$i] !== "Bare earth"
                 && $data[$i] !== "Paved Surface" 
                 && $data[$i] !== "Lake"
                 && $data[$i] !== "Ocean"
                 && $data[$i] !== "Rough rock"
                 && $data[$i] !== "Bare soil"){
                
                    $error_msgs[] = "Maximum length 50 characters. The type of
                terrain found at a midpoint. <br/>The allowed
                values are:<br/>
                Grassland,<br/>
                Rough Grassland,<br/>
                Smooth rock,<br/>
                Bare Rock,<br/>
                Bare earth,<br/>
                Paved Surface,<br/>
                Lake,<br/>
                Ocean,<br/>
                Rough rock";
            }
            else{
                $terraintype = $data[$i];
            }
        }
        if($i == 3){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else{
                $obstrucheight = $data[$i];
            }
        }
        if($i == 4){
            if(strlen($data[$i]) == 0){
                $error_msgs[] = "the field is required";
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = "The value should not exceed 50 characters";
            }
            else if($data[$i] !== "None" 
                 && $data[$i] !== "Trees" 
                 && $data[$i] !== "Brush" 
                 && $data[$i] !== "Buildings" 
                 && $data[$i] !== "Webbed Towers" 
                 && $data[$i] !== "Solid Towers" 
                 && $data[$i] !== "Power Cables"
                 && $data[$i] !== "Building"){
                
                $error_msgs[] = "Maximum length 50 characters. The type of
                terrain found at a midpoint.<br/>The allowed
                values are:<br/>
                None,<br/>
                Trees,<br/>
                Brush,<br/>
                Buildings,<br/>
                Webbed Towers,<br/>
                Solid Towers,<br/>
                Power Cables,<br/>
                Building";
            }
            else{
                $obstructype = $data[$i];
            }
        }
    }

    if(count($error_msgs) === 0){
        $_SESSION['distance'] = $distance;
        $_SESSION['groundheight'] = $groundheight;
        $_SESSION['terraintype'] = $terraintype;
        $_SESSION['obstrucheight'] = $obstrucheight;
        $_SESSION['obstructype'] = $obstructype;
    }

    return $error_msgs;
    
}


function insertPathway( $db_conn ){
    //print_r($_SESSION);
 
            
        if (!$db_conn){
	        $status = "DBConnectionFail";
            } 
        else {
		    $stmt = $db_conn->prepare("insert into pathway ( pathname, opfrq, description, note, pathfile) values(?,?,?,?,?)");
		    if (!$stmt){
			    $status = "PrepareFail";
            } 
            else {
            $pathname = $_SESSION['pathname'];
            $opfrq = $_SESSION['opfrq'];
            $description = $_SESSION['description'];
            $note = $_SESSION['note'];
            $pathfile = $_SESSION['store_file_name'];
			//encodes data for the security
			//$content = base64_encode(file_get_contents($_FILES['uploads']['tmp_name']));
			$data = array($pathname, $opfrq, $description, $note, $pathfile);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                
                //$status = "Execute Fail";
            }
            else{
                $status = "OK";
            }
		}
		
    }
    // if ($status != "OK"){
    //     //delete
    //     unlink($pathfile);
    //     }
    
	return $status;

}

function insertPoints($point, $db_conn ){
    
    
            
        if (!$db_conn){
	        $status = "DBConnectionFail";
            } 
        else {
            if($point == "start"){
                $stmt = $db_conn->prepare("insert into points ( startpoint, groundheight, antennaheight, antennatype, antennalength) values(?,?,?,?,?)");
            }
            else if($point == "end"){
                $stmt = $db_conn->prepare("insert into points ( endpoint, groundheight, antennaheight, antennatype, antennalength) values(?,?,?,?,?)");
            }
		    
            if (!$stmt){
			    $status = "PrepareFail";
            } 
            else {
            $pointIns = $_SESSION['point'];
            $groundheight = $_SESSION['groundheight'];
            $antennaheight = $_SESSION['antennaheight'];
            $antennatype = $_SESSION['antennatype'];
            $antennalength = $_SESSION['antennalength'];
			//encodes data for the security
			//$content = base64_encode(file_get_contents($_FILES['uploads']['tmp_name']));
			$data = array($pointIns, $groundheight, $antennaheight, $antennatype, $antennalength);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                
                //$status = "Execute Fail";
			}
		}
		
    }


	return $status;

}

//function to insert valid midpoints into database !

function insertValidMidpoints( $db_conn ) {

        if (!$db_conn){
	        $status = "DBConnectionFail";
            } 
        else {
		    $stmt = $db_conn->prepare("insert into midpoint ( distance, groundheight, terraintype, obstrucheight, obstructype) values(?,?,?,?,?)");
		    if (!$stmt){
			    $status = "PrepareFail";
            } 
            else {
            $distance = $_SESSION['distance'];
            $groundheight = $_SESSION['groundheight'];
            $terraintype = $_SESSION['terraintype'];
            $obstrucheight = $_SESSION['obstrucheight'];
            $obstructype = $_SESSION['obstructype'];
			//encodes data for the security
			//$content = base64_encode(file_get_contents($_FILES['uploads']['tmp_name']));
			$data = array($distance, $groundheight, $terraintype, $obstrucheight, $obstructype);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                
                //$status = "Execute Fail";
			}
		}
		
    }
    // if ($status != "OK"){
    //     //delete
    //     unlink($pathfile);
    //     }

	return $status;

}

?>