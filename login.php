<?php

session_start();

if (isset($_POST['submit'])){
$email = $_POST['email'];
$password = $_POST['password'];
}

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";


$sqlconn = new mysqli($server, $user, $pass, $db);

$sql = "SELECT * FROM userlogin WHERE email = '$email';";

$data = $sqlconn->query($sql);

if ($data->num_rows>0) {
    if ($row = $data->fetch_assoc())
    {
        if ($password !=  $row["password"])
        {
            echo '<script>alert("wrong password")</script>';
            header('Refresh: 1; URL= login.html');
		}
        else
        {
            //echo "password matched";
            $_SESSION["email"] = $email;
            $_SESSION["loggedin"] = true;
            header("location: welcome.php");
            //header("Refresh: 1; URL= welcome.php");
        }
	}

} else {
    echo '<script>alert("Invalid Credentials.")</script>';
    header('Refresh: 1; URL= login.html');
}

$sqlconn->close();

?>