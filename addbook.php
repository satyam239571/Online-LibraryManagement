<?php

if (isset($_POST['submit'])) {

$book = $_POST["book"];
$author = $_POST["author"];
$category = $_POST["category"];
$publication = $_POST["publication"];
$edition = $_POST["edition"];
$price = $_POST["price"];

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error){
  echo "error";
  die($sqlconn->connect_error);
}

$sql = "INSERT INTO books (bookname, author,  category, publication, edition, price) VALUES ('$book', '$author', '$category', '$publication', '$edition', '$price');";

if ($sqlconn->query($sql) === TRUE) {
  echo "book inserted";
  header('Refresh: 1; URL=dashbook.php');
}
else
{
  echo "error: ".$sqlconn->error;
}
$sqlconn->close();
}

?>