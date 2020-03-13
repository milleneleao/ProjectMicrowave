<?php

// <!-- 
// 	File:    dbFunctions.php
// 	Purpose: Validate's Functions and Database Functions 
// 	Authors: Millene L B S Cesconetto
// 			 Olha Tymoshchuk
// 			 Omar Rafik
// -->

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


function validatePathway($data,$line){
    $error_msgs = array();
    
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            $msg = "Error: Line " . $line;
            $msg .= " Field : PathName ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg. " - the field is required";
                break;
            }
            else if(strlen($data[$i]) >  100){
                $error_msgs[] = $msg. " - The maximum length is 100 characters";
                break;
            }
            else{
                $pathname = $data[$i];
            }
        }

        if($i == 1){
            $msg = "Error: Line " . $line;
            $msg = $msg . " Field : Operanting Frequency ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg . " the field is required";
                break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = $msg . " The field should be numeric";
                break;
            } 
            else if($data[$i] < 1.0 && $data[$i] > 100.0){
                $error_msgs[] = $msg . " The operating frequency for the path in
                Gigahertz (GHz). Allowed values are between
                1.0 and 100.0 GHz";
                break;
            }
            else{
                $opfrq = $data[$i];
            }
        }

        if($i == 2){
            $msg = "Error: Line " . $line;
            $msg = $msg . " Field : Description ";
            if(!isset($data[$i])){
                $error_msgs[] = $msg ." the field is required";
                break;
            }
            else if(strlen($data[$i]) > 225){
                $error_msgs[] = $msg . " A short description of the path
                Maximum 255 characters in length";
               break;
            }
            else{
                $description = $data[$i];
                
            }
        }
        
        if($i == 3){
            $msg = "Error: Line " . $line;
            $msg = $msg . " Field : Note ";
            if(strlen($data[$i]) > 65534){
                $error_msgs[] = $msg . " Notes about this path.
                May contain special characters.
                Maximum length of 65534 characters";
                break;
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

function validatePoint($data,$point,$line){
    $error_msgs = array();

    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Distance ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg ."the field is required";
                break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = $msg ."The field is numeric";
                break;
            }
            else if($data[$i] != 0 && $point == "start"){
                $error_msgs[] = $msg ."The distance of this end point from the start of
                the path in kilometres. On the second line this
                should be 0";
                break;
            }
            else{
                $point = $data[$i];
            }
            
            if($data[$i] < 0 && $point == "end"){
                $error_msgs[] = $msg ."The end point should be more than 0";
                break;
            }
            else {
                $point = $data[$i];
            }
        }
        if($i == 1){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Ground height ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg ."The value shouldn't be empty";
                break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = $msg ."The value should be numeric";
                break;
            }
            else {
                $groundheight = $data[$i];
            }

        }
        if($i == 2){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Antenna height ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] =  $msg ." the field is requires";
                break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = $msg ." The value should be numeric";
                break;
            }
            else {
                $antennaheight = $data[$i];
            }
        }
        if($i == 3){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Antenna cable type ";
            if($data[$i] !== "LDF4-50A" && 
                $data[$i] !== "LDF5-50A" &&
                $data[$i] !== "LDF-6-50" && 
                $data[$i] !== "LDF-6-50" && 
                $data[$i] !== "LDF7-50A" && 
                $data[$i] !== "LDF12-50"){

                $error_msgs[] =  $msg ."Allowed values are:<br/>
                LDF4-50A,<br/>
                LDF5-50A,<br/>
                LDF-6-50,<br/>
                LDF7-50A,<br/>
                LDF12-50";
                break;
            }
            else {
                $antennatype = $data[$i];
            }
        }
        if($i == 4){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Antenna cable length ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] =  $msg ."the field is required";
                break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] =  $msg ."The value should be numeric";
                break;
            }
            else {
                $antennalength = $data[$i];
            }
        }
    }


    if(count($error_msgs) === 0){
        $_SESSION['point'] = $point;
        $_SESSION['antennaheight'] = $antennaheight;
        $_SESSION['groundheight'] = $groundheight;
        $_SESSION['antennatype'] = $antennatype;
        $_SESSION['antennalength'] = $antennalength;
    }
	return $error_msgs;
}

function validateMidPoints($data,$line){
    $error_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        if($i == 0){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Distance ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg ."the field is requires";
            break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = $msg ."The value should be numeric";
            break;
            }
            else{
                $distance = $data[$i];
            }
        }
        if($i == 1){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Ground Height";
            if(strlen($data[$i]) == 0){
                $error_msgs[] =  $msg ."the field is requires";
            break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] =  $msg ."The value should be numeric";
            break;
            }
            else{
                $groundheight = $data[$i];
            }

        }
        if($i == 2){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Terrain Type ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] =  $msg ."the field is requires";
            break;
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] =  $msg ."The value should not exceed 50 charaters";
            break;
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
                
                    $error_msgs[] =  $msg ."Maximum length 50 characters. The type of
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
            break;
            }
            else{
                $terraintype = $data[$i];
            }
        }
        if($i == 3){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Obstruction height  ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] =  $msg ."the field is required";
            break;
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] =  $msg ."The value should be numeric";
            break;
            }
            else{
                $obstrucheight = $data[$i];
            }
        }
        if($i == 4){
            $msg = "Error: Line " . $line;
            $msg .= " Field : Obstruction type  ";
            if(strlen($data[$i]) == 0){
                $error_msgs[] = $msg ."the field is required";
            break;
            }
            else if(strlen($data[$i]) > 50){
                $error_msgs[] = $msg ."The value should not exceed 50 characters";
            break;
            }
            else if($data[$i] !== "None" 
                 && $data[$i] !== "Trees" 
                 && $data[$i] !== "Brush" 
                 && $data[$i] !== "Buildings" 
                 && $data[$i] !== "Webbed Towers" 
                 && $data[$i] !== "Solid Towers" 
                 && $data[$i] !== "Power Cables"
                 && $data[$i] !== "Building"){
                
                $error_msgs[] = $msg ."Maximum length 50 characters. The type of
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
            break;
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


function insertPathway( $db_conn,$fileName ){  
        if (!$db_conn){
	        $status = "File upload failed - Error connecting to the database";
            } 
        else {
		    $stmt = $db_conn->prepare("insert into pathway ( pathname, opfrq, description, note, pathfile) values(?,?,?,?,?)");
		    if (!$stmt){
			    $status = "Error getting pathway ready to insert data into the database";
            } 
            else {
            $pathname    = $_SESSION['pathname'];
            $opfrq       = $_SESSION['opfrq'];
            $description = $_SESSION['description'];
            $note        = $_SESSION['note'];
            $pathfile    = $fileName;
			$data = array($pathname, $opfrq, $description, $note, $pathfile);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            }
            else{
                $id = $db_conn->lastInsertId();
                $_SESSION['idpathway'] = $id;
                $status = "OK";
            }
		}
		
    }
	return $status;
}

function insertPoints($point, $db_conn ){
    
        if (!$db_conn){
	        $status = "File upload failed - Error connecting to the database";
            } 
        else {
            if($point == "start"){
                $stmt = $db_conn->prepare("insert into points ( startpoint, groundheight, antennaheight, antennatype, antennalength,idpathway) values(?,?,?,?,?,?)");
            }
            else if($point == "end"){
                $stmt = $db_conn->prepare("insert into points ( endpoint, groundheight, antennaheight, antennatype, antennalength,idpathway) values(?,?,?,?,?,?)");
            }
		    
            if (!$stmt){
			    $status = "Error getting points ready to insert data into the database";
            } 
            else {
            $pointIns       = $_SESSION['point'];
            $groundheight   = $_SESSION['groundheight'];
            $antennaheight  = $_SESSION['antennaheight'];
            $antennatype    = $_SESSION['antennatype'];
            $antennalength  = $_SESSION['antennalength'];
            $id             = $_SESSION['idpathway'];
			$data = array($pointIns, $groundheight, $antennaheight, $antennatype, $antennalength,$id);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
			} else {
                $status = "OK";
            }
		}
		
    }
	return $status;
}

//function to insert valid midpoints into database !

function insertValidMidpoints( $db_conn ) {

        if (!$db_conn){
	        $status = "File upload failed - Error connecting to the database";
            } 
        else {
		    $stmt = $db_conn->prepare("insert into midpoint ( distance, groundheight, terraintype, obstrucheight, obstructype,idpathway) values(?,?,?,?,?,?)");
		    if (!$stmt){
			    $status = "Error getting points ready to insert data into the database";
            } 
            else {
            $distance      = $_SESSION['distance'];
            $groundheight  = $_SESSION['groundheight'];
            $terraintype   = $_SESSION['terraintype'];
            $obstrucheight = $_SESSION['obstrucheight'];
            $obstructype   = $_SESSION['obstructype'];
            $id            = $_SESSION['idpathway']; 
			//encodes data for the security
			//$content = base64_encode(file_get_contents($_FILES['uploads']['tmp_name']));
			$data = array($distance, $groundheight, $terraintype, $obstrucheight, $obstructype, $id);
			$result = $stmt->execute($data);
			if(!$result){
                $status = "Error".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
			} else {
                $status = "OK";
            }
		}
		
    }
	return $status;

}



//Update Functions
//Update Pathway
function updatePathway($db_conn, $data){
    if (!$db_conn){
        $status = "File upload failed - Error connecting to the database";
        } 
    else {
        $stmt = $db_conn->prepare("update pathway set opfrq=?, description=?, note=? where idpathway = ?");
        if (!$stmt){
            $status = "Error getting pathway ready to insert data into the database";
        } 
        else {
            $idpath      = $data[0];
            $opfrq       = $data[2];
            $description = $data[3];
            $note        = $data[4];
            
            $data = array($opfrq, $description, $note, $idpath);
            
            $result = $stmt->execute($data);
            if(!$result){

                $status = "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            }
            else{
                $status = "OK";
            }
        }
    
    }
    return $status;
}

//Update Points

function updatePoints($db_conn, $data){
    if (!$db_conn){
        $status = "File upload failed - Error connecting to the database";
        } 
    else {
        $idpoints       = $data[0];
        $idsPoint       = $data[1];
        $endpoint       = $data[2];
        $groundheight   = $data[3];
        $antennaheight  = $data[4];
        $antennatype    = $data[5];
        $antennalength  = $data[6];

        if ($idsPoint == 'start'){
            $stmt = $db_conn->prepare("update points set groundheight=?, antennaheight=?, antennatype=?, antennalength=? where idpoints = ?");
        }else{
            $stmt = $db_conn->prepare("update points set endpoint=?, groundheight=?, antennaheight=?, antennatype=?, antennalength=? where idpoints = ?");
  
        }

        if (!$stmt){
            $status = "Error getting midpoint ready to insert data into the database";
        } 
        else {
            if ($idsPoint == 'start'){
                $data = array($groundheight, $antennaheight,$antennatype,$antennalength, $idpoints);
        
            }else{
              $data = array($endpoint, $groundheight, $antennaheight,$antennatype,$antennalength, $idpoints);
            }
            
            $result = $stmt->execute($data);
            if(!$result){

                $status = "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            }
            else{
                $status = "OK";
            }
        }
    
    }
    return $status;
}

//Update Pathway
function updateMidPoints($db_conn, $data){
    if (!$db_conn){
        $status = "File upload failed - Error connecting to the database";
        } 
    else {
        $stmt = $db_conn->prepare("update midpoint set groundheight=?, terraintype=?, obstrucheight=?, obstructype=? where idmidPoint = ?");
        if (!$stmt){
            $status = "Error getting midpoint ready to insert data into the database";
        } 
        else {
            $idmidPoint    = $data[0];
            $groundheight  = $data[2];
            $terraintype   = $data[3];
            $obstrucheight = $data[4];
            $obstructype   = $data[5];

            $data = array($groundheight, $terraintype, $obstrucheight,$obstructype, $idmidPoint);
            
            $result = $stmt->execute($data);
            if(!$result){

                $status = "Error ".$stmt->errorCode()."\nMessage ".implode($stmt->errorInfo())."\n";
            }
            else{
                $status = "OK";
            }
        }
    
    }
    return $status;
}

?>