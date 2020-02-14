<?php
// <!-- 
// 	File:    db_connection.php
// 	Purpose: Database Conncetion and desconnect Functions 
// 	Authors: Millene L B S Cesconetto
// 			 Olha Tymoshchuk
// 			 Omar Rafik
// -->
	define("DBHOST", "localhost");
	define("DBDB",   "microwave");
	define("DBUSER", "microwaveuser");
	define("DBPW", "!Lamp12!");

	function connectDB(){
		$dsn = "mysql:host=".DBHOST.";dbname=".DBDB.";charset=utf8";
		try{
			$db_conn = new PDO($dsn, DBUSER, DBPW);
			return $db_conn;
		} catch (PDOException $e){
			return FALSE;
		}
	}

	function disconnect_db($db_conn){
		$db_conn = null;
	}
?>
