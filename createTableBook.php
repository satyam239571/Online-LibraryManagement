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

$sql = "CREATE TABLE books (slno INT(3) AUTO_INCREMENT, bookname VARCHAR(100) NOT NULL,author VARCHAR(100) NOT NULL,category VARCHAR(15) NOT NULL, publication VARCHAR(100) NOT NULL, edition VARCHAR(4) NOT NULL, price INT(4) NOT NULL, time DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (slno));";

if ($sqlconn->query($sql) === TRUE) {
	echo "TABLE created";
} else {
	echo "error: ".$sqlconn->error;
}

$sqlconn->close();
?>
