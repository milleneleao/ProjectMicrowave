
<?php

function validatePath($data){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        echo $data[$i]. "<br />";
    }
    echo "<br /><br />";
	return $err_msgs;
}

function validatePoint($data,$point){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        echo $data[$i]. "<br />";
    }
    echo "<br /><br />";
	return $err_msgs;
}

function validateMidPoints($data){
    $err_msgs = array();
    for ($i = 0; $i < count($data); $i++) {
        echo $data[$i]. "<br />";
    }
    echo "<br /><br />";
	return $err_msgs;
}
?>