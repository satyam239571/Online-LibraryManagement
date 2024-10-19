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

//require_once "config.php";

$email = $password = "";
$email_err = $password_err = "";

if (isset($_POST['submit']))
{
    if (empty(trim($_POST["email"])))
    {
        $email_err = "Email cannot be blank";
        echo $email_err;
    }

    else
    {
        $sql = "SELECT slno FROM userlogin WHERE email = ?";
        $stmt = $sqlconn -> prepare($sql);
        if ($stmt)
        {
            $stmt -> bind_param("s", $param_email);

            // Set the value of param email
            $param_email = trim($_POST['email']);

            if ($stmt->execute())
            {
                $stmt->store_result();
                if ($stmt ->num_rows == 1)
                {
                    $email_err = "This email is already taken";
                    echo $email_err;
                }
                else
                {
                    $email = trim($_POST['email']);
                }
            }
            else
            {
                echo "Something went wrong";
            }
        }
    }

    $stmt->close();

    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
        echo $password_err;
    } elseif (strlen(trim($_POST['password'])) < 7) {
        $password_err = "Password cannot be less than 7 characters";
        echo $password_err;
    } else {
        $password =  trim($_POST['password']);
    }

    if (empty($email_err) && empty($password_err))
    {
        $sql = "INSERT INTO userlogin (name, regno, gender, profession, email, mobile, password) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $sqlconn -> prepare($sql);

        if ($stmt)
        {
            $stmt -> bind_param("sssssss",$param_name, $param_regno, $param_gender, $param_profession, $param_email, $param_mobile, $param_password);

            $param_name = trim($_POST['name']);
            $param_regno = trim($_POST['regno']);
            $param_gender = trim($_POST['gender']);
            $param_profession = trim($_POST['profession']);
            $param_email = $email;
            $param_mobile = trim($_POST['mobile']);
            $param_password = password_hash($password, PASSWORD_DEFAULT);


            if ($stmt->execute())
            {
                echo "data inserted";
                header('Refresh: 2; URL= login.html');
            }
            else
            {
                echo "Something went wrong...cannot redirect!";
            }
        }
        $stmt->close();
    }
    $sqlconn->close();
}