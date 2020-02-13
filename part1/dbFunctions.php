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
        }
        if($i == 2){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(strlen($data[$i]) > 225){
                $error_msgs[] = "A short description of the path
                Maximum 255 characters in length";
            } 
        }
        if($i == 3){
            if(strlen($data[$i]) > 65534){
                $error_msgs[] = "Notes about this path.
                May contain special characters.
                Maximum length of 65534 characters";
            } 
        }
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
            if($data[$i] < 0 && $point == "end"){
                $error_msgs[] = "The end point should be more than 0";
            }
        }
        if($i == 1){
            if(empty($data[$i])){
                $error_msgs[] = "The value shouldn't be empty";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }

        }
        if($i == 2){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
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
        }
        if($i == 4){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
            }
        }
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
        }
        if($i == 3){
            if(empty($data[$i])){
                $error_msgs[] = "the field is requires";
            }
            else if(!is_numeric($data[$i])){
                $error_msgs[] = "The value should be numeric";
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
        }
    }
    
}



?>