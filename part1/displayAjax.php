<?php
header("Content-Type: application/json");
require_once("../db/db_connection.php");

if(isset($_POST['display_row']))
{
 $row=$_POST['row_id'];
 $db_conn = connect_db();


 $qry = "select * from pathway where idpathway = ?;";
 $field_data[] = $row;
 $stmt = $db_conn->prepare($qry);
 if (!$stmt){
     echo "<p>Error in display prepare: ".$dbc->errorCode()."</p>\n<p>Message ".implode($dbc->errorInfo())."</p>\n";
     exit(1);
 }
 
 $status = $stmt->execute($field_data);
 if ($status){
     if ($stmt->rowCount() > 0){
        $posts = array("status" => "OK");
        $posts['posts'] = array();
        while ($row = $rs->fetch_assoc()){
            array_push($posts['posts'], $row);
        }
        echo json_encode($posts);
        exit();
    } else {
        echo '{ "status": "None" }';
        exit();
    }
 }

}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 mysql_query("delete from user_detail where id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $name=$_POST['name_val'];
 $age=$_POST['age_val'];
 mysql_query("insert into user_detail values('','$name','$age')");
 echo mysql_insert_id();
 exit();
}
?>