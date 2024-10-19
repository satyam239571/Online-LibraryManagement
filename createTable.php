<?php

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error){
	echo "error";
	die($sqlconn->connect_error);
}

$sql = "CREATE TABLE userlogin (slno INT(3) AUTO_INCREMENT, name VARCHAR(30) NOT NULL,regno VARCHAR(10) UNIQUE NOT NULL,gender VARCHAR(10) NOT NULL,profession VARCHAR(10) NOT NULL, email VARCHAR(30) NOT NULL, mobile VARCHAR(13) NOT NULL, password VARCHAR(30) NOT NULL,PRIMARY KEY (slno));";

if ($sqlconn->query($sql) === TRUE) {
	echo "TABLE created";
} else {
	echo "error: ".$sqlconn->error;
}

$sqlconn->close();
?>
