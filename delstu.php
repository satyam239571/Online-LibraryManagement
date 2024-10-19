<?php

$email = $_GET["email"];

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error){
	echo "error";
	die($sqlconn->connect_error);
}

$sql = "DELETE FROM userlogin WHERE email='$email';";

if ($sqlconn->query($sql) === TRUE) {
	echo "student data Deleted";
	header("Refresh:1, URL=dashadmin.php");
} else {
	echo "error: ".$sqlconn->error;
}


// $sqlconn->close();
?>