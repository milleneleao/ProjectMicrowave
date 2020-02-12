<!-- 
	File:    dbFunctions.php
	Purpose: Validate's Functions and Database Functions 
	Authors: Millene L B S Cesconetto
			 Olha Tymoshchuk
			 Omar Rafik
-->
<?php

function validatePathway($data){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            if(empty($data[$i])){
                $error_msgs[] = "the field is required";
            }
            else if(strlen($data[$i]) >  100){
                $error_msgs[] = "The maximum length is 100 characters";
            }
            else{
                $pathName = $data[$i];
            }
        }
        if($i == 1){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The field should be numeric";
            } 
            else if($data[$i]< 1.0 && $data[$i] > 100.0){
                $error_msgs[] = "The operating frequency for the path in
                Gigahertz (GHz). Allowed values are between
                1.0 and 100.0 GHz";
            }
            else{
                $opfrq = $data[$i];
            }
        }
        if($i == 2){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
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

    if(count($err_msgs) < 0){
        $_SESSION['pathname'] = $pathName;
        $_SESSION['opfrq'] = $opfrq;
        $_SESSION['description'] = $description;
        $_SESSION['note'] = $note;
        $_SESSION['pathfile'] = $pathfile;
    }

    return $err_msgs;
}

function validatePoint($data,$point){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            if(empty($data[$i])){
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
                $startpoint = $data[$i];
            }
            
            if($data[$i] < 0 && $point == "end"){
                $error_msgs[] = "The end point should be more than 0";
            }
            else {
                $endpoint = $data[$i];
            }
        }
        if($i == 1){
            if(empty($data[$i])){
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
            if(empty($data[$i])){
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
            if($data[$i] === "LDF4-50A" || $data[$i] === "LDF5-50A" || $data[$i] === "LDF-6-50" || $data[$i] === "LDF-6-50" || $data[$i] === "LDF7-50A" || $data[$i] === "LDF12-50"){
                $error_msgs[] = "Allowed values are:
                LDF4-50A
                LDF5-50A
                LDF-6-50
                LDF7-50A
                LDF12-50";
            }
            else {
                $antennatype = $data[$i];
            }
        }
        if($i == 4){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else {
                $antennalength = $data[$i];
            }
        }
    }
    if(count($err_msgs) < 0){
        $_SESSION['startpoint'] = $startpoint;
        $_SESSION['endpoint'] = $endpoint;
        $_SESSION['groundheight'] = $groundheight;
        $_SESSION['antennatype'] = $antennatype;
        $_SESSION['antennalength'] = $antennalength;
    }
	return $err_msgs;
}

function validateMidPoints($data){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            if(empty($data[$i])){
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
            if(empty($data[$i])){
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
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = "The value should be numeric";
            }
            else if($data[$i] !== "Grassland" || $data[$i] !== "Rough Grassland" 
            || $data[$i] !== "Rough Grassland" || $data[$i] !== "Smooth Rock" 
            || $data[$i] !== "Bare Rock" || $data[$i] !== "Bare earth"
            || $data[$i] !== "Paved Surface" || $data[$i] !== "Lake"
            || $data[$i] !== "Ocean"){
                $error_msgs[] = "Maximum length 50 characters. The type of
                terrain found at a midpoint. The allowed
                values are:
                Grassland
                Rough Grassland
                Smooth rock
                Bare Rock
                Bare earth
                Paved Surface
                Lake
                Ocean";
            }
            else{
                $terraintype = $data[$i];
            }
        }
        if($i == 3){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
            else{
                $obstrucheight = $data[$i];
            }
        }
        if($i == 4){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = "The value should be numeric";
            }
            else if($data[$i] !== "Trees" || $data[$i] !== "Brush" 
            || $data[$i] !== "Buildings" || $data[$i] !== "Webbed Towers" 
            || $data[$i] !== "Solid Towers" || $data[$i] !== "Solid Towers"
            || $data[$i] !== "Power Cables "){
                $error_msgs[] = "Maximum length 50 characters. The type of
                terrain found at a midpoint. The allowed
                values are:
                None
                Trees
                Brush
                Buildings
                Webbed Towers
                Solid Towers
                Power Cables";
            }
            else{
                $obstructype = $data[$i];
            }
        }
    }

    if(count($err_msgs) < 0){
        $_SESSION['distance'] = $distance;
        $_SESSION['groundheight'] = $groundheight;
        $_SESSION['terraintype'] = $terraintype;
        $_SESSION['obstrucheight'] = $obstrucheight;
        $_SESSION['obstructype'] = $obstructype;
    }

    return $err_msgs;
    
}


function insertPPP(){
    $db_conn = connectDB();
            
    if (!$db_conn){
	        $status = "DBConnectionFail";
            } 
            else {
		    $stmt = $db_conn->prepare("insert into pathway (idpathway, pathname, opfrq, description, note, pathfile) values(?,?,?,?,?,?)");
		    if (!$stmt){
			    $status = "PrepareFail";
            } 
            else {
            $idPathfile = $_SESSION['idPathFile'];
			//encodes data for the security
			//$content = base64_encode(file_get_contents($_FILES['uploads']['tmp_name']));
			$data = array($name, $age, $dio, $f_name, $f_new_name, $f_date, $f_size, $f_type);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
                
                //$status = "Execute Fail";
			}
		}
		$db_conn = NULL;
    }
    if ($status != "OK"){
        //delete
        unlink($newName);
        }
    }
}	
	return $status;
}
}
?>