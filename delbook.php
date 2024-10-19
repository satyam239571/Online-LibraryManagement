<?php

$bookname = $_GET["book"];

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error){
	echo "error";
	die($sqlconn->connect_error);
}

$sql = "DELETE FROM books WHERE bookname='$bookname';";

if ($sqlconn->query($sql) === TRUE) {
	echo "book Deleted";
	header("Refresh:1, URL=dashbook.php");
} else {
	echo "error: ".$sqlconn->error;
}


$sqlconn->close();
?>