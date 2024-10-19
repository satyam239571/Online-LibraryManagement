<?php

$server   = "localhost";
$user = "root";
$pass = "";

$sqlconn = new mysqli($server, $user, $pass);

if ($sqlconn->connect_error){
	echo "error";
	die($sqlconn->connect_error);
}

$sql = "CREATE DATABASE lms";

if ($sqlconn->query($sql) === TRUE) {
	echo "DATABASE created";
} else {
	echo "error: ".$sqlconn->error;
}

$sqlconn->close();
?>