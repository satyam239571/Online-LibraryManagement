<?php

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";
$num = "1";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error) {
    echo "error";
    die($sqlconn->connect_error);
}
$sql = "SELECT * FROM userlogin;";

$data = $sqlconn->query($sql);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Library Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <section id="header">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand">Admin Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a href="#" class="nav-link">Students</a>
                            </li>

                            <li class="nav-item">
                                <a href="dashbook.php" class="nav-link">Books</a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link">Fine</a>
                            </li>

                            <li class="nav-item">
                                <a href="admin.html" class="nav-link">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </section>
    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Slno.</th>
                                <th scope="col">Registration No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Profession</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                                // echo $row["email"]." ".$row["regno"]." ".$row["name"]." ".$row["mobile"]."<br/>";
                                // $num;
                        ?>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo $num++; ?></th>
                                        <td><?php echo $row["regno"]; ?></td>
                                        <td><?php echo $row["name"]; ?></td>
                                        <td><?php echo $row["gender"]; ?></td>
                                        <td><?php echo $row["profession"]; ?></td>
                                        <td><?php echo $row["email"]; ?></td>
                                        <td><?php echo $row["mobile"]; ?></td>
                                        <td><a href="delstu.php?email=<?php echo $row["email"]; ?>"> <button type="button" class="btn btn-danger">Delete</button></a></td>
                                    </tr>
                            <?php
                            }
                        } else {
                            echo "error: " . $sqlconn->error;
                        }

                        $sqlconn->close();
                            ?>
                                </tbody>
                    </table>
                    <!-- <a href="#"><button type="button" class="btn btn-warning">Add</button></a> -->
                    <!-- <button type="button" class="btn btn-warning btn-lg" disabled = "disabled" style="opacity: 1">
                        Number of Books in the library    <span class="badge badge-light">  9
                    </button> -->
                </div>
            </div>
        </div>
        <!-- <div class="container">
            <div class="row">
                <div class="col">
                    <button class="btn btn-danger form-control  btn-block" routerLink='/login'>Cancel</button></div>
                <div class="col">
                    <button id="btnSubmit" class="btn btn-primary form-control btn-block" type="submit" (click)="onSubmit()">Submit</button></div>
            </div>
        </div> -->

    </section>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>